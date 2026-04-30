<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\ScanController;




Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('warga', WargaController::class)->middleware('auth');

    Route::resource('pengajuan', PengajuanController::class)->middleware('auth');
    Route::get('/scan/{nik}', [ScanController::class, 'getWarga']);

    Route::post('/upload-foto', [PengajuanController::class, 'upload'])->name('pengajuan.upload');

});

require __DIR__.'/auth.php';
