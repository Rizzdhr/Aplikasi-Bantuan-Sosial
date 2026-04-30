<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('warga.index', [
            'wargas' => Warga::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warga.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Warga::create($request->all());
        return redirect()->route('warga.index');
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $warga = Warga::findOrFail($id);
        return view('warga.show', compact('warga'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $warga = Warga::findOrFail($id);
        return view('warga.edit', compact('warga'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $warga = Warga::findOrFail($id);
        $warga->update($request->all());

        return redirect()->route('warga.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Warga::destroy($id);
        return redirect()->route('warga.index');
    }

    public function generateQR($nik)
{
    $warga = Warga::where('nik', $nik)->first();

    return QrCode::size(300)->generate($warga->nik);
}
}
