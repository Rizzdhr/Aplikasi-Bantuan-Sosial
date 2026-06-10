<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $fillable = [
        'warga_id',
        'bantuan_id',
        'pekerjaan',
        'penghasilan',
        'usia',
        'foto_rumah',
        'kondisi_rumah',
        'skor_kelayakan',
        'status',
        'status_verifikasi',
        'hasil_verifikasi',
        'catatan_petugas'
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }
}
