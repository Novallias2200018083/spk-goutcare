<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property float|null $kebutuhan_kalori
 * @property float|null $kebutuhan_protein
 * @property float|null $kebutuhan_lemak
 * @property float|null $toleransi_purin
 * @property string|null $catatan_tambahan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfilPasien newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfilPasien newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfilPasien query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfilPasien whereCatatanTambahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfilPasien whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfilPasien whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfilPasien whereKebutuhanKalori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfilPasien whereKebutuhanLemak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfilPasien whereKebutuhanProtein($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfilPasien whereToleransiPurin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfilPasien whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfilPasien whereUserId($value)
 * @mixin \Eloquent
 */
class ProfilPasien extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'kebutuhan_kalori',
        'kebutuhan_protein',
        'kebutuhan_lemak',
        'toleransi_purin',
        'catatan_tambahan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}