<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Pengajuan;
use App\Models\PenerimaBantuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
{
    $totalWarga = \App\Models\Warga::count();

    $totalPengajuan = \App\Models\Pengajuan::count();

    $diterima = \App\Models\Pengajuan::where(
        'status',
        'diterima'
    )->count();

    $ditolak = \App\Models\Pengajuan::where(
        'status',
        'ditolak'
    )->count();

    $menungguVerifikasi = \App\Models\Pengajuan::where(
        'status_verifikasi',
        'belum_dicek'
    )->count();

    $menungguAdmin = \App\Models\Pengajuan::where(
        'status_verifikasi',
        'sudah_dicek'
    )
    ->where(
        'status',
        'menunggu'
    )
    ->count();

    $pengajuanTerbaru = \App\Models\Pengajuan::with('warga')
        ->latest()
        ->take(5)
        ->get();

    $penerimaBantuan = PenerimaBantuan::count();
    $menungguPenyaluran = PenerimaBantuan::where(
        'status',
        'belum_menerima'
    )->count();

    $sudahMenerima = PenerimaBantuan::where(
        'status',
        'sudah_menerima'
    )->count();

    
    return view(
    'dashboard.index',
    compact(
        'totalWarga',
        'totalPengajuan',
        'diterima',
        'ditolak',
        'menungguVerifikasi',
        'menungguAdmin',
        'pengajuanTerbaru'
    )
    );
}
}