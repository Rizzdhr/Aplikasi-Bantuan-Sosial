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
            'warga_id' => 'required|exists:wargas,id',
            'jenis_bantuan' => 'required',
            'foto_rumah' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'kepemilikan_rumah' => 'required'
        ]);

        // Simpan foto
        $path = $request->file('foto_rumah')->store('foto_rumah', 'public');
        $fullPath = storage_path('app/public/' . $path);

        // Default nilai AI
        $label = null;
        $confidence = null;

        try {
            // Kirim ke Roboflow
            $response = Http::attach(
                'file',
                file_get_contents($fullPath),
                'foto.jpg'
            )->post(env('ROBOFLOW_URL'));

            $result = $response->json();

            if (isset($result['predictions'][0])) {
                $label = $result['predictions'][0]['class'];
                $confidence = $result['predictions'][0]['confidence'];
            }

        } catch (\Exception $e) {
            // kalau gagal, tetap lanjut simpan
        }

        // Simpan ke DB
        Pengajuan::create([
            'warga_id' => $request->warga_id,
            'jenis_bantuan' => $request->jenis_bantuan,
            'foto_rumah' => $path,
            'kepemilikan_rumah' => $request->kepemilikan_rumah,
            'hasil_ai' => $label,
            'confidence' => $confidence,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Pengajuan berhasil + AI diproses!');
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
}
