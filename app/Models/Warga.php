<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $fillable = [
        'nik',
        'nama',
        'alamat',
        'penghasilan',
        'jumlah_tanggungan',
        'foto_rumah'
    ];
}
