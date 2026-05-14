<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiKriteriaMakanan extends Model
{
    use HasFactory;

    protected $table = 'nilai_kriteria_makanans';

    protected $fillable = [
        'makanan_id',
        'kriteria_id',
        'nilai',
    ];

    public function makanan()
    {
        return $this->belongsTo(Makanan::class, 'makanan_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}