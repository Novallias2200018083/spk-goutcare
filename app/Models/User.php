<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import HasMany
use Illuminate\Database\Eloquent\Relations\HasOne; // Import HasOne

/**
 * @property string $name
 * @property string $email
 * @property string $role
 * @property-read \App\Models\ProfilPasien|null $profilPasien
 * @property-read Collection|\App\Models\HasilKeputusan[] $hasilKeputusan
 * @property-read Collection|\App\Models\Makanan[] $makanans // Relasi untuk makanan pribadi user
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $hasil_keputusan_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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

    /**
     * Mendapatkan profil pasien yang terkait dengan user.
     * @return HasOne
     */
    public function profilPasien(): HasOne
    {
        return $this->hasOne(ProfilPasien::class);
    }

    /**
     * Mendapatkan riwayat hasil keputusan yang terkait dengan user.
     * @return HasMany
     */
    public function hasilKeputusan(): HasMany
    {
        return $this->hasMany(HasilKeputusan::class);
    }

    /**
     * Mendapatkan semua makanan yang diinput pribadi oleh user ini.
     * @return HasMany
     */
    public function makanans(): HasMany // Relasi untuk makanan yang diinput user
    {
        // Menghubungkan ke tabel Makanan dengan filter is_user_input=true
        return $this->hasMany(Makanan::class, 'user_id', 'id')->where('is_user_input', true);
    }
}