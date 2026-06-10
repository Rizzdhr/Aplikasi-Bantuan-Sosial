<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;

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

                // INI USIA
                'usia' => \Carbon\Carbon::parse($warga->tanggal_lahir)->age
            ]
        ]);
}
}
