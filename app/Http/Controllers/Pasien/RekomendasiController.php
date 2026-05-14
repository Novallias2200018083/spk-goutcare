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

        // Jika profil belum diisi, arahkan untuk mengisi profil dulu
        if (!$profil) {
            return redirect()->route('pasien.profil.index')
                             ->with('error', 'Silakan isi profil kesehatan Anda terlebih dahulu.');
        }

        return view('pasien.rekomendasi.index', compact('profil'));
    }

    public function hitung(Request $request)
    {
        $user = Auth::user();
        $profil = $user->profilPasien;

        if (!$profil) {
            return redirect()->route('pasien.profil.index')->with('error', 'Isi profil terlebih dahulu.');
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

            // 2. Tentukan Skala Target Pasien (Berdasarkan Profil atau Custom Input)
            $targetSkala = [];
            
            $tPurin = $request->custom_purin ?? $profil->toleransi_purin;
            $tKalori = $request->custom_kalori ?? $profil->kebutuhan_kalori;
            $tProtein = $request->custom_protein ?? $profil->kebutuhan_protein;
            $tLemak = $request->custom_lemak ?? $profil->kebutuhan_lemak;
            $tKarbo = $request->custom_karbohidrat ?? $profil->kebutuhan_karbohidrat;

            foreach ($kriterias as $k) {
                $val = 0;
                $kName = strtolower($k->nama_kriteria);
                
                if (str_contains($kName, 'purin')) $val = $tPurin;
                elseif (str_contains($kName, 'kalori')) $val = $tKalori;
                elseif (str_contains($kName, 'protein')) $val = $tProtein;
                elseif (str_contains($kName, 'lemak')) $val = $tLemak;
                elseif (str_contains($kName, 'karbohidrat')) $val = $tKarbo;

                // Cari masuk ke skala mana (Gunakan filter untuk menangani desimal)
                $skalaDitemukan = $skalas->where('kriteria_id', $k->id)
                    ->filter(fn($s) => $val >= $s->batas_bawah && $val <= $s->batas_atas)
                    ->first();
                
                $targetSkala[$k->id] = $skalaDitemukan ? $skalaDitemukan->nilai_skala : 3; // Default 3 jika diluar range
            }

            // 3. Ambil Alternatif Makanan
            $makanans = Makanan::where('is_user_input', false)
                               ->orWhere(function($query) use ($user) {
                                   $query->where('is_user_input', true)->where('user_id', $user->id);
                               })
                               ->with('nilaiKriterias')
                               ->get();

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

                    // Hitung GAP (Skala Makanan - Skala Target)
                    $gap = (int)$skalaMakanan - (int)$targetSkala[$k->id];

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

                // Tentukan Status Kelayakan
                $status = 'Kurang Direkomendasikan';
                if ($nilaiAkhir >= 4.5) $status = 'Sangat Direkomendasikan';
                elseif ($nilaiAkhir >= 3.8) $status = 'Direkomendasikan';
                elseif ($nilaiAkhir >= 3.0) $status = 'Cukup Direkomendasikan';

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