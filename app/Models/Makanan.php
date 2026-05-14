<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;

    protected $table = 'makanans';

    protected $fillable = [
        'nama_makanan',
        'deskripsi',
        'is_user_input',
        'user_id',
    ];

    // Relasi ke User yang menginput (jika makanan custom)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke nilai gizi/kriteria makanan tersebut
    public function nilaiKriterias()
    {
        return $this->hasMany(NilaiKriteriaMakanan::class, 'makanan_id');
    }

    // Relasi jika makanan ini masuk dalam riwayat rekomendasi
    public function detailRiwayats()
    {
        return $this->hasMany(DetailRiwayatRekomendasi::class, 'makanan_id');
    }
}