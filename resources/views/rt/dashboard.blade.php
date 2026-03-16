<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard RT - SI Bansos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f3f4f6; font-family: sans-serif; }
        .sidebar { min-height: 100vh; background: #1e293b; color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; }
        .nav-link:hover, .nav-link.active { background: #0d6efd; color: white; }
        .nav-link i { width: 24px; display: inline-block; }
        .stat-card { border: none; border-radius: 12px; transition: transform 0.2s; background: white; }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .icon-circle { width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <h5 class="fw-bold mb-4 px-2 py-2 border-bottom border-secondary">
                <i class="bi bi-building me-2"></i>MENU RT
            </h5>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('rt.dashboard') }}" class="nav-link active">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pengajuan.create') }}" class="nav-link">
                        <i class="bi bi-file-earmark-plus-fill"></i> Pengajuan Baru
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('rt.warga.index') }}" class="nav-link">
                        <i class="bi bi-people-fill"></i> Data Warga RT
                    </a>
                </li>
                <li class="nav-item mt-5">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link bg-danger text-white w-100 text-start border-0 shadow-sm">
                            <i class="bi bi-box-arrow-right"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
            
            <div class="d-md-none d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold"><i class="bi bi-speedometer2 me-2"></i>Dashboard RT</h5>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-danger"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                        <div>
                            <strong>Berhasil!</strong> {{ session('success') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm bg-primary text-white mb-4 rounded-4 overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-1">Selamat Datang, Bapak/Ibu RT!</h2>
                            <p class="mb-0 opacity-75 fs-5">
                                Wilayah Tugas: <strong>RT {{ explode('/', $user->wilayah_rt_rw)[0] ?? '-' }} / RW {{ explode('/', $user->wilayah_rt_rw)[1] ?? '-' }}</strong>
                            </p>
                        </div>
                        <div class="col-md-4 text-end d-none d-md-block">
                            <i class="bi bi-person-badge" style="font-size: 4rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-info bg-opacity-10 text-info me-3"><i class="bi bi-people-fill"></i></div>
                                <div>
                                    <h6 class="text-muted small mb-1 text-uppercase fw-bold">Warga Saya</h6>
                                    <h3 class="fw-bold mb-0 text-dark">{{ $wargaSaya }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-primary bg-opacity-10 text-primary me-3"><i class="bi bi-send-fill"></i></div>
                                <div>
                                    <h6 class="text-muted small mb-1 text-uppercase fw-bold">Total Usulan</h6>
                                    <h3 class="fw-bold mb-0 text-dark">{{ $totalUsulanSaya }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-warning bg-opacity-10 text-warning me-3"><i class="bi bi-hourglass-split"></i></div>
                                <div>
                                    <h6 class="text-muted small mb-1 text-uppercase fw-bold">Verifikasi</h6>
                                    <h3 class="fw-bold mb-0 text-dark">{{ $menungguVerifikasi }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-success bg-opacity-10 text-success me-3"><i class="bi bi-check-circle-fill"></i></div>
                                <div>
                                    <h6 class="text-muted small mb-1 text-uppercase fw-bold">Disetujui</h6>
                                    <h3 class="fw-bold mb-0 text-dark">{{ $siapDisalurkan }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-clock-history me-2"></i>Status Pengajuan Terkini</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Tanggal</th>
                                    <th>Nama Warga</th>
                                    <th>Bansos</th>
                                    <th>Status Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuanTerbaru as $item)
                                <tr>
                                    <td class="ps-4 small text-muted">
                                        {{ $item->tgl_pengajuan->format('d M Y') }}
                                    </td>
                                    <td class="fw-bold">{{ $item->warga->nama_lengkap ?? 'Data Warga Terhapus' }}</td>
                                    <td>
                                        <span class="badge bg-light text-primary border">
                                            {{ $item->jenisBansos->nama_bansos ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(in_array($item->status_verifikasi_admin, ['Proses', 'Verifikasi Lapangan', 'Menunggu Musdes', 'Siap Keputusan']))
                                            <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> {{ $item->status_verifikasi_admin }}</span>
                                        @elseif($item->status_verifikasi_admin == 'Layak')
                                            <span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i> Disetujui</span>
                                        @else
                                            <span class="badge bg-danger"><i class="bi bi-x-circle-fill me-1"></i> Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada pengajuan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-lightning-charge-fill me-2"></i>Aksi Cepat</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('pengajuan.create') }}" class="btn btn-outline-primary w-100 py-3 fw-bold text-start ps-4 h-100 d-flex align-items-center">
                                <i class="bi bi-plus-circle-fill fs-4 me-3"></i> 
                                <div>
                                    <div>Buat Pengajuan Bansos</div>
                                    <small class="fw-normal text-muted">Usulkan warga yang membutuhkan</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('rt.warga.index') }}" class="btn btn-outline-dark w-100 py-3 fw-bold text-start ps-4 h-100 d-flex align-items-center">
                                <i class="bi bi-search fs-4 me-3"></i> 
                                <div>
                                    <div>Cek Data Warga</div>
                                    <small class="fw-normal text-muted">Lihat daftar warga di RT {{ explode('/', $user->wilayah_rt_rw)[0] }}</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>