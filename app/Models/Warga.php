<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'penghasilan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'penghasilan' => 'integer',
    ];

    public function getUsiaAttribute()
    {
        return $this->tanggal_lahir
            ? Carbon::parse($this->tanggal_lahir)->age
            : null;
    }
}
