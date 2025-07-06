<?php

namespace App\Services;

use App\Models\Makanan;
use App\Models\Kriteria;
use App\Models\ProfilPasien;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log; // Digunakan untuk logging error/debug

class SpkService
{
    /**
     * Mengatur bobot untuk selisih (gap) dalam metode Profile Matching.
     * Ini bisa disesuaikan berdasarkan domain pengetahuan.
     * @var array
     */
    protected array $bobotGap = [
        0 => 5.0,   // Sangat sesuai (tidak ada selisih)
        1 => 4.5,   // Selisih 1 (sedikit lebih dari target)
        -1 => 4.0,  // Selisih -1 (sedikit kurang dari target)
        2 => 3.5,
        -2 => 3.0,
        3 => 2.5,
        -3 => 2.0,
        4 => 1.5,
        -4 => 1.0,
        5 => 0.5,
        -5 => 0.5,
        // Untuk selisih yang lebih besar dari 5 atau -5, bobot defaultnya bisa 0.1
    ];

    /**
     * Faktor inti dan sekunder untuk Profile Matching.
     * @var array
     */
    protected array $coreFactors = ['Kadar Purin', 'Protein'];
    protected array $secondaryFactors = ['Kalori', 'Lemak', 'Serat']; // Menambahkan serat jika relevan

    /**
     * Bobot persentase untuk faktor inti dan sekunder dalam Profile Matching.
     * @var float
     */
    protected float $persentaseCore = 0.6;
    protected float $persentaseSecondary = 0.4;

    /**
     * Ambil semua kriteria yang relevan dari database.
     * @return Collection
     */
    protected function getKriterias(): Collection
    {
        return Kriteria::all();
    }

    /**
     * Membangun matriks keputusan awal dari koleksi makanan dan kriteria.
     *
     * @param Collection $makananCollection Koleksi objek Makanan.
     * @param Collection $kriteriaCollection Koleksi objek Kriteria.
     * @return array Matriks keputusan.
     */
    private function buildMatriksKeputusan(Collection $makananCollection, Collection $kriteriaCollection): array
    {
        $matriksKeputusan = [];
        foreach ($makananCollection as $makanan) {
            $rowKriteria = [];
            foreach ($kriteriaCollection as $kriteria) {
                // Akses nilai kriteria melalui relasi 'nilaiKriteria' dan filter berdasarkan kriteria_id
                $nilai = $makanan->nilaiKriteria->where('kriteria_id', $kriteria->id)->first()->nilai ?? 0;
                $rowKriteria[$kriteria->id] = $nilai;
            }
            // Menggunakan ID makanan sebagai kunci utama untuk array matriksKeputusan
            $matriksKeputusan[$makanan->id] = $rowKriteria;
        }
        return $matriksKeputusan;
    }

    /**
     * Menghitung skor SAW dan normalisasinya.
     *
     * @param array $matriksKeputusan Matriks keputusan awal.
     * @param Collection $kriteriaCollection Koleksi objek Kriteria.
     * @return array Mengandung normalisasiSAW, peringkatSAW, dan maxMinValues.
     */
    private function calculateSawScores(array $matriksKeputusan, Collection $kriteriaCollection): array
    {
        $normalisasiSAW = [];
        $maxMinValues = [];

        // Temukan nilai Max/Min untuk setiap kriteria DARI SELURUH DATA MAKANAN YANG DIHITUNG
        foreach ($kriteriaCollection as $kriteria) {
            $values = [];
            foreach ($matriksKeputusan as $makananId => $kriteriaValues) {
                // Pastikan akses ke $kriteriaValues[$kriteria->id] dilakukan dengan aman
                $values[] = $kriteriaValues[$kriteria->id] ?? 0;
            }

            // Inisialisasi dengan nilai default yang aman jika array kosong
            $maxVal = 0.0001; // Pastikan nilai default tidak nol
            $minVal = 0.0001; // Pastikan nilai default tidak nol

            if (!empty($values)) {
                $maxVal = max($values);
                $minVal = min($values);
            }
            
            // Pastikan nilai max/min tidak nol untuk menghindari pembagian dengan nol
            if ($maxVal == 0) $maxVal = 0.0001;
            if ($minVal == 0) $minVal = 0.0001;

            $maxMinValues[$kriteria->id] = ['max' => $maxVal, 'min' => $minVal];
        }

        // Lakukan Normalisasi SAW
        foreach ($matriksKeputusan as $makananId => $makananKriteriaValues) {
            $normalizedRow = [];
            foreach ($kriteriaCollection as $kriteria) {
                $nilai = $makananKriteriaValues[$kriteria->id]; // Menggunakan nilai dari matriks keputusan
                $maxMin = $maxMinValues[$kriteria->id];

                $normalizedValue = 0;
                if ($kriteria->tipe === 'benefit') {
                    if ($maxMin['max'] != 0) {
                        $normalizedValue = $nilai / $maxMin['max'];
                    }
                } else { // 'cost'
                    if ($nilai != 0 && $maxMin['min'] != 0) {
                        $normalizedValue = $maxMin['min'] / $nilai;
                    }
                }
                $normalizedRow[$kriteria->id] = $normalizedValue;
            }
            // Menggunakan ID makanan sebagai kunci utama untuk normalisasiSAW
            $normalisasiSAW[$makananId] = $normalizedRow; 
        }

        // Hitung Peringkat SAW (Weighted Sum)
        $peringkatSAW = [];
        foreach ($normalisasiSAW as $makananId => $normalizedMakananKriteria) {
            $score = 0;
            foreach ($kriteriaCollection as $kriteria) {
                $bobot = $kriteria->bobot;
                $score += ($normalizedMakananKriteria[$kriteria->id] ?? 0) * $bobot;
            }
            // Menggunakan ID makanan sebagai kunci utama untuk peringkatSAW
            $peringkatSAW[$makananId] = $score;
        }

        return compact('normalisasiSAW', 'peringkatSAW', 'maxMinValues');
    }

