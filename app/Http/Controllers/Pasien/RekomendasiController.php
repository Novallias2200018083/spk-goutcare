<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Makanan;
use App\Models\Kriteria;
use App\Models\SkalaKriteria;
use App\Models\BobotGap;
use App\Models\Pengaturan;
use App\Models\RiwayatRekomendasi;
use App\Models\DetailRiwayatRekomendasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekomendasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profil = $user->profilPasien;

        // Jika profil belum diisi atau data antropometri tidak lengkap, arahkan untuk mengisi profil dulu
        if (!$profil || empty($profil->berat_badan) || empty($profil->tinggi_badan) || empty($profil->fase_asam_urat)) {
            return redirect()->route('pasien.profil.index')
                             ->with('error', 'Silakan lengkapi data fisik Anda (Berat Badan, Tinggi Badan, & Fase Asam Urat) terlebih dahulu agar AI dapat menghitung rule-based target Anda.');
        }

        $makananSistem = Makanan::where('is_user_input', false)->with('nilaiKriterias.kriteria')->get();
        $makananPribadi = Makanan::where('is_user_input', true)->where('user_id', $user->id)->with('nilaiKriterias.kriteria')->get();
        $kriterias = Kriteria::orderBy('id')->get();
        $skalas = SkalaKriteria::all();
        
        $tinggiMeter = $profil->tinggi_badan / 100;
        $imt = ($tinggiMeter > 0) ? ($profil->berat_badan / ($tinggiMeter * $tinggiMeter)) : 0;
        $statusImt = $imt < 18.5 ? 'Kurus' : ($imt >= 25 ? 'Gemuk / Obesitas' : 'Normal');

        // Kalkulasi Target Skala dan Range Nilai Asli untuk UI
        $targetData = [];
        foreach ($kriterias as $k) {
            $kName = strtolower($k->nama_kriteria);
            $skala = 3; // default
            $label = 'Sedang';
            $alasan = '';

            // Ambil semua aturan target dari database
            $aturans = \App\Models\Pengaturan::where('tipe', 'skala')->pluck('nilai', 'nama_pengaturan');

            if (str_contains($kName, 'purin')) {
                if (strtolower($profil->fase_asam_urat) == 'akut') { 
                    $skala = $aturans['target_purin_akut'] ?? 4; $label = 'Disesuaikan (Akut)'; 
                    $alasan = 'Kondisi fase Akut (kambuh).';
                } else { 
                    $skala = $aturans['target_purin_normal'] ?? 3; $label = 'Disesuaikan (Normal)'; 
                    $alasan = 'Fase Normal (pemeliharaan).';
                }
            } elseif (str_contains($kName, 'kalori')) {
                if ($imt < 18.5) { 
                    $skala = $aturans['target_kalori_kurus'] ?? 2; $label = 'Disesuaikan (Kurus)'; 
                    $alasan = 'IMT Kurus (< 18.5).';
                } elseif ($imt >= 25) { 
                    $skala = $aturans['target_kalori_obesitas'] ?? 4; $label = 'Disesuaikan (Obesitas)'; 
                    $alasan = 'IMT Obesitas (>= 25).';
                } else { 
                    $skala = $aturans['target_kalori_normal'] ?? 3; $label = 'Disesuaikan (Normal)'; 
                    $alasan = 'IMT Normal.';
                }
            } elseif (str_contains($kName, 'lemak')) {
                if ($imt >= 25) { 
                    $skala = $aturans['target_lemak_obesitas'] ?? 4; $label = 'Disesuaikan (Obesitas)'; 
                    $alasan = 'IMT Obesitas (>= 25).';
                } else { 
                    $skala = $aturans['target_lemak_normal'] ?? 3; $label = 'Disesuaikan (Normal)'; 
                    $alasan = 'IMT Normal/Kurus.';
                }
            } elseif (str_contains($kName, 'protein')) {
                $skala = $aturans['target_protein_default'] ?? 3; $label = 'Disesuaikan';
                $alasan = 'Kebutuhan standar otot.';
            } elseif (str_contains($kName, 'karbohidrat')) {
                $skala = $aturans['target_karbohidrat_default'] ?? 3; $label = 'Disesuaikan';
                $alasan = 'Kebutuhan standar kalori.';
            }

            // Nilai asli harian dari profil pasien
            $nilaiAsli = 0;
            if (str_contains($kName, 'purin')) {
                $nilaiAsli = $profil->toleransi_purin;
            } elseif (str_contains($kName, 'kalori')) {
                $nilaiAsli = $profil->kebutuhan_kalori;
            } elseif (str_contains($kName, 'lemak')) {
                $nilaiAsli = $profil->kebutuhan_lemak;
            } elseif (str_contains($kName, 'protein')) {
                $nilaiAsli = $profil->kebutuhan_protein;
            } elseif (str_contains($kName, 'karbohidrat')) {
                $nilaiAsli = $profil->kebutuhan_karbohidrat;
            }

            // Cari batas bawah dan batas atas dari tabel skala_kriteria
            $skalaKriteria = $skalas->where('kriteria_id', $k->id)->where('nilai_skala', $skala)->first();
            
            $targetData[$k->id] = [
                'skala' => $skala,
                'label' => $label,
                'alasan' => $alasan,
                'nilai_asli' => $nilaiAsli,
                'batas_bawah' => $skalaKriteria ? $skalaKriteria->batas_bawah : 0,
                'batas_atas' => $skalaKriteria ? $skalaKriteria->batas_atas : 0,
                'keterangan' => $skalaKriteria ? $skalaKriteria->keterangan : ''
            ];
        }

        return view('pasien.rekomendasi.index', compact('profil', 'makananSistem', 'makananPribadi', 'kriterias', 'imt', 'statusImt', 'targetData'));
    }

    public function hitung(Request $request)
    {
        $user = Auth::user();
        $profil = $user->profilPasien;

        if (!$profil || empty($profil->berat_badan) || empty($profil->tinggi_badan) || empty($profil->fase_asam_urat)) {
            return redirect()->route('pasien.profil.index')->with('error', 'Silakan lengkapi data fisik Anda terlebih dahulu.');
        }

        DB::beginTransaction();
        try {
            // 1. Ambil Data Master yang Dinamis dari Database
            $kriterias = Kriteria::all();
            $skalas = SkalaKriteria::all();
            $bobotGaps = BobotGap::all();
            
            // Ambil persentase (Default 60/40 jika database kosong)
            $persentaseNcf = (Pengaturan::where('nama_pengaturan', 'persentase_ncf')->value('nilai') ?? 60) / 100;
            $persentaseNsf = (Pengaturan::where('nama_pengaturan', 'persentase_nsf')->value('nilai') ?? 40) / 100;

            // Tentukan Skala Target Pasien (Berbasis Aturan dari Pengaturan)
            $targetSkala = [];
            
            // Hitung IMT (Indeks Massa Tubuh)
            $tinggiMeter = $profil->tinggi_badan / 100;
            $imt = ($tinggiMeter > 0) ? ($profil->berat_badan / ($tinggiMeter * $tinggiMeter)) : 0;
            
            // Ambil semua aturan skala
            $aturans = \App\Models\Pengaturan::where('tipe', 'skala')->pluck('nilai', 'nama_pengaturan');

            foreach ($kriterias as $k) {
                $kName = strtolower($k->nama_kriteria);
                $skala = 3; // Default Skala
                
                if (str_contains($kName, 'purin')) {
                    $skala = (strtolower($profil->fase_asam_urat) == 'akut') ? ($aturans['target_purin_akut'] ?? 4) : ($aturans['target_purin_normal'] ?? 3);
                } elseif (str_contains($kName, 'kalori')) {
                    if ($imt < 18.5) $skala = $aturans['target_kalori_kurus'] ?? 2;
                    elseif ($imt >= 25) $skala = $aturans['target_kalori_obesitas'] ?? 4;
                    else $skala = $aturans['target_kalori_normal'] ?? 3;
                } elseif (str_contains($kName, 'lemak')) {
                    $skala = ($imt >= 25) ? ($aturans['target_lemak_obesitas'] ?? 4) : ($aturans['target_lemak_normal'] ?? 3);
                } elseif (str_contains($kName, 'protein')) {
                    $skala = $aturans['target_protein_default'] ?? 3;
                } elseif (str_contains($kName, 'karbohidrat')) {
                    $skala = $aturans['target_karbohidrat_default'] ?? 3;
                }
                
                $targetSkala[$k->id] = $skala;
            }

            $sumber = $request->input('sumber_makanan', ['sistem']); // default ke sistem jika kosong
            $makanans = Makanan::where(function($query) use ($user, $sumber) {
                                   if (in_array('sistem', $sumber)) {
                                       $query->orWhere('is_user_input', false);
                                   }
                                   if (in_array('pribadi', $sumber)) {
                                       $query->orWhere(function($q) use ($user) {
                                           $q->where('is_user_input', true)->where('user_id', $user->id);
                                       });
                                   }
                               })
                               ->with('nilaiKriterias')
                               ->get();

            // Cek apakah ada modifikasi custom inline table
            if ($request->has('custom_makanan')) {
                foreach ($makanans as $key => $makanan) {
                    if (isset($request->custom_makanan[$makanan->id])) {
                        $isModified = false;
                        $inputCustom = $request->custom_makanan[$makanan->id];

                        foreach ($makanan->nilaiKriterias as $nk) {
                            if (isset($inputCustom[$nk->kriteria_id]) && $inputCustom[$nk->kriteria_id] != $nk->nilai) {
                                $isModified = true;
                                break;
                            }
                        }

                        if ($isModified) {
                            if ($makanan->is_user_input == false) {
                                // Clone sistem ke pribadi
                                $clonedMakanan = Makanan::create([
                                    'nama_makanan' => $makanan->nama_makanan . ' (Custom)',
                                    'deskripsi' => 'Salinan dari sistem dengan nilai dimodifikasi.',
                                    'is_user_input' => true,
                                    'user_id' => $user->id,
                                ]);
                                foreach ($makanan->nilaiKriterias as $nk) {
                                    $newVal = isset($inputCustom[$nk->kriteria_id]) ? $inputCustom[$nk->kriteria_id] : $nk->nilai;
                                    \App\Models\NilaiKriteriaMakanan::create([
                                        'makanan_id' => $clonedMakanan->id,
                                        'kriteria_id' => $nk->kriteria_id,
                                        'nilai' => $newVal,
                                    ]);
                                }
                                // Ganti instance di array agar yang dihitung adalah clone-nya
                                $clonedMakanan->load('nilaiKriterias');
                                $makanans[$key] = $clonedMakanan;
                            } else {
                                // Update langsung makanan pribadinya
                                foreach ($makanan->nilaiKriterias as $nk) {
                                    if (isset($inputCustom[$nk->kriteria_id])) {
                                        $nk->update(['nilai' => $inputCustom[$nk->kriteria_id]]);
                                    }
                                }
                                $makanan->refresh();
                            }
                        }
                    }
                }
            }

            if ($makanans->isEmpty()) {
                DB::rollBack();
                return back()->with('error', 'Pilih minimal satu sumber makanan (Sistem / Pribadi) yang memiliki data makanan.');
            }

            $riwayat = RiwayatRekomendasi::create([
                'user_id' => $user->id,
                'tanggal_rekomendasi' => now(),
            ]);

            // 4. Proses Tiap Makanan
            foreach ($makanans as $makanan) {
                $totalNilaiCore = 0;
                $jumlahCore = 0;
                $totalNilaiSecondary = 0;
                $jumlahSecondary = 0;

                foreach ($kriterias as $k) {
                    $nilaiKriteriaMakanan = $makanan->nilaiKriterias->where('kriteria_id', $k->id)->first();
                    $valMakanan = $nilaiKriteriaMakanan ? $nilaiKriteriaMakanan->nilai : 0;

                    // Konversi nilai makanan ke skala
                    $skalaMakananDitemukan = $skalas->where('kriteria_id', $k->id)
                        ->filter(fn($s) => $valMakanan >= $s->batas_bawah && $valMakanan <= $s->batas_atas)
                        ->first();
                    $skalaMakanan = $skalaMakananDitemukan ? $skalaMakananDitemukan->nilai_skala : 3;

                    // Hitung GAP (Skala Target - Skala Makanan) berdasarkan permintaan user
                    $gap = (int)$targetSkala[$k->id] - (int)$skalaMakanan;

                    // Cari Bobot GAP
                    $bobot = $bobotGaps->where('selisih_gap', $gap)->first();
                    $nilaiBobot = $bobot ? $bobot->bobot_nilai : 1; 

                    // Kelompokkan ke NCF atau NSF
                    if (strtolower($k->tipe_faktor) == 'core') {
                        $totalNilaiCore += $nilaiBobot;
                        $jumlahCore++;
                    } else {
                        $totalNilaiSecondary += $nilaiBobot;
                        $jumlahSecondary++;
                    }
                }

                // 5. Hitung NCF, NSF dan Nilai Akhir
                $ncf = $jumlahCore > 0 ? ($totalNilaiCore / $jumlahCore) : 0;
                $nsf = $jumlahSecondary > 0 ? ($totalNilaiSecondary / $jumlahSecondary) : 0;
                
                // Pastikan nilai akhir dihitung dengan benar
                $nilaiAkhir = ($persentaseNcf * $ncf) + ($persentaseNsf * $nsf);

                // Tentukan Status Kelayakan berdasarkan Profile Matching
                $status = 'Kurang Direkomendasikan';
                if ($nilaiAkhir >= 4.5) $status = 'Sangat Direkomendasikan';
                elseif ($nilaiAkhir >= 3.8) $status = 'Direkomendasikan';
                elseif ($nilaiAkhir >= 3.0) $status = 'Cukup Direkomendasikan';

                // Terapkan Filter Medis Absolut (Toleransi Purin per Porsi)
                // Asumsi standar 3x makan sehari untuk porsi batas bahaya
                $tPurin = $profil->toleransi_purin / 3;
                $purinKriteria = $kriterias->where('nama_kriteria', 'Kandungan Purin')->first();
                if ($purinKriteria) {
                    $nilaiPurinMakanan = $makanan->nilaiKriterias->where('kriteria_id', $purinKriteria->id)->first();
                    $purinVal = $nilaiPurinMakanan ? $nilaiPurinMakanan->nilai : 0;
                    if ($purinVal > $tPurin) {
                        $status = 'Tidak Direkomendasikan (Bahaya)';
                        // Kita TETAP menyimpannya dengan nilai akhir aslinya, tidak dihancurkan ke -999
                        // agar pasien bisa melihat bahwa makanan ini bergizi tapi BAHAYA.
                    }
                }

                DetailRiwayatRekomendasi::create([
                    'riwayat_id' => $riwayat->id,
                    'makanan_id' => $makanan->id,
                    'nilai_ncf' => $ncf,
                    'nilai_nsf' => $nsf,
                    'nilai_akhir' => $nilaiAkhir,
                    'status_kelayakan' => $status,
                ]);
            }

            DB::commit();

            // 6. Redirect ke halaman detail riwayat untuk melihat hasil (Ranking)
            return redirect()->route('pasien.riwayat.show', $riwayat->id)
                             ->with('success', 'Rekomendasi makanan berhasil dihitung!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat menghitung rekomendasi: ' . $e->getMessage());
        }
    }
}