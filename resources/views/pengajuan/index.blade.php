@extends('layouts.main')
@section('judul', 'Pengajuan')

@section('content')

<div class="space-y-6">

    <!-- ALERT -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg">
            {{ session('success') }}
        </div>

        <div class="bg-blue-100 text-blue-700 p-4 rounded-lg">
            <b>Kondisi Rumah:</b> {{ session('kondisi_rumah') }} <br>
            <b>Status:</b> {{ session('status') }} <br>
            <b>Skor:</b> {{ session('skor_kelayakan') ?? '-' }}
        </div>
    @endif

    <!-- TITLE -->
    <h2 class="text-xl font-semibold text-gray-700">
        Form Pengajuan Bantuan
    </h2>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- ========================= -->
    <!-- KIRI (2/3): SCAN + FORM -->
    <!-- ========================= -->
    <div class="lg:col-span-2 flex flex-col gap-3">

        <!-- SCANNER -->
        <div id="scannerBox" class="bg-white p-4 rounded-2xl shadow">
            <h4 class="font-semibold mb-2">Scan QR Warga</h4>
            <div id="reader" class="w-full max-w-sm"></div>
        </div>

        <!-- DATA WARGA -->
        <div id="wargaCard" class="bg-white p-4 rounded-2xl shadow hidden">
            <h5 class="font-semibold mb-1">Data Warga</h5>
            <p><b>NIK:</b> <span id="nik"></span></p>
            <p><b>Nama:</b> <span id="nama"></span></p>
            <p><b>Alamat:</b> <span id="alamat"></span></p>
        </div>

        <!-- FORM -->
        <form id="formPengajuan" action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl shadow hidden space-y-4">

            @csrf
            <input type="hidden" name="warga_id" id="warga_id">

            <input type="hidden" name="latitude_pengajuan" id="latitude_pengajuan">
            <input type="hidden" name="longitude_pengajuan" id="longitude_pengajuan">
            <!-- BUTTON VERIFIKASI LOKASI -->
            <button
                type="button"
                onclick="ambilLokasi()"
                id="btnLokasi"
                class="w-full flex items-center justify-center gap-2
                    bg-blue-600 hover:bg-blue-700
                    text-white font-semibold
                    px-5 py-3 rounded-xl
                    shadow-md transition duration-300">

                <!-- ICON -->
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>

                </svg>

                <span id="textLokasi">
                    Verifikasi Lokasi
                </span>

            </button>

            <div>
                <label class="text-sm">Program Bantuan</label>
                <select name="program_bantuan" class="w-full border rounded-lg p-2">
                    <option value="jkn">Bantuan Iuran JKN (kesehatan)</option>
                    <option value="bpnt">Bantuan Pangan Non-Tunai (BPNT) (pangan)</option>
                    <option value="blt">Bantuan Langsung Tunai (BLT) (tunai)</option>
                </select>
            </div>

            <div>
                <label class="text-sm">Penghasilan</label>
                <input type="number" name="penghasilan" class="w-full border rounded-lg p-2">
            </div>

            <div>
                <label class="text-sm">Usia</label>
                <input type="number" name="usia" class="w-full border rounded-lg p-2">
            </div>

            <div>
                <label class="text-sm">Pekerjaan</label>
                <select name="pekerjaan" class="w-full border rounded-lg p-2">
                    <option value="tidak_bekerja">Tidak Bekerja</option>
                    <option value="buruh_harian">Buruh Harian</option>
                    <option value="pegawai/karyawan">Pegawai</option>
                </select>
            </div>

            <div>
                <label class="text-sm">Foto Rumah</label>
                <input type="file" name="foto_rumah" class="w-full border rounded-lg p-2">
            </div>

            <img id="preview" class="w-40 hidden rounded-lg">

            <button id="btnAjukan" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 w-full" disabled>
                Ajukan Bantuan
            </button>

            @if(session('error'))

            <div class="bg-red-100 border border-red-400
                        text-red-700 px-4 py-3 rounded mb-4">

                {{ session('error') }}

            </div>

            @endif
        </form>

    </div>

    <!-- ========================= -->
    <!-- KANAN (1/3): HASIL -->
    <!-- ========================= -->
    <div class="space-y-6">

        <!-- HASIL STATUS -->
        <div class="bg-white p-5 rounded-2xl shadow">
            <h4 class="font-semibold mb-4">Hasil Pengajuan</h4>

            <div class="space-y-2 text-sm">
                <p><span class="text-gray-500">Pemohon</span><br>
                <b>{{ session('nama') ?? '-' }}</b></p>

                <p><span class="text-gray-500">Program</span><br>
                <b>{{ session('program') ?? '-' }}</b></p>

                <p><span class="text-gray-500">Status</span><br>
                    @if(session('status') == 'diterima')
                        <span class="bg-green-100 text-green-600 px-3 py-1 rounded-lg text-xs">Diterima</span>
                    @elseif(session('status') == 'ditolak')
                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-lg text-xs">Ditolak</span>
                    @else
                        -
                    @endif
                </p>
            </div>
        </div>

        <!-- SKOR PENILAIAN -->
        <div class="bg-white p-5 rounded-2xl shadow">
            <h4 class="font-semibold mb-4">Skor Penilaian</h4>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">

                <!-- STATUS LOKASI -->
                <div class="bg-blue-100 p-4 rounded-2xl min-h-[120px] flex flex-col justify-center">

                    <p class="text-sm text-gray-500 mb-2">
                        Status Lokasi
                    </p>
                    @if(session('status_lokasi') == 'sesuai_area')
                        <p class="text-xl font-bold text-green-600 break-words leading-tight">
                            Sesuai Area
                        </p>
                    @elseif(session('status_lokasi') == 'area_dekat')
                        <p class="text-xl font-bold text-yellow-600 break-words leading-tight">
                            Area Dekat
                        </p>
                    @elseif(session('status_lokasi') == 'di_luar_area')
                        <p class="text-xl font-bold text-red-600 break-words leading-tight">
                            Di luar Area
                        </p>
                    @else
                        <p class="text-xl font-bold text-gray-500">
                            -
                        </p>
                    @endif
                </div>

                <!-- KONDISI RUMAH -->
                <div class="bg-yellow-100 p-4 rounded-2xl min-h-[120px] flex flex-col justify-center">
                    <p class="text-sm text-gray-500 mb-2">
                        Kondisi Rumah
                    </p>
                    @if(session('kondisi_rumah') == 'rumah_buruk')
                        <p class="text-xl font-bold text-green-600">
                            Buruk
                        </p>
                    @elseif(session('kondisi_rumah') == 'rumah_sedang')
                        <p class="text-xl font-bold text-yellow-600">
                            Sedang
                        </p>
                    @elseif(session('kondisi_rumah') == 'rumah_baik')
                        <p class="text-xl font-bold text-red-600">
                            Baik
                        </p>
                    @else
                        <p class="text-xl font-bold text-gray-500">
                            -
                        </p>
                    @endif
                </div>

                <!-- SKOR KELAYAKAN -->
                <div class="bg-green-100 p-4 rounded-2xl min-h-[120px] flex flex-col justify-center">
                    <p class="text-sm text-gray-500 mb-2">
                        Kelayakan
                    </p>
                    <p class="text-2xl font-bold text-green-600">
                        {{ session('skor_kelayakan') ?? '0.0' }}
                    </p>
                </div>
            </div>
        </div>

                {{-- <div class="bg-red-100 p-3 rounded-xl">
                    <p class="text-xs text-gray-500">Fraud</p>
                    <p class="text-lg font-bold text-red-600">0.0</p>
                </div> --}}

                {{-- <div class="bg-blue-100 p-3 rounded-xl">
                    <p class="text-xs text-gray-500">Overall</p>
                    <p class="text-lg font-bold text-blue-600">
                        {{ session('skor_kelayakan') ?? '0.0' }}
                    </p>
                </div> --}}

            </div>
        </div>

    </div>

