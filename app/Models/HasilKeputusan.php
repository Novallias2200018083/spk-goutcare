<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilKeputusan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hasil_keputusans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'makanan_terpilih_id',
        'tanggal_keputusan',
        'nilai_saw',
        'nilai_profile_matching',
        'rekomendasi_akhir',
        'is_layak',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_keputusan' => 'datetime',
        'is_layak' => 'boolean',
    ];

    /**
     * Get the user that owns the decision result.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the selected food associated with the decision result.
     */
    public function makananTerpilih()
    {
        return $this->belongsTo(Makanan::class, 'makanan_terpilih_id');
    }
}