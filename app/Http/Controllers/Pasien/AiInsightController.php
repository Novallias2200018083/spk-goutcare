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

        // Siapkan Prompt untuk dikirim ke AI Eksternal (Gemini / OpenAI)
        $prompt = "Kamu adalah ahli gizi spesialis penyakit Asam Urat (Gout). "
                . "Pasien memiliki batas toleransi purin " . $profil->toleransi_purin . " mg, "
                . "butuh " . $profil->kebutuhan_kalori . " kalori, dan " . $profil->kebutuhan_protein . " gram protein harian.\n"
                . "Pasien ingin makan '" . $makanan->nama_makanan . "' yang mengandung ";
        
        foreach ($makanan->nilaiKriterias as $nk) {
            $prompt .= $nk->nilai . " " . $nk->kriteria->nama_kriteria . ", ";
        }

        $prompt .= "Berdasarkan sistem SPK, makanan ini berstatus '" . $detail->status_kelayakan . "'.\n"
                 . "Tolong berikan analisis singkat (maksimal 3 kalimat) dengan gaya bahasa yang empati, profesional, dan mudah dipahami pasien, mengapa makanan ini direkomendasikan atau dilarang. Gunakan format markdown tebal untuk penekanan.";

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
