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
        'confidence',
        'status'
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }
}
