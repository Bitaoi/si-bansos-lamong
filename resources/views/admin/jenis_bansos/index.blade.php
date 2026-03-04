<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Bansos - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Daftar Jenis Bantuan Sosial</h3>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('jenis-bansos.create') }}" class="btn btn-primary">+ Tambah Bansos</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Nama Bansos</th>
                        <th>Kriteria / Syarat</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bansos as $key => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $item->nama_bansos }}</strong></td>
                        <td>{{ $item->kriteria_penerima }}</td>
                        <td>
                            <form action="{{ route('jenis-bansos.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus bansos ini?')">
                                <a href="{{ route('jenis-bansos.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>