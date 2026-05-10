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
        $query = Warga::query();

        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('nik', 'like', '%' . $request->search . '%');
        }

        $wargas = $query->latest()->paginate(10);

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
            'alamat' => 'required'
        ]);

        $alamat = $request->alamat;

        $response = Http::withHeaders([
            'User-Agent' => 'BansosApp'
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $alamat,
            'format' => 'json',
            'limit' => 1
        ]);

        // dd($response->json());
        $data = $response->json();

        // alamat tidak ditemukan
        if(empty($data)){

            return back()
                ->withInput()
                ->withErrors([
                    'alamat' => 'Alamat tidak ditemukan atau tidak valid'
                ]);

        }

        // ambil hasil geocoding
        $latitude = $data[0]['lat'];
        $longitude = $data[0]['lon'];


        Warga::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'latitude_rumah' => $latitude,
            'longitude_rumah' => $longitude
        ]);

        return redirect()->route('warga.index')
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
            'alamat' => 'required'
        ]);

        $warga = Warga::findOrFail($id);

        // geocoding alamat
        $response = Http::withHeaders([
            'User-Agent' => 'BansosApp'
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $request->alamat . ', Indonesia',
            'format' => 'json',
            'limit' => 1
        ]);

        $data = $response->json();

        // cek apakah alamat ditemukan
        if(!$response->successful() || !isset($data[0])){

            return back()
                ->withInput()
                ->withErrors([
                    'alamat' => 'Alamat tidak ditemukan atau tidak valid'
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

    public function generateQR($nik)
    {
        $warga = Warga::where('nik', $nik)->firstOrFail();

        return QrCode::size(300)->generate($warga->nik);
    }
}
