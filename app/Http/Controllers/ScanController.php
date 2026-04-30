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
            'data' => $warga
        ]);
}
}
