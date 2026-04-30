<!-- resources/views/warga/index.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Data Warga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h3>Data Warga</h3>

<a href="{{ route('warga.create') }}" class="btn btn-primary mb-3">+ Tambah Warga</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>NIK</th>
            <th>Nama</th>
            <th>Pekerjaan</th>
            <th>Penghasilan</th>
            <th>Tanggungan</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($wargas as $w)
        <tr>
            <td>{{ $w->nik }}</td>
            <td>{{ $w->nama }}</td>
            <td>{{ $w->pekerjaan }}</td>
            <td>{{ $w->penghasilan }}</td>
            <td>{{ $w->tanggungan }}</td>

            <td>
                <a href="{{ route('warga.show', $w->id) }}" class="btn btn-info btn-sm">Detail</a>
                <a href="{{ route('warga.edit', $w->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('warga.destroy', $w->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
