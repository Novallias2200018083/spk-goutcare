<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatRekomendasi extends Model
{
    use HasFactory;

    protected $table = 'riwayat_rekomendasis';

    protected $fillable = [
        'user_id',
        'tanggal_rekomendasi',
    ];

    protected $casts = [
        'tanggal_rekomendasi' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detailRiwayats()
    {
        return $this->hasMany(DetailRiwayatRekomendasi::class, 'riwayat_id');
    }
}