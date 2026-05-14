<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilPasien extends Model
{
    use HasFactory;

    protected $table = 'profil_pasiens';

    protected $fillable = [
        'user_id',
        'metode_input',
        'jenis_kelamin',
        'umur',
        'berat_badan',
        'tinggi_badan',
        'tingkat_aktivitas',
        'fase_asam_urat',
        'kebutuhan_kalori',
        'kebutuhan_protein',
        'kebutuhan_lemak',
        'kebutuhan_karbohidrat',
        'toleransi_purin',
        'catatan_tambahan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}