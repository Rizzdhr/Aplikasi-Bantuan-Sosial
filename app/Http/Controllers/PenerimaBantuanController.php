<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenerimaBantuan;
use App\Models\Bantuan;
use App\Models\Warga;
use App\Models\Pengajuan;

class PenerimaBantuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $data = PenerimaBantuan::with([
        'warga.pengajuans',
        'bantuan'
    ])
    ->latest()
    ->get();

    return view(
        'penerima_bantuan.index',
        compact('data')
    );
}

    /**
     * Show the form for creating a new resource.
     */
   public function create()
    {
    $wargas = Warga::all();
    $bantuans = Bantuan::all();

    return view(
        'penerima_bantuan.create',
        compact('wargas', 'bantuans')
    );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    PenerimaBantuan::create([
        'warga_id' => $request->warga_id,
        'bantuan_id' => $request->bantuan_id,
        'status' => 'belum_menerima',
    ]);

    return redirect()->route('penerima-bantuan.index');
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    $penerima = PenerimaBantuan::with([
        'warga',
        'bantuan'
    ])->findOrFail($id);

    $pengajuan = Pengajuan::where(
        'warga_id',
        $penerima->warga_id
    )
    ->latest()
    ->first();

    return view(
        'penerima_bantuan.show',
        compact(
            'penerima',
            'pengajuan'
        )
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
