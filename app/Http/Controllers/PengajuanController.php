<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::with('warga')->get();
        $wargas = Warga::all();
        return view('pengajuan.index', compact('pengajuans', 'wargas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required',
            'jenis_bantuan' => 'required'
        ]);

        Pengajuan::create([
            'warga_id' => $request->warga_id,
            'jenis_bantuan' => $request->jenis_bantuan,
        ]);

        return redirect()->back()->with('success', 'Pengajuan berhasil!');
    }

    public function update(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->update($request->all());
        return redirect()->back();
    }

    public function destroy($id)
    {
        Pengajuan::destroy($id);
        return redirect()->back();
    }

    public function upload(Request $request)
    {
        $request->validate([
            'foto_rumah' => 'required|image'
        ]);

        // Simpan foto
        $path = $request->file('foto_rumah')->store('foto', 'public');
        $imagePath = storage_path('app/public/' . $path);

        // Kirim ke Roboflow
        $response = Http::attach(
            'file', file_get_contents($imagePath), 'image.jpg'
        )->post('https://detect.roboflow.com/YOUR_MODEL/1?api_key=YOUR_API_KEY');

        $result = $response->json();

        // Contoh ambil hasil
        $label = $result['predictions'][0]['class'] ?? 'unknown';
        $confidence = $result['predictions'][0]['confidence'] ?? 0;

        // Simpan ke DB
        Pengajuan::create([
            'foto_rumah' => $path,
            'hasil_ai' => $label,
            'confidence' => $confidence
        ]);

        return back()->with('success', 'Foto berhasil diupload & dianalisis!');
    }
}
