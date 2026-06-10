<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PengajuanWargaController extends Controller
{
    public function index()
    {
        //dd('INDEX OKE');

        /*$warga = Auth::user()->warga;
        $pengajuans = Pengajuan::where(
            'warga_id',
            $warga->id
        )->latest()->get();
        return view(
            'warga.pengajuan.index',
            compact('pengajuans')
        );*/

    }
    public function create()
    {
        $warga = Auth::user()->warga;
        $pengajuan = Pengajuan::where(
            'warga_id',
        $warga->id
            )->first();
        if ($pengajuan) {
            return redirect()
            ->route('warga.dashboard')
            ->with(
                'error',
                'Anda sudah pernah mengajukan bantuan sosial.'
            );
    }
    return view(
        'warga.pengajuan.create',
        compact('warga')
    );
    }
    /*
    ==================================
    ANALISIS AI
    ==================================
    */
    public function analisisAI(Request $request)
    {
        $request->validate([
            'foto_rumah' => 'required|image|max:5120',
        ]);
        $warga = Auth::user()->warga;
        $file = $request->file('foto_rumah');
        try {
            /*
            =====================================
            ROBOFLOW
            =====================================
            */
            $imageBase64 = base64_encode(
                file_get_contents($file->getRealPath())
            );
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded'
            ])->withBody(
                $imageBase64,
                'application/x-www-form-urlencoded'
            )->post(
                'https://serverless.roboflow.com/' .
                env('ROBOFLOW_MODEL') .
                '?api_key=' .
                env('ROBOFLOW_API_KEY')
            );
            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengambil data dari Roboflow',
                    'roboflow' => $response->json()
                ], 500);
            }
            $roboflow = $response->json();
            /*
            =====================================
            HASIL KLASIFIKASI RUMAH
            =====================================
            */
            $kelas = $roboflow['top'] ?? 'rumah_sedang';
            /*
            =====================================
            MAPPING RUMAH
            =====================================
            */
            $mappingRumah = [
                'rumah_buruk' => 0,
                'rumah_sedang' => 1,
                'rumah_baik' => 2,
            ];
            /*
            =====================================
            MAPPING PEKERJAAN
            =====================================
            */
            $mappingPekerjaan = [
                'TIDAK BEKERJA'      => 0,
                'BURUH'              => 1,
                'TUKANG OJEK'        => 1,
                'KARYAWAN'           => 2,
                'PELAJAR/MAHASISWA'  => 2,
                'PROFESIONAL'        => 3,
                'PENGUSAHA'          => 4,
            ];
            /*
            =====================================
            FLASK AI
            =====================================
            */
            $payload = [
                'penghasilan' => (float)$warga->penghasilan,
                'usia' => (int)$warga->usia,
                'pekerjaan' =>
                    $mappingPekerjaan[
                        strtoupper($warga->pekerjaan)
                    ] ?? 2,
                'kondisi_rumah' =>
                    $mappingRumah[$kelas] ?? 1
            ];
            $flask = Http::timeout(30)
                ->post(
                    env('FLASK_API_URL') . '/predict',
                    $payload
                );
            /*
            =====================================
            JIKA FLASK ERROR
            =====================================
            */
            if (!$flask->successful()) {
                return response()->json([
                    'success' => true,
                    'kondisi_rumah' => $kelas,
                    'skor' => 0,
                    'status' => 'ditolak',
                    'alasan' => [
                        'Flask API tidak merespon'
                    ]
                ]);
            }
            $hasilAI = $flask->json();
            return response()->json([
                'success' => true,
                'kondisi_rumah' => $kelas,
                'skor' => round(
                    ($hasilAI['skor'] ?? 0) * 100,
                    2
                ),
                'status' =>
                    $hasilAI['status']
                    ?? 'ditolak',
                'alasan' =>
                    $hasilAI['alasan']
                    ?? []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /*
    ==================================
    SIMPAN PENGAJUAN
    ==================================
    */
  public function store(Request $request)
{
    $request->validate([
        'foto_rumah' => 'required|image|max:5120',
        'kondisi_rumah' => 'required',
        'skor_kelayakan' => 'required'
    ]);

    $warga = Auth::user()->warga;

    $path = $request
        ->file('foto_rumah')
        ->store('pengajuan-rumah', 'public');

    $cekPengajuan = Pengajuan::where(
        'warga_id',
        $warga->id
    )->exists();

    if ($cekPengajuan) {

        return redirect()
            ->back()
            ->with(
                'error',
                'Pengajuan hanya dapat dilakukan satu kali.'
            );
    }

    Pengajuan::create([

        'warga_id' => $warga->id,
        'pekerjaan' => $warga->pekerjaan,
        'penghasilan' => $warga->penghasilan,
        'usia' => $warga->usia,
        'foto_rumah' => $path,
        'kondisi_rumah' => $request->kondisi_rumah,
        'skor_kelayakan' => $request->skor_kelayakan / 100,
        'status' => 'menunggu',
        'status_verifikasi' => 'belum_dicek',
        'catatan_petugas' => null

    ]);
    
    return redirect()
        ->route('warga.pengajuan.index')
        ->with(
            'success',
            'Pengajuan berhasil dikirim.'
        );
    }
}