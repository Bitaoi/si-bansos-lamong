<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Warga RT - SI Bansos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f3f4f6; font-family: sans-serif; }
        .sidebar { min-height: 100vh; background: #1e293b; color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; }
        .nav-link:hover, .nav-link.active { background: #0d6efd; color: white; }
        .nav-link i { width: 24px; display: inline-block; }
        .table-custom thead th { background-color: #f8fafc; color: #64748b; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <h5 class="fw-bold mb-4 px-2 py-2 border-bottom border-secondary"><i class="bi bi-building me-2"></i>MENU RT</h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="{{ route('rt.dashboard') }}" class="nav-link"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('pengajuan.create') }}" class="nav-link"><i class="bi bi-file-earmark-plus-fill"></i> Pengajuan Baru</a></li>
                <li class="nav-item"><a href="{{ route('rt.warga.index') }}" class="nav-link active"><i class="bi bi-people-fill"></i> Data Warga RT</a></li>
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
                    <h4 class="fw-bold mb-1">Daftar Warga RT {{ $rt }} / RW {{ $rw }}</h4>
                    <p class="text-muted mb-0">Total {{ $wargas->total() }} penduduk terdaftar di wilayah Anda.</p>
                </div>
                <a href="{{ route('rt.dashboard') }}" class="btn btn-secondary shadow-sm"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">No. KK / NIK</th>
                                    <th>Nama Lengkap</th>
                                    <th>L/P</th>
                                    <th>Pekerjaan</th>
                                    <th>Status Kawin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($wargas as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $item->no_kk }}</div>
                                        <small class="text-muted">{{ $item->nik }}</small>
                                    </td>
                                    <td class="fw-bold">{{ $item->nama_lengkap }}</td>
                                    <td>{{ $item->jenis_kelamin }}</td>
                                    <td>{{ $item->pekerjaan }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $item->status_kawin }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-people fs-1 d-block mb-3 opacity-25"></i>
                                        Belum ada data warga di wilayah RT Anda.<br>Pastikan admin desa telah mengimpor data kependudukan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($wargas->hasPages())
                    <div class="card-footer bg-white py-3 border-top-0">
                        {{ $wargas->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
</body>
</html>