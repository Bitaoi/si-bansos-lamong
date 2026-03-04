<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenis Bansos - Admin SI Bansos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f3f4f6; font-family: sans-serif; }
        
        /* Sidebar & Nav */
        .sidebar { min-height: 100vh; background: #1e293b; color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; }
        .nav-link:hover, .nav-link.active { background: #0d6efd; color: white; }
        .nav-link i { width: 24px; display: inline-block; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; padding: 10px 20px; letter-spacing: 0.5px; }

        /* Table Styling */
        .table-custom thead th { background-color: #f8fafc; color: #64748b; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; border-bottom: 2px solid #e2e8f0; }
        .table-custom tbody td { vertical-align: middle; border-bottom: 1px solid #f1f5f9; padding: 1rem 0.75rem; font-size: 0.95rem; }
        
        /* Button & Card */
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .btn-action { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <h5 class="fw-bold mb-4 px-2 py-2 border-bottom border-secondary text-white">
                <i class="bi bi-shield-lock-fill me-2"></i>ADMIN PANEL
            </h5>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                </li>
                
                <div class="sidebar-heading mt-3">Master Data</div>
                <li class="nav-item">
                    <a href="{{ route('warga.index') }}" class="nav-link">
                        <i class="bi bi-people-fill"></i> Data Warga
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('jenis-bansos.index') }}" class="nav-link active">
                        <i class="bi bi-gift-fill"></i> Jenis Bansos
                    </a>
                </li>

                <div class="sidebar-heading mt-3">Transaksi</div>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-file-earmark-text-fill"></i> Verifikasi Pengajuan
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
                        <button type="submit" class="nav-link bg-danger text-white w-100 text-start border-0 shadow-sm">
                            <i class="bi bi-box-arrow-right"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
            
            <div class="d-md-none d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold"><i class="bi bi-gift-fill me-2"></i>Jenis Bansos</h5>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-danger"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Program Bantuan Sosial</h4>
                    <p class="text-muted mb-0">Atur jenis bantuan, kuota, dan nominal penyaluran.</p>
                </div>
                <a href="{{ route('jenis-bansos.create') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Program
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Nama Program</th>
                                    <th>Sumber Dana</th>
                                    <th>Nominal / Bentuk</th>
                                    <th>Kuota Penerima</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bansos as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $item->nama_bansos }}</div>
                                        <small class="text-muted text-uppercase" style="font-size: 0.75rem;">{{ $item->kode_bansos ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-primary border border-primary-subtle">
                                            {{ $item->sumber_dana }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $item->nominal }}</div>
                                        <small class="text-muted">{{ $item->bentuk_bantuan }}</small>
                                    </td>
                                    <td>
                                        @if($item->kuota_penerima > 0)
                                            {{ $item->kuota_penerima }} Orang
                                        @else
                                            <span class="text-success"><i class="bi bi-infinity"></i> Unlimited</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->status == 'Aktif')
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 rounded-pill">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 rounded-pill">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('jenis-bansos.edit', $item->id) }}" class="btn btn-action btn-warning text-white btn-sm" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('jenis-bansos.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus program bansos ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-action btn-danger btn-sm" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-box-seam fs-1 d-block mb-3 opacity-25"></i>
                                        Belum ada program bantuan yang dibuat.
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