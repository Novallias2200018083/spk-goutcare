<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke Profil Pasien
    public function profilPasien()
    {
        return $this->hasOne(ProfilPasien::class, 'user_id');
    }

    // Relasi ke Riwayat Rekomendasi
    public function riwayatRekomendasis()
    {
        return $this->hasMany(RiwayatRekomendasi::class, 'user_id');
    }

    // Relasi ke Makanan Custom yang diinput user
    public function makananCustom()
    {
        return $this->hasMany(Makanan::class, 'user_id');
    }
}