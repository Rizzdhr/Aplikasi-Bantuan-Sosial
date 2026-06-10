<?php

namespace App\Http\Controllers;

use App\Models\PenerimaBantuan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Bantuan;

class BantuanWargaController extends Controller
{
    public function index()
    {
        ($user = auth()->user());

        $data = PenerimaBantuan::with('bantuan')
            ->where('warga_id', $user->warga_id)
            ->get();

        return view(
            'warga.bantuan.index',
            compact('data')
        );
    }

    public function scan($id)
    {
    $penerima = PenerimaBantuan::with('bantuan')
        ->findOrFail($id);

    return view(
        'warga.bantuan.scan',
        compact('penerima')
    );
    }

   public function prosesScan(Request $request)
{
    $user = auth()->user();

    $bantuan = Bantuan::where(
        'qr_token',
        $request->token
    )->first();

    if (!$bantuan) {
        return response()->json([
            'success' => false,
            'message' => 'QR tidak valid'
        ]);
    }

    $penerima = PenerimaBantuan::where(
        'warga_id',
        $user->warga_id
    )
    ->where(
        'bantuan_id',
        $bantuan->id
    )
    ->where(
        'status',
        'belum_menerima'
    )
    ->first();

    if (!$penerima) {
        return response()->json([
            'success' => false,
            'message' => 'Anda tidak terdaftar sebagai penerima bantuan ini'
        ]);
    }

    $penerima->update([
        'status' => 'sudah_menerima',
        'tanggal_terima' => Carbon::now()
    ]);

    return response()->json([
    'success' => true,
    'message' => 'Bantuanphp berhasil menerima bantuan ',
    'bantuan' => $bantuan->nama_bantuan,
    'tanggal' => now()->format('d-m-Y H:i')

    ]);
    }
}