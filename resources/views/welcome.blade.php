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
            --warna-background: #F4F7FA;
        }

        .text-primary { color: var(--warna-utama-gelap) !important; } 
        .bg-primary { background-color: var(--warna-utama) !important; }

        .btn-primary {
            background-color: var(--warna-utama-gelap) !important;
            border-color: var(--warna-utama-gelap) !important;
            color: white !important;
            box-shadow: 0 4px 15px rgba(125, 136, 220, 0.4);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .btn-primary:hover {
            background-color: #2C3E50 !important;
            transform: translateY(-3px) scale(1.02);
        }

        body { font-family: 'Poppins', sans-serif; background-color: var(--warna-background) !important; overflow-x: hidden; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .glass-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(125, 136, 220, 0.15);
        }

        .glass-card-colored {
            background: rgba(255, 255, 255, 0.4); 
            backdrop-filter: blur(15px); 
            -webkit-backdrop-filter: blur(15px);
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }
        .glass-card-colored:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.6);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }
        .color-tint {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            opacity: 0.1; 
            z-index: -1;
        }
        .pulse-active-glass {
            animation: pulse-active-glow 2s infinite;
            border: 2px solid white !important;
        }
        @keyframes pulse-active-glow {
            0% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4); transform: scale(1); }
            70% { box-shadow: 0 0 0 20px rgba(255, 255, 255, 0); transform: scale(1.02); }
            100% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0); transform: scale(1); }
        }

        .navbar-glass { 
            background: rgba(255, 255, 255, 0.75) !important; 
            backdrop-filter: blur(20px);
            box-shadow: 0 4px 30px rgba(0,0,0,0.03); 
            padding: 15px 0; 
            border-bottom: 1px solid rgba(255, 255, 255, 0.6);
        }
        .navbar-brand { font-weight: 800; color: var(--warna-utama-gelap) !important; }
        .nav-link { font-weight: 600; color: #4b5563 !important; margin-left: 20px; }

        .hero-section {
            background: linear-gradient(135deg, var(--warna-utama-gelap) 0%, var(--warna-utama) 100%);
            color: white;
            padding: 140px 0 160px 0;
            border-radius: 0 0 60px 60px;
            margin-bottom: 50px;
            position: relative;
            overflow: hidden;
        }
        
        .blob { position: absolute; filter: blur(50px); z-index: 1; opacity: 0.7; animation: float 8s ease-in-out infinite; }
        .blob-1 { background: rgba(255,255,255,0.4); width: 350px; height: 350px; border-radius: 50%; top: -50px; left: -50px; }
        .blob-2 { background: rgba(255,255,255,0.3); width: 300px; height: 300px; border-radius: 50%; bottom: -50px; right: 5%; animation-delay: -3s; }

        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(30px) scale(1.1); }
            100% { transform: translateY(0px) scale(1); }
        }

        .fade-in-up { opacity: 0; animation: fadeInUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .icon-box {
            width: 65px; height: 65px;
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem; margin-bottom: 15px;
        }

        .gallery-container {
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .gallery-container img {
            height: 450px; 
            object-fit: cover;
        }
        .carousel-caption-custom {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0) 100%);
            padding: 40px 20px 20px 20px;
            color: white;
            text-align: left;
        }

        .modal-content.glass-modal { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border-radius: 24px; border: 1px solid white; }
        .modal-header { background: linear-gradient(135deg, var(--warna-utama-gelap) 0%, var(--warna-utama) 100%); color: white; border-bottom: none; }
        .btn-close { filter: invert(1); }
        .form-control { padding: 14px; border-radius: 12px; background-color: rgba(255,255,255,0.9); border: 2px solid #e2e8f0; transition: all 0.3s; }
        .form-control:focus { background-color: white; border-color: var(--warna-utama); box-shadow: 0 0 0 5px rgba(125, 136, 220, 0.2); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-glass sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center m-0 p-0" href="#">
                <img src="{{ asset('img/logo-desa.png') }}" alt="Logo Desa" 
                     onerror="this.onerror=null; this.outerHTML='<div class=\'bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm\' style=\'width: 45px; height: 45px; margin-right: 15px;\'><i class=\'bi bi-house-door-fill fs-5\'></i></div>';" 
                     style="width: 45px; height: 45px; object-fit: contain; margin-right: 15px;">
                <span class="fs-4 fw-bold text-primary" style="letter-spacing: 0.5px;">DESA LAMONG</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-1 text-primary"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#galeri">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="#transparansi">Statistik</a></li>
                    <li class="nav-item"><a class="nav-link" href="#jadwal-bansos">Jadwal</a></li>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        @auth
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle rounded-pill px-4 fw-bold border-0" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle me-2"></i> {{ Auth::user()->username }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 p-2 rounded-4 glass-card">
                                    <li>
                                        <a class="dropdown-item py-2 rounded-3 fw-medium" href="{{ Auth::user()->role == 'Admin' ? route('admin.dashboard') : route('rt.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2 text-primary"></i> Dashboard
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider opacity-25 my-1"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item py-2 text-danger rounded-3 fw-medium">
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
            <h1 class="display-4 fw-bold mb-3 fade-in-up" style="animation-delay: 0.2s;">Sistem Informasi Bantuan Sosial</h1>
            <p class="lead opacity-100 mb-4 mx-auto fade-in-up" style="max-width: 700px; animation-delay: 0.4s;">
                Platform terpadu pengelolaan data kependudukan dan penyaluran bantuan sosial Desa Lamong yang akuntabel dan transparan.
            </p>
            <a href="{{ route('status.index') }}" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-bold shadow-lg mt-3 text-primary fade-in-up" style="animation-delay: 0.6s;">
                <i class="bi bi-search me-2"></i> CEK STATUS PENGAJUAN ANDA
            </a>
        </div>
    </section>

    <div class="container" style="margin-top: -80px; position: relative; z-index: 10;">
        
        <div class="row g-4 mb-5" id="statistik">
            <div class="col-md-4 fade-in-up" style="animation-delay: 0.2s;">
                <div class="glass-card p-4 h-100 text-center">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary mx-auto"><i class="bi bi-people-fill"></i></div>
                    <h2 class="fw-bold mb-0 text-dark display-6">{{ number_format($totalWarga ?? 0) }}</h2>
                    <p class="text-muted mb-0 fw-medium">Total Penduduk</p>
                </div>
            </div>
            <div class="col-md-4 fade-in-up" style="animation-delay: 0.4s;">
                <div class="glass-card p-4 h-100 text-center">
                    <div class="icon-box bg-success bg-opacity-10 text-success mx-auto"><i class="bi bi-house-door-fill"></i></div>
                    <h2 class="fw-bold mb-0 text-dark display-6">{{ number_format($totalKK ?? 0) }}</h2>
                    <p class="text-muted mb-0 fw-medium">Kepala Keluarga (KK)</p>
                </div>
            </div>
            <div class="col-md-4 fade-in-up" style="animation-delay: 0.6s;">
                <div class="glass-card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center h-100 py-2">
                        <div class="d-flex flex-column align-items-center w-50 border-end">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mb-2 shadow-sm" style="width: 50px; height: 50px;"><i class="bi bi-gender-male fs-4 fw-bold"></i></div>
                            <h4 class="fw-bold mb-0 text-dark">{{ number_format($lakiLaki ?? 0) }}</h4>
                            <small class="text-muted fw-bold" style="font-size: 0.7rem;">Laki-laki</small>
                        </div>
                        <div class="d-flex flex-column align-items-center w-50">
                            <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center mb-2 shadow-sm" style="width: 50px; height: 50px;"><i class="bi bi-gender-female fs-4 fw-bold"></i></div>
                            <h4 class="fw-bold mb-0 text-dark">{{ number_format($perempuan ?? 0) }}</h4>
                            <small class="text-muted fw-bold" style="font-size: 0.7rem;">Perempuan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
            $safeGaleriStatis = $galeriStatis ?? [
                (object)['foto' => 'https://images.unsplash.com/photo-1593115057322-e94b77572f20?q=80&w=800&auto=format&fit=crop', 'judul' => 'Kegiatan Musdes Desa Lamong'],
                (object)['foto' => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?q=80&w=800&auto=format&fit=crop', 'judul' => 'Penyaluran Bantuan Sosial']
            ];
        @endphp

        <div class="row mb-5 fade-in-up" id="galeri" style="animation-delay: 0.8s;">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between mb-4 px-2">
                    <h3 class="fw-bold text-dark mb-0"><i class="bi bi-images text-primary me-2"></i> Potret Desa Lamong</h3>
                </div>
                <div class="gallery-container glass-card border-0 p-2">
                    <div id="carouselGaleriLengkap" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
                        <div class="carousel-inner rounded-4 overflow-hidden">
                            @foreach($safeGaleriStatis as $key => $galeri)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ str_starts_with($galeri->foto, 'http') ? $galeri->foto : asset('storage/' . $galeri->foto) }}" class="d-block w-100" alt="Galeri">
                                    <div class="carousel-caption-custom">
                                        <h4 class="fw-bold mb-1">{{ $galeri->judul }}</h4>
                                        <p class="mb-0 opacity-75 small"><i class="bi bi-geo-alt-fill me-1"></i> Desa Lamong</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if(count($safeGaleriStatis) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselGaleriLengkap" data-bs-slide="prev"><span class="bg-dark bg-opacity-50 p-3 rounded-circle"><span class="carousel-control-prev-icon"></span></span></button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselGaleriLengkap" data-bs-slide="next"><span class="bg-dark bg-opacity-50 p-3 rounded-circle"><span class="carousel-control-next-icon"></span></span></button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5 fade-in-up" id="transparansi" style="animation-delay: 1s;">
            
            <div class="col-12 mb-2 px-3 d-flex justify-content-between align-items-center flex-wrap">
                <h3 class="fw-bold text-dark mb-0"><i class="bi bi-bar-chart-line text-primary me-2"></i> Data & Transparansi</h3>
                
                <form action="{{ url('/') }}#transparansi" method="GET" class="d-flex align-items-center mt-3 mt-md-0 bg-white p-1 rounded-pill shadow-sm border" style="max-width: 300px;">
                    <i class="bi bi-funnel-fill text-muted ms-3"></i>
                    <input type="number" name="tahun" class="form-control form-control-sm border-0 bg-transparent text-primary ms-1 shadow-none" placeholder="Ketik Tahun" value="{{ $tahunFilter ?? '' }}">
                    
                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold"><i class="bi bi-search"></i></button>
                    
                    @if(!empty($tahunFilter))
                        <a href="{{ url('/') }}#transparansi" class="btn btn-light btn-sm rounded-pill ms-1 text-danger" title="Hapus Filter"><i class="bi bi-x-circle-fill"></i></a>
                    @endif
                </form>
            </div>
            
            <div class="col-lg-6">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-pie-chart-fill text-primary me-2"></i>Sebaran Penerima Bansos</h5>
                    <div style="position: relative; height: 300px;"><canvas id="bansosChart"></canvas></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-bar-chart-steps text-primary me-2"></i>Grafik Perbandingan Diterima dan Ditolak</h5>
                    <div style="position: relative; height: 300px;"><canvas id="compareChart"></canvas></div>
                </div>
            </div>

            <div class="col-12 mt-3">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-graph-up-arrow text-primary me-2"></i>Tren Pengajuan Bantuan (Tahunan)</h5>
                    <div style="position: relative; height: 350px;"><canvas id="trenChart"></canvas></div>
                </div>
            </div>
            
            <div class="col-12 mt-4">
                <div class="info-box glass-card shadow-sm d-flex flex-column flex-md-row align-items-center justify-content-between p-4" style="border-left: 6px solid #ffc107;">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                        <div class="icon-box bg-warning bg-opacity-25 text-warning mb-0 me-4 shadow-sm" style="min-width: 60px;"><i class="bi bi-headset"></i></div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Pusat Layanan & Pengaduan</h5>
                            <p class="small text-muted mb-0">Jika menemukan ketidaksesuaian data kependudukan atau bansos, harap lapor ke RT setempat atau hubungi Admin Balai Desa.</p>
                        </div>
                    </div>
                    <a href="https://wa.me/6285735939161" target="_blank" class="btn btn-success rounded-pill px-4 py-2 fw-bold shadow-sm text-nowrap">
                        <i class="bi bi-whatsapp me-2"></i> Hubungi Admin
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section id="jadwal-bansos" class="py-5 mt-4 position-relative" style="background-color: var(--warna-background);">
        <div class="container py-4 position-relative" style="z-index: 1;">
            <div class="text-center mb-5 fade-in-up">
                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 mb-2 fw-bold">Timeframe</span>
                <h2 class="fw-bold text-dark">Siklus Tahapan Bansos Bulanan</h2>
                <div class="badge bg-white text-dark fs-6 px-4 py-2 mt-2 shadow-sm rounded-pill border">
                    <i class="bi bi-calendar-event text-primary me-2"></i> Hari ini: Tanggal {{ $hariIni ?? date('d') }}
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach($jadwal ?? [] as $item)
                    @php 
                        $isActive = (isset($hariIni) && $hariIni >= $item->hari_mulai && $hariIni <= $item->hari_selesai); 
                        $warnaAsli = $item->warna_bg; 
                    @endphp
                    <div class="col-md-6 col-lg-4 fade-in-up" style="animation-delay: {{ $loop->iteration * 0.1 }}s;">
                        <div class="glass-card-colored h-100 {{ $isActive ? 'pulse-active-glass' : '' }}" style="border-top: 8px solid {{ $warnaAsli }} !important;">
                            
                            <div class="color-tint" style="background-color: {{ $warnaAsli }};"></div>

                            <div class="card-body text-center p-4 position-relative">

                                @if($isActive)
                                    <span class="badge mb-3 shadow-sm rounded-pill px-3 py-2" style="background-color: {{ $warnaAsli }}; color: white;">
                                        <i class="bi bi-broadcast pulse me-1"></i> Aktif Sekarang
                                    </span>
                                @else
                                    <div class="mb-5"></div>
                                @endif

                                <h5 class="fw-bold text-dark mb-3 mt-2">{{ $item->nama_tahapan }}</h5>
                                
                                <h2 class="display-5 fw-bold my-3" style="color: {{ $warnaAsli }}; letter-spacing: -1px;">
                                    Tgl {{ $item->hari_mulai }}-{{ $item->hari_selesai > 30 ? 'Akhir' : $item->hari_selesai }}
                                </h2>
                                
                                <p class="text-muted mb-0 small fw-medium">{{ $item->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="py-4 bg-white text-center border-top">
        <div class="container"><small class="text-muted fw-bold">&copy; {{ date('Y') }} Pemerintah Desa Lamong. <span class="fw-normal">Sistem Informasi Bantuan Sosial.</span></small></div>
    </footer>

    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content glass-modal">
                <div class="modal-header justify-content-center text-center">
                    <div><h5 class="modal-title fw-bold mb-0">Login Petugas</h5><small class="text-white-50">Masuk untuk mengelola data</small></div>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 top-0 m-3" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    
                    @if($errors->has('login_error'))
                        <div class="alert alert-danger mb-3 py-2 text-center shadow-sm" style="font-size: 0.85rem; border-radius: 10px;">
                            <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $errors->first('login_error') }}
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow">MASUK SISTEM</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @if($errors->has('login_error'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
            myModal.show();
        });
    </script>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // DATA GRAFIK
            const dtLabelTahun  = {!! json_encode($labelTahun ?? [date('Y')]) !!};
            const dtDataTahun   = {!! json_encode($dataTahun ?? [0]) !!};
            const dtLabelBansos = {!! json_encode($labelBansos ?? []) !!};
            const dtDataBansos  = {!! json_encode($dataBansos ?? []) !!};
            
            const dtLabelPerbandingan = {!! json_encode($labelPerbandingan ?? []) !!};
            const dtDataDiterima      = {!! json_encode($dataDiterima ?? []) !!};
            const dtDataDitolak       = {!! json_encode($dataDitolak ?? []) !!};

            // 1. TREN TAHUNAN (Bawah)
            const ctxT = document.getElementById('trenChart');
            if(ctxT) {
                new Chart(ctxT.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: dtLabelTahun,
                        datasets: [{
                            label: 'Pengajuan',
                            data: dtDataTahun,
                            borderColor: '#7D88DC', 
                            backgroundColor: 'rgba(125, 136, 220, 0.15)', 
                            borderWidth: 3, pointBackgroundColor: '#fff', fill: true, tension: 0.4 
                        }]
                    },
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: false, 
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { 
                                beginAtZero: true,
                                ticks: { stepSize: 1, precision: 0 } // <-- MEMAKSA SKALA BILANGAN BULAT
                            }
                        }
                    }
                });
            }

            // 2. SEBARAN BANSOS (Atas Kiri)
            const ctxB = document.getElementById('bansosChart');
            if(ctxB) {
                const bgColors = ['rgba(125, 136, 220, 0.85)', 'rgba(40, 167, 69, 0.85)', 'rgba(255, 193, 7, 0.85)', 'rgba(220, 53, 69, 0.85)', 'rgba(23, 162, 184, 0.85)', 'rgba(253, 126, 20, 0.85)'];
                const borderColors = ['#7D88DC', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#fd7e14'];

                new Chart(ctxB.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: dtLabelBansos.length ? dtLabelBansos : ['Data Kosong'],
                        datasets: [{
                            label: 'Penerima',
                            data: dtDataBansos.length ? dtDataBansos : [0],
                            backgroundColor: bgColors,
                            borderColor: borderColors,
                            borderWidth: 2,
                            borderRadius: 8
                        }]
                    },
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: false, 
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { 
                                beginAtZero: true,
                                ticks: { stepSize: 1, precision: 0 } // <-- MEMAKSA SKALA BILANGAN BULAT
                            }
                        }
                    }
                });
            }

            // 3. DITERIMA VS DITOLAK (Atas Kanan)
            const ctxC = document.getElementById('compareChart');
            if(ctxC) {
                new Chart(ctxC.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: dtLabelPerbandingan.length ? dtLabelPerbandingan : ['Data Kosong'],
                        datasets: [
                            {
                                label: 'Disetujui',
                                data: dtDataDiterima.length ? dtDataDiterima : [0],
                                backgroundColor: 'rgba(40, 167, 69, 0.85)',
                                borderColor: '#28a745',
                                borderWidth: 1,
                                borderRadius: 4
                            },
                            {
                                label: 'Ditolak',
                                data: dtDataDitolak.length ? dtDataDitolak : [0],
                                backgroundColor: 'rgba(220, 53, 69, 0.85)',
                                borderColor: '#dc3545',
                                borderWidth: 1,
                                borderRadius: 4
                            }
                        ]
                    },
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: false, 
                        plugins: { legend: { display: true, position: 'bottom' } },
                        scales: { 
                            y: { 
                                beginAtZero: true,
                                ticks: { stepSize: 1, precision: 0 } // <-- MEMAKSA SKALA BILANGAN BULAT
                            } 
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>