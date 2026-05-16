<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SI Bansos Lamong</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --warna-paling-gelap: #2C3E50; --warna-utama: #7D88DC; --warna-soft: #BBD0EC; --warna-background: #FEFCFB; }
        body { background-color: var(--warna-background) !important; font-family: 'Poppins', sans-serif !important; color: var(--warna-paling-gelap); }
        .sidebar { min-height: 100vh; background: var(--warna-paling-gelap); color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: var(--warna-utama); color: white; }
        .card { border: 1px solid var(--warna-soft) !important; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); }
        .table-custom thead th { background-color: var(--warna-soft); color: var(--warna-paling-gelap); font-weight: 700; font-size: 0.8rem; text-transform: uppercase; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: var(--warna-soft); font-weight: 700; padding: 10px 20px; letter-spacing: 0.5px; opacity: 0.8; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <h5 class="fw-bold mb-4 px-2 py-2 border-bottom text-white"><i class="bi bi-shield-lock-fill me-2"></i>ADMIN PANEL</h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link active"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('admin.rt.index') }}" class="nav-link"><i class="bi bi-person-badge-fill"></i> Akun RT</a></li>
                <div class="sidebar-heading mt-3">Master Data</div>
                <li class="nav-item"><a href="{{ route('warga.index') }}" class="nav-link"><i class="bi bi-people-fill"></i> Data Warga</a></li>
                <li class="nav-item"><a href="{{ route('jenis-bansos.index') }}" class="nav-link"><i class="bi bi-gift-fill"></i> Jenis Bansos</a></li>
                <li class="nav-item"><a href="{{ route('admin.jadwal.index') }}" class="nav-link"><i class="bi bi-calendar-event"></i> Jadwal Tahapan</a></li>
                <div class="sidebar-heading mt-3">Transaksi</div>
                <li class="nav-item"><a href="{{ route('verifikasi.index') }}" class="nav-link"><i class="bi bi-file-earmark-check-fill"></i> Verifikasi</a></li>
                <li class="nav-item"><a href="{{ route('penyaluran.index') }}" class="nav-link"><i class="bi bi-truck"></i> Penyaluran</a></li>
                <li class="nav-item mt-5">
                    <form action="{{ route('logout') }}" method="POST">@csrf
                        <button type="submit" class="nav-link text-white w-100 text-start border-0 bg-danger rounded-3"><i class="bi bi-box-arrow-right"></i> Keluar</button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
            
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 bg-white p-3 rounded-4 border shadow-sm">
                <div>
                    <h3 class="fw-bold mb-1">Pusat Informasi & Rekapitulasi</h3>
                    <p class="text-muted mb-0 small">Laporan ringkasan rekapitulasi data usulan bansos desa terintegrasi.</p>
                </div>
                
                <form action="{{ route('admin.dashboard') }}" method="GET" class="d-flex gap-2 mt-2 mt-md-0">
                    <select name="bulan" class="form-select form-select-sm fw-bold border-secondary text-primary" onchange="this.form.submit()">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ sprintf('%02d', $m) }}" {{ $bulanFilter == sprintf('%02d', $m) ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                    <select name="tahun" class="form-select form-select-sm fw-bold border-secondary text-primary" onchange="this.form.submit()">
                        <option value="{{ date('Y') }}" {{ $tahunFilter == date('Y') ? 'selected' : '' }}>{{ date('Y') }}</option>
                        @foreach($daftarTahun as $thn)
                            @if($thn != date('Y'))
                                <option value="{{ $thn }}" {{ $tahunFilter == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                            @endif
                        @endforeach
                    </select>
                    <button type="submit" formaction="{{ route('admin.rekap.export') }}" class="btn btn-success btn-sm fw-bold shadow-sm text-nowrap">
                        <i class="bi bi-file-earmark-excel-fill me-1"></i> Unduh Excel
                    </button>
                    <button type="submit" formaction="{{ route('admin.rekap.export.pdf') }}" class="btn btn-danger btn-sm fw-bold shadow-sm text-nowrap ms-1">
                        <i class="bi bi-file-earmark-pdf-fill me-1"></i> Unduh PDF
                    </button>
                </form>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card p-3 bg-white text-center">
                        <h6 class="text-muted fw-bold small text-uppercase">Total Master Warga</h6>
                        <h2 class="fw-bold text-dark mb-0">{{ number_format($totalWarga) }} <span class="fs-6 text-muted">Jiwa</span></h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 bg-white text-center">
                        <h6 class="text-muted fw-bold small text-uppercase">Usulan Masuk Periode Ini</h6>
                        <h2 class="fw-bold text-primary mb-0">{{ $totalPengajuanMasaIni ?? 0 }} <span class="fs-6 text-muted">Berkas</span></h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 bg-white text-center">
                        <h6 class="text-muted fw-bold small text-uppercase">Disetujui (Layak)</h6>
                        <h2 class="fw-bold text-success mb-0">{{ $penerimaLayak ?? 0 }} <span class="fs-6 text-muted">Warga</span></h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 bg-white text-center">
                        <h6 class="text-muted fw-bold small text-uppercase">Antrean Verifikasi</h6>
                        <h2 class="fw-bold text-warning mb-0">{{ $menungguVerifikasi ?? 0 }} <span class="fs-6 text-muted">Berkas</span></h2>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-collection-fill me-2"></i>Rekapitulasi Total Ajuan Bansos Desa Terdaftar</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th class="ps-4">Nama Program Bantuan</th>
                                    <th class="text-center">Total Diajukan</th>
                                    <th class="text-center">Disetujui (Layak)</th>
                                    <th class="text-center">Ditolak (Tidak Layak)</th>
                                    <th class="text-center">Belum Selesai (Proses)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rekapBansos as $rekap)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="fw-bold text-dark">{{ $rekap->nama_bansos }}</div>
                                        <small class="badge bg-light text-primary border">{{ $rekap->kode_bansos }}</small>
                                    </td>
                                    <td class="text-center fw-bold fs-5 text-dark">{{ $rekap->total_diajukan }}</td>
                                    <td class="text-center fw-bold fs-5 text-success">{{ $rekap->disetujui }}</td>
                                    <td class="text-center fw-bold fs-5 text-danger">{{ $rekap->ditolak }}</td>
                                    <td class="text-center fw-bold fs-5 text-warning">{{ $rekap->diproses }}</td>
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

</body>
</html>