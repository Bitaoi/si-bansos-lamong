<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Akun RT - Admin SI Bansos</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --warna-paling-gelap: #2C3E50; 
            --warna-utama: #7D88DC; 
            --warna-soft: #BBD0EC; 
            --warna-background: #FEFCFB; 
        }

        body { background-color: var(--warna-background) !important; color: var(--warna-paling-gelap); font-family: 'Poppins', sans-serif !important; }
        .text-primary { color: var(--warna-utama) !important; }
        .bg-primary { background-color: var(--warna-utama) !important; color: #ffffff !important; }
        .btn-primary { background-color: var(--warna-utama) !important; border-color: var(--warna-utama) !important; color: #ffffff !important; }
        .btn-primary:hover { background-color: var(--warna-paling-gelap) !important; border-color: var(--warna-paling-gelap) !important; }
        
        .sidebar { min-height: 100vh; background: var(--warna-paling-gelap); color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: var(--warna-utama); color: white; }
        .nav-link i { width: 24px; display: inline-block; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: var(--warna-soft); font-weight: 700; padding: 10px 20px; letter-spacing: 0.5px; opacity: 0.8; }

        .card { border: 1px solid var(--warna-soft) !important; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .form-control { border-radius: 8px; padding: 10px 15px; border-color: #e2e8f0; }
        .form-control:focus { border-color: var(--warna-utama); box-shadow: 0 0 0 0.25rem rgba(125, 136, 220, 0.25); }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        
        <!-- SIDEBAR PINTAR -->
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <h5 class="fw-bold mb-4 px-2 py-2 border-bottom text-white" style="border-color: var(--warna-soft) !important;">
                <i class="bi bi-shield-lock-fill me-2"></i>ADMIN PANEL
            </h5>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.rt.index') }}" class="nav-link {{ Request::routeIs('admin.rt.*') ? 'active' : '' }}">
                        <i class="bi bi-person-badge-fill"></i> Manajemen Akun RT
                    </a>
                </li>
                
                <div class="sidebar-heading mt-3">Master Data</div>
                <li class="nav-item">
                    <a href="{{ route('warga.index') }}" class="nav-link {{ Request::routeIs('warga.*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i> Data Warga
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('jenis-bansos.index') }}" class="nav-link {{ Request::routeIs('jenis-bansos.*') ? 'active' : '' }}">
                        <i class="bi bi-gift-fill"></i> Jenis Bansos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.jadwal.index') }}" class="nav-link {{ Request::routeIs('admin.jadwal.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-event"></i> Jadwal Tahapan
                    </a>
                </li>
                
                <div class="sidebar-heading mt-3">Transaksi</div>
                <li class="nav-item">
                    <a href="{{ route('verifikasi.index') }}" class="nav-link {{ Request::routeIs('verifikasi.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-check-fill"></i> Verifikasi Pengajuan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('penyaluran.index') }}" class="nav-link {{ Request::routeIs('penyaluran.*') ? 'active' : '' }}">
                        <i class="bi bi-truck"></i> Penyaluran
                    </a>
                </li>
                
                <!-- TOMBOL KELUAR -->
                <li class="nav-item mt-5">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link text-white w-100 text-start border-0 shadow-sm" style="background-color: #dc3545; border-radius: 8px;">
                            <i class="bi bi-box-arrow-right"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        <!-- AKHIR SIDEBAR -->

        <div class="col-md-9 col-lg-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Tambah Akun Ketua RT</h4>
                    <p class="text-muted mb-0">Buat akses kredensial untuk ketua RT agar dapat mengelola data warganya.</p>
                </div>
                <a href="{{ route('admin.rt.index') }}" class="btn btn-outline-secondary fw-bold shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
                        
                        @if($errors->any())
                            <div class="alert alert-danger rounded-3 border-0 shadow-sm mb-4">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.rt.store') }}" method="POST">
                            @csrf
                            <h6 class="fw-bold text-primary mb-3"><i class="bi bi-person-vcard me-2"></i>Informasi Ketua RT</h6>
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Nama Lengkap Ketua RT <span class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" class="form-control" placeholder="Contoh: Budi Santoso" value="{{ old('nama_lengkap') }}" required>
                            </div>

                            <!-- NAMA INPUT SUDAH DIPERBAIKI MENJADI wilayah_rt_rw -->
                            <div class="mb-4">
                                <label class="form-label small fw-bold">Wilayah (RT/RW) <span class="text-danger">*</span></label>
                                <input type="text" name="wilayah_rt_rw" class="form-control" placeholder="Contoh: 001/005" value="{{ old('wilayah_rt_rw') }}" required>
                                <small class="text-muted d-block mt-2" style="font-size: 0.75rem;">
                                    <i class="bi bi-info-circle me-1"></i> Gunakan format angka 3 digit dipisah garis miring (RT/RW). Pastikan sama persis dengan data wilayah di Data Warga.
                                </small>
                            </div>

                            <hr class="text-muted my-4">

                            <h6 class="fw-bold text-primary mb-3"><i class="bi bi-key me-2"></i>Kredensial Login</h6>
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control" placeholder="Contoh: rt001" value="{{ old('username') }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                            </div>

                            <div class="d-grid mt-5">
                                <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm">
                                    <i class="bi bi-save me-2"></i> SIMPAN AKUN
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="col-lg-4 mt-4 mt-lg-0">
                    <div class="alert alert-light border-0 shadow-sm rounded-4" style="border-left: 4px solid var(--warna-utama) !important;">
                        <h6 class="fw-bold text-dark"><i class="bi bi-shield-check text-primary me-2"></i>Hak Akses RT</h6>
                        <p class="small text-muted mb-0">Dengan akun ini, Ketua RT memiliki kewenangan penuh untuk:</p>
                        <ul class="small text-muted mt-2 ps-3 mb-0">
                            <li class="mb-1">Melihat data warganya sendiri.</li>
                            <li class="mb-1">Melakukan pengajuan bantuan sosial (Bansos).</li>
                            <li>Memantau status verifikasi dan penyaluran.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>