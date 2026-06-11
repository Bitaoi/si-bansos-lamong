<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard RT - SI Bansos Lamong</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --warna-paling-gelap: #2C3E50; 
            --warna-utama: #7D88DC; 
            --warna-soft: #e5ebf4; 
            --warna-background: #F8FAFC; 
        }

        body { 
            background-color: var(--warna-background) !important; 
            color: var(--warna-paling-gelap);
            font-family: 'Poppins', sans-serif !important; 
        }
        
        .text-primary { color: var(--warna-utama) !important; }
        .bg-primary { background-color: var(--warna-utama) !important; color: #ffffff !important; }
        .border-primary { border-color: var(--warna-utama) !important; }

        .btn-primary { background-color: var(--warna-utama) !important; border-color: var(--warna-utama) !important; color: #ffffff !important; box-shadow: 0 4px 6px rgba(125, 136, 220, 0.2); transition: all 0.2s;}
        .btn-primary:hover { background-color: var(--warna-paling-gelap) !important; border-color: var(--warna-paling-gelap) !important; transform: translateY(-2px); }

        .btn-outline-primary { color: var(--warna-utama) !important; border-color: var(--warna-utama) !important; background-color: transparent !important; }
        .btn-outline-primary:hover { background-color: var(--warna-utama) !important; color: #ffffff !important; }

        .sidebar { min-height: 100vh; background: var(--warna-paling-gelap); color: white; }
        .nav-link { color: rgba(255,255,255,0.7); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: var(--warna-utama); color: white; }
        .nav-link i { width: 24px; display: inline-block; }
        
        .stat-card { border: 1px solid rgba(0,0,0,0.05); border-radius: 16px; transition: transform 0.2s; background: white; box-shadow: 0 4px 10px rgba(0,0,0,0.02); }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(125, 136, 220, 0.1); }
        .icon-circle { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        
        .table-custom thead th { background-color: var(--warna-soft); color: var(--warna-paling-gelap); font-weight: 600; font-size: 0.85rem; border-bottom: 2px solid var(--warna-utama); text-transform: uppercase; letter-spacing: 0.5px;}
        .table-custom tbody td { vertical-align: middle; border-bottom: 1px solid #f1f5f9; padding: 1rem 0.75rem; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block shadow-sm">
            <h5 class="fw-bold mb-4 px-2 py-3 border-bottom text-white" style="border-color: rgba(255,255,255,0.1) !important;">
                <i class="bi bi-buildings-fill me-2 text-primary"></i>MENU RT
            </h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="{{ route('rt.dashboard') }}" class="nav-link active"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('pengajuan.create') }}" class="nav-link"><i class="bi bi-file-earmark-plus-fill"></i> Pengajuan Baru</a></li>
                <li class="nav-item"><a href="{{ route('rt.warga.index') }}" class="nav-link"><i class="bi bi-people-fill"></i> Data Warga RT</a></li>
                <li class="nav-item mt-5">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link text-white w-100 text-start border-0 shadow-sm" style="background-color: rgba(220, 53, 69, 0.8); border-radius: 8px;">
                            <i class="bi bi-box-arrow-right"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10 p-4 pb-5">
            
            <div class="d-md-none d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-4 shadow-sm">
                <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-grid-1x2-fill me-2"></i>Dashboard RT</h5>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-danger rounded-3"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                    <div class="d-flex align-items-center"><i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i><div><strong>Gagal!</strong> Periksa kembali isian form Anda.</div></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                    <div class="d-flex align-items-center"><i class="bi bi-shield-x fs-4 me-3"></i><div><strong>Gagal!</strong> {{ session('error') }}</div></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                    <div class="d-flex align-items-center"><i class="bi bi-check-circle-fill fs-4 me-3"></i><div><strong>Berhasil!</strong> {{ session('success') }}</div></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm bg-white mb-4 rounded-4 overflow-hidden position-relative" style="border-left: 6px solid var(--warna-utama) !important;">
                <div class="position-absolute top-0 end-0 p-3 opacity-10 d-none d-md-block">
                    <i class="bi bi-building-fill-gear" style="font-size: 8rem;"></i>
                </div>
                <div class="card-body p-4 p-lg-5 position-relative z-1">
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <h2 class="fw-bold text-dark mb-2">Halo, Ketua {{ $user->wilayah_rt_rw ?? $user->username }}! 👋</h2>
                            <p class="mb-4 text-muted fs-6">Selamat datang di Panel Pengelola Bantuan Sosial Desa Lamong. Kelola data pengajuan dan pantau kuota wilayah Anda di sini.</p>
                            <button type="button" class="btn btn-primary btn-sm fw-bold rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEditProfil">
                                <i class="bi bi-person-fill-gear me-2"></i> Pengaturan Akun
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, var(--warna-paling-gelap), #1a252f); color: white;">
                        <div class="card-body p-4 position-relative overflow-hidden">
                            <i class="bi bi-calendar2-check-fill position-absolute" style="font-size: 7rem; right: -15px; bottom: -20px; opacity: 0.1;"></i>
                            <h6 class="text-uppercase fw-bold text-primary mb-3" style="letter-spacing: 1px;">Status Sistem</h6>
                            
                            @php 
                                $periodeAktifInfo = \App\Models\PeriodeBansos::where('status', 'Aktif')->first(); 
                            @endphp

                            @if($periodeAktifInfo)
                                <h3 class="fw-bold text-white mb-1">{{ $periodeAktifInfo->nama_periode }}</h3>
                                <div class="mt-3 bg-white bg-opacity-10 p-3 rounded-3 border border-white border-opacity-25">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="spinner-grow spinner-grow-sm text-success me-2" role="status"></div>
                                        <span class="fw-bold text-success">Sedang Berjalan</span>
                                    </div>
                                    <p class="mb-0 text-white-50 small">
                                        Silakan manfaatkan kuota wilayah Anda sebelum periode ditutup oleh admin.
                                    </p>
                                </div>
                            @else
                                <div class="d-flex align-items-center h-100 mt-2">
                                    <div class="bg-danger bg-opacity-25 border border-danger p-3 rounded-3 text-white">
                                        <i class="bi bi-exclamation-octagon-fill me-2"></i> <strong>Sistem Ditutup.</strong> Saat ini belum ada periode bansos yang aktif.
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center rounded-top-4">
                            <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-pie-chart-fill text-primary me-2"></i>Sisa Kuota RT {{ $user->wilayah_rt_rw ?? '-' }}</h6>
                            <span class="badge bg-light text-secondary border">Periode: {{ $periodeTerpilih->nama_periode ?? 'Belum Dipilih' }}</span>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush rounded-bottom-4">
                                @if(isset($kuotaRTSaya) && $kuotaRTSaya->count() > 0)
                                    @foreach($kuotaRTSaya as $k)
                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3 hover-bg-light">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-circle bg-primary bg-opacity-10 text-primary me-3" style="width: 40px; height: 40px; font-size: 1rem;">
                                                    <i class="bi bi-box2-heart-fill"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $k->jenisBansos->nama_bansos ?? '-' }}</div>
                                                    <small class="text-muted">Total Kuota RT: {{ $k->kuota }}</small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                @if($k->sisa_kuota > 0)
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-2">
                                                        Tersisa {{ $k->sisa_kuota }} Kuota
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger rounded-pill px-3 py-2">
                                                        Kuota Habis
                                                    </span>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="list-group-item text-muted p-5 text-center d-flex flex-column align-items-center">
                                        <i class="bi bi-inbox fs-1 mb-2 opacity-50"></i>
                                        <span>Tidak ada alokasi kuota khusus untuk RT Anda pada periode ini.</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 bg-white p-3 rounded-4 border shadow-sm" style="border-color: var(--warna-soft) !important;">
                <div class="mb-3 mb-lg-0">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-funnel-fill me-2 text-primary"></i>Filter Laporan Dashboard</h6>
                </div>
                
                <form action="{{ route('rt.dashboard') }}" method="GET" class="d-flex gap-2 align-items-center flex-wrap">
                    <select name="id_periode" class="form-select form-select-sm fw-bold border-secondary text-primary shadow-sm" style="width: auto; cursor: pointer; border-radius: 8px;">
                        @foreach($dataPeriodes ?? [] as $periode)
                            <option value="{{ $periode->id }}" {{ ($periodeTerpilih && $periodeTerpilih->id == $periode->id) ? 'selected' : '' }}>
                                {{ $periode->nama_periode }} {{ $periode->status == 'Aktif' ? '(Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary btn-sm fw-bold shadow-sm px-3 rounded-3">
                        <i class="bi bi-search me-1"></i> Terapkan
                    </button>

                    <div class="d-none d-md-block border-end mx-2" style="height: 30px;"></div>

                    <button type="submit" formaction="{{ route('rt.rekap.export') }}" class="btn btn-success btn-sm fw-bold shadow-sm text-nowrap rounded-3">
                        <i class="bi bi-file-earmark-excel-fill me-1"></i> Export Excel
                    </button>
                    <button type="submit" formaction="{{ route('rt.rekap.export.pdf') }}" class="btn btn-danger btn-sm fw-bold shadow-sm text-nowrap rounded-3">
                        <i class="bi bi-file-earmark-pdf-fill me-1"></i> Cetak PDF
                    </button>
                </form>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card stat-card h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle me-3 bg-secondary bg-opacity-10 text-secondary"><i class="bi bi-people-fill"></i></div>
                                <div>
                                    <h6 class="text-muted small mb-1 fw-bold">Total Warga RT</h6>
                                    <h3 class="fw-bold mb-0 text-dark">{{ $wargaSaya ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card stat-card h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle me-3 bg-primary bg-opacity-10 text-primary"><i class="bi bi-send-fill"></i></div>
                                <div>
                                    <h6 class="text-muted small mb-1 fw-bold">Usulan (Periode Ini)</h6>
                                    <h3 class="fw-bold mb-0 text-dark">{{ $totalUsulanSaya ?? 0 }}</h3> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card stat-card h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-warning bg-opacity-10 text-warning me-3"><i class="bi bi-hourglass-split"></i></div>
                                <div>
                                    <h6 class="text-muted small mb-1 fw-bold">Proses Validasi</h6>
                                    <h3 class="fw-bold mb-0 text-dark">{{ $menungguVerifikasi ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card stat-card h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle bg-success bg-opacity-10 text-success me-3"><i class="bi bi-check-circle-fill"></i></div>
                                <div>
                                    <h6 class="text-muted small mb-1 fw-bold">Disetujui</h6>
                                    <h3 class="fw-bold mb-0 text-dark">{{ $siapDisalurkan ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($rekapBansosRT))
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center rounded-top-4">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-clipboard-data-fill me-2 text-primary"></i>Rekapitulasi Usulan Bantuan</h6>
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3">{{ $periodeTerpilih->nama_periode ?? '' }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Program Bansos</th>
                                    <th class="text-center">Total Usulan</th>
                                    <th class="text-center">Disetujui</th>
                                    <th class="text-center">Ditolak</th>
                                    <th class="text-center">Proses Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekapBansosRT as $rekap)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded p-2 me-3"><i class="bi bi-box2-heart text-primary fs-5"></i></div>
                                            <div>
                                                <span class="fw-bold text-dark d-block">{{ $rekap->nama_bansos }}</span>
                                                <small class="text-muted">{{ $rekap->kode_bansos }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center fw-bold text-dark fs-5">{{ $rekap->total }}</td>
                                    <td class="text-center fw-bold text-success fs-5">{{ $rekap->layak }}</td>
                                    <td class="text-center fw-bold text-danger fs-5">{{ $rekap->tidak_layak }}</td>
                                    <td class="text-center fw-bold text-warning fs-5">{{ $rekap->proses }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-5 text-muted"><i class="bi bi-inbox fs-2 mb-2 d-block"></i>Belum ada data rekap pada periode ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 mb-5 bg-white">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center rounded-top-4">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-clock-history me-2 text-primary"></i>Status Pengajuan Terkini</h6>
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
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuanTerbaru ?? [] as $item)
                                <tr>
                                    <td class="ps-4 small fw-medium text-secondary">{{ $item->tgl_pengajuan->format('d M Y') }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $item->warga->nama_lengkap ?? 'Data Warga Terhapus' }}</div>
                                        <small class="text-muted">NIK: {{ $item->nik }}</small>
                                    </td>
                                    <td><span class="badge bg-light text-dark border">{{ $item->jenisBansos->nama_bansos ?? '-' }}</span></td>
                                    <td>
                                        @if(in_array($item->status_verifikasi_admin, ['Proses', 'Verifikasi Lapangan', 'Menunggu Musdes', 'Siap Keputusan']))
                                            <span class="badge bg-warning text-dark px-2 py-1"><i class="bi bi-hourglass-split me-1"></i> {{ $item->status_verifikasi_admin }}</span>
                                        @elseif($item->status_verifikasi_admin == 'Layak')
                                            <span class="badge bg-success px-2 py-1"><i class="bi bi-check-circle-fill me-1"></i> Disetujui</span>
                                        @else
                                            <span class="badge bg-danger px-2 py-1"><i class="bi bi-x-circle-fill me-1"></i> Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        @if($item->status_verifikasi_admin == 'Proses')
                                            <form action="{{ route('pengajuan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan atas nama {{ $item->warga->nama_lengkap ?? 'warga ini' }}? Kuota RT akan otomatis dikembalikan.');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill fw-bold px-3"><i class="bi bi-trash3-fill me-1"></i> Tarik/Batal</button>
                                            </form>
                                        @else
                                            <span class="text-muted small"><i class="bi bi-lock-fill text-secondary"></i> Validasi</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-5 text-muted"><i class="bi bi-inbox fs-2 mb-2 d-block"></i>Belum ada pengajuan di periode ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @php
                $jadwalUsulan = \App\Models\JadwalBansos::where('nama_tahapan', 'LIKE', '%Usulan%')->first();
                $hariIni = (int) date('d');
                $isBuka = false;
                if ($jadwalUsulan && $hariIni >= $jadwalUsulan->hari_mulai && $hariIni <= $jadwalUsulan->hari_selesai && $periodeAktifInfo) {
                    $isBuka = true;
                }
            @endphp

            <div class="card border-0 shadow-sm rounded-4 mb-5 bg-white">
                <div class="card-header bg-white py-3 border-bottom rounded-top-4">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-lightning-charge-fill me-2 text-primary"></i>Aksi Cepat Menu Utama</h6>
                </div>
                
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            @if($isBuka)
                                <a href="{{ route('pengajuan.create') }}" class="btn btn-primary w-100 py-3 fw-bold text-start ps-4 h-100 d-flex align-items-center shadow-sm rounded-4">
                                    <div class="bg-white bg-opacity-25 rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width:50px; height:50px;">
                                        <i class="bi bi-plus-lg fs-4 text-white"></i> 
                                    </div>
                                    <div>
                                        <div class="fs-5 text-white">Buat Pengajuan Bansos</div>
                                        <small class="fw-normal text-white-50">Batas waktu: Tgl {{ $jadwalUsulan->hari_mulai ?? 1 }} - {{ $jadwalUsulan->hari_selesai ?? 8 }} Bulan Ini</small>
                                    </div>
                                </a>
                            @else
                                <div class="w-100 py-3 px-4 h-100 d-flex align-items-center bg-light border rounded-4" style="cursor: not-allowed;">
                                    <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width:50px; height:50px;">
                                        <i class="bi bi-door-closed-fill fs-4 text-secondary"></i> 
                                    </div>
                                    <div>
                                        <div class="fw-bold text-secondary fs-5">Pengajuan Ditutup</div>
                                        <small class="fw-normal text-muted">Di luar jadwal usulan atau tidak ada periode aktif.</small>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('rt.warga.index') }}" class="btn btn-outline-dark w-100 py-3 fw-bold text-start ps-4 h-100 d-flex align-items-center rounded-4">
                                <div class="bg-dark bg-opacity-10 rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width:50px; height:50px;">
                                    <i class="bi bi-search fs-4 text-dark"></i> 
                                </div>
                                <div>
                                    <div class="fs-5">Cari & Kelola Warga</div>
                                    <small class="fw-normal text-muted">Lihat dan tambah daftar warga di wilayah Anda.</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalEditProfil" tabindex="-1" aria-labelledby="modalEditProfilLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 text-dark">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="fw-bold" id="modalEditProfilLabel"><i class="bi bi-person-gear me-2 text-primary"></i>Pengaturan Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('rt.profil.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username Login</label>
                        <input type="text" name="username" class="form-control form-control-lg bg-light" value="{{ Auth::user()->username }}" required>
                    </div>
                    
                    <hr class="my-4 opacity-25">
                    
                    <div class="alert alert-warning border-0 p-3 small mb-3 rounded-3 bg-warning bg-opacity-10 text-dark">
                        <i class="bi bi-info-circle-fill text-warning me-2"></i> Isi bagian di bawah ini <b>hanya</b> jika Anda ingin mengganti kata sandi. Kosongkan jika tidak ada perubahan.
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan sandi baru (min. 5 karakter)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ketik ulang sandi baru">
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 pb-4 pe-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>