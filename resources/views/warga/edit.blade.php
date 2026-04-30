<!-- resources/views/warga/edit.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Edit Warga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h3>Edit Warga</h3>

<form action="{{ route('warga.update', $warga->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="nik" value="{{ $warga->nik }}" class="form-control mb-2">
    <input type="text" name="nama" value="{{ $warga->nama }}" class="form-control mb-2">
    <input type="text" name="alamat" value="{{ $warga->alamat }}" class="form-control mb-2">
    <input type="text" name="pekerjaan" class="form-control mb-2" placeholder="Pekerjaan">
    <input type="number" name="penghasilan" value="{{ $warga->penghasilan }}" class="form-control mb-2">
    <input type="number" name="tanggungan" value="{{ $warga->jumlah_tanggungan }}" class="form-control mb-2">


    <button class="btn btn-success">Update</button>
</form>

</body>
</html>
