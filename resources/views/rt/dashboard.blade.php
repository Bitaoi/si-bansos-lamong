<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard RT - SI Bansos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* 1. STRUKTUR PALET WARNA (KONTRAST TINGGI) */
        :root {
            --warna-paling-gelap: #2C3E50; /* Biru gelap untuk teks & Sidebar */
            --warna-utama: #7D88DC; /* Warna tombol/elemen utama */
            --warna-soft: #BBD0EC; /* Warna aksen/background muda */
            --warna-background: #FEFCFB; /* Warna latar halaman */
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

        /* 3. STYLING TOMBOL */
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
        
        .stat-card { border: 1px solid var(--warna-soft); border-radius: 12px; transition: transform 0.2s; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(125, 136, 220, 0.15); }
        .icon-circle { width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        
        .table-custom thead th { background-color: var(--warna-soft); color: var(--warna-paling-gelap); font-weight: 600; font-size: 0.85rem; border-bottom: 2px solid var(--warna-utama); }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <h5 class="fw-bold mb-4 px-2 py-2 border-bottom text-white" style="border-color: var(--warna-soft) !important;">
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
                        <button type="submit" class="nav-link text-white w-100 text-start border-0 shadow-sm" style="background-color: #dc3545;">
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

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                        <div><strong>Akses Ditolak!</strong> {{ session('error') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                        <div><strong>Berhasil!</strong> {{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm bg-primary text-white mb-4 rounded-4 overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-1">Halo, Ketua {{ Auth::user()->wilayah_rt_rw ?? Auth::user()->username }}! 👋</h2>
                            <p class="mb-0 opacity-75 fs-5">
                                Selamat datang di Panel Pengelola Bantuan Sosial Desa Lamong.
                            </p>
                        </div>
                        <div class="col-md-4 text-end d-none d-md-block">
                            <i class="bi bi-person-badge" style="font-size: 4rem; opacity: 0.2;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle me-3" style="background-color: #e2e8f0; color: #64748b;"><i class="bi bi-people-fill"></i></div>
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
                                <div class="icon-circle me-3" style="background-color: var(--warna-soft); color: var(--warna-utama);"><i class="bi bi-send-fill"></i></div>
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

            <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--warna-soft) !important;">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-clock-history me-2"></i>Status Pengajuan Terkini</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead>
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
                                        <span class="badge" style="background-color: var(--warna-soft); color: var(--warna-paling-gelap);">
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

            <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--warna-soft) !important;">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-lightning-charge-fill me-2"></i>Aksi Cepat</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            @php
                                $tanggalSekarang = (int) now()->format('d');
                                $isBuka = $tanggalSekarang <= 8;
                            @endphp

                            @if($isBuka)
                                <a href="{{ route('pengajuan.create') }}" class="btn btn-outline-primary w-100 py-3 fw-bold text-start ps-4 h-100 d-flex align-items-center">
                                    <i class="bi bi-plus-circle-fill fs-4 me-3"></i> 
                                    <div>
                                        <div>Buat Pengajuan Bansos</div>
                                        <small class="fw-normal text-muted">Batas waktu: Tgl 1 - 8 Bulan Ini</small>
                                    </div>
                                </a>
                            @else
                                <button class="btn btn-outline-secondary w-100 py-3 fw-bold text-start ps-4 h-100 d-flex align-items-center" disabled style="cursor: not-allowed; background-color: var(--warna-background);">
                                    <i class="bi bi-lock-fill fs-4 me-3 text-danger"></i> 
                                    <div>
                                        <div class="text-secondary">Pengajuan Ditutup</div>
                                        <small class="fw-normal text-danger">Akan dibuka kembali Tgl 1 bulan depan.</small>
                                    </div>
                                </button>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('rt.warga.index') }}" class="btn btn-outline-dark w-100 py-3 fw-bold text-start ps-4 h-100 d-flex align-items-center">
                                <i class="bi bi-search fs-4 me-3"></i> 
                                <div>
                                    <div>Cek Data Warga</div>
                                    <small class="fw-normal text-muted">Lihat daftar warga di RT/RW Anda</small>
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