<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenerimaBantuan extends Model
{
    protected $fillable = [
        'warga_id',
        'bantuan_id',
        'status'
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }

    public function bantuan()
    {
        return $this->belongsTo(Bantuan::class);
    }
}
