<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Publik - Desa Lamong</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --warna-utama: #BBD0EC; 
            --warna-utama-gelap: #7D88DC; 
            --warna-aksen: #A4BEE3; 
            --warna-background: #F8FAFC; 
        }

        .text-primary { color: var(--warna-utama-gelap) !important; } 
        .bg-primary { background-color: var(--warna-utama) !important; }
        .border-primary { border-color: var(--warna-utama) !important; }

        .btn-primary {
            background-color: var(--warna-utama-gelap) !important;
            border-color: var(--warna-utama-gelap) !important;
            color: white !important;
            box-shadow: 0 4px 15px rgba(125, 136, 220, 0.3);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: var(--warna-paling-gelap) !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(125, 136, 220, 0.4);
        }

        body { font-family: 'Poppins', sans-serif; background-color: var(--warna-background) !important; overflow-x: hidden; }
        
        /* GLASSMORPHISM */
        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        }

        .navbar-glass { 
            background: rgba(255, 255, 255, 0.85) !important; 
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            box-shadow: 0 4px 30px rgba(0,0,0,0.03); 
            padding: 15px 0; 
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }
        .navbar-brand { font-weight: 800; color: var(--warna-utama-gelap) !important; letter-spacing: -0.5px; }
        .nav-link { font-weight: 600; color: #4b5563 !important; margin-left: 20px; transition: color 0.3s; }
        .nav-link:hover { color: var(--warna-utama-gelap) !important; }

        .hero-section {
            background: linear-gradient(135deg, var(--warna-utama-gelap) 0%, var(--warna-utama) 100%);
            color: white;
            padding: 120px 0 140px 0;
            border-radius: 0 0 50px 50px;
            margin-bottom: 50px;
            position: relative;
            overflow: hidden;
        }
        .hero-section h1, .hero-section p { position: relative; z-index: 2; text-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        
        .blob { position: absolute; filter: blur(40px); z-index: 1; opacity: 0.6; animation: float 8s ease-in-out infinite; }
        .blob-1 { background: rgba(255,255,255,0.3); width: 300px; height: 300px; border-radius: 50%; top: -50px; left: -50px; }
        .blob-2 { background: rgba(255,255,255,0.2); width: 250px; height: 250px; border-radius: 50%; bottom: -50px; right: 10%; animation-delay: -4s; }

        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(20px) scale(1.05); }
            100% { transform: translateY(0px) scale(1); }
        }

        .fade-in-up { opacity: 0; animation: fadeInUp 0.8s ease-out forwards; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .icon-box {
            width: 60px; height: 60px;
            border-radius: 15px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; margin-bottom: 15px;
        }
        
        .info-box {
            background: rgba(255,255,255,0.6); padding: 25px;
            border-radius: 15px;
            border-left: 5px solid var(--warna-utama-gelap);
            margin-bottom: 20px;
        }

        /* GAYA TAB DOKUMENTASI */
        .nav-tabs .nav-link { color: #6c757d; border: none; font-size: 0.9rem; transition: 0.3s; }
        .nav-tabs .nav-link.active { color: var(--warna-utama-gelap); background: white; border-bottom: 3px solid var(--warna-utama-gelap); }

        .modal-content.glass-modal { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(15px); border-radius: 20px; border: 1px solid rgba(255,255,255,0.8); overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
        .modal-header { background: linear-gradient(135deg, var(--warna-utama-gelap) 0%, var(--warna-utama) 100%); color: white; border-bottom: none; padding: 20px 30px; }
        .btn-close { filter: invert(1); }
        .form-control { padding: 12px; border-radius: 10px; background-color: rgba(255,255,255,0.8); border: 1px solid #e9ecef; }
        .form-control:focus { background-color: white; border-color: var(--warna-utama); box-shadow: 0 0 0 4px rgba(187, 208, 236, 0.4); }

        .pulse-active { animation: pulse-animation 2s infinite; border: 2px solid #0d6efd !important; }
        @keyframes pulse-animation {
            0% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(13, 110, 253, 0); }
            100% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0); }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-glass sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-buildings-fill me-2"></i>DESA LAMONG
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#statistik">Statistik</a></li>
                    <li class="nav-item"><a class="nav-link" href="#transparansi">Transparansi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#dokumentasi">Dokumentasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#jadwal-bansos">Jadwal Bansos</a></li>
                    
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        @auth
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle rounded-pill px-4 fw-bold border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle me-2"></i> {{ Auth::user()->username }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2 rounded-3 glass-card">
                                    <li>
                                        @if(Auth::user()->role == 'Admin')
                                            <a class="dropdown-item py-2 rounded-2 fw-medium" href="{{ route('admin.dashboard') }}">
                                                <i class="bi bi-speedometer2 me-2 text-primary"></i> Dashboard Admin
                                            </a>
                                        @else
                                            <a class="dropdown-item py-2 rounded-2 fw-medium" href="{{ route('rt.dashboard') }}">
                                                <i class="bi bi-grid-fill me-2 text-primary"></i> Dashboard RT
                                            </a>
                                        @endif
                                    </li>
                                    <li><hr class="dropdown-divider opacity-25"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item py-2 text-danger rounded-2 fw-medium">
                                                <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold border-0" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="bi bi-lock-fill me-1"></i> Masuk Sistem
                            </button>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        
        <div class="container position-relative">
            <h1 class="display-4 fw-bold mb-3 fade-in-up">Transparansi Bantuan Sosial</h1>
            <p class="lead opacity-100 mb-4 mx-auto fade-in-up" style="max-width: 700px; animation-delay: 0.1s;">
                Sistem informasi terpadu untuk pengelolaan data kependudukan dan penyaluran bantuan sosial 
                Desa Lamong yang akuntabel dan transparan.
            </p>
            
            <a href="{{ route('status.index') }}" class="btn btn-warning btn-lg rounded-pill px-5 py-3 fw-bold shadow-lg mt-2 text-dark fade-in-up" style="animation-delay: 0.2s;">
                <i class="bi bi-search me-2"></i> CEK STATUS PENGAJUAN ANDA
            </a>
        </div>
    </section>

    <div class="container" style="margin-top: -80px; position: relative; z-index: 10;">
        
        <div class="row g-4 mb-5" id="statistik">
            <div class="col-md-4 fade-in-up" style="animation-delay: 0.3s;">
                <div class="glass-card p-4 h-100">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h2 class="fw-bold mb-0 text-dark">{{ number_format($totalWarga ?? 0) }}</h2>
                    <p class="text-muted mb-0 fw-medium">Total Penduduk</p>
                </div>
            </div>
            
            <div class="col-md-4 fade-in-up" style="animation-delay: 0.4s;">
                <div class="glass-card p-4 h-100">
                    <div class="icon-box bg-success bg-opacity-10 text-success">
                        <i class="bi bi-house-door-fill"></i>
                    </div>
                    <h2 class="fw-bold mb-0 text-dark">{{ number_format($totalKK ?? 0) }}</h2>
                    <p class="text-muted mb-0 fw-medium">Kepala Keluarga (KK)</p>
                </div>
            </div>

            <div class="col-md-4 fade-in-up" style="animation-delay: 0.5s;">
                <div class="glass-card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center h-100 py-2">
                        <div class="d-flex align-items-center w-50">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 50px; height: 50px;">
                                <i class="bi bi-gender-male fs-4 fw-bold"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0 text-dark">{{ number_format($lakiLaki ?? 0) }}</h4>
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Laki-laki</small>
                            </div>
                        </div>
                        <div class="vr mx-2" style="width: 2px; background-color: var(--warna-utama); opacity: 0.3;"></div>
                        <div class="d-flex align-items-center w-50 ps-2">
                            <div class="bg-danger bg-opacity-10 text-danger rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 50px; height: 50px;">
                                <i class="bi bi-gender-female fs-4 fw-bold"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0 text-dark">{{ number_format($perempuan ?? 0) }}</h4>
                                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Perempuan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-8" id="transparansi">
                <div class="glass-card p-4 mb-4">
                    <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-graph-up-arrow text-primary me-2"></i>Tren Pengajuan Bantuan per Tahun</h5>
                    <div style="position: relative; height: 280px;">
                        <canvas id="trenChart"></canvas>
                    </div>
                </div>

                <div class="glass-card p-4">
                    <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-bar-chart-fill text-primary me-2"></i>Sebaran Penerima Bantuan (Disetujui)</h5>
                    <div style="position: relative; height: 280px;">
                        <canvas id="bansosChart"></canvas>
                    </div>
                </div>
            </div>

            @php
                $safeGaleriStatis = $galeriStatis ?? [
                    (object)['foto' => 'https://images.unsplash.com/photo-1593115057322-e94b77572f20?q=80&w=800&auto=format&fit=crop', 'judul' => 'Rapat Musdes 2026'],
                    (object)['foto' => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?q=80&w=800&auto=format&fit=crop', 'judul' => 'Gotong Royong Perbaikan Jalan']
                ];
            @endphp

            <div class="col-lg-4" id="dokumentasi">
                
                <div class="glass-card overflow-hidden mb-4 p-0">
                    
                    <ul class="nav nav-tabs nav-fill bg-light border-bottom" id="photoTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold py-3 rounded-0" id="live-tab" data-bs-toggle="tab" data-bs-target="#live-photo" type="button" role="tab">
                                <i class="bi bi-broadcast text-danger me-1"></i> Live Salur
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold py-3 rounded-0" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery-photo" type="button" role="tab">
                                <i class="bi bi-images text-primary me-1"></i> Galeri Desa
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="photoTabsContent">
                        
                        <div class="tab-pane fade show active" id="live-photo" role="tabpanel">
                            <div id="carouselLive" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @forelse($dokumentasi ?? [] as $key => $foto)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $foto->foto_bukti) }}" class="d-block w-100" style="height: 280px; object-fit: cover;" alt="Live Salur">
                                            <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.6); border-radius: 10px; backdrop-filter: blur(5px); bottom: 10px;">
                                                <p class="small mb-0 fw-bold">{{ $foto->pengajuan->warga->nama_lengkap ?? 'Warga' }}</p>
                                                <p class="mb-0" style="font-size: 0.7rem;">Menerima: {{ $foto->pengajuan->jenisBansos->nama_bansos ?? 'Bantuan' }}</p>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="carousel-item active">
                                            <div class="d-flex flex-column align-items-center justify-content-center bg-light text-muted" style="height: 280px;">
                                                <i class="bi bi-camera-video fs-1 mb-2"></i>
                                                <p class="small mb-0">Belum ada penyaluran terbaru</p>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                                @if(isset($dokumentasi) && count($dokumentasi) > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselLive" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselLive" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
                                @endif
                            </div>
                            <div class="p-3 bg-white text-center">
                                <h6 class="fw-bold text-dark mb-1">Bukti Serah Terima</h6>
                                <p class="text-muted small mb-0">Update otomatis saat bansos disalurkan.</p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="gallery-photo" role="tabpanel">
                            <div id="carouselGaleri" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($safeGaleriStatis as $key => $galeri)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            <img src="{{ str_starts_with($galeri->foto, 'http') ? $galeri->foto : asset('storage/' . $galeri->foto) }}" class="d-block w-100" style="height: 280px; object-fit: cover;" alt="Galeri Desa">
                                            <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.6); border-radius: 10px; backdrop-filter: blur(5px); bottom: 10px;">
                                                <p class="small mb-0 fw-bold">{{ $galeri->judul }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if(count($safeGaleriStatis) > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselGaleri" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselGaleri" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
                                @endif
                            </div>
                            <div class="p-3 bg-white text-center">
                                <h6 class="fw-bold text-dark mb-1">Potret Kegiatan</h6>
                                <p class="text-muted small mb-0">Dokumentasi kegiatan dan program desa.</p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="info-box border-start-0 border-top border-4 border-warning glass-card">
                    <span class="badge bg-warning text-dark mb-2 shadow-sm">LAYANAN</span>
                    <h6 class="fw-bold text-dark">Pusat Pengaduan</h6>
                    <p class="small text-muted mb-0 fst-italic">Jika menemukan ketidaksesuaian data atau kendala layanan, harap segera hubungi Balai Desa atau lapor ke RT setempat.</p>
                </div>

            </div>
        </div>
    </div>

    <section id="jadwal-bansos" class="py-5 mt-4" style="background-color: rgba(187, 208, 236, 0.15); border-top: 1px solid rgba(125, 136, 220, 0.2);">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark">Siklus Tahapan Bansos Bulanan</h2>
                <p class="text-muted">Proses pengusulan hingga pencairan dilakukan secara bertahap setiap bulannya sesuai kalender di bawah ini.</p>
                <div class="badge bg-primary fs-6 px-4 py-2 mt-2 shadow-sm rounded-pill">
                    <i class="bi bi-calendar-event me-2"></i> Hari ini: Tanggal {{ $hariIni ?? date('d') }}
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach($jadwal ?? [] as $item)
                    @php 
                        $isActive = (isset($hariIni) && $hariIni >= $item->hari_mulai && $hariIni <= $item->hari_selesai); 
                    @endphp
                    <div class="col-md-4">
                        <div class="glass-card timeline-card h-100 {{ $isActive ? 'pulse-active' : '' }}" style="border-top: 6px solid {{ $item->warna_bg }} !important;">
                            <div class="card-body text-center p-4">
                                @if($isActive)
                                    <span class="badge bg-primary mb-3 shadow-sm rounded-pill px-3 py-2"><i class="bi bi-broadcast me-1"></i> Sedang Berlangsung</span>
                                @endif
                                <h5 class="fw-bold text-dark">{{ $item->nama_tahapan }}</h5>
                                <h2 class="display-6 fw-bold my-3" style="color: {{ $item->warna_bg }};">Tgl {{ $item->hari_mulai }}-{{ $item->hari_selesai > 30 ? 'Akhir' : $item->hari_selesai }}</h2>
                                <p class="text-muted mb-0 small">{{ $item->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="py-4 bg-white text-center border-top">
        <div class="container">
            <small class="text-muted fw-medium">&copy; 2026 Pemerintah Desa Lamong. Sistem Informasi Bantuan Sosial.</small>
        </div>
    </footer>

    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content glass-modal">
                <div class="modal-header justify-content-center text-center">
                    <div>
                        <h5 class="modal-title fw-bold mb-0">Login Petugas</h5>
                        <small class="text-white-50">Silakan masuk untuk mengelola data</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body p-4">
                    @if($errors->has('login_error'))
                        <div class="alert alert-danger py-2 small text-center mb-3 shadow-sm border-0 rounded-3">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $errors->first('login_error') }}
                        </div>
                        <script>
                            window.addEventListener('DOMContentLoaded', (event) => {
                                var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
                                myModal.show();
                            });
                        </script>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Username</label>
                            <div class="input-group shadow-sm rounded-3">
                                <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-person"></i></span>
                                <input type="text" name="username" class="form-control border-start-0 ps-0" placeholder="Username" value="{{ old('username') }}" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">Password</label>
                            <div class="input-group shadow-sm rounded-3">
                                <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-key"></i></span>
                                <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="••••••••" required>
                            </div>
                        </div>
                        
                        <div class="d-grid mt-2">
                            <button type="submit" class="btn btn-primary rounded-pill fw-bold py-2 shadow">
                                MASUK SISTEM <i class="bi bi-box-arrow-in-right ms-1"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="modal-footer justify-content-center py-3 border-0" style="background: rgba(248, 249, 250, 0.8);">
                    <small class="text-muted fw-bold" style="font-size: 0.75rem;">
                        <i class="bi bi-shield-lock me-1"></i> Area Terbatas (Admin & RT)
                    </small>
                </div>
            </div>
        </div>
    </div>

    @php
        $safeLabelTahun  = $labelTahun ?? ['2023', '2024', '2025', '2026'];
        $safeDataTahun   = $dataTahun ?? [45, 120, 150, 210];
        $safeLabelBansos = $labelBansos ?? [];
        $safeDataBansos  = $dataBansos ?? [];
    @endphp

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <script>
        Chart.register(ChartDataLabels);

        const dtLabelTahun  = @json($safeLabelTahun);
        const dtDataTahun   = @json($safeDataTahun);
        const dtLabelBansos = @json($safeLabelBansos);
        const dtDataBansos  = @json($safeDataBansos);

        const ctxTren = document.getElementById('trenChart').getContext('2d');
        new Chart(ctxTren, {
            type: 'line',
            data: {
                labels: dtLabelTahun,
                datasets: [{
                    label: 'Jumlah Pengajuan',
                    data: dtDataTahun,
                    borderColor: '#7D88DC', 
                    backgroundColor: 'rgba(125, 136, 220, 0.15)', 
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#7D88DC',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.4 
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: { top: 30, right: 20 } },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { precision: 0, stepSize: 20 },
                        grid: { borderDash: [5, 5], color: 'rgba(0,0,0,0.05)' } 
                    },
                    x: { grid: { display: false } }
                },
                plugins: { 
                    legend: { display: false },
                    datalabels: {
                        align: 'top',
                        anchor: 'end',
                        color: '#2C3E50',
                        font: { family: 'Poppins', weight: 'bold', size: 12 },
                        formatter: function(value) { return value + ' Berkas'; }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(44, 62, 80, 0.9)',
                        padding: 12,
                        titleFont: { family: 'Poppins', size: 13 },
                        bodyFont: { family: 'Poppins', size: 14, weight: 'bold' },
                        displayColors: false,
                        cornerRadius: 8
                    }
                }
            }
        });

        const ctxBansos = document.getElementById('bansosChart').getContext('2d');
        const bgColors = ['rgba(125, 136, 220, 0.85)', 'rgba(40, 167, 69, 0.85)', 'rgba(255, 193, 7, 0.85)', 'rgba(220, 53, 69, 0.85)', 'rgba(23, 162, 184, 0.85)', 'rgba(253, 126, 20, 0.85)'];
        const borderColors = ['#7D88DC', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#fd7e14'];

        new Chart(ctxBansos, {
            type: 'bar',
            data: {
                labels: dtLabelBansos.length ? dtLabelBansos : ['Belum Ada Data'],
                datasets: [{
                    label: 'Jumlah Penerima',
                    data: dtDataBansos.length ? dtDataBansos : [0],
                    backgroundColor: bgColors,
                    borderColor: borderColors,
                    borderWidth: 2,
                    borderRadius: 8, 
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: { top: 35 } },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { precision: 0, stepSize: 1 },
                        grid: { borderDash: [5, 5], color: 'rgba(0,0,0,0.05)' } 
                    },
                    x: { grid: { display: false } }
                },
                plugins: { 
                    legend: { display: false },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#2C3E50',
                        font: { family: 'Poppins', weight: 'bold', size: 13 },
                        formatter: function(value) { return value > 0 ? value + ' KK' : ''; }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(44, 62, 80, 0.9)',
                        padding: 12,
                        titleFont: { family: 'Poppins', size: 13 },
                        bodyFont: { family: 'Poppins', size: 14, weight: 'bold' },
                        displayColors: false,
                        cornerRadius: 8
                    }
                }
            } 
        });
    </script>
</body>
</html>