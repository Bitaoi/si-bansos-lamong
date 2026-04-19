<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Publik - Desa Lamong</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* 1. PALET WARNA KUSTOM */
        :root {
            --warna-utama: #BBD0EC; 
            --warna-utama-gelap: #7D88DC; 
            --warna-aksen: #A4BEE3; 
            --warna-background: #FEFCFB; 
        }

        /* 2. MENIMPA WARNA 'PRIMARY' BOOTSTRAP */
        .text-primary { color: var(--warna-utama-gelap) !important; } /* Pakai yang gelap agar teks terbaca jelas */
        .bg-primary { background-color: var(--warna-utama) !important; }
        .border-primary { border-color: var(--warna-utama) !important; }

        /* 3. MENYESUAIKAN WARNA TOMBOL */
        .btn-primary {
            background-color: var(--warna-utama-gelap) !important;
            border-color: var(--warna-utama-gelap) !important;
            color: white !important;
        }
        .btn-primary:hover {
            background-color: var(--warna-utama) !important;
            border-color: var(--warna-utama) !important;
            color: #333 !important;
        }

        .btn-outline-primary {
            color: var(--warna-utama-gelap) !important;
            border-color: var(--warna-utama-gelap) !important;
        }
        .btn-outline-primary:hover {
            background-color: var(--warna-utama-gelap) !important;
            color: white !important;
        }

        /* 4. GAYA HALAMAN UMUM */
        body { font-family: 'Inter', sans-serif; background-color: var(--warna-background) !important; }
        
        /* Navbar */
        .navbar { background-color: #ffffff; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 15px 0; }
        .navbar-brand { font-weight: 800; color: var(--warna-utama-gelap) !important; letter-spacing: -0.5px; }
        .nav-link { font-weight: 600; color: #4b5563 !important; margin-left: 20px; }
        .nav-link:hover { color: var(--warna-utama-gelap) !important; }

        /* Hero Section (Diperbarui dengan Variabel Warna) */
        .hero-section {
            background: linear-gradient(135deg, var(--warna-utama-gelap) 0%, var(--warna-utama) 100%);
            color: white;
            padding: 100px 0 100px 0;
            border-radius: 0 0 50px 50px;
            margin-bottom: 50px;
        }
        .hero-section h1, .hero-section p { text-shadow: 0 2px 4px rgba(0,0,0,0.1); }

        /* Cards Statistik */
        .stat-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: transform 0.3s;
            background: white;
            overflow: hidden;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .icon-box {
            width: 60px; height: 60px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; margin-bottom: 15px;
        }
        
        /* Section Info Desa (Diperbarui border kirinya) */
        .info-box {
            background: white; padding: 25px;
            border-radius: 15px;
            border-left: 5px solid var(--warna-utama-gelap);
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            margin-bottom: 20px;
        }

        /* Modal Login Custom */
        .modal-content { border-radius: 20px; border: none; overflow: hidden; }
        .modal-header { background: var(--warna-utama-gelap); color: white; border-bottom: none; padding: 20px 30px; }
        .btn-close { filter: invert(1); }
        .form-control { padding: 12px; border-radius: 10px; background-color: #f8f9fa; border: 1px solid #e9ecef; }
        .form-control:focus { background-color: white; border-color: var(--warna-utama); box-shadow: 0 0 0 4px rgba(187, 208, 236, 0.4); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
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
                    <li class="nav-item"><a class="nav-link" href="#info">Info Desa</a></li>
                    
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <a class="btn btn-outline-primary rounded-pill px-4 fw-bold" href="{{ route('status.index') }}">
                            <i class="bi bi-search me-1"></i> Cek Status
                        </a>
                    </li>
                    
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        @auth
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle rounded-pill px-4 fw-bold border-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle me-2"></i> {{ Auth::user()->username }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2 rounded-3">
                                    <li>
                                        @if(Auth::user()->role == 'Admin')
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('admin.dashboard') }}">
                                                <i class="bi bi-speedometer2 me-2 text-primary"></i> Dashboard Admin
                                            </a>
                                        @else
                                            <a class="dropdown-item py-2 rounded-2" href="{{ route('rt.dashboard') }}">
                                                <i class="bi bi-grid-fill me-2 text-primary"></i> Dashboard RT
                                            </a>
                                        @endif
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item py-2 text-danger rounded-2">
                                                <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="bi bi-lock-fill me-1"></i> Masuk Sistem
                            </button>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Transparansi Bantuan Sosial</h1>
            <p class="lead opacity-100 mb-4 mx-auto" style="max-width: 700px;">
                Sistem informasi terpadu untuk pengelolaan data kependudukan dan penyaluran bantuan sosial 
                Desa Lamong yang akuntabel dan transparan.
            </p>
            
            <a href="{{ route('status.index') }}" class="btn btn-warning btn-lg rounded-pill px-5 py-3 fw-bold shadow mt-2 text-dark">
                <i class="bi bi-search me-2"></i> CEK STATUS PENGAJUAN ANDA
            </a>
        </div>
    </section>

    <div class="container" style="margin-top: -80px;">
        
        <div class="row g-4 mb-5" id="statistik">
            <div class="col-md-4">
                <div class="stat-card p-4">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h2 class="fw-bold mb-0">{{ number_format($totalWarga) }}</h2>
                    <p class="text-muted mb-0">Total Penduduk</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card p-4">
                    <div class="icon-box bg-success bg-opacity-10 text-success">
                        <i class="bi bi-house-door-fill"></i>
                    </div>
                    <h2 class="fw-bold mb-0">{{ number_format($totalKK) }}</h2>
                    <p class="text-muted mb-0">Kepala Keluarga (KK)</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card p-4">
                    <div class="d-flex justify-content-between align-items-center h-100">
                        <div>
                            <h5 class="fw-bold text-primary mb-1"><i class="bi bi-gender-male"></i> {{ $lakiLaki }} Laki-laki</h5>
                            <h5 class="fw-bold text-danger mb-0"><i class="bi bi-gender-female"></i> {{ $perempuan }} Perempuan</h5>
                        </div>
                        <div style="width: 80px; height: 80px;">
                            <canvas id="genderChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-5">
            <div class="col-lg-8" id="transparansi">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <h4 class="fw-bold mb-4"><i class="bi bi-bar-chart-fill text-primary me-2"></i>Sebaran Penerima Bantuan</h4>
                    <div style="position: relative; height: 350px;">
                        <canvas id="bansosChart"></canvas>
                    </div>
                    <div class="mt-4 text-center">
                        <small class="text-muted fst-italic">*Data berdasarkan pengajuan yang telah diverifikasi layak.</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" id="info">
                <h4 class="fw-bold mb-4"><i class="bi bi-megaphone-fill text-danger me-2"></i>Informasi Desa</h4>
                
                <div class="info-box">
                    <span class="badge bg-danger mb-2">PENTING</span>
                    <h6 class="fw-bold">Jadwal Penyaluran BLT-DD</h6>
                    <p class="small text-muted mb-0">Penyaluran BLT Dana Desa periode Maret 2026 akan dilaksanakan pada tanggal 15 Maret di Balai Desa.</p>
                </div>

                <div class="info-box border-start-0 border-top border-3 border-warning">
                    <span class="badge bg-warning text-dark mb-2">POSYANDU</span>
                    <h6 class="fw-bold">Jadwal Posyandu Balita</h6>
                    <p class="small text-muted mb-0">Posyandu Mawar 1 akan diadakan hari Selasa depan. Harap membawa buku KIA.</p>
                </div>

                <div class="card border-0 shadow-sm p-3 bg-dark text-white mt-4">
                    <h6 class="fw-bold border-bottom border-secondary pb-2 mb-3">Perangkat Desa</h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2 d-flex justify-content-between">
                            <span>Kepala Desa</span>
                            <span class="fw-bold text-warning">Bpk. H. Suwarno</span>
                        </li>
                        <li class="mb-2 d-flex justify-content-between">
                            <span>Sekretaris</span>
                            <span class="fw-bold">Ibu Siti Aminah</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span>Kasi Kesejahteraan</span>
                            <span class="fw-bold">Bpk. Budi Santoso</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5 py-4 bg-white text-center border-top">
        <div class="container">
            <small class="text-muted">&copy; 2026 Pemerintah Desa Lamong. Sistem Informasi Bantuan Sosial.</small>
        </div>
    </footer>

    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header justify-content-center text-center">
                    <div>
                        <h5 class="modal-title fw-bold mb-0">Login Petugas</h5>
                        <small class="text-white-50">Silakan masuk untuk mengelola data</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body p-4">
                    
                    @if($errors->has('login_error'))
                        <div class="alert alert-danger py-2 small text-center mb-3 shadow-sm border-0">
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
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" name="username" class="form-control border-start-0 ps-0" placeholder="Username" value="{{ old('username') }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-key text-muted"></i></span>
                                <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="••••••••" required>
                            </div>
                        </div>
                        
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm">
                                MASUK SISTEM <i class="bi bi-box-arrow-in-right ms-1"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="modal-footer justify-content-center bg-light py-2 border-0 rounded-bottom">
                    <small class="text-muted" style="font-size: 0.75rem;">
                        <i class="bi bi-shield-lock me-1"></i> Area Terbatas (Admin & RT)
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // 1. CHART GENDER 
        const ctxGender = document.getElementById('genderChart').getContext('2d');
        new Chart(ctxGender, {
            type: 'doughnut',
            data: {
                labels: ['L', 'P'],
                datasets: [{
                    data: [{{ $lakiLaki }}, {{ $perempuan }}],
                    backgroundColor: ['#7D88DC', '#dc3545'], // <- Diperbarui warnanya
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%', 
                plugins: { legend: { display: false }, tooltip: { enabled: false } },
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // 2. CHART BANSOS 
        const ctxBansos = document.getElementById('bansosChart').getContext('2d');
        const labels = @json($labelBansos); 
        const dataTotal = @json($dataBansos);

        new Chart(ctxBansos, {
            type: 'bar',
            data: {
                labels: labels.length ? labels : ['Belum Ada Data'],
                datasets: [{
                    label: 'Jumlah Penerima (KK)',
                    data: dataTotal.length ? dataTotal : [0],
                    backgroundColor: '#BBD0EC', // <- Diperbarui warnanya
                    borderColor: '#7D88DC', // <- Diperbarui warnanya
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                    x: { grid: { display: false } }
                },
                plugins: { legend: { display: false } }
            }
        });
    </script>
</body>
</html>