<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

/**
 * @property int $id
 * @property int $makanan_id
 * @property int $kriteria_id
 * @property float $nilai
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kriteria $kriteria
 * @property-read \App\Models\Makanan $makanan
 */
class NilaiKriteriaMakanan extends Model
{
    use HasFactory;
    protected $fillable = ['makanan_id', 'kriteria_id', 'nilai'];

    /**
     * Get the makanan that owns the NilaiKriteriaMakanan.
     * @return BelongsTo
     */
    public function makanan(): BelongsTo
    {
        return $this->belongsTo(Makanan::class);
    }

    /**
     * Get the kriteria that owns the NilaiKriteriaMakanan.
     * @return BelongsTo
     */
    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class);
    }
}