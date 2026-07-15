<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DetailRiwayatRekomendasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiInsightController extends Controller
{
    public function generate(Request $request, $id)
    {
        $detail = DetailRiwayatRekomendasi::with(['makanan.nilaiKriterias.kriteria', 'riwayat.user.profilPasien'])->find($id);
        
        if (!$detail) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $makanan = $detail->makanan;
        $profil = $detail->riwayat->user->profilPasien;

        $purinItem = $makanan->nilaiKriterias->first(function($nk) {
            return str_contains(strtolower($nk->kriteria->nama_kriteria), 'purin');
        });
        $purin = $purinItem ? $purinItem->nilai : 0;
        $skor_akhir = $detail->nilai_akhir;
        $batas_pasien = $profil->toleransi_purin;

        // Siapkan Prompt untuk dikirim ke AI Eksternal (Gemini / OpenAI)
        $prompt = "Kamu adalah ahli gizi spesialis penyakit Asam Urat (Gout). "
                . "Pasien memiliki batas toleransi purin " . $batas_pasien . " mg, "
                . "butuh " . $profil->kebutuhan_kalori . " kalori, dan " . $profil->kebutuhan_protein . " gram protein harian.\n"
                . "Pasien ingin makan '" . $makanan->nama_makanan . "' yang mengandung ";
        
        foreach ($makanan->nilaiKriterias as $nk) {
            $prompt .= $nk->nilai . " " . $nk->kriteria->nama_kriteria . ", ";
        }

        $prompt .= "\nAturan mutlak:\n"
                 . "1. Nilai skor maksimal adalah 5.0.\n"
                 . "2. Jika Skor Akhir >= 4.0, maka makanan ini SANGAT DIREKOMENDASIKAN karena profil gizi sangat cocok.\n"
                 . "3. Jika Skor Akhir 3.5 - 3.9, makanan ini CUKUP DIREKOMENDASIKAN.\n"
                 . "4. Jika Skor Akhir < 3.5 ATAU Purin > Batas Pasien, makanan ini BAHAYA / TIDAK DIREKOMENDASIKAN karena jauh meleset.\n"
                 . "Sekarang buat narasinya untuk makanan dengan purin " . $purin . " dan skor " . number_format($skor_akhir, 2) . ".\n"
                 . "Tolong berikan analisis komprehensif (maksimal 5 kalimat) dengan gaya bahasa yang sangat empati, profesional, dan memberikan edukasi yang menenangkan pasien. Jelaskan mengapa makanan ini direkomendasikan atau dilarang secara detail sesuai aturan di atas. Gunakan format markdown tebal untuk penekanan dan buat hasilnya terlihat sangat bagus.";

        // CONTOH INTEGRASI MENGGUNAKAN GOOGLE GEMINI API
        $apiKey = env('GEMINI_API_KEY'); // Pastikan kunci API diisi di file .env

        if (!$apiKey) {
            // Fallback jika API Key belum dipasang
            return response()->json([
                'insight' => "🔑 *Kunci API AI Eksternal belum dikonfigurasi di file .env.* Namun berdasarkan sistem: " . $detail->ai_insight
            ]);
        }

        try {
            // Menggunakan withoutVerifying() karena Laragon sering mengalami isu SSL Certificate (cURL error 60)
            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent?key=" . $apiKey, [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ]
            ]);

            if ($response->successful()) {
                $aiText = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? null;
                if ($aiText) {
                    return response()->json(['insight' => $aiText]);
                }
                return response()->json(['insight' => "AI Eksternal mengembalikan respons kosong."]);
            }

            // Menampilkan pesan error asli dari API agar kita tahu apa masalahnya
            return response()->json(['insight' => "Error API Gemini (Status " . $response->status() . "): " . $response->body()]);

        } catch (\Exception $e) {
            return response()->json(['insight' => "Terjadi kesalahan sistem/koneksi: " . $e->getMessage()]);
        }
    }
}
