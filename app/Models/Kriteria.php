<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriterias';

    protected $fillable = [
        'nama_kriteria',
        'tipe_faktor',
    ];

    // Satu kriteria memiliki banyak skala penilaian
    public function skalaKriterias()
    {
        return $this->hasMany(SkalaKriteria::class, 'kriteria_id');
    }

    // Satu kriteria memiliki banyak nilai yang terkait dengan makanan
    public function nilaiMakanans()
    {
        return $this->hasMany(NilaiKriteriaMakanan::class, 'kriteria_id');
    }
}