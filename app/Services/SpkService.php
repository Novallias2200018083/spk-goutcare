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
                $nilai = $makanan->nilaiKriterias->where('kriteria_id', $kriteria->id)->first()->nilai ?? 0;
                $rowKriteria[$kriteria->id] = $nilai;
            }
            $matriksKeputusan[$makanan->id] = $rowKriteria;
        }
        return $matriksKeputusan;
    }

    /**
     * Removed SAW Calculations.
     */

    /**
     * Helper untuk mendapatkan nilai skala berdasarkan kriteria dan nilai mentah.
     */
    private function getNilaiSkala($kriteriaId, $nilaiMentah): int
    {
        $skala = \App\Models\SkalaKriteria::where('kriteria_id', $kriteriaId)
            ->where('batas_bawah', '<=', $nilaiMentah)
            ->where('batas_atas', '>=', $nilaiMentah)
            ->first();

        // Default to 1 if not found just in case, though it shouldn't happen with proper seeders
        return $skala ? $skala->nilai_skala : 1;
    }

    /**
     * Menghitung skor Profile Matching dengan logika yang sesuai PDF.
     */
    private function calculateProfileMatchingScores(ProfilPasien $profilPasien, array $matriksKeputusan, Collection $kriteriaCollection): array
    {
        $normalisasiPM = [];
        $peringkatPM = [];

        // Mengambil target mentah dari ProfilPasien
        $rawTargets = [
            'Kandungan Purin' => $profilPasien->toleransi_purin,
            'Kandungan Kalori' => $profilPasien->kebutuhan_kalori,
            'Kandungan Lemak' => $profilPasien->kebutuhan_lemak,
            'Kandungan Protein' => $profilPasien->kebutuhan_protein,
            'Kandungan Karbohidrat' => 20, // Default dari contoh studi kasus jika tidak ada di ProfilPasien
        ];

        // Konversi target mentah ke skala 1-5
        $targetKebutuhanSkala = [];
        foreach ($kriteriaCollection as $kriteria) {
            $rawVal = $rawTargets[$kriteria->nama_kriteria] ?? 0;
            // Gunakan nilai target statis seperti PDF (Tabel 2.13) sebagai default fallback yang baik
            if ($kriteria->nama_kriteria === 'Kandungan Purin' && $rawVal == 0) $rawVal = 90;
            if ($kriteria->nama_kriteria === 'Kandungan Kalori' && $rawVal == 0) $rawVal = 120;
            if ($kriteria->nama_kriteria === 'Kandungan Lemak' && $rawVal == 0) $rawVal = 4;
            if ($kriteria->nama_kriteria === 'Kandungan Protein' && $rawVal == 0) $rawVal = 12;
            if ($kriteria->nama_kriteria === 'Kandungan Karbohidrat' && $rawVal == 0) $rawVal = 20;
            
            $targetKebutuhanSkala[$kriteria->nama_kriteria] = $this->getNilaiSkala($kriteria->id, $rawVal);
        }

        foreach ($matriksKeputusan as $makananId => $makananKriteriaValues) {
            $gaps = [];
            $terjemahanGaps = [];
            
            foreach ($kriteriaCollection as $kriteria) {
                $kriteriaNama = $kriteria->nama_kriteria;
                $nilaiMentahMakanan = $makananKriteriaValues[$kriteria->id];
                
                // 1. Konversi profil makanan ke skala 1-5
                $nilaiSkalaMakanan = $this->getNilaiSkala($kriteria->id, $nilaiMentahMakanan);
                $targetSkala = $targetKebutuhanSkala[$kriteriaNama] ?? 3;

                // 2. Hitung Gap = Target_Skala - Makanan_Skala (Sesuai dengan tabel 2.16 di PDF)
                $gap = $targetSkala - $nilaiSkalaMakanan;
                
                // 3. Konversi Gap ke Bobot berdasarkan tabel 2.2
                $bobot = $this->bobotGap[$gap] ?? 1.0; 
                
                $gaps[$kriteria->id] = $gap;
                $terjemahanGaps[$kriteria->id] = $bobot;
            }
            
            // 4. Hitung NCF dan NSF
            $coreFactorSum = 0;
            $coreFactorCount = 0;
            $secondaryFactorSum = 0;
            $secondaryFactorCount = 0;

            foreach ($kriteriaCollection as $kriteria) {
                $kriteriaNama = $kriteria->nama_kriteria;
                $bobotGapValue = $terjemahanGaps[$kriteria->id];

                if ($kriteria->tipe_faktor === 'core') {
                    $coreFactorSum += $bobotGapValue;
                    $coreFactorCount++;
                } else if ($kriteria->tipe_faktor === 'secondary') {
                    $secondaryFactorSum += $bobotGapValue;
                    $secondaryFactorCount++;
                }
            }

            $nilaiCore = ($coreFactorCount > 0) ? ($coreFactorSum / $coreFactorCount) : 0;
            $nilaiSecondary = ($secondaryFactorCount > 0) ? ($secondaryFactorSum / $secondaryFactorCount) : 0;

            // 5. Hitung Nilai Total PM (N)
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
        
        return compact('normalisasiPM', 'peringkatPM', 'targetKebutuhanSkala');
    }

    /**
     * Memeriksa kelayakan makanan berdasarkan toleransi purin.
     */
    private function determineFoodEligibility(Makanan $makanan, ProfilPasien $profilPasien): bool
    {
        $purinKriteria = Kriteria::where('nama_kriteria', 'Kandungan Purin')->first();

        if (!$purinKriteria) {
            return true;
        }

        $nilaiPurinMakanan = $makanan->nilaiKriterias->where('kriteria_id', $purinKriteria->id)->first();

        if ($nilaiPurinMakanan && $profilPasien->toleransi_purin !== null) {
            // Makanan layak jika kadar purin <= toleransi (atau sedikit di atas toleransi jika ingin lebih longgar)
            // Sesuai kaidah medis purin, jika melebihi batas akan berisiko.
            return $nilaiPurinMakanan->nilai <= $profilPasien->toleransi_purin;
        }

        return true; 
    }

    /**
     * Hasil akhir berdasarkan Profile Matching.
     */
    private function formatResults(Collection $makananCollection, array $pmResults, ProfilPasien $profilPasien): Collection
    {
        $finalRecommendations = collect();
        $peringkatPM = collect($pmResults['peringkatPM']);

        foreach ($makananCollection as $originalFoodItem) {
            $makananId = $originalFoodItem->id;
            $pmScore = $peringkatPM->get($makananId, 0);
            $isLayak = $this->determineFoodEligibility($originalFoodItem, $profilPasien);

            $finalScore = 0;
            if ($isLayak) {
                // Skor akhir murni dari PM
                $finalScore = $pmScore;
            } else {
                // Biarkan skor aslinya tetap terlihat untuk transparansi
                $finalScore = $pmScore; 
            }
            
            // Aturan Mutlak
            if (!$isLayak || $finalScore < 3.5) {
                $statusLayak = 'TIDAK DIREKOMENDASIKAN';
            } elseif ($finalScore >= 4.0) {
                $statusLayak = 'DIREKOMENDASIKAN';
            } else {
                // Skor Akhir 3.5 - 3.9
                $statusLayak = 'CUKUP DIREKOMENDASIKAN';
            }

            $finalRecommendations->push([
                'makanan_obj' => $originalFoodItem,
                'nama_makanan' => $originalFoodItem->nama_makanan,
                'type' => $originalFoodItem->source_type ?? 'Umum',
                'nilai_saw' => 0, // Dihapus
                'nilai_profile_matching' => $pmScore,
                'final_score' => $finalScore,
                'is_layak' => ($isLayak && $finalScore >= 3.5),
                'status_layak' => $statusLayak,
            ]);
        }

        return $finalRecommendations->sortByDesc('final_score');
    }

    /**
     * Metode utama untuk menghitung rekomendasi makanan.
     */
    public function hitungRekomendasi(ProfilPasien $profilPasien, Collection $makananCollection, Collection $kriteriaCollection, bool $includeDetails = false): array
    {
        // Validasi input
        if ($makananCollection->isEmpty() || $kriteriaCollection->isEmpty()) {
            return [
                'finalRecommendations' => collect(),
                'matriksKeputusan' => [],
                'normalisasiPM' => [],
                'peringkatPM' => [],
            ];
        }

        try {
            // Step 1: Bangun Matriks Keputusan
            $matriksKeputusan = $this->buildMatriksKeputusan($makananCollection, $kriteriaCollection);

            // Step 2: Hitung Profile Matching
            $pmResults = $this->calculateProfileMatchingScores($profilPasien, $matriksKeputusan, $kriteriaCollection);

            // Step 3: Format Hasil
            $finalRecommendations = $this->formatResults($makananCollection, $pmResults, $profilPasien);

            // Siapkan response
            $response = [
                'finalRecommendations' => $finalRecommendations,
            ];

            if ($includeDetails) {
                $response['matriksKeputusan'] = $matriksKeputusan;
                $response['normalisasiPM'] = $pmResults['normalisasiPM'];
                $response['peringkatPM'] = $pmResults['peringkatPM'];
                $response['targetKebutuhanSkala'] = $pmResults['targetKebutuhanSkala'];
                $response['bobotKriteria'] = $kriteriaCollection->pluck('tipe_faktor', 'id');
            }

            return $response;

        } catch (\Exception $e) {
            Log::error('Error dalam perhitungan rekomendasi: ' . $e->getMessage());
            return [
                'finalRecommendations' => collect(),
                'error' => 'Terjadi kesalahan dalam perhitungan rekomendasi: ' . $e->getMessage(),
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
            'normalisasi_pm' => $result['normalisasiPM'] ?? [],
            'peringkat_pm' => $result['peringkatPM'] ?? [],
            'rekomendasi_akhir' => $result['finalRecommendations']->take(10)->toArray(),
        ];

        return $formattedResult;
    }
}