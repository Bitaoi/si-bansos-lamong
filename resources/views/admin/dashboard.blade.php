<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SI Bansos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* 1. STRUKTUR PALET WARNA (KONTRAST TINGGI) */
        :root {
            --warna-paling-gelap: #2C3E50; /* Biru sangat gelap untuk teks & Sidebar agar jelas */
            --warna-utama: #7D88DC; /* Warna tengah dari paletmu untuk tombol utama */
            --warna-soft: #BBD0EC; /* Warna pastel dari paletmu untuk aksen/border */
            --warna-background: #FEFCFB; /* Warna putih pucat dari paletmu */
        }

        body { 
            background-color: var(--warna-background) !important; 
            color: var(--warna-paling-gelap);
            font-family: sans-serif; 
        }

        /* 2. OVERRIDE WARNA PRIMARY BOOTSTRAP */
        .text-primary { color: var(--warna-utama) !important; }
        .bg-primary { background-color: var(--warna-utama) !important; color: #ffffff !important; }
        .border-primary { border-color: var(--warna-utama) !important; }

        /* 3. STYLING TOMBOL AGAR TEKS TERBACA */
        .btn-primary {
            background-color: var(--warna-utama) !important;
            border-color: var(--warna-utama) !important;
            color: #ffffff !important; 
            box-shadow: 0 4px 6px rgba(125, 136, 220, 0.2);
        }
        .btn-primary:hover {
            background-color: var(--warna-paling-gelap) !important;
            border-color: var(--warna-paling-gelap) !important;
            color: #ffffff !important;
        }

        .btn-outline-primary {
            color: var(--warna-utama) !important;
            border-color: var(--warna-utama) !important;
            background-color: transparent !important;
        }
        .btn-outline-primary:hover {
            background-color: var(--warna-utama) !important;
            color: #ffffff !important;
        }

        /* 4. SIDEBAR & KARTU */
        .sidebar { min-height: 100vh; background: var(--warna-paling-gelap); color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: var(--warna-utama); color: white; }
        .nav-link i { width: 24px; display: inline-block; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: var(--warna-soft); font-weight: 700; padding: 10px 20px; letter-spacing: 0.5px; opacity: 0.8; }

        .stat-card { border: 1px solid var(--warna-soft); border-radius: 12px; transition: transform 0.2s; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(125, 136, 220, 0.15); }
        .icon-circle { width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }

        .table-custom thead th { background-color: var(--warna-soft); color: var(--warna-paling-gelap); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; border-bottom: 2px solid var(--warna-utama); }
        .table-custom tbody td { vertical-align: middle; border-bottom: 1px solid #f1f5f9; padding: 1rem 0.75rem; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <h5 class="fw-bold mb-4 px-2 py-2 border-bottom text-white" style="border-color: var(--warna-soft) !important;">
                <i class="bi bi-shield-lock-fill me-2"></i>ADMIN PANEL
            </h5>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.rt.index') }}" class="nav-link">
                        <i class="bi bi-person-badge-fill"></i> Manajemen Akun RT
                    </a>
                </li>
                
                <div class="sidebar-heading mt-3">Master Data</div>
                <li class="nav-item">
                    <a href="{{ route('warga.index') }}" class="nav-link">
                        <i class="bi bi-people-fill"></i> Data Warga
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('jenis-bansos.index') }}" class="nav-link">
                        <i class="bi bi-gift-fill"></i> Jenis Bansos
                    </a>
                </li>

                <div class="sidebar-heading mt-3">Transaksi</div>
                <li class="nav-item">
                    <a href="{{ route('verifikasi.index') }}" class="nav-link {{ Request::routeIs('verifikasi.index') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-check-fill"></i> Verifikasi Pengajuan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-truck"></i> Penyaluran
                    </a>
                </li>

                <li class="nav-item mt-5">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link text-white w-100 text-start border-0 shadow-sm" style="background-color: #dc3545;">
                            <i class="bi bi-box-arrow-right"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
            
            <div class="d-md-none d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold"><i class="bi bi-speedometer2 me-2"></i>Dashboard Admin</h5>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-danger"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>

            <div class="card border-0 shadow-sm bg-white mb-4 rounded-4 overflow-hidden" style="border-left: 5px solid var(--warna-utama) !important;">
                <div class="card-body p-4 position-relative">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold text-dark mb-1">Halo, Administrator!</h2>
                            <p class="mb-0 text-muted fs-5">
                                Pantau dan kelola penyaluran bantuan sosial Desa Lamong dengan mudah.
                            </p>
                        </div>
                        <div class="col-md-4 text-end d-none d-md-block">
                             <i class="bi bi-bar-chart-line text-primary" style="font-size: 4rem; opacity: 0.2;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-12 col-md-6 col-lg-4 col-xl-2"> 
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body p-3">
                            <div class="d-flex flex-column align-items-center text-center">
                                <div class="icon-circle mb-2" style="background-color: #e2e8f0; color: #64748b;">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <h6 class="text-muted small mb-1 text-uppercase fw-bold">Penduduk</h6>
                                <h3 class="fw-bold mb-0 text-dark">{{ $totalWarga }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4 col-xl-2">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body p-3">
                            <div class="d-flex flex-column align-items-center text-center">
                                <div class="icon-circle mb-2" style="background-color: var(--warna-soft); color: var(--warna-utama);">
                                    <i class="bi bi-send-fill"></i>
                                </div>
                                <h6 class="text-muted small mb-1 text-uppercase fw-bold">Total Usulan</h6>
                                <h3 class="fw-bold mb-0 text-dark">{{ $totalPengajuan }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4 col-xl-2">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body p-3">
                            <div class="d-flex flex-column align-items-center text-center">
                                <div class="icon-circle bg-warning bg-opacity-10 text-warning mb-2">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>
                                <h6 class="text-muted small mb-1 text-uppercase fw-bold">Verifikasi</h6>
                                <h3 class="fw-bold mb-0 text-dark">{{ $menungguVerifikasi }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4 col-xl-2">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body p-3">
                            <div class="d-flex flex-column align-items-center text-center">
                                <div class="icon-circle bg-success bg-opacity-10 text-success mb-2">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                                <h6 class="text-muted small mb-1 text-uppercase fw-bold">Siap Salur</h6>
                                <h3 class="fw-bold mb-0 text-dark">{{ $penerimaLayak }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                 <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                    <div class="card stat-card shadow-sm h-100" style="background-color: var(--warna-utama); color: white;">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="small mb-1 text-uppercase fw-bold opacity-75">Sisa Kuota Global</h6>
                                <h2 class="fw-bold mb-0 text-white">{{ $sisaKuota }}</h2>
                            </div>
                            <div class="icon-circle bg-white" style="color: var(--warna-utama);">
                                <i class="bi bi-pie-chart-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--warna-soft) !important;">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-clock-history me-2"></i>5 Pengajuan Terbaru</h6>
                    <a href="{{ route('verifikasi.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Tanggal</th>
                                    <th>Nama Warga</th>
                                    <th>Jenis Bansos</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuanTerbaru as $item)
                                <tr>
                                    <td class="ps-4 text-muted small">{{ \Carbon\Carbon::parse($item->tgl_pengajuan)->format('d M Y') }}</td>
                                    <td class="fw-bold">{{ $item->warga->nama_lengkap ?? '-' }}</td>
                                    <td>
                                        <span class="badge" style="background-color: var(--warna-soft); color: var(--warna-paling-gelap);">
                                            {{ $item->jenisBansos->nama_bansos ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(in_array($item->status_verifikasi_admin, ['Proses', 'Verifikasi Lapangan', 'Menunggu Musdes', 'Siap Keputusan']))
                                            <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i> {{ $item->status_verifikasi_admin }}</span>
                                        @elseif($item->status_verifikasi_admin == 'Layak')
                                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Layak</span>
                                        @else
                                            <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('verifikasi.index') }}" class="btn btn-sm btn-light text-primary"><i class="bi bi-eye"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                        Belum ada pengajuan baru.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>