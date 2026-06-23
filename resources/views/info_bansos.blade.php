<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Bantuan Sosial - Desa Lamong</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Poppins', sans-serif; }
        .hero-section { background: linear-gradient(135deg, #7D88DC, #2C3E50); color: white; padding: 80px 0; border-radius: 0 0 50px 50px; }
        .card { border: none; border-radius: 20px; box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .badge-periode { background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); }
        .form-select-lg { border-radius: 15px; border: 2px solid #e2e8f0; }
        .form-select-lg:focus { border-color: #7D88DC; box-shadow: 0 0 0 4px rgba(125,136,220,0.15); }
        .btn-cari { background-color: #7D88DC; border: none; border-radius: 15px; transition: 0.3s; }
        .btn-cari:hover { background-color: #2C3E50; transform: translateY(-2px); }
    </style>
</head>
<body>

<nav class="navbar navbar-light bg-transparent position-absolute w-100 mt-3" style="z-index: 10;">
    <div class="container">
        <a href="{{ url('/') }}" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Beranda
        </a>
    </div>
</nav>

<div class="hero-section text-center position-relative">
    <div class="container">
        <h1 class="fw-bold display-5">Informasi Bantuan Sosial</h1>
        <p class="lead opacity-75 mb-0">Cek jadwal tahapan dan ketersediaan kuota bantuan Desa Lamong.</p>
        
        @if($periode)
            <div class="badge-periode d-inline-block px-4 py-2 rounded-pill mt-4 shadow-sm">
                <i class="bi bi-calendar2-check-fill me-2 text-warning"></i> Periode Aktif: <strong>{{ $periode->nama_periode }}</strong>
            </div>
        @endif
    </div>
</div>

<div class="container" style="margin-top: -30px; position: relative; z-index: 5;">
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="card p-4 p-md-5 bg-white shadow">
                <h5 class="fw-bold mb-3 text-dark text-center"><i class="bi bi-search text-primary me-2"></i>Cek Ketersediaan Bantuan Terperinci</h5>
                <form action="{{ route('info.bansos') }}" method="GET" class="d-flex flex-column flex-md-row gap-3">
                    <select name="jenis_bantuan" class="form-select form-select-lg fw-medium" required>
                        <option value="">-- Pilih Jenis Program Bansos --</option>
                        @foreach($semuaBansos as $b)
                            <option value="{{ $b->id }}" {{ (isset($bansosTerpilih) && $bansosTerpilih->id == $b->id) ? 'selected' : '' }}>
                                {{ $b->kode_bansos }} - {{ $b->nama_bansos }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-cari btn-primary btn-lg px-5 fw-bold text-white shadow-sm">CEK</button>
                </form>
            </div>
        </div>
    </div>

    @if(isset($bansosTerpilih))
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="alert {{ $statusKetersediaan == 'Tersedia' ? 'alert-success border-success' : 'alert-danger border-danger' }} bg-white border-2 shadow-sm rounded-4 p-4 p-md-5">
                    <div class="d-flex flex-column">
                        <div class="d-flex flex-column flex-md-row align-items-center mb-4">
                            <i class="bi {{ $statusKetersediaan == 'Tersedia' ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' }} me-md-4 mb-3 mb-md-0" style="font-size: 4rem;"></i>
                            <div class="text-center text-md-start">
                                <h4 class="fw-bold mb-1 text-dark">{{ $bansosTerpilih->nama_bansos }}</h4>
                                <p class="mb-2 text-muted">Status pada Periode <strong>{{ $periode->nama_periode ?? 'Belum ada periode' }}</strong></p>
                                <span class="badge {{ $statusKetersediaan == 'Tersedia' ? 'bg-success' : 'bg-danger' }} px-4 py-2 fs-6 rounded-pill shadow-sm mb-2">
                                    {{ $statusKetersediaan }}
                                </span>
                            </div>
                        </div>
                        
                        @if($statusKetersediaan == 'Tersedia' || $statusKetersediaan == 'Kuota Penuh')
                            
                            @if($statusKetersediaan == 'Tersedia')
                                <p class="small text-dark mb-4 bg-success bg-opacity-10 p-3 rounded-3 border border-success border-opacity-25">
                                    <i class="bi bi-info-circle-fill text-success me-1"></i> Kuota untuk program ini <b>MASIH TERSEDIA</b> pada beberapa wilayah Rukun Tetangga (RT) di bawah ini. Silakan hubungi Ketua RT terkait.
                                </p>
                            @else
                                <p class="small text-danger mb-4 bg-danger bg-opacity-10 p-3 rounded-3 border border-danger border-opacity-25">
                                    <i class="bi bi-x-circle-fill text-danger me-1"></i> Mohon maaf, jatah kuota pengusulan program bantuan ini sudah <b>HABIS TERISI PENUH</b> di seluruh wilayah RT desa.
                                </p>
                            @endif

                            <div class="card border border-light-subtle shadow-sm rounded-3">
                                <div class="card-header bg-light fw-bold text-dark"><i class="bi bi-geo-alt-fill text-primary me-2"></i>Daftar Wilayah RT dan Ketersediaan Kuota</div>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0 text-center">
                                        <thead class="table-light text-secondary small">
                                            <tr>
                                                <th>Nomor Wilayah (RW/RT)</th>
                                                <th>Total Kuota</th>
                                                <th>Sudah Terpakai</th>
                                                <th>Sisa Jatah Alokasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($rincianKuotaRT as $k)
                                            <tr>
                                                <td class="fw-bold text-dark">RW {{ $k->rw }} / RT {{ $k->rt }}</td>
                                                <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 py-1 rounded-pill">{{ $k->kuota }} KPM</span></td>
                                                <td><span class="badge bg-secondary rounded-pill px-3 py-1">{{ $k->terpakai }}</span></td>
                                                <td>
                                                    @if(($k->kuota - $k->terpakai) > 0)
                                                        <span class="badge bg-success rounded-pill px-3 py-1">{{ $k->kuota - $k->terpakai }} KK / KPM</span>
                                                    @else
                                                        <span class="badge bg-danger rounded-pill px-3 py-1">Penuh / Habis</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr><td colspan="4" class="text-center py-3 text-muted">Data kuota wilayah belum didistribusikan oleh Pemerintah Desa.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <p class="small text-danger mb-0 bg-danger bg-opacity-10 p-3 rounded-3 border border-danger border-opacity-25">Program bantuan sosial ini belum dibuka jatah kuotanya oleh Pemerintah Desa pada periode berjalan.</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row g-4 mb-5">
        <div class="col-lg-7">
            <div class="card p-4 h-100">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-clock-history text-primary me-2"></i>Jadwal Tahapan Bansos</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr><th>Tahapan</th><th>Tanggal Pelaksanaan</th></tr>
                        </thead>
                        <tbody>
                            @forelse($jadwals as $j)
                            <tr>
                                <td class="fw-bold text-dark">{{ $j->nama_tahapan }}</td>
                                <td><span class="badge bg-light text-dark border"><i class="bi bi-calendar me-1"></i> Tgl {{ $j->hari_mulai }} s/d {{ $j->hari_selesai > 30 ? 'Akhir Bulan' : $j->hari_selesai }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="text-center text-muted py-4">Belum ada jadwal tahapan untuk periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card p-4 h-100" style="background: #2C3E50; color: white;">
                <h5 class="fw-bold mb-4"><i class="bi bi-clipboard-check text-info me-2"></i>Syarat Umum Penerima</h5>
                <ul class="list-unstyled mb-4">
                    <li class="mb-3 d-flex"><i class="bi bi-check-circle-fill text-info me-3"></i> <span>Tercatat sebagai Warga Domisili Desa Lamong.</span></li>
                    <li class="mb-3 d-flex"><i class="bi bi-check-circle-fill text-info me-3"></i> <span>Memiliki KTP & KK yang valid dan masih aktif.</span></li>
                    <li class="mb-3 d-flex"><i class="bi bi-check-circle-fill text-info me-3"></i> <span>Tergolong dalam kategori masyarakat tidak mampu berdasarkan Desil Ekonomi.</span></li>
                    <li class="mb-3 d-flex"><i class="bi bi-check-circle-fill text-info me-3"></i> <span>Lolos Verifikasi Lapangan dan disetujui dalam Musyawarah Desa (Musdes).</span></li>
                </ul>
                <div class="mt-auto p-3 bg-white bg-opacity-10 rounded-3 small border border-white border-opacity-25">
                    <i class="bi bi-exclamation-triangle-fill text-warning me-1"></i> <b>Catatan:</b> Setiap jenis bantuan mungkin memiliki syarat khusus tambahan yang ditentukan oleh pusat.
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="text-center py-4 text-muted bg-white border-top">
    <p class="mb-0">&copy; {{ date('Y') }} Sistem Informasi Bansos Desa Lamong.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>