    /**
     * Menghitung skor Profile Matching.
     *
     * @param ProfilPasien $profilPasien Profil pasien.
     * @param array $matriksKeputusan Matriks keputusan awal.
     * @param Collection $kriteriaCollection Koleksi objek Kriteria.
     * @return array Mengandung normalisasiPM dan peringkatPM.
     */
    private function calculateProfileMatchingScores(ProfilPasien $profilPasien, array $matriksKeputusan, Collection $kriteriaCollection): array
    {
        $normalisasiPM = []; // Untuk menyimpan nilai gap dan bobot gap
        $peringkatPM = [];   // Untuk menyimpan skor akhir PM

        $targetKebutuhan = [
            'Kadar Purin' => $profilPasien->toleransi_purin,
            'Kalori' => $profilPasien->kebutuhan_kalori,
            'Protein' => $profilPasien->kebutuhan_protein,
            'Lemak' => $profilPasien->kebutuhan_lemak,
            // Tambahkan kriteria lain jika ada di profil pasien
        ];

        foreach ($matriksKeputusan as $makananId => $makananKriteriaValues) { // Iterasi langsung dengan makananId sebagai kunci
            $gaps = [];
            $terjemahanGaps = []; 
            
            foreach ($kriteriaCollection as $kriteria) {
                $kriteriaNama = $kriteria->nama_kriteria;
                $nilaiMakanan = $makananKriteriaValues[$kriteria->id]; // Menggunakan nilai dari matriks keputusan
                $targetNilai = $targetKebutuhan[$kriteriaNama] ?? null;

                if ($targetNilai === null || $targetNilai == 0) { // Handle target_nilai 0 atau null
                    $gap = 0; // Jika tidak ada target, anggap sempurna atau tidak relevan untuk gap
                    $bobot = 5.0; // Beri bobot tertinggi
                } else {
                    $gap = $nilaiMakanan - $targetNilai;

                    // Penyesuaian khusus untuk kriteria 'Cost' seperti Purin
                    if ($kriteria->tipe === 'cost' && $kriteriaNama === 'Kadar Purin') {
                        if ($nilaiMakanan <= $targetNilai) {
                            $gap = 0; // Ideal: di bawah atau sama dengan toleransi
                        } else {
                            // Jika melebihi toleransi, buat gap positif yang lebih besar
                            // Contoh: setiap 10mg kelebihan = 1 unit gap
                            $gap = ceil(($nilaiMakanan - $targetNilai) / 10);
                            // Pastikan gap tidak menjadi terlalu besar atau terlalu kecil untuk bobotGap
                            $gap = max(-5, min(5, $gap)); // Batasi gap antara -5 dan 5 untuk mapping bobot
                        }
                    } else {
                        // Untuk kriteria benefit atau cost biasa, bulatkan selisih
                        $gap = round($gap);
                        // Batasi gap agar sesuai dengan mapping bobotGap
                        $gap = max(-5, min(5, $gap));
                    }
                    $bobot = $this->bobotGap[$gap] ?? 0.1; // Default ke 0.1 jika gap di luar definisi
                }
                
                $gaps[$kriteria->id] = $gap;
                $terjemahanGaps[$kriteria->id] = $bobot;
            }
            
            // Hitung nilai faktor inti dan sekunder
            $coreFactorSum = 0;
            $coreFactorCount = 0;
            $secondaryFactorSum = 0;
            $secondaryFactorCount = 0;

            foreach ($kriteriaCollection as $kriteria) {
                $kriteriaNama = $kriteria->nama_kriteria;
                // Pastikan kriteria.id ada di $terjemahanGaps sebelum mengakses
                $bobotGapValue = $terjemahanGaps[$kriteria->id] ?? 0.1; 

                if (in_array($kriteriaNama, $this->coreFactors)) {
                    $coreFactorSum += $bobotGapValue;
                    $coreFactorCount++;
                } elseif (in_array($kriteriaNama, $this->secondaryFactors)) {
                    $secondaryFactorSum += $bobotGapValue;
                    $secondaryFactorCount++;
                }
            }

            $nilaiCore = ($coreFactorCount > 0) ? ($coreFactorSum / $coreFactorCount) : 0;
            $nilaiSecondary = ($secondaryFactorCount > 0) ? ($secondaryFactorSum / $secondaryFactorCount) : 0;

            // Hitung skor akhir Profile Matching
            $totalProfileMatching = ($this->persentaseCore * $nilaiCore) + ($this->persentaseSecondary * $nilaiSecondary);

            // Menggunakan ID makanan sebagai kunci utama untuk normalisasiPM
            $normalisasiPM[$makananId] = [
                'gap' => $gaps,
                'terjemahan_gap' => $terjemahanGaps,
                'nilai_ncf' => $nilaiCore,
                'nilai_nsf' => $nilaiSecondary,
                'nilai_total_pm' => $totalProfileMatching, // Ini adalah nilai PM untuk makanan ini
            ];

            // Menggunakan ID makanan sebagai kunci utama untuk peringkatPM
            $peringkatPM[$makananId] = $totalProfileMatching; 
        }
        return compact('normalisasiPM', 'peringkatPM');
    }

