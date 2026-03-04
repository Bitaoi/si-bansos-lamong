<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Admin - SI Bansos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <span class="navbar-brand mb-0 h1">Admin Desa Lamong</span>
        <form action="/logout" method="POST" class="d-flex">
            @csrf
            <button class="btn btn-danger btn-sm" type="submit">Logout</button>
        </form>
    </div>
</nav>

<div class="container">
    <h3 class="mb-4">Dashboard Utama</h3>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Pengajuan</h5>
                    <p class="card-text display-4">{{ $totalPengajuan }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Menunggu Verifikasi</h5>
                    <p class="card-text display-4">{{ $menungguVerifikasi }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Penerima Layak</h5>
                    <p class="card-text display-4">{{ $penerimaLayak }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Sisa Kuota</h5>
                    <p class="card-text display-4">{{ $sisaKuota }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header fw-bold">Menu Pengelolaan Data</div>
                <div class="card-body">
                    <a href="{{ route('warga.index') }}" class="btn btn-outline-primary btn-lg me-2">
                         Kelola Data Warga
                    </a>
                    
                    <a href="{{ route('jenis-bansos.index') }}" class="btn btn-outline-primary btn-lg me-2">
                        <i class="fas fa-gift"></i> Kelola Jenis Bansos
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header fw-bold">5 Pengajuan Terbaru</div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>NIK</th>
                        <th>Nama Warga</th>
                        <th>Jenis Bantuan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuanTerbaru as $p)
                    <tr>
                        <td>{{ $p->tgl_pengajuan->format('d-m-Y') }}</td>
                        <td>{{ $p->nik }}</td>
                        <td>{{ $p->warga->nama_lengkap ?? '-' }}</td>
                        <td>{{ $p->jenisBansos->nama_bansos ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $p->status_verifikasi_admin == 'Layak' ? 'success' : ($p->status_verifikasi_admin == 'Proses' ? 'warning' : 'danger') }}">
                                {{ $p->status_verifikasi_admin }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data pengajuan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>