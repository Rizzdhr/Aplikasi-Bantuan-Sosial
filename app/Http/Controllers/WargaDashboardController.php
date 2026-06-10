<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Pengajuan;
use App\Models\PenerimaBantuan;

class WargaDashboardController extends Controller
{
 public function index()
{
    $warga = Auth::user()->warga;

    $pengajuanTerakhir = Pengajuan::where(
        'warga_id',
        $warga->id
    )->latest()->first();

    $pengajuan = Pengajuan::where(
        'warga_id',
        $warga->id
    )->exists();

    $bantuanAktif = PenerimaBantuan::with('bantuan')
        ->where('warga_id', $warga->id)
        ->where('status', 'belum_menerima')
        ->first();

    return view(
        'warga.dashboard',
        compact(
            'warga',
            'pengajuan',
            'pengajuanTerakhir',
            'bantuanAktif'
        )
    );
}
}