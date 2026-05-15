<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $fillable = [
        'provinsi',
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'gol_darah',
        'alamat',
        'kel_desa',
        'kecamatan',
        'agama',
        'status_pernikahan',
        'pekerjaan',
        'kewarganegaraan',
        'latitude_rumah',
        'longitude_rumah',
    ];
}
