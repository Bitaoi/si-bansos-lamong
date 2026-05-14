<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Warga RT - SI Bansos</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* 1. STRUKTUR PALET WARNA */
        :root {
            --warna-paling-gelap: #2C3E50; 
            --warna-utama: #7D88DC; 
            --warna-soft: #BBD0EC; 
            --warna-background: #FEFCFB; 
        }

        body { 
            background-color: var(--warna-background) !important; 
            color: var(--warna-paling-gelap);
            font-family: 'Poppins', sans-serif !important; 
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
        
        .card { border: 1px solid var(--warna-soft) !important; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        
        /* 5. STYLING TABEL KONSISTEN */
        .table-custom thead th { background-color: var(--warna-soft); color: var(--warna-paling-gelap); font-weight: 600; font-size: 0.85rem; border-bottom: 2px solid var(--warna-utama); text-transform: uppercase; }
        .table-custom tbody td { vertical-align: middle; border-bottom: 1px solid #f1f5f9; padding: 1rem 0.75rem; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <h5 class="fw-bold mb-4 px-2 py-2 border-bottom text-white" style="border-color: var(--warna-soft) !important;">
                <i class="bi bi-buildings-fill me-2"></i>MENU RT
            </h5>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('rt.dashboard') }}" class="nav-link">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pengajuan.create') }}" class="nav-link">
                        <i class="bi bi-file-earmark-plus-fill"></i> Pengajuan Baru
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('rt.warga.index') }}" class="nav-link active">
                        <i class="bi bi-people-fill"></i> Data Warga RT
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
                <h5 class="fw-bold"><i class="bi bi-people-fill me-2"></i>Data Warga RT</h5>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-danger"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">Daftar Warga RT {{ $rt }} / RW {{ $rw }}</h4>
                    <p class="text-muted mb-0">Total {{ $wargas->total() }} penduduk terdaftar di wilayah Anda.</p>
                </div>
                <a href="{{ route('rt.dashboard') }}" class="btn btn-outline-primary rounded-pill fw-bold shadow-sm px-4">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white" style="border: 1px solid var(--warna-soft) !important;">
                <div class="card-body p-3">
                    <form action="{{ route('rt.warga.index') }}" method="GET" class="row g-2 align-items-center">
                        <div class="col-md-9 col-lg-10">
                            <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control border-0 bg-light py-2" placeholder="Cari berdasarkan NIK atau Nama Lengkap..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-2 d-grid d-md-flex gap-2">
                            <button type="submit" class="btn btn-primary fw-bold shadow-sm w-100 rounded-3">CARI</button>
                            @if(request('search'))
                                <a href="{{ route('rt.warga.index') }}" class="btn btn-outline-danger fw-bold shadow-sm rounded-3" title="Reset Pencarian"><i class="bi bi-x-lg"></i></a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--warna-soft) !important;">
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
                                    <td class="fw-bold text-dark">{{ $item->nama_lengkap }}</td>
                                    <td>{{ $item->jenis_kelamin }}</td>
                                    <td>{{ $item->pekerjaan }}</td>
                                    <td>
                                        <span class="badge rounded-pill" style="background-color: var(--warna-soft); color: var(--warna-paling-gelap);">
                                            {{ $item->status_kawin }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-search fs-1 d-block mb-3" style="opacity: 0.2; color: var(--warna-paling-gelap);"></i>
                                        @if(request('search'))
                                            Data warga dengan kata kunci "<strong>{{ request('search') }}</strong>" tidak ditemukan.
                                        @else
                                            Belum ada data warga di wilayah RT Anda.<br>Pastikan admin desa telah mengimpor data kependudukan.
                                        @endif
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($wargas->hasPages())
                    <div class="card-footer bg-white py-3 border-top-0 rounded-bottom-4">
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