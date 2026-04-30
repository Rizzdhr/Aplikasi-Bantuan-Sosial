<!DOCTYPE html>
<html>
<head>
    <title>Pengajuan Bantuan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>

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
        <p><b>Pekerjaan:</b> <span id="pekerjaan"></span></p>
        <p><b>Penghasilan:</b> <span id="penghasilan"></span></p>
        <p><b>Tanggungan:</b> <span id="tanggungan"></span></p>

    </div>
</div>

<!-- FORM PENGAJUAN -->
<form id="formPengajuan" action="{{ route('pengajuan.store') }}" method="POST" style="display:none;">
    @csrf

    <input type="hidden" name="warga_id" id="warga_id">

    <div class="mb-2">
        <input type="text" name="jenis_bantuan" class="form-control" placeholder="Jenis Bantuan" required>
    </div>

    <button class="btn btn-success">Ajukan Bantuan</button>
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
                document.getElementById('pekerjaan').innerText = w.pekerjaan;
                document.getElementById('penghasilan').innerText = w.penghasilan;
                document.getElementById('tanggungan').innerText = w.tanggungan;



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

</body>
</html>
