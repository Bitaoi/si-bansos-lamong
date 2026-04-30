<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Bansos - Desa Lamong</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* PALET WARNA KUSTOM */
        :root {
            --warna-paling-gelap: #2C3E50; 
            --warna-utama: #7D88DC; 
            --warna-soft: #BBD0EC; 
            --warna-background: #FEFCFB; 
        }

        body { background-color: var(--warna-background) !important; font-family: 'Poppins', sans-serif !important; }

        .btn-primary { background-color: var(--warna-utama) !important; border-color: var(--warna-utama) !important; color: white !important; }
        .btn-primary:hover { background-color: var(--warna-paling-gelap) !important; border-color: var(--warna-paling-gelap) !important; color: white !important; }

        .navbar { background: var(--warna-paling-gelap); }
        .card-search { margin-top: -50px; border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }

        /* STEPPER KUSTOM (DIJADIKAN 5 LANGKAH) */
        .stepper { display: flex; justify-content: space-between; position: relative; margin: 40px 0; }
        .stepper::before { content: ''; position: absolute; top: 20px; left: 0; width: 100%; height: 4px; background: #e2e8f0; z-index: 1; }
        .step { position: relative; z-index: 2; text-align: center; flex: 1; }
        .step-icon { width: 45px; height: 45px; border-radius: 50%; background: #e2e8f0; color: #64748b; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: bold; border: 4px solid white; }

        .step.active .step-icon { background: var(--warna-utama); color: white; }
        .step.completed .step-icon { background: #198754; color: white; }
        .step.rejected .step-icon { background: #dc3545; color: white; }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="bi bi-shield-check me-2"></i>SI BANSOS LAMONG
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm rounded-pill fw-bold px-3">Kembali ke Beranda</a>
        </div>
    </nav>

    <div class="py-5 text-white text-center" style="background-color: var(--warna-utama);">
        <div class="container pb-5">
            <h2 class="fw-bold">Lacak Pengajuan Anda</h2>
            <p class="opacity-75">Masukkan NIK untuk melihat sejauh mana proses pengajuan bantuan Anda.</p>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card card-search mb-5 border-0">
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
                            <p class="fw-bold mb-4" style="color: var(--warna-utama);">{{ $pengajuan->jenisBansos->nama_bansos }}</p>

                            <div class="stepper d-none d-md-flex">
                                @php 
                                    $s = $pengajuan->status_verifikasi_admin; 
                                    // Cek ke tabel penyaluran, apakah ID pengajuan ini sudah dicairkan?
                                    $isDisalurkan = \App\Models\Penyaluran::where('id_pengajuan', $pengajuan->id)->first();
                                @endphp
                                
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
                                
                                <div class="step {{ in_array($s, ['Layak']) ? 'completed' : ($s == 'Tidak Layak' ? 'rejected' : ($s == 'Siap Keputusan' ? 'active' : '')) }}">
                                    <div class="step-icon"><i class="bi bi-flag"></i></div>
                                    <div class="step-label small fw-bold">Keputusan</div>
                                </div>

                                @if($s != 'Tidak Layak')
                                <div class="step {{ $isDisalurkan ? 'completed' : ($s == 'Layak' ? 'active' : '') }}">
                                    <div class="step-icon"><i class="bi bi-gift"></i></div>
                                    <div class="step-label small fw-bold">Penyaluran</div>
                                </div>
                                @endif
                            </div>

                            <div class="alert {{ $isDisalurkan ? 'alert-success' : ($s == 'Layak' ? 'alert-primary' : ($s == 'Tidak Layak' ? 'alert-danger' : 'alert-secondary')) }} border-0 rounded-4 mt-4 text-start">
                                <div class="d-flex align-items-center">
                                    @if($isDisalurkan)
                                        <i class="bi bi-check-circle-fill fs-1 me-3 text-success"></i>
                                        <div>
                                            <strong class="d-block text-success mb-1">Bantuan Telah Disalurkan</strong>
                                            <span class="small">Bantuan telah diambil dan dicairkan pada tanggal <strong>{{ \Carbon\Carbon::parse($isDisalurkan->tgl_terima)->format('d F Y') }}</strong>.</span>
                                        </div>
                                    @elseif($s == 'Layak')
                                        <i class="bi bi-hourglass-split fs-1 me-3" style="color: var(--warna-utama);"></i>
                                        <div>
                                            <strong class="d-block mb-1" style="color: var(--warna-utama);">Menunggu Penyaluran</strong>
                                            <span class="small">Selamat! Pengajuan Anda <strong>Disetujui</strong>. Saat ini masuk dalam antrean jadwal penyaluran bantuan oleh pihak Desa.</span>
                                        </div>
                                    @elseif($s == 'Tidak Layak')
                                        <i class="bi bi-x-circle-fill fs-1 me-3 text-danger"></i>
                                        <div>
                                            <strong class="d-block text-danger mb-1">Pengajuan Ditolak</strong>
                                            <span class="small">Maaf, pengajuan belum dapat disetujui. Alasan: <em>{{ $pengajuan->keterangan_ditolak }}</em></span>
                                        </div>
                                    @else
                                        <i class="bi bi-arrow-repeat fs-1 me-3 text-secondary"></i>
                                        <div>
                                            <strong class="d-block text-secondary mb-1">Dalam Tahap: {{ $s }}</strong>
                                            <span class="small">Mohon tunggu, berkas Anda sedang dalam tahap pemeriksaan dan evaluasi oleh tim verifikasi desa.</span>
                                        </div>
                                    @endif
                                </div>
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