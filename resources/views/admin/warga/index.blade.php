<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Warga - SI Bansos Lamong</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root { --warna-paling-gelap: #2C3E50; --warna-utama: #7D88DC; --warna-soft: #BBD0EC; --warna-background: #FEFCFB; }
        body { background-color: var(--warna-background); font-family: 'Poppins', sans-serif; color: var(--warna-paling-gelap); }
        .sidebar { min-height: 100vh; background: var(--warna-paling-gelap); color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: var(--warna-utama); color: white; }
        .nav-link i { width: 24px; display: inline-block; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: var(--warna-soft); font-weight: 700; padding: 10px 20px; letter-spacing: 0.5px; opacity: 0.8; }
        .card { border: 1px solid var(--warna-soft); border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); }
        .table-custom thead th { background-color: var(--warna-soft); color: var(--warna-paling-gelap); font-weight: 600; font-size: 0.85rem; border-bottom: 2px solid var(--warna-utama); text-transform: uppercase; padding: 15px; }
        .table-custom tbody td { padding: 15px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
        .btn-primary { background-color: var(--warna-utama); border-color: var(--warna-utama); }
        .btn-primary:hover { background-color: #6a75ca; border-color: #6a75ca; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <h5 class="fw-bold mb-4 px-2 py-2 border-bottom border-secondary text-white"><i class=""></i>KASI KESEJAHTERAAN</h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('admin.rt.index') }}" class="nav-link"><i class="bi bi-person-badge-fill"></i> Akun RT</a></li>
                <div class="sidebar-heading mt-3">Master Data</div>
                <li class="nav-item"><a href="{{ route('warga.index') }}" class="nav-link active"><i class="bi bi-people-fill"></i> Data Warga</a></li>
                <li class="nav-item"><a href="{{ route('jenis-bansos.index') }}" class="nav-link"><i class="bi bi-gift-fill"></i> Jenis Bansos</a></li>
                <li class="nav-item"><a href="{{ route('admin.jadwal.index') }}" class="nav-link"><i class="bi bi-calendar-event"></i> Jadwal Tahapan</a></li>
                <div class="sidebar-heading mt-3">Transaksi</div>
                <li class="nav-item"><a href="{{ route('verifikasi.index') }}" class="nav-link"><i class="bi bi-file-earmark-check-fill"></i> Verifikasi</a></li>
                <li class="nav-item"><a href="{{ route('penyaluran.index') }}" class="nav-link"><i class="bi bi-truck"></i> Penyaluran</a></li>
                <li class="nav-item mt-5">
                    <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="nav-link text-white w-100 text-start border-0 bg-danger rounded-3"><i class="bi bi-box-arrow-right"></i> Keluar</button></form>
                </li>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-1 text-dark">Master Data Warga</h3>
                    <p class="text-muted mb-0">Kelola basis data penduduk Desa Lamong.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm bg-white mb-4 overflow-visible rounded-4">
                <div class="card-body p-4">
                    <div class="row g-3 align-items-center justify-content-between">
                        <div class="col-md-6 col-lg-5">
                            <form action="{{ route('warga.index') }}" method="GET" class="d-flex gap-2">
                                <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-secondary text-muted"><i class="bi bi-search"></i></span>
                                    <input type="text" name="keyword" class="form-control border-secondary" placeholder="Cari NIK atau Nama Lengkap..." value="{{ request('keyword') }}">
                                    <button class="btn btn-primary fw-bold" type="submit">Cari</button>
                                </div>
                                @if(request('keyword'))
                                    <a href="{{ route('warga.index') }}" class="btn btn-outline-danger fw-bold shadow-sm d-flex align-items-center" title="Hapus Filter Pencarian">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                @endif
                            </form>
                        </div>

                        <div class="col-md-6 col-lg-7 d-flex justify-content-md-end gap-2">
                            <div class="dropdown">
                                <button class="btn btn-success rounded-3 shadow-sm fw-bold dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-file-earmark-excel me-1"></i> Import Excel
                                </button>
                                <ul class="dropdown-menu border-0 shadow-lg rounded-3">
                                    <li><a class="dropdown-item" href="{{ route('warga.template') }}"><i class="bi bi-download me-2 text-primary"></i>1. Unduh Template</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('warga.import') }}" method="POST" enctype="multipart/form-data" class="px-3 py-2">
                                            @csrf
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold">2. Unggah File (.xlsx / .csv)</label>
                                                <input class="form-control form-control-sm" type="file" name="file_excel" accept=".xlsx, .xls, .csv" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">Proses Import</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            <a href="{{ route('warga.create') }}" class="btn btn-primary rounded-3 shadow-sm fw-bold">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Warga
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm overflow-hidden rounded-4">
                <div class="table-responsive">
                    <table class="table table-custom table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th class="text-center">No. KK</th>
                                <th class="text-center">RT/RW</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($wargas as $warga)
                                <tr>
                                    <td class="text-center fw-bold text-muted">{{ ($wargas->currentPage() - 1) * $wargas->perPage() + $loop->iteration }}</td>
                                    <td class="fw-bold text-dark">{{ $warga->nik }}</td>
                                    <td>{{ $warga->nama_lengkap }}</td>
                                    <td class="text-center">{{ $warga->no_kk }}</td>
                                    <td class="text-center"><span class="badge bg-light text-dark border">{{ $warga->rt }} / {{ $warga->rw }}</span></td>
                                    <td class="text-center">
                                        <div class="btn-group gap-1">
                                            <a href="{{ route('warga.edit', $warga->nik) }}" class="btn btn-sm btn-outline-primary rounded-2" title="Edit Data"><i class="bi bi-pencil-square"></i></a>
                                            <form action="{{ route('warga.destroy', $warga->nik) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data warga ini? Seluruh riwayat pengajuannya juga akan ikut terhapus!');" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger rounded-2" title="Hapus Data"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-search fs-1 mb-3 d-block text-secondary opacity-50"></i>
                                            <h6 class="fw-bold">Data Warga Tidak Ditemukan</h6>
                                            @if(request('keyword'))
                                                <p class="small mb-0">Tidak ada warga dengan NIK atau Nama <b>"{{ request('keyword') }}"</b>.</p>
                                            @else
                                                <p class="small mb-0">Belum ada data warga yang tersimpan di dalam sistem.</p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($wargas->hasPages())
                    <div class="card-footer bg-white border-top py-3">
                        {{ $wargas->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>