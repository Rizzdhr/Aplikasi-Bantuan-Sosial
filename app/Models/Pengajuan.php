<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $fillable = [
        'warga_id',
        'jenis_bantuan',
        'foto_rumah',
        'kepemilikan_rumah',
        'hasil_ai',
        'confidence',
        'status'
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }
}
