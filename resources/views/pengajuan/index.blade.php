<!DOCTYPE html>
<html>
<head>
    <title>Pengajuan Bantuan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>


@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>

    <div class="alert alert-info">
        <b>Kondisi Rumah:</b> {{ session('kondisi_rumah') }} <br>
        <b>Status:</b> {{ session('status') }} <br>
        <b>Skor:</b> {{ session('skor_kelayakan') ?? '-' }}
    </div>
@endif

<body class="container mt-4">

<h3>Pengajuan Bantuan (Scan QR)</h3>

<!-- SCANNER -->
<div class="mb-4">
    <h5>Scan QR Warga</h5>
    <div id="reader" style="width:300px;"></div>
</div>

<!-- INFO WARGA -->
<div id="wargaCard" class="card mb-4" style="display:none;">
    <div class="card-body">
        <h5>Data Warga</h5>
        <p><b>NIK:</b> <span id="nik"></span></p>
        <p><b>Nama:</b> <span id="nama"></span></p>
        <p><b>Alamat:</b> <span id="alamat"></span></p>
    </div>
</div>

<!-- FORM PENGAJUAN -->
{{-- @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif --}}
<form id="formPengajuan" action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data" style="display:none;">
    @csrf

    <input type="hidden" name="warga_id" id="warga_id">

    <div class="mb-2">
        <label for="">Program Bantuan</label>
        <select name="program_bantuan" class="form-control" required>
            <option value="jkn">Bantuan Iuran JKN (kesehatan)</option>
            <option value="bpnt">Bantuan Pangan Non-Tunai (BPNT) (pangan)</option>
            <option value="blt">Bantuan Langsung Tunai (BLT) (tunai)</option>
        </select>
    </div>

    <div class="mb-2">
        <label>Penghasilan Bulanan (Rp)</label>
        <input type="number" name="penghasilan" class="form-control" required>
    </div>

    <div class="mb-2">
        <label for="">Usia</label>
        <input type="number" name="usia" class="form-control" required>
    </div>


    <div class="mb-2">
        <label>Pekerjaan</label>
        <select name="pekerjaan" class="form-control" required>
            <option value="tidak_bekerja">Tidak Bekerja</option>
            <option value="buruh_harian">Buruh Harian</option>
            <option value="pegawai/karyawan">Pegawai / Karyawan</option>
        </select>
    </div>

    <div class="mb-2">
        <label>Upload Foto Rumah</label>
        <input type="file" name="foto_rumah" class="form-control" required>
    </div>

    <img id="preview" width="200" style="display:none; margin-top:10px;">

    <button type="submit" class="btn btn-success">Ajukan Bantuan</button>
    <a href="{{ route('pengajuan.index') }}" class="btn btn-secondary">Kembali</a>

</form>

<script>
function onScanSuccess(decodedText) {
    // STOP scanner setelah berhasil
    html5QrcodeScanner.clear();

    let nik = decodedText;

    fetch('/scan/' + nik)
        .then(res => res.json())
        .then(res => {
            if(res.status === 'success') {

                let w = res.data;

                // tampilkan data warga
                document.getElementById('wargaCard').style.display = 'block';
                document.getElementById('formPengajuan').style.display = 'block';

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
    preview.style.display = 'block';
});
</script>

</body>
</html>
