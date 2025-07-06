<?php

namespace App\Http\Controllers;

use App\Models\HasilKeputusan;
use App\Models\ProfilPasien;
use App\Models\Makanan;
use App\Models\Kriteria;
use App\Services\SpkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class RekomendasiController extends Controller
{
    protected $spkService;

    /**
     * Konstruktor untuk menginject SpkService.
     */
    public function __construct(SpkService $spkService)
    {
        $this->spkService = $spkService;
    }

    /**
     * Menampilkan hasil rekomendasi makanan dan detail perhitungannya.
     * Ini akan menjadi halaman utama untuk mendapatkan rekomendasi.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = Auth::user();
        $profilPasien = $user->profilPasien; // Menggunakan relasi dari model User

        // Arahkan jika profil pasien belum lengkap
        if (!$profilPasien) {
            return redirect()->route('pasien.profil.create')->with('info', 'Harap lengkapi profil Anda terlebih dahulu untuk mendapatkan rekomendasi.');
        }

        // --- Persiapan Data Makanan untuk SPK ---
        // 1. Ambil semua makanan umum/master (yang diinput admin)
        // Eager load relasi nilaiKriteria dan kriteria di dalamnya
        $makananMaster = Makanan::where('is_user_input', false)
                                ->with('nilaiKriteria.kriteria')
                                ->get();

        // 2. Ambil semua makanan pribadi milik user yang sedang login
        // Eager load relasi nilaiKriteria dan kriteria di dalamnya
        $userMakanans = Makanan::where('user_id', $user->id)
                                ->where('is_user_input', true)
                                ->with('nilaiKriteria.kriteria')
                                ->get();

        // 3. Gabungkan kedua koleksi makanan dan tambahkan penanda sumber
        $allMakanans = collect([]); // Membuat koleksi kosong baru

        // Tambahkan makanan master, beri tanda 'Umum'
        foreach ($makananMaster as $makanan) {
            $makanan->source_type = 'Umum';
            $allMakanans->push($makanan);
        }

        // Tambahkan makanan pribadi, beri tanda 'Pribadi'
        foreach ($userMakanans as $makanan) {
            $makanan->source_type = 'Pribadi';
            $allMakanans->push($makanan);
        }

        // Ambil semua kriteria yang aktif
        $kriterias = Kriteria::all();

        // Jika tidak ada makanan atau kriteria, berikan pesan error
        if ($allMakanans->isEmpty() || $kriterias->isEmpty()) {
            return view('rekomendasi.index', [
                'profilPasien' => $profilPasien,
                'kriterias' => $kriterias,
                'finalRecommendations' => collect([]), // Kirim koleksi kosong
                'matriksKeputusan' => [],
                'normalisasiSAW' => [],
                'peringkatSAW' => [],
                'maxMinValues' => [],
                'normalisasiPM' => [],
                'peringkatPM' => [],
            ])->with('info', 'Tidak ada data makanan atau kriteria yang cukup untuk menghasilkan rekomendasi.');
        }

        // --- Panggil Service SPK untuk Perhitungan ---
        // Panggil service untuk perhitungan SPK, minta detailnya (true)
        $result = $this->spkService->hitungRekomendasi($profilPasien, $allMakanans, $kriterias, true);

        // --- Simpan Hasil Keputusan (berdasarkan kelayakan dan top rekomendasi) ---
        // Filter rekomendasi yang layak dan ambil beberapa teratas (misal 3)
        $rekomendasiLayakUntukDisimpan = collect($result['finalRecommendations'])->filter(function($rec) {
            return $rec['is_layak'];
        })->take(3); // Ambil 3 rekomendasi layak teratas

        foreach ($rekomendasiLayakUntukDisimpan as $recommendation) {
            // Perlu memastikan makanan_terpilih_id tidak null.
            // Gunakan updateOrCreate untuk menghindari duplikasi jika sudah ada rekomendasi untuk makanan dan tanggal yang sama
            HasilKeputusan::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'makanan_terpilih_id' => $recommendation['makanan_obj']->id, // Menggunakan ID dari objek makanan asli
                    'tanggal_keputusan' => now()->toDateString() // Contoh: Simpan per hari. Sesuaikan tipe kolom di DB (date/datetime)
                ],
                [
                    'nilai_saw' => $recommendation['nilai_saw'],
                    'nilai_profile_matching' => $recommendation['nilai_profile_matching'],
                    'rekomendasi_akhir' => $recommendation['final_score'], // Simpan skor total
                    'is_layak' => $recommendation['is_layak'], // Simpan status kelayakan
                ]
            );
        }

        // --- Kirim Data ke View untuk Transparansi ---
        return view('rekomendasi.index', [
            'profilPasien' => $profilPasien,
            'kriterias' => $kriterias,
            'finalRecommendations' => $result['finalRecommendations'], // Hasil akhir
            'matriksKeputusan' => $result['matriksKeputusan'], // Detail perhitungan
            'normalisasiSAW' => $result['normalisasiSAW'],
            'peringkatSAW' => $result['peringkatSAW'],
            'maxMinValues' => $result['maxMinValues'] ?? [], // Penting untuk penjelasan normalisasi
            'normalisasiPM' => $result['normalisasiPM'] ?? [], // Hasil PM (jika diimplementasikan)
            'peringkatPM' => $result['peringkatPM'] ?? [], // Hasil PM (jika diimplementasikan)
        ]);
    }

    /**
     * Menampilkan riwayat rekomendasi untuk user yang sedang login dengan fitur filter dan sorting.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function history(Request $request)
    {
        $user = Auth::user();
        $profilPasien = $user->profilPasien; // Ambil profil pasien

        $query = HasilKeputusan::where('user_id', $user->id)
                                ->with('makananTerpilih.nilaiKriteria.kriteria'); // Eager load relasi yang diperlukan

        // --- Search ---
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('makananTerpilih', function ($q) use ($search) {
                $q->where('nama_makanan', 'like', '%' . $search . '%');
            });
        }

        // --- Filter by Date Range ---
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_keputusan', '>=', $request->input('start_date'));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_keputusan', '<=', $request->input('end_date'));
        }

        // --- Filter by Eligibility Status (Layak / Tidak Layak) ---
        if ($request->filled('eligibility_status')) {
            $status = $request->input('eligibility_status');
            if ($status === 'layak') {
                $query->where('is_layak', true);
            } elseif ($status === 'tidak_layak') {
                $query->where('is_layak', false);
            }
        }

        // --- Sorting ---
        $sortBy = $request->input('sort_by', 'tanggal_keputusan'); // Default sort by tanggal
        $sortOrder = $request->input('sort_order', 'desc'); // Default order descending

        // List kolom yang valid untuk sorting di tabel hasil_keputusan
        $validSortColumns = ['tanggal_keputusan', 'nilai_saw', 'nilai_profile_matching', 'rekomendasi_akhir'];

        if (in_array($sortBy, $validSortColumns)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            // Fallback jika sortBy tidak valid (misalnya, dari input manual yang aneh)
            $query->orderBy('tanggal_keputusan', 'desc');
        }

        // Ambil hasil dan tambahkan parameter query yang ada ke link paginasi
        $history = $query->paginate(10)->appends($request->query());

        // Kirim profilPasien ke view. Ini penting untuk perhitungan is_layak_computed di Blade
        // jika kolom 'is_layak' di HasilKeputusan belum diimplementasikan.
        return view('rekomendasi.history', compact('history', 'profilPasien'));
    }

    /**
     * Menampilkan detail riwayat rekomendasi.
     * Ini memerlukan view baru dan mungkin logika tambahan untuk menampilkan matriks dan perhitungan.
     *
     * @param HasilKeputusan $hasilKeputusan Objek HasilKeputusan yang akan ditampilkan detailnya.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(HasilKeputusan $hasilKeputusan)
    {
        // Otorisasi: Pastikan user yang login adalah pemilik riwayat ini
        if ($hasilKeputusan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat detail riwayat ini.');
        }

        // Muat semua relasi yang dibutuhkan untuk menampilkan detail lengkap
        $hasilKeputusan->load('makananTerpilih.nilaiKriteria.kriteria', 'user.profilPasien');

        // Data yang dibutuhkan untuk menghitung ulang SPK untuk makanan ini
        $profilPasien = $hasilKeputusan->user->profilPasien;
        
        // Pastikan makananTerpilih tidak null sebelum dimasukkan ke koleksi
        if (!$hasilKeputusan->makananTerpilih) {
            return back()->with('error', 'Makanan terpilih untuk riwayat ini tidak ditemukan.');
        }
        $makananUntukPerhitungan = collect([$hasilKeputusan->makananTerpilih]); // Masukkan makanan terpilih ke dalam koleksi
        $kriterias = Kriteria::all(); // Ambil semua kriteria aktif

        // // DEBUGGING: Cek input ke SPK Service
        // dd('Inputs to SPK Service:', [
        //     'profilPasien' => $profilPasien,
        //     'makananUntukPerhitungan' => $makananUntukPerhitungan,
        //     'kriterias' => $kriterias
        // ]);


        // Jika profil pasien atau makanan terpilih atau kriteria tidak ditemukan, handle error
        if (!$profilPasien || $makananUntukPerhitungan->isEmpty() || $kriterias->isEmpty()) {
            return back()->with('error', 'Data tidak lengkap untuk menampilkan detail perhitungan.');
        }

        // Panggil service untuk perhitungan SPK hanya untuk makanan ini
        $calculationDetails = $this->spkService->hitungRekomendasi(
            $profilPasien,
            $makananUntukPerhitungan, // Hanya makanan yang dipilih
            $kriterias,
            true // Minta detail perhitungan
        );
        
        // // DEBUGGING: Cek output dari SPK Service
        // dd('Output from SPK Service:', $calculationDetails);


        // Ambil data untuk makanan_obj yang sedang dilihat dari finalRecommendations
        // Kita perlu mencari item di finalRecommendations yang memiliki makanan_obj.id sama dengan makanan_terpilih_id
        $currentMakananObjId = $hasilKeputusan->makanan_terpilih_id;
        $currentFoodDetails = collect($calculationDetails['finalRecommendations'])->firstWhere('makanan_obj.id', $currentMakananObjId);

        // Jika currentFoodDetails tidak ditemukan, ini bisa jadi masalah di service atau data
        if (!$currentFoodDetails) {
            Log::error('Current food details not found in SPK calculation result.', [
                'makanan_id' => $currentMakananObjId,
                'user_id' => Auth::id(),
                'calculation_details' => $calculationDetails // Untuk debugging
            ]);
            return back()->with('error', 'Detail perhitungan untuk makanan ini tidak ditemukan.');
        }

        // Filter matriks, normalisasi, dan peringkat agar hanya menampilkan untuk makanan ini
        // Kita hanya mengambil data yang relevan dengan $hasilKeputusan->makanan_terpilih_id
        $filteredMatriksKeputusan = [];
        if (isset($calculationDetails['matriksKeputusan'][$currentMakananObjId])) {
            $filteredMatriksKeputusan[$currentMakananObjId] = $calculationDetails['matriksKeputusan'][$currentMakananObjId];
        }

        $filteredNormalisasiSAW = [];
        if (isset($calculationDetails['normalisasiSAW'][$currentMakananObjId])) {
            $filteredNormalisasiSAW[$currentMakananObjId] = $calculationDetails['normalisasiSAW'][$currentMakananObjId];
        }
        
        // MaxMinValues tidak perlu difilter per makanan karena itu nilai global
        $maxMinValues = $calculationDetails['maxMinValues'] ?? [];

        $filteredNormalisasiPM = [];
        if (isset($calculationDetails['normalisasiPM'][$currentMakananObjId])) {
            $filteredNormalisasiPM[$currentMakananObjId] = $calculationDetails['normalisasiPM'][$currentMakananObjId];
        }

        $filteredPeringkatSAW = [];
        if (isset($calculationDetails['peringkatSAW'][$currentMakananObjId])) {
            $filteredPeringkatSAW[$currentMakananObjId] = $calculationDetails['peringkatSAW'][$currentMakananObjId];
        }

        $filteredPeringkatPM = [];
        if (isset($calculationDetails['peringkatPM'][$currentMakananObjId])) {
            $filteredPeringkatPM[$currentMakananObjId] = $calculationDetails['peringkatPM'][$currentMakananObjId];
        }

        // Kirim data ke view
        return view('pasien.rekomendasi.show', [
            'hasilKeputusan' => $hasilKeputusan,
            'kriterias' => $kriterias, // Tetap kirim semua kriteria untuk header tabel
            'matriksKeputusan' => $filteredMatriksKeputusan,
            'normalisasiSAW' => $filteredNormalisasiSAW,
            'maxMinValues' => $maxMinValues,
            'normalisasiPM' => $filteredNormalisasiPM,
            'peringkatSAW' => $filteredPeringkatSAW,
            'peringkatPM' => $filteredPeringkatPM,
            'currentFoodDetails' => $currentFoodDetails // Detail spesifik makanan ini dari hasil SPK
        ]);
    }

    /**
     * Menghapus riwayat rekomendasi tertentu.
     *
     * @param HasilKeputusan $hasilKeputusan Objek HasilKeputusan yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(HasilKeputusan $hasilKeputusan)
    {
        // Otorisasi: Pastikan user yang login adalah pemilik riwayat ini
        if ($hasilKeputusan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus riwayat ini.');
        }

        try {
            $hasilKeputusan->delete(); // Hapus record dari database
            return redirect()->route('pasien.history')->with('success', 'Riwayat rekomendasi berhasil dihapus.');
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Gagal menghapus riwayat rekomendasi: ' . $e->getMessage(), ['hasil_keputusan_id' => $hasilKeputusan->id, 'user_id' => Auth::id()]);
            return back()->with('error', 'Gagal menghapus riwayat: ' . $e->getMessage());
        }
    }
}
