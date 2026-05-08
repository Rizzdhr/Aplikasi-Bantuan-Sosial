<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $fillable = [
        'warga_id',
        'pekerjaan',
        'penghasilan',
        'usia',
        'program_bantuan',
        'foto_rumah',
        'kondisi_rumah',
        'skor_kelayakan',
        'status',
        'latitude_pengajuan',
        'longitude_pengajuan',
        'jarak_lokasi',
        'status_lokasi',
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }
}
