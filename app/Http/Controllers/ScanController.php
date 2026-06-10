<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\PenerimaBantuan;
class ScanController extends Controller
{
    public function getWarga($nik)
    {
    $warga = Warga::where('nik', $nik)->first();

    if (!$warga) {
        return response()->json([
            'status' => 'error'
        ]);
    }

    $penerima = PenerimaBantuan::where(
    'warga_id',
    $warga->id
    )->first();

    return response()->json([
        'status' => 'success',
        'data' => [
            'id' => $warga->id,
            'nik' => $warga->nik,
            'nama' => $warga->nama,
            'alamat' => $warga->alamat,
            'tanggal_lahir' => $warga->tanggal_lahir,
            'kecamatan' => $warga->kecamatan,
            'penghasilan' => $warga->penghasilan,
            'pekerjaan' => $warga->pekerjaan,
            'usia' => \Carbon\Carbon::parse(
                $warga->tanggal_lahir
            )->age,

            'status_bantuan' =>
            $penerima
                ? $penerima->status
                : 'tidak_terdaftar'
        ]
        ]);
    }
}
