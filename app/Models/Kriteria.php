<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import HasMany

/**
 * @property int $id
 * @property string $nama_kriteria
 * @property float $bobot
 * @property string $tipe
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NilaiKriteriaMakanan> $nilaiMakanan
 * @property-read int|null $nilai_makanan_count
 */
class Kriteria extends Model
{
    use HasFactory;
    protected $fillable = ['nama_kriteria', 'bobot', 'tipe'];

    /**
     * Get all of the NilaiKriteriaMakanan for the Kriteria.
     * @return HasMany
     */
    public function nilaiMakanan(): HasMany
    {
        return $this->hasMany(NilaiKriteriaMakanan::class);
    }
}