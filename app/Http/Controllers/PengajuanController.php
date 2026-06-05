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
            'foto_rumah' => 'required|image'
        ]);

        $warga = Warga::find($request->warga_id);

        $usia = \Carbon\Carbon::parse($warga->tanggal_lahir)->age;
        $penghasilan = $warga->penghasilan;
        $pekerjaan   = strtoupper(trim($warga->pekerjaan));

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
            'rumah_buruk' => 0,
            'rumah_sedang' => 1,
            'rumah_baik' => 2,
        ];

        $kondisiRumah = $mapRumah[$label] ?? 1; // default sedang

        // =========================
        // 5. Mapping pekerjaan
        // =========================
        $mapPekerjaan = [
            // Kelompok 0 — Tidak/belum bekerja
            'BELUM/TIDAK BEKERJA'      => 0,
            'BELUM BEKERJA'            => 0,
            'TIDAK BEKERJA'            => 0,
            'PELAJAR/MAHASISWA'        => 0,
            'PELAJAR'                  => 0,
            'MAHASISWA'                => 0,
            'IBU RUMAH TANGGA'         => 0,
            'PENSIUNAN'                => 0,
            'PENSIUN'                  => 0,

            // Kelompok 1 — Buruh / pekerja harian
            'BURUH HARIAN LEPAS'       => 1,
            'BURUH TANI/PERKEBUNAN'    => 1,
            'BURUH TANI'             => 1,
            'PERKEBUNAN'              => 1,
            'BURUH NELAYAN/PERIKANAN'  => 1,
            'BURUH NELAYAN'           => 1,
            'PERIKANAN'              => 1,
            'BURUH PETERNAKAN'         => 1,
            'PETANI/PEKEBUN'           => 1,
            'PETANI'                   => 1,
            'PEKEBUN'                  => 1,
            'NELAYAN/PERIKANAN'        => 1,
            'NELAYAN'                  => 1,
            'PETERNAK'                 => 1,
            'TUKANG BATU'              => 1,
            'TUKANG KAYU'              => 1,
            'TUKANG SOL SEPATU'        => 1,
            'TUKANG CUKUR'             => 1,
            'TUKANG LAS/PANDAI BESI'   => 1,
            'TUKANG LAS'                 => 1,
            'PANDAI BESI'              => 1,
            'TUKANG LISTRIK'           => 1,
            'TUKANG JAHIT'             => 1,
            'TUKANG GIGI'              => 1,
            'MEKANIK'                  => 1,
            'PEMBANTU RUMAH TANGGA'    => 1,
            'TUKANG OJEK'              => 1,

            // Kelompok 2 — Pegawai / karyawan
            'KARYAWAN SWASTA'          => 2,
            'KARYAWAN BUMN'            => 2,
            'KARYAWAN BUMD'            => 2,
            'KARYAWAN HONORER'         => 2,
            'PEGAWAI NEGERI'     => 2,
            'PEGAWAI SWASTA'       => 2,
            'TENTARA NASIONAL INDONESIA' => 2,
            'KEPOLISIAN RI'            => 2,
            'PERDAGANGAN'              => 2,
            'WIRASWASTA'               => 2,
            'TRANSPORTASI'             => 2,
            'INDUSTRI'                 => 2,
            'KONSTRUKSI'               => 2,

            // Kelompok 3 — Profesional / tenaga ahli
            'DOKTER'                   => 3,
            'BIDAN'                    => 3,
            'PERAWAT'                  => 3,
            'APOTEKER'                 => 3,
            'PSIKIATER/PSIKOLOG'       => 3,
            'PSIKIATER'                => 3,
            'PSIKOLOG'                 => 3,
            'DOKTER GIGI'              => 3,
            'GURU/DOSEN'               => 3,
            'GURU'                     => 3,
            'DOSEN'                    => 3,
            'PENGACARA'                => 3,
            'NOTARIS'                  => 3,
            'AKUNTAN'                  => 3,
            'KONSULTAN'                => 3,
            'SENIMAN'                  => 3,
            'WARTAWAN'                 => 3,
            'USTADZ/MUBALIGH'          => 3,
            'USTADZ'                   => 3,
            'MUBALIGH'                  => 3,
            'PASTOR'                   => 3,
            'PENDETA'                  => 3,
            'POLITIKUS'                => 3,
            'ANGGOTA DPR-RI'           => 3,
            'ANGGOTA DPRD'             => 3,
            'KEPALA DESA'              => 3,
            'PERANGKAT DESA'           => 3,
            'PELAUT'                   => 3,
            'PILOT'                    => 3,

            // Kelompok 4 — Pengusaha / pejabat tinggi
            'PENELITI'                 => 4,
            'PEJABAT NEGARA'           => 4,
            'ANGGOTA BPK'              => 4,
            'DUTA BESAR'               => 4,
            'GUBERNUR'                 => 4,
            'BUPATI/WALIKOTA'          => 4,
            'BUPATI'                    => 4,
            'WALIKOTA'                  => 4,
            'LAINNYA'                  => 2,
        ];

        // =========================
        // 6. Kirim ke ML Python
        // =========================
        $ml = Http::post(env('FLASK_API_URL').'/predict', [
            'penghasilan'   => (int)$penghasilan,
            'usia'  => $usia,
            'pekerjaan'     => $mapPekerjaan[$pekerjaan] ?? 0,
            'kondisi_rumah' => $kondisiRumah
        ]);

        $dataML = $ml->json();

        $hasil = $dataML['status'] ?? 'DITOLAK';
        $skor = $dataML['skor'] ?? null;
        $alasan = $dataML['alasan'] ?? [];

        // =========================
        // 7. Simpan ke database
        // =========================
        Pengajuan::create([
            'warga_id' => $request->warga_id,
            'penghasilan' => $penghasilan,
            'usia' => $usia,
            'pekerjaan'   => $pekerjaan,
            'foto_rumah' => $path,
            'kondisi_rumah' => $label,
            'skor_kelayakan' => $skor,
            'status' => $hasil
        ]);

        return redirect()->back()->with([
            'nama' => $warga->nama,
            'penghasilan' => $penghasilan,
            'usia' => $usia,
            'pekerjaan' => $pekerjaan,
            'foto_rumah' => $path,
            'kondisi_rumah' => $label,
            'skor_kelayakan' => $skor,
            'status' => $hasil,
            'alasan' => $alasan,
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
