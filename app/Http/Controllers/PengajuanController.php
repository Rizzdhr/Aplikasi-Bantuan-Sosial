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

    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earth = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a =
            sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            sin($dLon / 2) *
            sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earth * $c;
    }

    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required',
            'program_bantuan' => 'required',
            'penghasilan' => 'required|numeric',
            'usia' => 'required|numeric',
            'pekerjaan' => 'required',
            'foto_rumah' => 'required|image'
        ]);

        $warga = Warga::find($request->warga_id);

        $jarak = $this->hitungJarak(
            $warga->latitude_rumah,
            $warga->longitude_rumah,

            $request->latitude_pengajuan,
            $request->longitude_pengajuan
        );

        if($jarak <= 2){
            $status_lokasi = 'sesuai_area';
        }
        elseif($jarak <= 10){
            $status_lokasi = 'area_dekat';
        }
        else{
            $status_lokasi = 'di_luar_area';
        }

        $programMap = [
            'jkn' => 'Bantuan Iuran JKN (kesehatan)',
            'bpnt' => 'Bantuan Pangan Non-Tunai (BPNT) (pangan)',
            'blt' => 'Bantuan Langsung Tunai (BLT) (tunai)'
        ];

        $programNama = $programMap[$request->program_bantuan] ?? '-';

        // =========================
        // 1. Upload foto ke storage
        // =========================
        $path = $request->file('foto_rumah')->store('rumah', 'public');
        $fullPath = storage_path('app/public/' . $path);

        // =========================
        // 2. Kirim ke Roboflow
        // =========================
        $response = Http::attach(
            'file',
            file_get_contents($fullPath),
            basename($fullPath)
        )->post(env('ROBOFLOW_URL'));

        // =========================
        // 3. Ambil hasil prediksi
        // =========================
        $result = $response->json();

        // Debug (optional)
        // dd($result);

        $label = 'tidak_diketahui';

        if (!empty($result['predictions'])) {
            $label = $result['predictions'][0]['class'];
        } elseif (isset($result['top'])) {
            $label = $result['top'];
        }

        // =========================
        // 4. Mapping kondisi rumah
        // =========================
        $mapRumah = [
            'layak' => 0, // rumah_buruk
            'tidak_layak' => 1, // rumah_baik
        ];

        $kondisiRumah = $mapRumah[$label] ?? 1; // default sedang

        // =========================
        // 5. Mapping pekerjaan
        // =========================
        $mapPekerjaan = [
            'tidak_bekerja' => 0,
            'buruh_harian' => 1,
            'pegawai/karyawan' => 2
        ];

        // =========================
        // 6. Kirim ke ML Python
        // =========================
        $ml = Http::post('http://127.0.0.1:5000/predict', [
            'penghasilan' => (int)$request->penghasilan,
            'usia' => (int)$request->usia,
            'pekerjaan' => $mapPekerjaan[$request->pekerjaan],
            'kondisi_rumah' => $kondisiRumah
        ]);

        // $hasil = $ml->json()['status'] ?? 'DITOLAK';
        $dataML = $ml->json();

        $hasil = $dataML['status'] ?? 'DITOLAK';
        $skor = $dataML['skor'] ?? null;

        // =========================
        // 7. Simpan ke database
        // =========================
        Pengajuan::create([
            'warga_id' => $request->warga_id,
            'latitude_pengajuan' => $request->latitude_pengajuan,
            'longitude_pengajuan' => $request->longitude_pengajuan,
            'jarak_lokasi' => $jarak,
            'status_lokasi' => $status_lokasi,

            'program_bantuan' => $request->program_bantuan,
            'penghasilan' => $request->penghasilan,
            'usia' => $request->usia,
            'pekerjaan' => $request->pekerjaan,
            'foto_rumah' => $path,
            'kondisi_rumah' => $label,
            'skor_kelayakan' => $skor,
            'status' => $hasil
        ]);

        // dd([
        //     'status_http' => $response->status(),
        //     'body' => $response->body(),
        //     'json' => $result
        // ]);

        // return back()->with('success', 'Pengajuan diproses: ' . $hasil);


        return redirect()->back()->with([
            // 'success' => 'Pengajuan berhasil diproses!',
            'nama' => $warga->nama,
            'program' => $programNama,
            'kondisi_rumah' => $label,
            'status_lokasi' => $status_lokasi,
            'skor_kelayakan' => $skor,
            'status' => $hasil
        ]);
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with('warga')->findOrFail($id);
        return view('pengajuan.show', compact('pengajuan'));
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
