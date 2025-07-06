<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo
use Illuminate\Database\Eloquent\Relations\HasMany; // Import HasMany

/**
 * @property int $id
 * @property string $nama_makanan
 * @property string|null $deskripsi
 * @property bool $is_user_input // Kolom baru dari migrasi alter
 * @property int|null $user_id // Kolom baru dari migrasi alter
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NilaiKriteriaMakanan> $nilaiKriteria
 * @property-read int|null $nilai_kriteria_count
 * @property-read \App\Models\User|null $user // Relasi ke User
 */
class Makanan extends Model
{
    use HasFactory;
    // Tambahkan 'is_user_input' dan 'user_id' ke fillable karena akan diisi
    protected $fillable = ['nama_makanan', 'deskripsi', 'is_user_input', 'user_id'];

    /**
     * Get all of the NilaiKriteriaMakanan for the Makanan.
     * @return HasMany
     */
    public function nilaiKriteria(): HasMany
    {
        return $this->hasMany(NilaiKriteriaMakanan::class);
    }

    /**
     * Get the user that owns the Makanan, if it's user-input.
     * @return BelongsTo
     */
    public function user(): BelongsTo // Relasi untuk makanan yang diinput user
    {
        return $this->belongsTo(User::class);
    }
}