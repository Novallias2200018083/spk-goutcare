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
}