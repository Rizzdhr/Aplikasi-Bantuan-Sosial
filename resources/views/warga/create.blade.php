<!-- resources/views/warga/create.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Warga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h3>Tambah Warga</h3>

<form action="{{ route('warga.store') }}" method="POST">
    @csrf

    <input type="text" name="nik" class="form-control mb-2" placeholder="NIK" required>
    <input type="text" name="nama" class="form-control mb-2" placeholder="Nama" required>
    <input type="text" name="alamat" class="form-control mb-2" placeholder="Alamat">
    <input type="number" name="penghasilan" class="form-control mb-2" placeholder="Penghasilan">
    <input type="number" name="tanggungan" class="form-control mb-2" placeholder="Tanggungan">

    <button class="btn btn-success">Simpan</button>
</form>

</body>
</html>
