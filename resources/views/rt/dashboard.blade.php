<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard RT - SI Bansos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <span class="navbar-brand mb-0 h1">Panel Ketua RT</span>
        <div class="d-flex align-items-center">
            <span class="text-white me-3">Halo, {{ Auth::user()->nama_lengkap }}</span>
            <form action="/logout" method="POST">
                @csrf
                <button class="btn btn-danger btn-sm" type="submit">Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="container">
    <h3 class="mb-4">Selamat Datang</h3>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Usulan Saya</h5>
                    <p class="card-text display-4">{{ $totalUsulanSaya }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Menunggu Verifikasi Desa</h5>
                    <p class="card-text display-4">{{ $menungguVerifikasi }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Siap Disalurkan</h5>
                    <p class="card-text display-4">{{ $siapDisalurkan }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-info text-white fw-bold">Pengumuman</div>
        <div class="card-body bg-light">
            <p class="card-text">
                <strong>Jadwal Musdes:</strong> Akan dilaksanakan pada tanggal 25 bulan ini di Balai Desa.<br>
                Mohon segera melengkapi data usulan warga sebelum tanggal 20.
            </p>
        </div>
    </div>
</div>

</body>
</html>