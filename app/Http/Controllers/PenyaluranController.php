<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Bantuan;
use App\Models\PenerimaBantuan;

class PenyaluranController extends Controller
{
    public function index()
    {
    $bantuans = \App\Models\Bantuan::where(
        'status',
        'aktif'
        )->get();

    return view(
        'penyaluran.index',
        compact('bantuans')
        );
    }

    public function terimaBantuan(Request $request)
    {
    $data = PenerimaBantuan::where(
        'warga_id',
        $request->warga_id
    )
    ->where(
        'bantuan_id',
        $request->bantuan_id
    )
    ->where(
        'status',
        'belum_menerima'
    )
    ->first();

    if (!$data) {
        return response()->json([
            'status' => 'error',
            'message' => 'Data penerima tidak ditemukan atau bantuan sudah diterima'
        ]);
    }

    $data->update([
        'status' => 'sudah_menerima'
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Penyaluran berhasil'
    ]);
    }
}