    /**
     * Memeriksa apakah suatu makanan layak dikonsumsi berdasarkan toleransi purin pasien.
     * Ini adalah logika tambahan di luar SAW/PM murni, tetapi penting untuk Gout.
     *
     * @param Makanan $makanan Objek makanan.
     * @param ProfilPasien $profilPasien Profil pasien.
     * @return bool True jika layak, false jika tidak.
     */
    private function determineFoodEligibility(Makanan $makanan, ProfilPasien $profilPasien): bool
    {
        $purinKriteria = Kriteria::where('nama_kriteria', 'Kadar Purin')->first();

        if (!$purinKriteria) {
            Log::warning('Kriteria "Kadar Purin" tidak ditemukan di database.');
            return true; // Anggap layak jika kriteria purin tidak didefinisikan
        }

        $nilaiPurinMakanan = $makanan->nilaiKriteria->where('kriteria_id', $purinKriteria->id)->first();

        // Makanan tidak layak jika kadar purin melebihi toleransi pasien
        // Pastikan toleransi_purin tidak null dan nilai purin makanan ditemukan
        if ($nilaiPurinMakanan && $profilPasien->toleransi_purin !== null) {
            return $nilaiPurinMakanan->nilai <= $profilPasien->toleransi_purin;
        }

        return true; // Default layak jika tidak ada data purin untuk makanan atau toleransi pasien tidak diatur
    }

