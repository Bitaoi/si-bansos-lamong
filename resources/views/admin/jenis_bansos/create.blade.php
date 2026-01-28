<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Bansos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 600px;">
    <h3>Tambah Jenis Bansos</h3>
    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('jenis-bansos.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Nama Bansos</label>
                    <input type="text" name="nama_bansos" class="form-control" placeholder="Contoh: BLT Dana Desa" required>
                </div>
                <div class="mb-3">
                    <label>Kriteria Penerima</label>
                    <textarea name="kriteria" class="form-control" rows="4" placeholder="Jelaskan siapa yang berhak menerima..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('jenis-bansos.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>