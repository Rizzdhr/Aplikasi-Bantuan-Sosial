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

            <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 w-full">
                Ajukan Bantuan
            </button>
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

        <!-- SKOR ML -->
        <div class="bg-white p-5 rounded-2xl shadow">
            <h4 class="font-semibold mb-4">Skor Penilaian</h4>

            <div class="grid grid-cols-3 gap-3 text-center">

                <!-- KONDISI RUMAH -->
                <div class="bg-yellow-100 p-3 rounded-xl">
                    <p class="text-xs text-gray-500">Kondisi Rumah</p>

                    @if(session('kondisi_rumah') == 'rumah_buruk')
                        <p class="text-lg font-bold text-green-600">Buruk</p>
                    @elseif(session('kondisi_rumah') == 'rumah_sedang')
                        <p class="text-lg font-bold text-red-600">Sedang</p>
                    @elseif(session('kondisi_rumah') == 'rumah_baik')
                    <p class="text-lg font-bold text-red-600">Baik</p>
                    @else
                        <p class="text-lg font-bold text-gray-500">-</p>
                    @endif
                </div>

                <div class="bg-green-100 p-3 rounded-xl">
                    <p class="text-xs text-gray-500">Kelayakan</p>
                    <p class="text-lg font-bold text-green-600">
                        {{ session('skor_kelayakan') ?? '0.0' }}
                    </p>
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
