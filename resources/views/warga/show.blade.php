<!-- resources/views/warga/show.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Detail Warga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h3>Detail Warga</h3>

<p><b>NIK:</b> {{ $warga->nik }}</p>
<p><b>Nama:</b> {{ $warga->nama }}</p>
<p><b>Alamat:</b> {{ $warga->alamat }}</p>
<p><b>Penghasilan:</b> {{ $warga->penghasilan }}</p>
<p><b>Tanggungan:</b> {{ $warga->tanggungan }}</p>
<p><b>Kondisi Rumah:</b> {{ $warga->kondisi_rumah }}</p>
<p><b>Status Kepemilikan:</b> {{ $warga->status_kepemilikan }}</p>
<p><b>Pekerjaan:</b> {{ $warga->pekerjaan }}</p>


<h5>QR Code</h5>

{!! QrCode::size(200)->generate($warga->nik) !!}

<br><br>
<a href="{{ route('warga.index') }}" class="btn btn-secondary">Kembali</a>

</body>
</html>
