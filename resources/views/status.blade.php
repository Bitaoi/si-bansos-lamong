<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Bansos - Desa Lamong</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        /* PALET WARNA KUSTOM */
        :root {
            --warna-utama: #BBD0EC; 
            --warna-utama-gelap: #7D88DC; 
            --warna-aksen: #A4BEE3; 
            --warna-background: #FEFCFB; 
        }

        body { background-color: var(--warna-background) !important; font-family: sans-serif; }
        
        /* OVERRIDE BOOTSTRAP PRIMARY */
        .text-primary { color: var(--warna-utama-gelap) !important; }
        .bg-primary { background-color: var(--warna-utama-gelap) !important; }
        .border-primary { border-color: var(--warna-utama-gelap) !important; }
        
        .btn-primary { background-color: var(--warna-utama-gelap) !important; border-color: var(--warna-utama-gelap) !important; color: white !important; }
        .btn-primary:hover { background-color: var(--warna-utama) !important; border-color: var(--warna-utama) !important; color: #333 !important; }

        .navbar { background: #1e293b; }
        .card-search { margin-top: -50px; border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        
        /* STEPPER KUSTOM */
        .stepper { display: flex; justify-content: space-between; position: relative; margin: 40px 0; }
        .stepper::before { content: ''; position: absolute; top: 20px; left: 0; width: 100%; height: 4px; background: #e2e8f0; z-index: 1; }
        .step { position: relative; z-index: 2; text-align: center; flex: 1; }
        .step-icon { width: 45px; height: 45px; border-radius: 50%; background: #e2e8f0; color: #64748b; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: bold; border: 4px solid white; }
        
        .step.active .step-icon { background: var(--warna-utama-gelap); color: white; }
        .step.completed .step-icon { background: #198754; color: white; }
        .step.rejected .step-icon { background: #dc3545; color: white; }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark py-3">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="bi bi-shield-check me-2"></i>SI BANSOS LAMONG
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm rounded-pill">Kembali ke Beranda</a>
        </div>
    </nav>

    <div class="bg-primary py-5 text-white text-center">
        <div class="container pb-5">
            <h2 class="fw-bold">Lacak Pengajuan Anda</h2>
            <p class="opacity-75">Masukkan NIK untuk melihat sejauh mana proses pengajuan bantuan Anda.</p>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-search mb-5">
                    <div class="card-body p-4">
                        <form action="{{ route('status.index') }}" method="GET">
                            <div class="input-group">
                                <input type="number" name="nik" class="form-control form-control-lg border-0 bg-light" placeholder="Masukkan 16 Digit NIK..." value="{{ $nik }}" required>
                                <button class="btn btn-primary px-4 fw-bold" type="submit">
                                    <i class="bi bi-search me-2"></i> CARI DATA
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if($dicari)
                    @if($pengajuan)
                        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white text-center">
                            <h5 class="text-muted small text-uppercase fw-bold mb-4">Hasil Pelacakan</h5>
                            <h3 class="fw-bold text-dark mb-1">{{ $pengajuan->warga->nama_lengkap }}</h3>
                            <p class="text-primary fw-bold mb-4">{{ $pengajuan->jenisBansos->nama_bansos }}</p>

                            <div class="stepper d-none d-md-flex">
                                @php $s = $pengajuan->status_verifikasi_admin; @endphp
                                <div class="step completed">
                                    <div class="step-icon"><i class="bi bi-check"></i></div>
                                    <div class="step-label small fw-bold">Diusulkan</div>
                                </div>
                                <div class="step {{ in_array($s, ['Menunggu Musdes','Siap Keputusan','Layak','Tidak Layak']) ? 'completed' : ($s == 'Verifikasi Lapangan' ? 'active' : '') }}">
                                    <div class="step-icon"><i class="bi bi-house"></i></div>
                                    <div class="step-label small fw-bold">Survei</div>
                                </div>
                                <div class="step {{ in_array($s, ['Siap Keputusan','Layak','Tidak Layak']) ? 'completed' : ($s == 'Menunggu Musdes' ? 'active' : '') }}">
                                    <div class="step-icon"><i class="bi bi-people"></i></div>
                                    <div class="step-label small fw-bold">Musdes</div>
                                </div>
                                <div class="step {{ $s == 'Layak' ? 'completed' : ($s == 'Tidak Layak' ? 'rejected' : ($s == 'Siap Keputusan' ? 'active' : '')) }}">
                                    <div class="step-icon"><i class="bi bi-flag"></i></div>
                                    <div class="step-label small fw-bold">Keputusan</div>
                                </div>
                            </div>

                            <div class="alert {{ $s == 'Layak' ? 'alert-success' : ($s == 'Tidak Layak' ? 'alert-danger' : 'alert-info') }} border-0 rounded-4 mt-4">
                                <strong>Status: {{ $s }}</strong><br>
                                @if($s == 'Layak') Selamat! Pengajuan Anda disetujui.
                                @elseif($s == 'Tidak Layak') Maaf, pengajuan belum dapat disetujui. Alasan: {{ $pengajuan->keterangan_ditolak }}
                                @else Mohon tunggu, berkas Anda sedang dalam tahap pemeriksaan.
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-search text-muted display-1 opacity-25"></i>
                            <h5 class="mt-3 fw-bold text-muted">NIK Tidak Terdaftar</h5>
                            <p class="text-muted">Pastikan NIK yang Anda masukkan sudah benar atau hubungi Ketua RT setempat.</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

</body>
</html>