<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Jadwal Bansos - Admin</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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

        body { background-color: var(--warna-background) !important; font-family: 'Poppins', sans-serif !important; color: var(--warna-paling-gelap); }
        .text-primary { color: var(--warna-utama) !important; }
        .bg-primary { background-color: var(--warna-utama) !important; color: #ffffff !important; }
        .btn-primary { background-color: var(--warna-utama) !important; border-color: var(--warna-utama) !important; color: #ffffff !important; }
        .btn-primary:hover { background-color: var(--warna-paling-gelap) !important; border-color: var(--warna-paling-gelap) !important; }
        
        /* GAYA SIDEBAR KONSISTEN */
        .sidebar { min-height: 100vh; background: var(--warna-paling-gelap); color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: var(--warna-utama); color: white; }
        .nav-link i { width: 24px; display: inline-block; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: var(--warna-soft); font-weight: 700; padding: 10px 20px; letter-spacing: 0.5px; opacity: 0.8; }
        
        .card { border: 1px solid var(--warna-soft) !important; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .table-custom thead th { background-color: var(--warna-soft); color: var(--warna-paling-gelap); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; border-bottom: 2px solid var(--warna-utama); }
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
                    <a href="{{ route('admin.jadwal.index') }}" class="nav-link active">
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

        <div class="col-md-9 col-lg-10 p-4">
            
            <div class="d-md-none d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold"><i class="bi bi-calendar-event me-2"></i>Jadwal Tahapan</h5>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-danger"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Pengaturan Kalender Bansos</h4>
                    <p class="text-muted mb-0">Atur rentang tanggal dan deskripsi untuk setiap tahapan (siklus bulanan).</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success rounded-4 border-0 shadow-sm"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
            @endif

            <div class="card border-0 shadow-sm bg-white overflow-hidden rounded-4 border-top-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Tahapan</th>
                                    <th>Deskripsi Sistem</th>
                                    <th class="text-center">Tgl Mulai</th>
                                    <th class="text-center">Tgl Selesai</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jadwal as $item)
                                <tr>
                                    <td class="ps-4 fw-bold">
                                        <i class="bi bi-circle-fill me-2" style="color: {{ $item->warna_bg }}; font-size: 0.7rem;"></i>
                                        {{ $item->nama_tahapan }}
                                    </td>
                                    <td class="small text-muted">{{ $item->deskripsi }}</td>
                                    <td class="text-center fw-bold fs-5 text-primary">{{ $item->hari_mulai }}</td>
                                    <td class="text-center fw-bold fs-5 text-primary">{{ $item->hari_selesai }}</td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-warning btn-sm fw-bold text-white shadow-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                            <i class="bi bi-pencil-square me-1"></i> Edit Data
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($jadwal as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:none; border-radius:15px; overflow:hidden;">
            <div class="modal-header text-white" style="background-color: var(--warna-paling-gelap);">
                <h5 class="modal-title fw-bold"><i class="bi bi-calendar-event me-2"></i>Edit {{ $item->nama_tahapan }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.jadwal.update', $item->id) }}" method="POST">
                @csrf 
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="alert alert-light border small text-muted mb-4">Pastikan rentang tanggal (1-31) tidak saling bertabrakan dengan tahapan lainnya.</div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-bold small">Tanggal Mulai</label>
                            <input type="number" name="hari_mulai" class="form-control border-secondary" min="1" max="31" value="{{ $item->hari_mulai }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small">Tanggal Selesai</label>
                            <input type="number" name="hari_selesai" class="form-control border-secondary" min="1" max="31" value="{{ $item->hari_selesai }}" required>
                        </div>
                        <div class="col-12 mt-3">
                            <label class="form-label fw-bold small">Deskripsi Tahapan</label>
                            <textarea name="deskripsi" class="form-control border-secondary" rows="4" required>{{ $item->deskripsi }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold shadow-sm"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>