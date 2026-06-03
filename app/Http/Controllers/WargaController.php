<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Http;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $wargas = Warga::when($search, function ($query) use ($search) {
            $query->where('nik', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%");
        })->paginate(10);

        return view('warga.index', compact('wargas'));
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
        $request->validate([
            'provinsi' => 'nullable|string|max:255',
            'nik' => 'required|unique:wargas,nik',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date|before_or_equal:today',
            'jenis_kelamin' => 'nullable|string|max:100',
            'gol_darah' => 'nullable|string|max:10',
            'alamat' => 'required|string',
            'kel_desa' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:255',
            'status_pernikahan' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'kewarganegaraan' => 'nullable|string|max:255',
            'penghasilan' => 'nullable|integer|min:0',
        ]);

        Warga::create($request->only([
            'provinsi',
            'nik',
            'nama',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'gol_darah',
            'alamat',
            'kel_desa',
            'kecamatan',
            'agama',
            'status_pernikahan',
            'pekerjaan',
            'kewarganegaraan',
            'penghasilan',
        ]));

        return redirect()
            ->route('warga.index')
            ->with('success', 'Data warga berhasil ditambahkan');
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
        $request->validate([
            'provinsi' => 'nullable|string|max:255',
            'nik' => 'required|unique:wargas,nik,' . $id,
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date|before_or_equal:today',
            'jenis_kelamin' => 'nullable|string|max:100',
            'gol_darah' => 'nullable|string|max:10',
            'alamat' => 'required|string',
            'kel_desa' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'agama' => 'nullable|string|max:255',
            'status_pernikahan' => 'nullable|string|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'kewarganegaraan' => 'nullable|string|max:255',
            'penghasilan' => 'nullable|integer|min:0',
        ]);

        $warga = Warga::findOrFail($id);

        $warga->update($request->only([
            'provinsi',
            'nik',
            'nama',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'gol_darah',
            'alamat',
            'kel_desa',
            'kecamatan',
            'agama',
            'status_pernikahan',
            'pekerjaan',
            'kewarganegaraan',
            'penghasilan',
        ]));

        return redirect()
            ->route('warga.index')
            ->with('success', 'Data warga berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Warga::destroy($id);

        return redirect()->route('warga.index');
    }

    /**
     * Generate QR
     */
    public function generateQR($nik)
    {
        $warga = Warga::where('nik', $nik)->firstOrFail();

        return QrCode::size(300)->generate($warga->nik);
    }
}
