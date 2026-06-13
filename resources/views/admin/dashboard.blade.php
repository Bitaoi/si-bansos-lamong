<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasi Kesejahteraan</title>
    
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

        body { 
            background-color: var(--warna-background) !important; 
            color: var(--warna-paling-gelap);
            font-family: 'Poppins', sans-serif !important; 
        }
        
        .text-primary { color: var(--warna-utama) !important; }
        .bg-primary { background-color: var(--warna-utama) !important; color: #ffffff !important; }
        .border-primary { border-color: var(--warna-utama) !important; }

        .btn-primary { background-color: var(--warna-utama) !important; border-color: var(--warna-utama) !important; color: #ffffff !important; box-shadow: 0 4px 6px rgba(125, 136, 220, 0.2); }
        .btn-primary:hover { background-color: var(--warna-paling-gelap) !important; border-color: var(--warna-paling-gelap) !important; color: #ffffff !important; }

        .sidebar { min-height: 100vh; background: var(--warna-paling-gelap); color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: var(--warna-utama); color: white; }
        .nav-link i { width: 24px; display: inline-block; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: var(--warna-soft); font-weight: 700; padding: 10px 20px; letter-spacing: 0.5px; opacity: 0.8; }
        
        .stat-card { border: 1px solid var(--warna-soft); border-radius: 12px; transition: transform 0.2s; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(125, 136, 220, 0.15); }
        .icon-circle { width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        
        .table-custom thead th { background-color: var(--warna-soft); color: var(--warna-paling-gelap); font-weight: 600; font-size: 0.85rem; border-bottom: 2px solid var(--warna-utama); text-transform: uppercase; }
        .table-custom tbody td { vertical-align: middle; border-bottom: 1px solid #f1f5f9; padding: 1rem 0.75rem; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <h5 class="fw-bold mb-4 px-2 py-2 border-bottom border-secondary text-white">
                <i class=""></i>KASI KESEJAHTERAAN
            </h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link active"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('admin.rt.index') }}" class="nav-link"><i class="bi bi-person-badge-fill"></i> Akun RT</a></li>
                
                <div class="sidebar-heading mt-3">Master Data</div>
                <li class="nav-item"><a href="{{ route('warga.index') }}" class="nav-link"><i class="bi bi-people-fill"></i> Data Warga</a></li>
                <li class="nav-item"><a href="{{ route('jenis-bansos.index') }}" class="nav-link"><i class="bi bi-gift-fill"></i> Jenis Bansos</a></li>
                
                <div class="sidebar-heading mt-3">Pengaturan Sistem</div>
                <li class="nav-item"><a href="{{ route('admin.galeri.index') }}" class="nav-link"><i class="bi bi-images"></i> Galeri Desa</a></li>
                <li class="nav-item"><a href="{{ route('admin.konfigurasi') }}" class="nav-link"><i class="bi bi-sliders"></i> Pusat Konfigurasi</a></li>
                
                <div class="sidebar-heading mt-3">Transaksi</div>
                <li class="nav-item"><a href="{{ route('verifikasi.index') }}" class="nav-link"><i class="bi bi-file-earmark-check-fill"></i> Verifikasi</a></li>
                <li class="nav-item"><a href="{{ route('penyaluran.index') }}" class="nav-link"><i class="bi bi-truck"></i> Penyaluran</a></li>
                
                <li class="nav-item mt-5">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link text-white w-100 text-start border-0 bg-danger rounded-3 shadow-sm">
                            <i class="bi bi-box-arrow-right"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10 p-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 bg-white p-3 rounded-4 border shadow-sm" style="position: relative; z-index: 50;">
                <div class="mb-3 mb-lg-0">
                    <h3 class="fw-bold mb-1 fs-5">Pusat Informasi & Rekapitulasi</h3>
                    <p class="text-muted mb-0 small">Laporan ringkasan rekapitulasi usulan bansos desa terintegrasi.</p>
                </div>
                
                <form action="{{ route('admin.dashboard') }}" method="GET" class="d-flex gap-2 align-items-center flex-wrap">
                    <select name="bulan" class="form-select form-select-sm fw-bold border-secondary text-primary" style="width: auto; cursor: pointer;">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ sprintf('%02d', $m) }}" {{ ($bulanFilter ?? date('m')) == sprintf('%02d', $m) ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                    
                    <select name="tahun" class="form-select form-select-sm fw-bold border-secondary text-primary" style="width: auto; cursor: pointer;">
                        <option value="{{ date('Y') }}" {{ ($tahunFilter ?? date('Y')) == date('Y') ? 'selected' : '' }}>{{ date('Y') }}</option>
                        @if(isset($daftarTahun))
                            @foreach($daftarTahun as $thn)
                                @if($thn != date('Y'))
                                    <option value="{{ $thn }}" {{ ($tahunFilter ?? date('Y')) == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>

                    <button type="submit" class="btn btn-primary btn-sm fw-bold shadow-sm px-3">
                        <i class="bi bi-search me-1"></i> Terapkan
                    </button>

                    <div class="d-none d-md-block border-end mx-1" style="height: 30px;"></div>

                    <button type="submit" formaction="{{ route('admin.rekap.export') }}" class="btn btn-success btn-sm fw-bold shadow-sm text-nowrap">
                        <i class="bi bi-file-earmark-excel-fill me-1"></i> Excel
                    </button>
                    <button type="submit" formaction="{{ route('admin.rekap.export.pdf') }}" class="btn btn-danger btn-sm fw-bold shadow-sm text-nowrap">
                        <i class="bi bi-file-earmark-pdf-fill me-1"></i> PDF
                    </button>
                </form>
            </div>

            @php
                // Ambil data periode aktif untuk Admin
                $periode = \App\Models\PeriodeBansos::where('status', 'Aktif')->first();
            @endphp
            <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, var(--warna-utama), var(--warna-paling-gelap)); color: white;">
                <div class="card-body p-4 position-relative overflow-hidden d-flex justify-content-between align-items-center flex-wrap">
                    <i class="bi bi-calendar2-check position-absolute" style="font-size: 8rem; right: 20px; top: -20px; opacity: 0.1;"></i>
                    <div>
                        <h5 class="fw-bold mb-2 text-white-50"><i class="bi bi-calendar-event me-2"></i> Status Periode Bansos Aktif</h5>
                        @if($periode)
                            <h3 class="fw-bold text-white mb-1">{{ $periode->nama_periode }}</h3>
                            <p class="mb-0 text-white-50">
                                Berlaku: {{ \Carbon\Carbon::parse($periode->tanggal_mulai)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($periode->tanggal_akhir)->translatedFormat('d F Y') }}
                            </p>
                        @else
                            <h4 class="fw-bold text-white mb-0">Belum Ada Periode Aktif</h4>
                            <p class="mb-0 text-white-50">Silakan atur periode pendataan baru di menu pengaturan.</p>
                        @endif
                    </div>
                    @if($periode)
                    <div class="mt-3 mt-md-0 position-relative z-1">
                        <span class="badge bg-success bg-opacity-25 border border-success text-white px-3 py-2 rounded-pill fs-6 shadow-sm">
                            <i class="bi bi-broadcast me-1"></i> Sedang Berlangsung
                        </span>
                    </div>
                    @endif
                </div>
            </div>
            <div class="row g-4 mb-4">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-primary bg-opacity-10 text-primary me-3"><i class="bi bi-people-fill"></i></div>
                                <div>
                                    <h6 class="text-muted small mb-1 text-uppercase fw-bold">Total Warga</h6>
                                    <h3 class="fw-bold mb-0 text-dark">{{ $totalWarga ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-success bg-opacity-10 text-success me-3"><i class="bi bi-file-earmark-text-fill"></i></div>
                                <div>
                                    <h6 class="text-muted small mb-1 text-uppercase fw-bold">Pengajuan (Bulan Ini)</h6>
                                    <h3 class="fw-bold mb-0 text-dark">{{ $totalPengajuan ?? 0 }}</h3>
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
                                    <h6 class="text-muted small mb-1 text-uppercase fw-bold">Menunggu Verifikasi</h6>
                                    <h3 class="fw-bold mb-0 text-dark">{{ $menungguVerifikasi ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card stat-card shadow-sm h-100" style="border-left: 4px solid #0dcaf0 !important;">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-circle bg-info bg-opacity-10 text-info me-3"><i class="bi bi-pie-chart-fill"></i></div>
                                <div>
                                    <h6 class="text-muted small mb-1 text-uppercase fw-bold">Sisa Kuota Global</h6>
                                    <h3 class="fw-bold mb-0 text-dark">{{ $sisaKuota ?? 0 }}</h3>
                                </div>
                            </div>
                            <a href="{{ route('admin.kuota.index') }}" class="btn btn-sm btn-info text-white w-100 fw-bold shadow-sm mt-1">
                                <i class="bi bi-eye-fill me-1"></i> Lihat Rincian Kuota
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($rekapBansos))
            <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--warna-soft) !important;">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-table me-2"></i>Rekapitulasi Bantuan (Seluruh RT)</h6>
                    <span class="badge bg-light text-secondary border">Periode: {{ \Carbon\Carbon::create()->month((int)($bulanFilter ?? date('m')))->translatedFormat('F') }} {{ $tahunFilter ?? date('Y') }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Program Bansos</th>
                                    <th class="text-center">Total Usulan</th>
                                    <th class="text-center">Disetujui (Layak)</th>
                                    <th class="text-center">Ditolak</th>
                                    <th class="text-center">Sedang Diproses</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekapBansos as $rekap)
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold text-dark">{{ $rekap->nama_bansos }}</span><br>
                                        <small class="badge bg-light text-secondary border">{{ $rekap->kode_bansos }}</small>
                                    </td>
                                    <td class="text-center fw-bold text-dark">{{ $rekap->total_diajukan }}</td>
                                    <td class="text-center fw-bold text-success">{{ $rekap->disetujui }}</td>
                                    <td class="text-center fw-bold text-danger">{{ $rekap->ditolak }}</td>
                                    <td class="text-center fw-bold text-warning">{{ $rekap->diproses }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data rekap di bulan ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--warna-soft) !important;">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-clock-history me-2"></i>Status Pengajuan Terkini</h6>
                    <span class="badge bg-light text-primary border"><i class="bi bi-funnel-fill"></i> Filter Aktif: {{ \Carbon\Carbon::create()->month((int)($bulanFilter ?? date('m')))->translatedFormat('F') }} {{ $tahunFilter ?? date('Y') }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Tanggal</th>
                                    <th>Nama Warga</th>
                                    <th>Bansos</th>
                                    <th>Pengusul</th>
                                    <th class="text-end pe-4">Status Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuanTerbaru ?? [] as $item)
                                <tr>
                                    <td class="ps-4 small text-muted">{{ $item->tgl_pengajuan->format('d M Y') }}</td>
                                    <td class="fw-bold text-dark">{{ $item->warga->nama_lengkap ?? 'Data Terhapus' }}</td>
                                    <td><span class="badge" style="background-color: var(--warna-soft); color: var(--warna-paling-gelap);">{{ $item->jenisBansos->nama_bansos ?? '-' }}</span></td>
                                    <td class="small text-muted">RT {{ $item->pengusul->wilayah_rt_rw ?? '-' }}</td>
                                    <td class="text-end pe-4">
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
                                <tr><td colspan="5" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-4 d-block mb-2"></i> Belum ada pengajuan di bulan ini.</td></tr>
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