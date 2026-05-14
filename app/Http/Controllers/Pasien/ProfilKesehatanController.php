<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\ProfilPasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilKesehatanController extends Controller
{
    // 1. Menampilkan halaman profil dan form
    public function index()
    {
        $user = Auth::user();
        $profil = $user->profilPasien; // Tarik data profil jika sudah ada

        return view('pasien.profil.index', compact('profil'));
    }

    // 2. Menyimpan atau Memperbarui Profil Kesehatan
    public function store(Request $request)
    {
        $request->validate([
            'metode_input' => 'required|in:manual,otomatis',
            'catatan_tambahan' => 'nullable|string'
        ]);

        $data = $request->only('metode_input', 'catatan_tambahan');
        $data['user_id'] = Auth::id();

        // JIKA METODE OTOMATIS (MENGGUNAKAN RUMUS BMR & STANDAR GOUT)
        if ($request->metode_input == 'otomatis') {
            $request->validate([
                'jenis_kelamin' => 'required|in:L,P',
                'umur' => 'required|numeric|min:10',
                'berat_badan' => 'required|numeric|min:20',
                'tinggi_badan' => 'required|numeric|min:100',
                'tingkat_aktivitas' => 'required|in:rendah,sedang,tinggi',
                'fase_asam_urat' => 'required|in:akut,normal',
            ]);

            // 1. Hitung BMR (Mifflin-St Jeor)
            $bmr = 0;
            if ($request->jenis_kelamin == 'L') {
                $bmr = (10 * $request->berat_badan) + (6.25 * $request->tinggi_badan) - (5 * $request->umur) + 5;
            } else {
                $bmr = (10 * $request->berat_badan) + (6.25 * $request->tinggi_badan) - (5 * $request->umur) - 161;
            }

            // 2. Tentukan Pengali Aktivitas
            $multiplier = 1.2; // Default Rendah (Sedentary)
            if ($request->tingkat_aktivitas == 'sedang') $multiplier = 1.55;
            if ($request->tingkat_aktivitas == 'tinggi') $multiplier = 1.725;

            // 3. Hitung Total Kebutuhan Kalori (TDEE)
            $kebutuhan_kalori = round($bmr * $multiplier);

            // 4. Hitung Makronutrien berdasar teori Gout (Bab 2)
            // Protein: ~1 gram per kg berat badan
            $kebutuhan_protein = round($request->berat_badan * 1);
            
            // Lemak: 15% dari total kalori (1 gram lemak = 9 kalori)
            $kebutuhan_lemak = round(($kebutuhan_kalori * 0.15) / 9);
            
            // Karbohidrat: Sisa kalori (1 gram karbo = 4 kalori)
            $kalori_protein = $kebutuhan_protein * 4;
            $kalori_lemak = $kebutuhan_lemak * 9;
            $kebutuhan_karbohidrat = round(($kebutuhan_kalori - $kalori_protein - $kalori_lemak) / 4);

            // 5. Toleransi Purin berdasar Fase
            $toleransi_purin = ($request->fase_asam_urat == 'akut') ? 100 : 150;

            // Masukkan hasil hitungan otomatis ke dalam array data yang akan disave
            $data = array_merge($data, [
                'jenis_kelamin' => $request->jenis_kelamin,
                'umur' => $request->umur,
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan,
                'tingkat_aktivitas' => $request->tingkat_aktivitas,
                'fase_asam_urat' => $request->fase_asam_urat,
                'kebutuhan_kalori' => $kebutuhan_kalori,
                'kebutuhan_protein' => $kebutuhan_protein,
                'kebutuhan_lemak' => $kebutuhan_lemak,
                'kebutuhan_karbohidrat' => $kebutuhan_karbohidrat,
                'toleransi_purin' => $toleransi_purin,
            ]);
        } 
        // JIKA METODE MANUAL (INPUT LANGSUNG DARI DOKTER/AHLI GIZI)
        else {
            $request->validate([
                'kebutuhan_kalori' => 'required|numeric|min:0',
                'kebutuhan_protein' => 'required|numeric|min:0',
                'kebutuhan_lemak' => 'required|numeric|min:0',
                'kebutuhan_karbohidrat' => 'required|numeric|min:0',
                'toleransi_purin' => 'required|numeric|min:0',
            ]);

            // Reset field otomatis menjadi null jika user pindah ke metode manual
            $data = array_merge($data, [
                'jenis_kelamin' => null, 'umur' => null, 'berat_badan' => null,
                'tinggi_badan' => null, 'tingkat_aktivitas' => null, 'fase_asam_urat' => null,
                'kebutuhan_kalori' => $request->kebutuhan_kalori,
                'kebutuhan_protein' => $request->kebutuhan_protein,
                'kebutuhan_lemak' => $request->kebutuhan_lemak,
                'kebutuhan_karbohidrat' => $request->kebutuhan_karbohidrat,
                'toleransi_purin' => $request->toleransi_purin,
            ]);
        }

        // Simpan (Create) atau Perbarui (Update) data ke tabel profil_pasiens
        ProfilPasien::updateOrCreate(
            ['user_id' => Auth::id()], // Cari berdasarkan user_id
            $data // Jika ketemu di-update, jika tidak di-create
        );

        return redirect()->route('pasien.profil.show')->with('success', 'Profil kesehatan berhasil diperbarui! Berikut adalah ringkasan kebutuhan gizi harian Anda.');
    }

    // 3. Menampilkan Ringkasan Profil (Poin 3 & 4)
    public function show()
    {
        $user = Auth::user();
        $profil = $user->profilPasien;

        if (!$profil) {
            return redirect()->route('pasien.profil.index')->with('error', 'Silakan isi profil terlebih dahulu.');
        }

        return view('pasien.profil.show', compact('profil'));
    }
}