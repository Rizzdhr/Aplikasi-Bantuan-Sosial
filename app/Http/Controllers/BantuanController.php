<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Bantuan;
use App\Models\Pengajuan;
use App\Models\PenerimaBantuan;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class BantuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $bantuans = Bantuan::latest()->get();
        return view('bantuan.index', compact('bantuans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bantuan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'nama_bantuan' => 'required',
        'deskripsi' => 'nullable',
        'nominal' => 'nullable|numeric',
        'tanggal_mulai' => 'required',
        'tanggal_selesai' => 'required',
    ]);

    Bantuan::create([
        'nama_bantuan' => $request->nama_bantuan,
        'deskripsi' => $request->deskripsi,
        'nominal' => $request->nominal,
        'tanggal_mulai' => $request->tanggal_mulai,
        'tanggal_selesai' => $request->tanggal_selesai,
        'status' => 'aktif',
    ]);

    return redirect()
        ->route('bantuan.index')
        ->with('success', 'Data bantuan berhasil ditambahkan');
    }

    public function downloadQr(Bantuan $bantuan)
{
    if (!$bantuan->qr_token) {

        $bantuan->update([
            'qr_token' => Str::uuid()
        ]);

        $bantuan->refresh();
    }

    $qrResult = Builder::create()
        ->writer(new PngWriter())
        ->data($bantuan->qr_token)
        ->size(300)
        ->margin(10)
        ->build();

    $fileName = "bantuan-{$bantuan->id}.png";

    return response(
        $qrResult->getString(),
        200,
        [
            'Content-Type' => 'image/png',
            'Content-Disposition' =>
                "attachment; filename=\"{$fileName}\"",
        ]
    );
    }
    public function distribusi($id)
    {
    $bantuan = Bantuan::findOrFail($id);
    $bantuan->update([
        'qr_token' => Str::uuid()
    ]);

    return back()->with(
        'success',
        'QR distribusi berhasil dibuat'
    );
    }

    public function showQr(Bantuan $bantuan)
{
    if (!$bantuan->qr_token) {

        $bantuan->update([
            'qr_token' => Str::uuid()
        ]);

        $bantuan->refresh();
    }

    $qrResult = Builder::create()
        ->writer(new PngWriter())
        ->data($bantuan->qr_token)
        ->size(300)
        ->margin(10)
        ->build();

    return response(
        $qrResult->getString(),
        200,
        [
            'Content-Type' => 'image/png'
        ]
    );
}
    

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    
}
