<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun RT - Admin SI Bansos</title>
    
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
        .table-custom thead th { background-color: var(--warna-soft); color: var(--warna-paling-gelap); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; border-bottom: 2px solid var(--warna-utama); }
        .table-custom tbody td { vertical-align: middle; border-bottom: 1px solid #f1f5f9; padding: 1rem 0.75rem; }
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
                    <h4 class="fw-bold mb-1">Manajemen Akun RT</h4>
                    <p class="text-muted mb-0">Kelola data akses login sistem untuk para Ketua RT.</p>
                </div>
                <a href="{{ route('admin.rt.create') }}" class="btn btn-primary fw-bold shadow-sm rounded-pill px-4">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Akun RT
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm bg-white overflow-hidden rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">No</th>
                                    <th>Identitas Ketua RT</th>
                                    <th>Username Login</th>
                                    <th>Wilayah Tugas</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- LOOPING DISESUAIKAN DENGAN NAMA VARIABEL DI CONTROLLER: $rts -->
                                @forelse($rts as $index => $rt)
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">{{ $index + 1 }}</td>
                                    <td class="fw-bold text-dark">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                            {{ $rt->nama_lengkap }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-3 py-2 fs-6 shadow-sm">{{ $rt->username }}</span>
                                    </td>
                                    <td>
                                        <span class="badge" style="background-color: var(--warna-soft); color: var(--warna-paling-gelap); padding: 8px 12px;">
                                            <i class="bi bi-geo-alt-fill me-1"></i> 
                                            RT/RW {{ $rt->wilayah_rt_rw }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <!-- HAPUS BERDASARKAN id_user SESUAI CONTROLLER -->
                                        <form action="{{ route('admin.rt.destroy', $rt->id_user) }}" method="POST" onsubmit="return confirm('Peringatan: Apakah Anda yakin ingin menghapus akun RT ini? Semua data terkait wilayah ini mungkin terdampak.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger shadow-sm fw-bold">
                                                <i class="bi bi-trash3-fill me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-person-x fs-1 d-block mb-3 opacity-25"></i>
                                        <h6 class="fw-bold">Belum ada akun RT yang terdaftar</h6>
                                        <p class="small mb-0">Klik tombol "Tambah Akun RT" di atas untuk menambahkan data baru.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- TAMBAHAN PAGINATION (Karena di controllermu memakai paginate(10)) -->
                @if($rts->hasPages())
                    <div class="card-footer bg-white py-3 border-0">
                        {{ $rts->links() }}
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>