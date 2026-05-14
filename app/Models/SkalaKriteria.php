<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkalaKriteria extends Model
{
    use HasFactory;

    protected $table = 'skala_kriterias';

    protected $fillable = [
        'kriteria_id',
        'batas_bawah',
        'batas_atas',
        'nilai_skala',
        'keterangan',
    ];

    // Relasi balik ke Kriteria
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}