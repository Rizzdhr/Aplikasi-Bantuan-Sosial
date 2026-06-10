<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bantuan extends Model
{
    protected $fillable = [
        'nama_bantuan',
        'deskripsi',
        'nominal',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'qr_token'  
    ];

    public function penerimaBantuan()
    {
        return $this->hasMany(PenerimaBantuan::class);
    }

}