</div>

<!-- SCRIPT -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
function onScanSuccess(decodedText) {
    html5QrcodeScanner.clear();

    // 🔥 hapus scanner dari DOM (lebih bersih)
    document.getElementById('scannerBox').remove();

    fetch('/scan/' + decodedText)
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {

                let w = res.data;

                document.getElementById('wargaCard').classList.remove('hidden');
                document.getElementById('formPengajuan').classList.remove('hidden');

                document.getElementById('nik').innerText = w.nik;
                document.getElementById('nama').innerText = w.nama;
                document.getElementById('alamat').innerText = w.alamat;
                document.getElementById('warga_id').value = w.id;

            } else {
                alert('Warga tidak ditemukan');
            }
        });
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: 250 }
);

html5QrcodeScanner.render(onScanSuccess);
</script>

<script>
document.querySelector('input[name="foto_rumah"]').addEventListener('change', function(e) {
    let file = e.target.files[0];
    let preview = document.getElementById('preview');

    preview.src = URL.createObjectURL(file);
    preview.classList.remove('hidden');
});
</script>

@endsection

<script>

function ambilLokasi()
{
    const btn = document.getElementById('btnLokasi');
    const text = document.getElementById('textLokasi');

    btn.disabled = true;

    text.innerHTML = 'Mengambil lokasi...';

    if(navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition(

            function(position)
            {
                document.getElementById('latitude_pengajuan').value =
                    position.coords.latitude;

                document.getElementById('longitude_pengajuan').value =
                    position.coords.longitude;

                btn.classList.remove(
                    'bg-blue-600',
                    'hover:bg-blue-700'
                );

                btn.classList.add(
                    'bg-green-600'
                );

                text.innerHTML = 'Lokasi Berhasil Diverifikasi';

                alert('Lokasi berhasil diambil');

                document.getElementById('btnAjukan')
                    .disabled = false;
            },

            function(error)
            {
                btn.disabled = false;

                text.innerHTML = 'Verifikasi Lokasi';

                alert('Gagal mengambil lokasi');
            }

        );
    }
}

</script>
