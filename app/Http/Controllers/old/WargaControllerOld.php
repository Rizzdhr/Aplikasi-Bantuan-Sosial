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

            'nik' => 'required|unique:wargas,nik',
            'nama' => 'required',
            'alamat' => 'required',
            'kecamatan' => 'required',
            'kota' => 'required'

        ]);

        /*
        |--------------------------------------------------------------------------
        | Geocoding berbasis area
        |--------------------------------------------------------------------------
        | Yang dikirim ke OpenStreetMap hanya:
        | kecamatan + kota + Indonesia
        */

        $lokasiGeo =
            $request->kecamatan . ', ' .
            $request->kota . ', Indonesia';

        $response = Http::withoutVerifying()
            ->withHeaders([
                'User-Agent' => 'BansosApp'
            ])
            ->get('https://nominatim.openstreetmap.org/search', [

                'q' => $lokasiGeo,
                'format' => 'json',
                'limit' => 1

            ]);

        $data = $response->json();

        // lokasi tidak ditemukan
        if(empty($data)){

            return back()
                ->withInput()
                ->withErrors([
                    'alamat' => 'Lokasi tidak ditemukan'
                ]);

        }

        // ambil koordinat area
        $latitude = $data[0]['lat'];
        $longitude = $data[0]['lon'];

        // simpan data warga
        Warga::create([

            'nik' => $request->nik,
            'nama' => $request->nama,

            'alamat' => $request->alamat,
            'kecamatan' => $request->kecamatan,
            'kota' => $request->kota,

            'latitude_rumah' => $latitude,
            'longitude_rumah' => $longitude

        ]);

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

            'nik' => 'required|unique:wargas,nik,' . $id,
            'nama' => 'required',
            'alamat' => 'required',
            'kecamatan' => 'required',
            'kota' => 'required'

        ]);

        $warga = Warga::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Geocoding berbasis area
        |--------------------------------------------------------------------------
        */

        $lokasiGeo =
            $request->kecamatan . ', ' .
            $request->kota . ', Indonesia';

        $response = Http::withoutVerifying()
            ->withHeaders([
                'User-Agent' => 'BansosApp'
            ])
            ->get('https://nominatim.openstreetmap.org/search', [

                'q' => $lokasiGeo,
                'format' => 'json',
                'limit' => 1

            ]);

        $data = $response->json();

        // cek apakah lokasi ditemukan
        if(empty($data)){

            return back()
                ->withInput()
                ->withErrors([
                    'alamat' => 'Lokasi tidak ditemukan'
                ]);

        }

        // ambil koordinat
        $latitude = $data[0]['lat'];
        $longitude = $data[0]['lon'];

        // update data warga
        $warga->update([

            'nik' => $request->nik,
            'nama' => $request->nama,

            'alamat' => $request->alamat,
            'kecamatan' => $request->kecamatan,
            'kota' => $request->kota,

            'latitude_rumah' => $latitude,
            'longitude_rumah' => $longitude

        ]);

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
