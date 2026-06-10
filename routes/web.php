<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\BantuanController;
use App\Http\Controllers\PenerimaBantuanController;
use App\Http\Controllers\PenyaluranController;
use App\Http\Controllers\WargaDashboardController;
use App\Http\Controllers\PengajuanWargaController;
use App\Http\Controllers\VerifikasiPetugasController;
use App\Http\Controllers\BantuanWargaController;
/*
|--------------------------------------------------------------------------
| Halaman Awal
|--------------------------------------------------------------------------
*/
Route::get('/', function () {return view('auth.login');});
Route::get('/dashboard', function () {return redirect()->route('pengajuan.index');})->middleware(['auth', 'verified'])->name('dashboard');
/*
|--------------------------------------------------------------------------
| Semua Route Login
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    /*
    |--------------------------------------------------------------------------
    | Dashboard Admin
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard-analitik', [DashboardController::class, 'dashboard'])->name('dashboard.analitik');
    /*
    |--------------------------------------------------------------------------
    | Dashboard Warga
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard-warga', [WargaDashboardController::class, 'index'])->name('warga.dashboard');
    /*
    |--------------------------------------------------------------------------
    | Pengajuan Warga
    |--------------------------------------------------------------------------
    */
    Route::get('/warga/pengajuan', [PengajuanWargaController::class, 'index'])->name('warga.pengajuan.index');
    Route::get('/warga/pengajuan/create', [PengajuanWargaController::class, 'create'])->name('warga.pengajuan.create');
    Route::post('/warga/pengajuan', [PengajuanWargaController::class, 'store'])->name('warga.pengajuan.store');
    Route::post('/warga/analisis-ai', [PengajuanWargaController::class, 'analisisAI'])->name('warga.analisisAI');
    /*
    |--------------------------------------------------------------------------
    | Bantuan Warga
    |--------------------------------------------------------------------------
    */
    Route::get('/warga/bantuan', [BantuanWargaController::class, 'index'])->name('warga.bantuan');
    Route::post('/warga/bantuan/scan', [BantuanWargaController::class, 'prosesScan'])->name('warga.bantuan.scan');
    /*
    |--------------------------------------------------------------------------
    | Data Warga
    |--------------------------------------------------------------------------
    */
    Route::post('/warga/import', [WargaController::class, 'import'])->name('warga.import');
    Route::get('/warga/{warga}/download-qr', [WargaController::class, 'downloadQr'])->name('warga.downloadQr');
    Route::resource('warga', WargaController::class);
    /*
    |--------------------------------------------------------------------------
    | Pengajuan Admin
    |--------------------------------------------------------------------------
    */
    Route::resource('pengajuan', PengajuanController::class);
    Route::post('/upload-foto', [PengajuanController::class, 'upload'])->name('pengajuan.upload');
    Route::post('/pengajuan/{id}/setujui', [PengajuanController::class, 'setujui'])->name('pengajuan.setujui');
    Route::post('/pengajuan/{id}/tolak', [PengajuanController::class, 'tolak'])->name('pengajuan.tolak');
    /*
    |--------------------------------------------------------------------------
    | Bantuan Sosial
    |--------------------------------------------------------------------------
    */
    Route::resource('bantuan', BantuanController::class);
    Route::post('/bantuan/{id}/distribusi', [BantuanController::class, 'distribusi'])->name('bantuan.distribusi');
    Route::get('/bantuan/{id}/qr', [BantuanController::class, 'showQr'])->name('bantuan.qr');
    Route::get('/bantuan/{bantuan}/download-qr', [BantuanController::class, 'downloadQr'])->name('bantuan.downloadQr');
    Route::get('/bantuan/{bantuan}/lihat-qr', [BantuanController::class, 'showQr'])->name('bantuan.showQr');

    /*
    |--------------------------------------------------------------------------
    | Penerima Bantuan
    |--------------------------------------------------------------------------
    */
    Route::resource('penerima-bantuan', PenerimaBantuanController::class);
    /*
    |--------------------------------------------------------------------------
    | Verifikasi Petugas
    |--------------------------------------------------------------------------
    */
    Route::get('/verifikasi', [VerifikasiPetugasController::class, 'index'])->name('verifikasi.index');
    Route::get('/verifikasi/{id}', [VerifikasiPetugasController::class, 'show'])->name('verifikasi.show');
    Route::post('/verifikasi/{id}/verifikasi', [VerifikasiPetugasController::class, 'simpan'])->name('verifikasi.verifikasi');
    Route::post('/verifikasi/{id}/proses', [VerifikasiPetugasController::class, 'simpan'])->name('verifikasi.proses');
    /*
    |--------------------------------------------------------------------------
    | Penyaluran Bantuan
    |--------------------------------------------------------------------------
    */
    Route::get('/penyaluran', [PenyaluranController::class, 'index'])->name('penyaluran.index');
    Route::post('/penyaluran/terima', [PenyaluranController::class, 'terimaBantuan'])->name('penyaluran.terima');
    /*
    |--------------------------------------------------------------------------
    | API Scan QR
    |--------------------------------------------------------------------------
    */
    Route::get('/api/scan/{nik}', [ScanController::class, 'getWarga']);
});

require __DIR__.'/auth.php';