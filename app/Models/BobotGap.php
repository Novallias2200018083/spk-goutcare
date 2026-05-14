<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BobotGap extends Model
{
    use HasFactory;

    protected $table = 'bobot_gaps';

    protected $fillable = [
        'selisih_gap',
        'bobot_nilai',
        'keterangan',
    ];
}