    /**
     * Menggabungkan hasil SAW dan Profile Matching untuk rekomendasi akhir.
     *
     * @param Collection $makananCollection Koleksi objek Makanan asli.
     * @param array $sawResults Hasil dari calculateSawScores.
     * @param array $pmResults Hasil dari calculateProfileMatchingScores.
     * @param ProfilPasien $profilPasien Profil pasien.
     * @return Collection Rekomendasi akhir yang sudah diurutkan.
     */
    private function combineResults(Collection $makananCollection, array $sawResults, array $pmResults, ProfilPasien $profilPasien): Collection
    {
        $finalRecommendations = collect();

        $peringkatSAW = collect($sawResults['peringkatSAW']);
        $peringkatPM = collect($pmResults['peringkatPM']);

        foreach ($makananCollection as $originalFoodItem) { // Iterasi melalui makanan asli
            $makananId = $originalFoodItem->id;

            $sawScore = $peringkatSAW->get($makananId, 0); // Ambil skor SAW, default 0
            $pmScore = $peringkatPM->get($makananId, 0);   // Ambil skor PM, default 0
            
            // Lakukan pengecekan kelayakan purin terlebih dahulu
            $isLayak = $this->determineFoodEligibility($originalFoodItem, $profilPasien);

            $finalScore = 0;
            // Hanya hitung skor gabungan jika makanan layak berdasarkan purin
            if ($isLayak) {
                // Bobot SAW dan PM (bisa disesuaikan)
                $weightSaw = 0.5; 
                $weightPm = 0.5;  
                $finalScore = ($sawScore * $weightSaw) + ($pmScore * $weightPm);
            } else {
                // Beri skor sangat rendah jika tidak layak, agar tidak muncul di atas
                $finalScore = -99999;
            }

            $finalRecommendations->push([
                'makanan_obj' => $originalFoodItem,
                'nama_makanan' => $originalFoodItem->nama_makanan, // Ambil langsung dari objek asli
                'type' => $originalFoodItem->source_type ?? 'Umum',
                'nilai_saw' => $sawScore,
                'nilai_profile_matching' => $pmScore,
                'final_score' => $finalScore,
                'is_layak' => $isLayak,
                'status_layak' => $isLayak ? 'Sangat Direkomendasikan' : 'Tidak Direkomendasikan (Purin Tinggi)',
            ]);
        }

        // Urutkan rekomendasi dari skor tertinggi ke terendah
        return $finalRecommendations->sortByDesc('final_score');
    }

    /**
     * Metode utama untuk menghitung rekomendasi makanan secara menyeluruh.
     *
     * @param ProfilPasien $profilPasien Profil pasien yang relevan.
     * @param Collection $makananCollection Koleksi objek Makanan (baik umum maupun pribadi) yang sudah di-tag dengan 'source_type'.
     * @param Collection $kriteriaCollection Koleksi objek Kriteria.
     * @param bool $includeDetails Mengembalikan detail perhitungan jika true.
     * @return array Hasil rekomendasi dan/atau detail perhitungan.
     */
    public function hitungRekomendasi(ProfilPasien $profilPasien, Collection $makananCollection, Collection $kriteriaCollection, bool $includeDetails = false): array
    {
        // Pastikan ada data untuk dihitung
        if ($makananCollection->isEmpty() || $kriteriaCollection->isEmpty()) {
            return [
                'finalRecommendations' => collect(),
                'matriksKeputusan' => [],
                'normalisasiSAW' => [],
                'peringkatSAW' => [],
                'maxMinValues' => [],
                'normalisasiPM' => [],
                'peringkatPM' => [],
            ];
        }

        // Step 1: Bangun Matriks Keputusan
        $matriksKeputusan = $this->buildMatriksKeputusan($makananCollection, $kriteriaCollection);

        // Step 2: Hitung SAW
        $sawResults = $this->calculateSawScores($matriksKeputusan, $kriteriaCollection);

        // Step 3: Hitung Profile Matching
        $pmResults = $this->calculateProfileMatchingScores($profilPasien, $matriksKeputusan, $kriteriaCollection);

        // Step 4: Gabungkan Hasil & Tentukan Rekomendasi Akhir
        $finalRecommendations = $this->combineResults($makananCollection, $sawResults, $pmResults, $profilPasien);

        // Siapkan hasil untuk dikembalikan
        $response = [
            'finalRecommendations' => $finalRecommendations,
        ];

        // Jika detail diminta, tambahkan ke response
        if ($includeDetails) {
            $response['matriksKeputusan'] = $matriksKeputusan;
            $response['normalisasiSAW'] = $sawResults['normalisasiSAW'];
            $response['peringkatSAW'] = $sawResults['peringkatSAW'];
            $response['maxMinValues'] = $sawResults['maxMinValues'];
            $response['normalisasiPM'] = $pmResults['normalisasiPM'];
            $response['peringkatPM'] = $pmResults['peringkatPM'];
            $response['bobotKriteria'] = $kriteriaCollection->pluck('bobot', 'id'); // Tambahkan bobot kriteria
        }

        return $response;
    }
}
