<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rincian Kuota Bansos - Admin</title>
    
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
        .sidebar { min-height: 100vh; background: var(--warna-paling-gelap); color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: var(--warna-utama); color: white; }
        .nav-link i { width: 24px; display: inline-block; }
        
        .card { border: 1px solid var(--warna-soft) !important; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .table-custom thead th { background-color: var(--warna-soft); color: var(--warna-paling-gelap); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; border-bottom: 2px solid var(--warna-utama); }
        
        .progress { height: 10px; border-radius: 10px; }
        .badge-habis { background-color: #fee2e2; color: #ef4444; border: 1px solid #fecaca; }
        .badge-tersedia { background-color: #dcfce7; color: #22c55e; border: 1px solid #bbf7d0; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <h5 class="fw-bold mb-4 px-2 py-2 border-bottom text-white">ADMIN PANEL</h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('admin.kuota.index') }}" class="nav-link active"><i class="bi bi-bar-chart-fill"></i> Rincian Kuota</a></li>
                </ul>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Rincian Kuota Bantuan Sosial</h4>
                    <p class="text-muted mb-0">Detail alokasi kuota per program bantuan desa.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill fw-bold">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <div class="row g-4">
                @foreach($bansos as $item)
                @php
                    $terpakai = $item->pengajuan->where('status_verifikasi_admin', 'Layak')->count();
                    $sisa = $item->kuota - $terpakai;
                    $persen = $item->kuota > 0 ? ($terpakai / $item->kuota) * 100 : 0;
                    $isHabis = $sisa <= 0;
                @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 bg-white">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="fw-bold text-dark mb-0">{{ $item->nama_bansos }}</h5>
                                <span class="badge {{ $isHabis ? 'badge-habis' : 'badge-tersedia' }} rounded-pill px-3">
                                    {{ $isHabis ? 'Kuota Habis' : 'Tersedia' }}
                                </span>
                            </div>
                            
                            <div class="mb-4">
                                <small class="text-muted d-block mb-1">Kode Bansos: {{ $item->kode_bansos }}</small>
                                <h3 class="fw-bold {{ $isHabis ? 'text-danger' : 'text-primary' }} mb-0">
                                    {{ $sisa }} <small class="fs-6 text-muted fw-normal">Sisa Kuota</small>
                                </h3>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted">Progres Penyerapan:</span>
                                    <span class="fw-bold">{{ round($persen) }}%</span>
                                </div>
                                <div class="progress bg-light">
                                    <div class="progress-bar {{ $persen >= 90 ? 'bg-danger' : ($persen >= 70 ? 'bg-warning' : 'bg-success') }}" 
                                         role="progressbar" style="width: {{ $persen }}%"></div>
                                </div>
                            </div>

                            <div class="row text-center pt-3 border-top">
                                <div class="col-6 border-end">
                                    <div class="small text-muted">Total Kuota</div>
                                    <div class="fw-bold">{{ $item->kuota }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="small text-muted">Terpakai</div>
                                    <div class="fw-bold text-success">{{ $terpakai }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>