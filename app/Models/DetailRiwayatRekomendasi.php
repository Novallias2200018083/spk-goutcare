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
        
        if (!$makanan || !$profil) return "Insight tidak tersedia karena data profil atau makanan tidak lengkap.";

        // Cari kadar purin makanan
        $purinItem = $makanan->nilaiKriterias->first(function($nk) {
            return str_contains(strtolower($nk->kriteria->nama_kriteria), 'purin');
        });
        
        $purinMakanan = $purinItem ? $purinItem->nilai : 0;
        $toleransiPurin = $profil->toleransi_purin;
        $insight = "";

        // Pengecekan mutlak medis (Purin melebihi batas) atau skor kurang dari 3.5
        if ($purinMakanan > $toleransiPurin || $this->nilai_akhir < 3.5) {
            $insight = "⚠️ **ANALISIS : TIDAK DIREKOMENDASIKAN**\n\n";
            $insight .= "Makanan ini **TIDAK DIREKOMENDASIKAN** untuk Anda konsumsi. ";
            if ($purinMakanan > $toleransiPurin) {
                $insight .= "Terdapat **kandungan purin yang terlampau tinggi (" . $purinMakanan . " mg)**, menembus batas maksimal toleransi harian tubuh Anda (" . $toleransiPurin . " mg). ";
            }
            if ($this->nilai_akhir < 3.5) {
                $insight .= "Selain itu, profil makronutrisi makanan ini **sangat meleset** dari angka ideal yang dibutuhkan oleh fisik Anda (Skor kecocokan hanya " . number_format($this->nilai_akhir, 2) . " / 5.0). ";
            }
            $insight .= "Memaksakan untuk mengonsumsi menu ini memiliki probabilitas tinggi untuk **memicu penumpukan kristal asam urat, pembengkakan sendi, dan serangan gout akut**. Mohon hindari menu ini demi kesehatan Anda.";
        } 
        // Jika Purin Aman dan Skor >= 3.5
        else {
            if ($this->nilai_akhir >= 4.0) {
                $insight = "✨ **ANALISIS : DIREKOMENDASIKAN**\n\n";
                $insight .= "Berita baik! Makanan ini merupakan **pilihan menu yang luar biasa sehat dan sangat selaras** dengan kondisi tubuh Anda. ";
                $insight .= "Kandungan purinnya yang sebesar **" . $purinMakanan . " mg** masih berada dalam teritori yang sangat aman (Toleransi Anda: " . $toleransiPurin . " mg). ";
                $insight .= "Sistem mencatat tingkat kecocokan gizi yang **sangat baik (Skor: " . number_format($this->nilai_akhir, 2) . " / 5.0)**, memastikan tubuh Anda mendapatkan asupan energi dan nutrisi yang pas tanpa berisiko menaikkan kadar asam urat secara drastis. Silakan nikmati menu ini dengan tenang!";
            } else {
                $insight = "✅ **ANALISIS MODERAT : CUKUP DIREKOMENDASIKAN**\n\n";
                $insight .= "Makanan ini adalah opsi yang **cukup baik dan relatif aman** sebagai alternatif harian Anda. ";
                $insight .= "Dengan angka purin **" . $purinMakanan . " mg**, makanan ini tidak akan melewati ambang batas maksimal Anda (" . $toleransiPurin . " mg). ";
                $insight .= "Secara keseluruhan komposisi gizi, makanan ini terbilang cukup seimbang (Skor: " . number_format($this->nilai_akhir, 2) . " / 5.0). Meski bukan opsi yang paling sempurna mutlak, makanan ini sangat ideal dikonsumsi dalam porsi wajar tanpa memprovokasi serangan gout Anda.";
            }
        }

        return $insight;
    }
}