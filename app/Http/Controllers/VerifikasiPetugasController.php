<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;

class VerifikasiPetugasController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::with('warga')
            ->latest()
            ->get();

        return view(
            'verifikasi.index',
            compact('pengajuans')
        );
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with('warga')
            ->findOrFail($id);

        return view(
            'verifikasi.show',
            compact('pengajuan')
        );
    }

    public function verifikasi(Request $request, $id)
    {
    return $this->simpan($request, $id);
    }

  public function simpan(Request $request, $id)
    {
    $request->validate([
        'catatan_petugas' => 'required'
    ]);

    $pengajuan = Pengajuan::findOrFail($id);

    $pengajuan->update([
        'status_verifikasi' => 'sudah_dicek',
        'hasil_verifikasi' => $request->hasil_verifikasi,
        'catatan_petugas' => $request->catatan_petugas
    ]);

    return redirect()
        ->route('verifikasi.index')
        ->with(
            'success',
            'Verifikasi lapangan berhasil disimpan'
        );
    }
}