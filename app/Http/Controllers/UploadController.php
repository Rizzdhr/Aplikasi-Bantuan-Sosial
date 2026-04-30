<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Pengajuan;

class UploadController extends Controller
{
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
