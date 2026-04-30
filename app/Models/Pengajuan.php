<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $fillable = [
        'warga_id',
        'jenis_bantuan',
        'keterangan',
        'status'
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }
}
