<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailRiwayatRekomendasi extends Model
{
    use HasFactory;

    protected $table = 'detail_riwayat_rekomendasis';

    protected $fillable = [
        'riwayat_id',
        'makanan_id',
        'nilai_ncf',
        'nilai_nsf',
        'nilai_akhir',
        'status_kelayakan',
    ];

    public function riwayat()
    {
        return $this->belongsTo(RiwayatRekomendasi::class, 'riwayat_id');
    }

    public function makanan()
    {
        return $this->belongsTo(Makanan::class, 'makanan_id');
    }

    public function getAiInsightAttribute()
    {
        $makanan = $this->makanan;
        $profil = $this->riwayat->user->profilPasien ?? null;
        
        if (!$makanan || !$profil) return "Insight AI tidak tersedia karena data profil atau makanan tidak lengkap.";

        // Cari kadar purin makanan
        $purinItem = $makanan->nilaiKriterias->first(function($nk) {
            return str_contains(strtolower($nk->kriteria->nama_kriteria), 'purin');
        });
        
        $purinMakanan = $purinItem ? $purinItem->nilai : 0;
        $toleransiPurin = $profil->toleransi_purin;
        $insight = "";

        // Pengecekan mutlak medis (Purin melebihi batas)
        if ($purinMakanan > $toleransiPurin) {
            $insight = "⚠️ **Peringatan AI:** Meskipun sistem memberikan skor kecocokan gizi " . number_format($this->nilai_akhir, 2) . ", makanan ini **Sangat Berbahaya** dan **Tidak Direkomendasikan** untuk kondisi Anda saat ini. ";
            $insight .= "Alasan utamanya adalah kandungan purinnya (" . $purinMakanan . " mg) telah melewati batas maksimal toleransi harian Anda (" . $toleransiPurin . " mg). Mengonsumsi ini sangat berisiko memicu pembengkakan/serangan Asam Urat (Gout).";
        } 
        // Jika Purin Aman, cek status dari sistem Profile Matching
        else {
            $status = strtolower($this->status_kelayakan);
            if (str_contains($status, 'tidak') || str_contains($status, 'kurang')) {
                $insight = "💡 **Analisis AI:** Makanan ini **" . $this->status_kelayakan . "** untuk Anda. ";
                $insight .= "Meskipun kandungan purinnya (" . $purinMakanan . " mg) sebenarnya aman (batas: " . $toleransiPurin . " mg), namun komposisi gizi lainnya (Kalori, Lemak, atau Karbohidrat) sangat jauh meleset dari profil kebutuhan ideal Anda (Skor kecocokan hanya " . number_format($this->nilai_akhir, 2) . ").";
            } else {
                $insight = "✨ **Analisis AI:** Makanan ini **" . $this->status_kelayakan . "**! ";
                $insight .= "Kandungan purinnya (" . $purinMakanan . " mg) berada di zona aman (batas Anda: " . $toleransiPurin . " mg). ";
                
                if ($this->nilai_ncf >= 4.0 && $this->nilai_nsf >= 4.0) {
                    $insight .= "Hebatnya lagi, makanan ini memiliki kecocokan Faktor Utama (Protein) dan Faktor Pendukung (Kalori/Lemak) yang nyaris sempurna dengan profil gizi Anda (Skor PM: " . number_format($this->nilai_akhir, 2) . "). Ini adalah pilihan diet harian yang sangat cerdas.";
                } elseif ($this->nilai_ncf >= 4.0) {
                    $insight .= "Makanan ini direkomendasikan karena kecocokan Core Factor-nya kuat (Nilai NCF: " . number_format($this->nilai_ncf, 2) . "), artinya asupan protein dan batas purin harian Anda dapat terjaga dengan baik.";
                } else {
                    $insight .= "Secara keseluruhan, makanan ini adalah alternatif yang aman dan cukup baik menyeimbangkan asupan gizi harian Anda berdasarkan kalkulasi Profile Matching.";
                }
            }
        }

        return $insight;
    }
}