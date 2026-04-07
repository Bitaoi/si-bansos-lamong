<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun RT - Admin SI Bansos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f3f4f6; font-family: sans-serif; }
        .sidebar { min-height: 100vh; background: #1e293b; color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; }
        .nav-link:hover, .nav-link.active { background: #0d6efd; color: white; }
        .nav-link i { width: 24px; display: inline-block; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <h5 class="fw-bold mb-4 px-2 py-2 border-bottom border-secondary text-white"><i class="bi bi-shield-lock-fill me-2"></i>ADMIN PANEL</h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('admin.rt.index') }}" class="nav-link active"><i class="bi bi-person-badge-fill"></i> Manajemen Akun RT</a></li>
                <li class="nav-item"><a href="{{ route('warga.index') }}" class="nav-link"><i class="bi bi-people-fill"></i> Data Warga</a></li>
                <li class="nav-item"><a href="{{ route('jenis-bansos.index') }}" class="nav-link"><i class="bi bi-gift-fill"></i> Jenis Bansos</a></li>
                <li class="nav-item"><a href="{{ route('verifikasi.index') }}" class="nav-link"><i class="bi bi-file-earmark-check-fill"></i> Verifikasi Pengajuan</a></li>
                <li class="nav-item mt-5">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf <button class="nav-link bg-danger text-white w-100 text-start border-0"><i class="bi bi-box-arrow-right"></i> Keluar</button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Manajemen Akun RT</h4>
                    <p class="text-muted mb-0">Kelola akses sistem untuk Ketua RT se-Desa Lamong.</p>
                </div>
                <a href="{{ route('admin.rt.create') }}" class="btn btn-primary fw-bold shadow-sm"><i class="bi bi-plus-lg me-2"></i>Tambah Akun RT</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}</div>
            @endif

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Wilayah (RT/RW)</th>
                                    <th>Nama Ketua RT</th>
                                    <th>Username Login</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rts as $rt)
                                <tr>
                                    <td class="ps-4 fw-bold text-primary">{{ $rt->wilayah_rt_rw }}</td>
                                    <td class="fw-bold">{{ $rt->nama_lengkap }}</td>
                                    <td><code>{{ $rt->username }}</code></td>
                                    <td class="text-end pe-4">
                                        <form action="{{ route('admin.rt.destroy', $rt->id_user) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus akun RT ini? Mereka tidak akan bisa login lagi.')">
                                                <i class="bi bi-trash-fill"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada akun RT yang didaftarkan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>