<?php

namespace App\Services;

use App\Models\Makanan;
use App\Models\Kriteria;
use App\Models\ProfilPasien;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class SpkService
{
    /**
     * Mengatur bobot untuk selisih (gap) dalam metode Profile Matching.
     * Disesuaikan dengan contoh perhitungan manual.
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
    ];

    /**
     * Faktor inti dan sekunder untuk Profile Matching.
     * Sesuai dengan contoh: Core = Purin & Protein, Secondary = Kalori & Lemak
     */
    protected array $coreFactors = ['Kadar Purin', 'Protein'];
    protected array $secondaryFactors = ['Kalori', 'Lemak'];

    /**
     * Bobot persentase untuk faktor inti dan sekunder dalam Profile Matching.
     */
    protected float $persentaseCore = 0.6;
    protected float $persentaseSecondary = 0.4;

    /**
     * Ambil semua kriteria yang relevan dari database.
     */
    protected function getKriterias(): Collection
    {
        return Kriteria::all();
    }

    /**
     * Membangun matriks keputusan awal dari koleksi makanan dan kriteria.
     */
    private function buildMatriksKeputusan(Collection $makananCollection, Collection $kriteriaCollection): array
    {
        $matriksKeputusan = [];
        foreach ($makananCollection as $makanan) {
            $rowKriteria = [];
            foreach ($kriteriaCollection as $kriteria) {
                $nilai = $makanan->nilaiKriteria->where('kriteria_id', $kriteria->id)->first()->nilai ?? 0;
                $rowKriteria[$kriteria->id] = $nilai;
            }
            $matriksKeputusan[$makanan->id] = $rowKriteria;
        }
        return $matriksKeputusan;
    }

    /**
     * Menghitung skor SAW dengan normalisasi yang benar.
     * PERBAIKAN: Normalisasi SAW yang tepat sesuai rumus standar.
     */
    private function calculateSawScores(array $matriksKeputusan, Collection $kriteriaCollection): array
    {
        $normalisasiSAW = [];
        $maxMinValues = [];

        // Temukan nilai Max/Min untuk setiap kriteria
        foreach ($kriteriaCollection as $kriteria) {
            $values = [];
            foreach ($matriksKeputusan as $makananId => $kriteriaValues) {
                $values[] = $kriteriaValues[$kriteria->id] ?? 0;
            }

            if (!empty($values)) {
                $maxVal = max($values);
                $minVal = min($values);
                
                // Pastikan tidak ada pembagian dengan nol
                if ($maxVal == 0) $maxVal = 0.0001;
                if ($minVal == 0) $minVal = 0.0001;
                
                $maxMinValues[$kriteria->id] = ['max' => $maxVal, 'min' => $minVal];
            }
        }

        // Lakukan Normalisasi SAW dengan rumus yang benar
        foreach ($matriksKeputusan as $makananId => $makananKriteriaValues) {
            $normalizedRow = [];
            foreach ($kriteriaCollection as $kriteria) {
                $nilai = $makananKriteriaValues[$kriteria->id];
                $maxMin = $maxMinValues[$kriteria->id];

                $normalizedValue = 0;
                if ($kriteria->tipe === 'benefit') {
                    // Untuk benefit: R[i,j] = X[i,j] / Max(X[i,j])
                    if ($maxMin['max'] != 0) {
                        $normalizedValue = $nilai / $maxMin['max'];
                    }
                } else { // 'cost'
                    // Untuk cost: R[i,j] = Min(X[i,j]) / X[i,j]
                    if ($nilai != 0) {
                        $normalizedValue = $maxMin['min'] / $nilai;
                    }
                }
                $normalizedRow[$kriteria->id] = $normalizedValue;
            }
            $normalisasiSAW[$makananId] = $normalizedRow;
        }

        // Hitung Skor SAW (Weighted Sum)
        $peringkatSAW = [];
        foreach ($normalisasiSAW as $makananId => $normalizedMakananKriteria) {
            $score = 0;
            foreach ($kriteriaCollection as $kriteria) {
                $bobot = $kriteria->bobot;
                $normalizedValue = $normalizedMakananKriteria[$kriteria->id] ?? 0;
                $score += $normalizedValue * $bobot;
            }
            $peringkatSAW[$makananId] = $score;
        }

        return compact('normalisasiSAW', 'peringkatSAW', 'maxMinValues');
    }

    /**
     * Menghitung skor Profile Matching dengan logika yang diperbaiki.
     * PERBAIKAN: Perhitungan gap yang sesuai dengan contoh manual.
     */
    private function calculateProfileMatchingScores(ProfilPasien $profilPasien, array $matriksKeputusan, Collection $kriteriaCollection): array
    {
        $normalisasiPM = [];
        $peringkatPM = [];

        $targetKebutuhan = [
            'Kadar Purin' => $profilPasien->toleransi_purin,
            'Kalori' => $profilPasien->kebutuhan_kalori,
            'Protein' => $profilPasien->kebutuhan_protein,
            'Lemak' => $profilPasien->kebutuhan_lemak,
        ];

        foreach ($matriksKeputusan as $makananId => $makananKriteriaValues) {
            $gaps = [];
            $terjemahanGaps = [];
            
            foreach ($kriteriaCollection as $kriteria) {
                $kriteriaNama = $kriteria->nama_kriteria;
                $nilaiMakanan = $makananKriteriaValues[$kriteria->id];
                $targetNilai = $targetKebutuhan[$kriteriaNama] ?? null;

                if ($targetNilai === null || $targetNilai == 0) {
                    $gap = 0;
                    $bobot = 5.0;
                } else {
                    // Hitung gap mentah terlebih dahulu
                    $rawGap = $nilaiMakanan - $targetNilai;

                    // Perlakuan khusus untuk kriteria 'Cost' seperti Purin
                    if ($kriteria->tipe === 'cost' && $kriteriaNama === 'Kadar Purin') {
                        if ($nilaiMakanan <= $targetNilai) {
                            // Jika di bawah atau sama dengan toleransi = sempurna
                            $gap = 0;
                        } else {
                            // Jika melebihi toleransi, hitung gap positif
                            // Setiap 10mg kelebihan = 1 gap (sesuai contoh manual)
                            $gap = ceil(($nilaiMakanan - $targetNilai) / 10);
                            $gap = max(1, min(5, $gap)); // Batasi 1-5 untuk kelebihan
                        }
                    } else {
                        // Untuk kriteria lain, gunakan skala yang disesuaikan
                        if ($kriteriaNama === 'Kalori') {
                            // Untuk kalori: setiap 25 kkal = 1 gap
                            $gap = round($rawGap / 25);
                        } elseif ($kriteriaNama === 'Protein') {
                            // Untuk protein: setiap 5g = 1 gap
                            $gap = round($rawGap / 5);
                        } elseif ($kriteriaNama === 'Lemak') {
                            // Untuk lemak: setiap 3g = 1 gap
                            $gap = round($rawGap / 3);
                        } else {
                            // Default: bulatkan langsung
                            $gap = round($rawGap);
                        }
                        
                        // Batasi gap antara -5 dan 5
                        $gap = max(-5, min(5, $gap));
                    }
                    
                    $bobot = $this->bobotGap[$gap] ?? 0.1;
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

            $normalisasiPM[$makananId] = [
                'gap' => $gaps,
                'terjemahan_gap' => $terjemahanGaps,
                'nilai_ncf' => $nilaiCore,
                'nilai_nsf' => $nilaiSecondary,
                'nilai_total_pm' => $totalProfileMatching,
            ];

            $peringkatPM[$makananId] = $totalProfileMatching;
        }
        
        return compact('normalisasiPM', 'peringkatPM');
    }

    /**
     * Memeriksa kelayakan makanan berdasarkan toleransi purin.
     * PERBAIKAN: Logika yang lebih jelas dan konsisten.
     */
    private function determineFoodEligibility(Makanan $makanan, ProfilPasien $profilPasien): bool
    {
        $purinKriteria = Kriteria::where('nama_kriteria', 'Kadar Purin')->first();

        if (!$purinKriteria) {
            Log::warning('Kriteria "Kadar Purin" tidak ditemukan di database.');
            return true;
        }

        $nilaiPurinMakanan = $makanan->nilaiKriteria->where('kriteria_id', $purinKriteria->id)->first();

        if ($nilaiPurinMakanan && $profilPasien->toleransi_purin !== null) {
            // Makanan layak jika kadar purin <= toleransi
            return $nilaiPurinMakanan->nilai <= $profilPasien->toleransi_purin;
        }

        return true; // Default layak jika tidak ada data
    }

    /**
     * Menggabungkan hasil SAW dan Profile Matching untuk rekomendasi akhir.
     * PERBAIKAN: Skor gabungan yang seimbang dan logis.
     */
    private function combineResults(Collection $makananCollection, array $sawResults, array $pmResults, ProfilPasien $profilPasien): Collection
    {
        $finalRecommendations = collect();

        $peringkatSAW = collect($sawResults['peringkatSAW']);
        $peringkatPM = collect($pmResults['peringkatPM']);

        foreach ($makananCollection as $originalFoodItem) {
            $makananId = $originalFoodItem->id;

            $sawScore = $peringkatSAW->get($makananId, 0);
            $pmScore = $peringkatPM->get($makananId, 0);
            
            $isLayak = $this->determineFoodEligibility($originalFoodItem, $profilPasien);

            $finalScore = 0;
            if ($isLayak) {
                // Bobot seimbang antara SAW dan PM
                $weightSaw = 0.5;
                $weightPm = 0.5;
                $finalScore = ($sawScore * $weightSaw) + ($pmScore * $weightPm);
            } else {
                // Skor sangat rendah untuk makanan tidak layak
                $finalScore = -99999;
            }

            $finalRecommendations->push([
                'makanan_obj' => $originalFoodItem,
                'nama_makanan' => $originalFoodItem->nama_makanan,
                'type' => $originalFoodItem->source_type ?? 'Umum',
                'nilai_saw' => $sawScore,
                'nilai_profile_matching' => $pmScore,
                'final_score' => $finalScore,
                'is_layak' => $isLayak,
                'status_layak' => $isLayak ? 'Sangat Direkomendasikan' : 'Tidak Direkomendasikan (Purin Tinggi)',
            ]);
        }

        return $finalRecommendations->sortByDesc('final_score');
    }

    /**
     * Metode utama untuk menghitung rekomendasi makanan.
     * PERBAIKAN: Struktur yang lebih bersih dan handling error yang lebih baik.
     */
    public function hitungRekomendasi(ProfilPasien $profilPasien, Collection $makananCollection, Collection $kriteriaCollection, bool $includeDetails = false): array
    {
        // Validasi input
        if ($makananCollection->isEmpty() || $kriteriaCollection->isEmpty()) {
            Log::warning('Data makanan atau kriteria kosong saat menghitung rekomendasi.');
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

        try {
            // Step 1: Bangun Matriks Keputusan
            $matriksKeputusan = $this->buildMatriksKeputusan($makananCollection, $kriteriaCollection);

            // Step 2: Hitung SAW
            $sawResults = $this->calculateSawScores($matriksKeputusan, $kriteriaCollection);

            // Step 3: Hitung Profile Matching
            $pmResults = $this->calculateProfileMatchingScores($profilPasien, $matriksKeputusan, $kriteriaCollection);

            // Step 4: Gabungkan Hasil
            $finalRecommendations = $this->combineResults($makananCollection, $sawResults, $pmResults, $profilPasien);

            // Siapkan response
            $response = [
                'finalRecommendations' => $finalRecommendations,
            ];

            if ($includeDetails) {
                $response['matriksKeputusan'] = $matriksKeputusan;
                $response['normalisasiSAW'] = $sawResults['normalisasiSAW'];
                $response['peringkatSAW'] = $sawResults['peringkatSAW'];
                $response['maxMinValues'] = $sawResults['maxMinValues'];
                $response['normalisasiPM'] = $pmResults['normalisasiPM'];
                $response['peringkatPM'] = $pmResults['peringkatPM'];
                $response['bobotKriteria'] = $kriteriaCollection->pluck('bobot', 'id');
            }

            return $response;

        } catch (\Exception $e) {
            Log::error('Error dalam perhitungan rekomendasi: ' . $e->getMessage());
            return [
                'finalRecommendations' => collect(),
                'error' => 'Terjadi kesalahan dalam perhitungan rekomendasi.',
            ];
        }
    }

    /**
     * Method tambahan untuk debugging - menampilkan detail perhitungan
     */
    public function getDetailedCalculation(ProfilPasien $profilPasien, Collection $makananCollection, Collection $kriteriaCollection): array
    {
        $result = $this->hitungRekomendasi($profilPasien, $makananCollection, $kriteriaCollection, true);
        
        // Format hasil untuk lebih mudah dibaca
        $formattedResult = [
            'profil_pasien' => [
                'toleransi_purin' => $profilPasien->toleransi_purin,
                'kebutuhan_kalori' => $profilPasien->kebutuhan_kalori,
                'kebutuhan_protein' => $profilPasien->kebutuhan_protein,
                'kebutuhan_lemak' => $profilPasien->kebutuhan_lemak,
            ],
            'matriks_keputusan' => $result['matriksKeputusan'] ?? [],
            'normalisasi_saw' => $result['normalisasiSAW'] ?? [],
            'peringkat_saw' => $result['peringkatSAW'] ?? [],
            'normalisasi_pm' => $result['normalisasiPM'] ?? [],
            'peringkat_pm' => $result['peringkatPM'] ?? [],
            'rekomendasi_akhir' => $result['finalRecommendations']->take(10)->toArray(),
        ];

        return $formattedResult;
    }
}