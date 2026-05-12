<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pengajuan - Admin SI Bansos</title>
    
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

        body { background-color: var(--warna-background) !important; color: var(--warna-paling-gelap); font-family: 'Poppins', sans-serif !important; }
        .text-primary { color: var(--warna-utama) !important; }
        .bg-primary { background-color: var(--warna-utama) !important; color: #ffffff !important; }
        .border-primary { border-color: var(--warna-utama) !important; }
        .btn-primary { background-color: var(--warna-utama) !important; border-color: var(--warna-utama) !important; color: #ffffff !important; box-shadow: 0 4px 6px rgba(125, 136, 220, 0.2); }
        .btn-primary:hover { background-color: var(--warna-paling-gelap) !important; border-color: var(--warna-paling-gelap) !important; color: #ffffff !important; }
        .btn-outline-primary { color: var(--warna-utama) !important; border-color: var(--warna-utama) !important; background-color: transparent !important; }
        .btn-outline-primary:hover { background-color: var(--warna-utama) !important; color: #ffffff !important; }
        
        .sidebar { min-height: 100vh; background: var(--warna-paling-gelap); color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: var(--warna-utama); color: white; }
        .nav-link i { width: 24px; display: inline-block; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: var(--warna-soft); font-weight: 700; padding: 10px 20px; letter-spacing: 0.5px; opacity: 0.8; }
        
        .card { border: 1px solid var(--warna-soft) !important; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .table-custom thead th { background-color: var(--warna-soft); color: var(--warna-paling-gelap); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; border-bottom: 2px solid var(--warna-utama); }
        .table-custom tbody td { vertical-align: middle; border-bottom: 1px solid #f1f5f9; padding: 1rem 0.75rem; font-size: 0.95rem; }
        
        .stepper { display: flex; justify-content: space-between; position: relative; margin-bottom: 30px; }
        .stepper::before { content: ''; position: absolute; top: 15px; left: 0; width: 100%; height: 3px; background: #e2e8f0; z-index: 1; }
        .step { position: relative; z-index: 2; text-align: center; background: white; padding: 0 10px; flex: 1; }
        .step-icon { width: 35px; height: 35px; border-radius: 50%; background: #e2e8f0; color: #64748b; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-weight: bold; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .step.active .step-icon { background: var(--warna-utama); color: white; border-color: var(--warna-soft); }
        .step.completed .step-icon { background: #198754; color: white; border-color: #d1e7dd; }
        .step.rejected .step-icon { background: #dc3545; color: white; border-color: #f8d7da; }
        .step-label { font-size: 0.75rem; font-weight: 700; color: #64748b; }
        
        .img-evidence { width: 100%; height: 150px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; cursor: zoom-in;}
        .timeline-doc { border-left: 3px solid var(--warna-utama); padding-left: 15px; margin-bottom: 15px; }
        .kriteria-list li { margin-bottom: 8px; font-size: 0.85rem; border-bottom: 1px dashed #eee; padding-bottom: 5px;}
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <h5 class="fw-bold mb-4 px-2 py-2 border-bottom text-white" style="border-color: var(--warna-soft) !important;">
                <i class="bi bi-shield-lock-fill me-2"></i>ADMIN PANEL
            </h5>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.rt.index') }}" class="nav-link {{ Request::routeIs('admin.rt.*') ? 'active' : '' }}">
                        <i class="bi bi-person-badge-fill"></i> Manajemen Akun RT
                    </a>
                </li>
                
                <div class="sidebar-heading mt-3">Master Data</div>
                <li class="nav-item"><a href="{{ route('warga.index') }}" class="nav-link {{ Request::routeIs('warga.*') ? 'active' : '' }}"><i class="bi bi-people-fill"></i> Data Warga</a></li>
                <li class="nav-item"><a href="{{ route('jenis-bansos.index') }}" class="nav-link {{ Request::routeIs('jenis-bansos.*') ? 'active' : '' }}"><i class="bi bi-gift-fill"></i> Jenis Bansos</a></li>
                <li class="nav-item"><a href="{{ route('admin.jadwal.index') }}" class="nav-link {{ Request::routeIs('admin.jadwal.*') ? 'active' : '' }}"><i class="bi bi-calendar-event"></i> Jadwal Tahapan</a></li>
                <li class="nav-item"><a href="{{ route('admin.galeri.index') }}" class="nav-link {{ Request::routeIs('admin.galeri.*') ? 'active' : '' }}"><i class="bi bi-images"></i> Galeri Desa</a></li>
                
                <div class="sidebar-heading mt-3">Transaksi</div>
                <li class="nav-item"><a href="{{ route('verifikasi.index') }}" class="nav-link {{ Request::routeIs('verifikasi.*') ? 'active' : '' }}"><i class="bi bi-file-earmark-check-fill"></i> Verifikasi Pengajuan</a></li>
                <li class="nav-item">
                    <a href="{{ route('penyaluran.index') }}" class="nav-link {{ Request::routeIs('penyaluran.*') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                        <div><i class="bi bi-truck"></i> Penyaluran</div>
                        @if(isset($jumlahAntreanPenyaluran) && $jumlahAntreanPenyaluran > 0)
                            <span class="badge rounded-pill bg-danger border border-light shadow-sm" style="font-size: 0.7rem; padding: 0.35em 0.65em;">{{ $jumlahAntreanPenyaluran }}</span>
                        @endif
                    </a>
                </li>
                
                <li class="nav-item mt-5">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link text-white w-100 text-start border-0 shadow-sm" style="background-color: #dc3545; border-radius: 8px;">
                            <i class="bi bi-box-arrow-right"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        
        <div class="col-md-9 col-lg-10 p-4">
            
            <div class="d-md-none d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold"><i class="bi bi-file-earmark-check-fill me-2"></i>Verifikasi Pengajuan</h5>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-danger"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>

            <h4 class="fw-bold mb-4">Verifikasi Kelayakan Pengajuan</h4>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
            @endif

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <table class="table table-custom table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Pemohon</th>
                                <th>Bansos</th>
                                <th>Skor Kelayakan</th>
                                <th>Tahapan Saat Ini</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuans as $item)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $item->warga->nama_lengkap ?? '-' }}</div>
                                    <small class="text-muted">RT: {{ $item->pengusul->wilayah_rt_rw ?? '-' }}</small>
                                </td>
                                <td>
                                    <span class="fw-bold fst-italic text-dark">
                                        {{ $item->jenisBansos->nama_bansos ?? '-' }}
                                    </span>
                                </td>
                                
                                <td>
                                    @php
                                        $desil = $item->warga->desil; 
                                        $warnaDesil = ''; $teksDesil = ''; $labelDesil = '';
                                        
                                        if(is_null($desil)) {
                                            $warnaDesil = 'bg-secondary bg-opacity-25 text-secondary border';
                                            $labelDesil = 'Belum Ditentukan';
                                            $teksDesil = 'Menunggu Observasi';
                                        } elseif($desil == 1) { 
                                            $warnaDesil = 'bg-danger'; $labelDesil = 'Desil 1'; $teksDesil = 'Sangat Miskin'; 
                                        } elseif($desil == 2) { 
                                            $warnaDesil = 'bg-warning text-dark'; $labelDesil = 'Desil 2'; $teksDesil = 'Miskin'; 
                                        } elseif($desil == 3) { 
                                            $warnaDesil = 'bg-info text-dark'; $labelDesil = 'Desil 3'; $teksDesil = 'Hampir Miskin'; 
                                        } elseif($desil == 4) { 
                                            $warnaDesil = 'bg-primary'; $labelDesil = 'Desil 4'; $teksDesil = 'Rentan Miskin'; 
                                        } else { 
                                            $warnaDesil = 'bg-success'; $labelDesil = 'Desil '.$desil; $teksDesil = 'Keluarga Mampu'; 
                                        }
                                    @endphp
                                    <span class="fw-bold fs-6">{{ $labelDesil }}</span><br>
                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $teksDesil }}</small>
                                </td>

                                <td>
                                    @php
                                        $badges = [
                                            'Proses' => ['bg-secondary', 'Menunggu Tindakan'],
                                            'Verifikasi Lapangan' => ['bg-warning text-dark', 'Sedang Observasi'],
                                            'Menunggu Musdes' => ['bg-info text-dark', 'Menunggu Musdes'],
                                            'Siap Keputusan' => ['bg-primary', 'Siap Putusan Akhir'],
                                            'Layak' => ['bg-success', 'Selesai - Layak'],
                                            'Tidak Layak' => ['bg-danger', 'Selesai - Ditolak'],
                                        ];
                                        $currentBadge = $badges[$item->status_verifikasi_admin] ?? ['bg-dark', $item->status_verifikasi_admin];
                                    @endphp
                                    <span class="fw-semibold">{{ $currentBadge[1] }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-primary btn-sm px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id }}">
                                        <i class="bi bi-search me-1"></i> Review
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada pengajuan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($pengajuans->hasPages())
                    <div class="card-footer bg-white py-3 border-0">
                        {{ $pengajuans->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

@foreach($pengajuans as $item)
    @php
        $desil = $item->warga->desil;
        $warnaDesil = ''; $teksDesil = ''; $labelDesil = '';
        
        if(is_null($desil)) {
            $warnaDesil = 'bg-secondary bg-opacity-25 text-secondary border';
            $labelDesil = 'Belum Ditentukan';
            $teksDesil = 'Menunggu Observasi';
        } elseif($desil == 1) { 
            $warnaDesil = 'bg-danger'; $labelDesil = 'Desil 1'; $teksDesil = 'Sangat Miskin'; 
        } elseif($desil == 2) { 
            $warnaDesil = 'bg-warning text-dark'; $labelDesil = 'Desil 2'; $teksDesil = 'Miskin'; 
        } elseif($desil == 3) { 
            $warnaDesil = 'bg-info text-dark'; $labelDesil = 'Desil 3'; $teksDesil = 'Hampir Miskin'; 
        } elseif($desil == 4) { 
            $warnaDesil = 'bg-primary'; $labelDesil = 'Desil 4'; $teksDesil = 'Rentan Miskin'; 
        } else { 
            $warnaDesil = 'bg-success'; $labelDesil = 'Desil '.$desil; $teksDesil = 'Keluarga Mampu'; 
        }
    @endphp

    <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border:none; border-radius:15px; overflow:hidden;">
                <div class="modal-header text-white" style="background-color: var(--warna-paling-gelap);">
                    <h5 class="modal-title fw-bold">Review Berkas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    
                    <div class="stepper mb-5 px-3">
                        @php $s = $item->status_verifikasi_admin; @endphp
                        <div class="step {{ in_array($s, ['Proses','Verifikasi Lapangan','Menunggu Musdes','Siap Keputusan','Layak','Tidak Layak']) ? 'completed' : 'active' }}">
                            <div class="step-icon"><i class="bi bi-1-circle"></i></div>
                            <div class="step-label">Pengajuan RT</div>
                        </div>
                        <div class="step {{ in_array($s, ['Menunggu Musdes','Siap Keputusan','Layak','Tidak Layak']) ? 'completed' : ($s == 'Verifikasi Lapangan' ? 'active' : '') }}">
                            <div class="step-icon"><i class="bi bi-2-circle"></i></div>
                            <div class="step-label">Observasi Lapangan</div>
                        </div>
                        <div class="step {{ in_array($s, ['Siap Keputusan','Layak','Tidak Layak']) ? 'completed' : ($s == 'Menunggu Musdes' ? 'active' : '') }}">
                            <div class="step-icon"><i class="bi bi-3-circle"></i></div>
                            <div class="step-label">Musdes</div>
                        </div>
                        <div class="step {{ $s == 'Layak' ? 'completed' : ($s == 'Tidak Layak' ? 'rejected' : ($s == 'Siap Keputusan' ? 'active' : '')) }}">
                            <div class="step-icon"><i class="bi bi-check2-all"></i></div>
                            <div class="step-label">Finalisasi</div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-7 border-end">
                            
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary mb-2"><i class="bi bi-person-lines-fill me-2"></i>DATA PEMOHON</h6>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-6"><small class="text-muted d-block">Nama Lengkap</small><strong class="text-dark">{{ $item->warga->nama_lengkap }}</strong></div>
                                <div class="col-6"><small class="text-muted d-block">NIK</small><strong class="text-dark">{{ $item->nik }}</strong></div>
                            </div>
                            <div class="mb-3"><small class="text-muted d-block">Alasan RT</small><div class="bg-light text-dark p-2 rounded border"><em>{{ $item->alasan_pengajuan }}</em></div></div>
                            
                            @if($item->surveiEkonomi)
                            <div class="alert py-2 my-3 small border bg-light text-dark d-flex justify-content-between align-items-center">
                                <span><strong>Skor Kelayakan (PMT):</strong> {{ $item->surveiEkonomi->total_skor }} Poin</span>
                                <i class="bi bi-calculator-fill fs-5 text-secondary"></i>
                            </div>
                            @endif

                            <div class="mb-4 mt-2">
                                <small class="text-muted d-block mb-1">Status Kategori Warga</small>
                                <div class="fw-semibold">
                                    {{ $teksDesil }} ({{ $labelDesil }})
                                </div>
                            </div>

                            <h6 class="fw-bold text-primary mb-3 mt-4"><i class="bi bi-camera-fill me-2"></i>FOTO LAMPIRAN RT</h6>
                            <div class="row g-2 text-center">
                                <div class="col-3">
                                    <a href="{{ asset('storage/'.$item->foto_ktp) }}" target="_blank">
                                        <img src="{{ asset('storage/'.$item->foto_ktp) }}" class="img-evidence">
                                    </a>
                                    <small class="d-block mt-2 fw-bold text-muted">KTP</small>
                                </div>
                                <div class="col-3">
                                    <a href="{{ asset('storage/'.$item->foto_kk) }}" target="_blank">
                                        <img src="{{ asset('storage/'.$item->foto_kk) }}" class="img-evidence">
                                    </a>
                                    <small class="d-block mt-2 fw-bold text-muted">Kartu Keluarga (KK)</small>
                                </div>
                                <div class="col-3">
                                    <a href="{{ asset('storage/'.$item->foto_rumah_depan) }}" target="_blank">
                                        <img src="{{ asset('storage/'.$item->foto_rumah_depan) }}" class="img-evidence">
                                    </a>
                                    <small class="d-block mt-2 fw-bold text-muted">Rumah Depan</small>
                                </div>
                                <div class="col-3">
                                    @if($item->foto_rumah_dalam) 
                                        <a href="{{ asset('storage/'.$item->foto_rumah_dalam) }}" target="_blank">
                                            <img src="{{ asset('storage/'.$item->foto_rumah_dalam) }}" class="img-evidence">
                                        </a>
                                        <small class="d-block mt-2 fw-bold text-muted">Rumah Dalam</small>
                                    @else 
                                        <div class="bg-light d-flex align-items-center justify-content-center border text-muted small" style="height: 150px; border-radius: 8px;">Tanpa Foto</div> 
                                        <small class="d-block mt-2 fw-bold text-muted">Rumah Dalam</small>
                                    @endif
                                </div>
                            </div>

                            @if($item->berkas_observasi || $item->berita_acara_musdes)
                                <h6 class="fw-bold text-primary mb-3 mt-4"><i class="bi bi-folder-check me-2"></i>ARSIP DOKUMEN</h6>
                                
                                @if($item->berkas_observasi)
                                    <div class="timeline-doc p-2 rounded mb-2 bg-light border border-start-0">
                                        <strong><i class="bi bi-file-earmark-pdf text-danger"></i> Hasil Observasi</strong><br>
                                        <small class="text-dark">Catatan: {{ $item->catatan_observasi ?? '-' }}</small><br>
                                        <a href="{{ asset('storage/'.$item->berkas_observasi) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Lihat Berkas</a>
                                    </div>
                                @endif
                                
                                @if($item->berita_acara_musdes)
                                    <div class="timeline-doc p-2 rounded bg-light border border-start-0">
                                        <strong><i class="bi bi-file-earmark-pdf text-danger"></i> Berita Acara Musdes</strong><br>
                                        <a href="{{ asset('storage/'.$item->berita_acara_musdes) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Lihat Berkas BA</a>
                                    </div>
                                @endif
                            @endif
                        </div>

                        <div class="col-md-5 bg-light p-3 rounded border">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-sliders me-2"></i>PANEL KENDALI TAHAPAN</h6>
                            
                            @if($item->status_verifikasi_admin == 'Proses')
                                <div class="alert alert-secondary small text-dark border-0">Data baru masuk. Silakan teruskan ke Dinsos untuk dilakukan survei lapangan.</div>
                                <form action="{{ route('verifikasi.update', $item->id) }}" method="POST">
                                    @csrf @method('PUT') <input type="hidden" name="tahap" value="jadwal_observasi">
                                    <button type="submit" class="btn btn-warning w-100 fw-bold shadow-sm"><i class="bi bi-cursor-fill me-2"></i>Jadwalkan Observasi Lapangan</button>
                                </form>
                            
                            @elseif($item->status_verifikasi_admin == 'Verifikasi Lapangan')
                                <div class="alert alert-warning small border-0 mb-3 text-dark"><i class="bi bi-info-circle me-1"></i> Form Sensus Ekonomi Terpadu (Kategori A, B, & C).</div>
                                
                                <form action="{{ route('verifikasi.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf @method('PUT') <input type="hidden" name="tahap" value="hasil_observasi">
                                    
                                    <div class="accordion" id="accordionSensus{{ $item->id }}">
                                        
                                        <div class="accordion-item mb-2 border-0 shadow-sm rounded">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#kategoriA{{ $item->id }}">
                                                    A. Kondisi Tempat Tinggal
                                                </button>
                                            </h2>
                                            <div id="kategoriA{{ $item->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionSensus{{ $item->id }}">
                                                <div class="accordion-body bg-white">
                                                    <div class="mb-2">
                                                        <label class="small fw-bold">Luas Lantai <span class="text-danger">*</span></label>
                                                        <select name="luas_lantai" class="form-select form-select-sm" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="< 8 m² per orang">< 8 m² per orang</option>
                                                            <option value="> 8 m² per orang">> 8 m² per orang</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="small fw-bold">Jenis Lantai <span class="text-danger">*</span></label>
                                                        <select name="jenis_lantai" class="form-select form-select-sm" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="Tanah / Bambu">Tanah / Bambu</option>
                                                            <option value="Semen / Plester">Semen / Plester</option>
                                                            <option value="Keramik / Marmer">Keramik / Marmer</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="small fw-bold">Jenis Dinding <span class="text-danger">*</span></label>
                                                        <select name="jenis_dinding" class="form-select form-select-sm" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="Bilik Bambu / Kayu Murah">Bilik Bambu / Kayu Murah</option>
                                                            <option value="Tembok Tanpa Plester">Tembok Tanpa Plester</option>
                                                            <option value="Tembok Bagus / Semen">Tembok Bagus / Semen</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="small fw-bold">Sumber Air <span class="text-danger">*</span></label>
                                                        <select name="sumber_air" class="form-select form-select-sm" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="Sungai / Mata Air">Sungai / Mata Air</option>
                                                            <option value="Sumur / Pompa">Sumur / Pompa</option>
                                                            <option value="PDAM">PDAM</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="small fw-bold">Daya Listrik <span class="text-danger">*</span></label>
                                                        <select name="daya_listrik" class="form-select form-select-sm" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="450 Watt (Subsidi)">450 Watt (Subsidi)</option>
                                                            <option value="900 Watt (Subsidi)">900 Watt (Subsidi)</option>
                                                            <option value="900 Watt (Non-Subsidi) / 1300+">900 Watt (Non-Subsidi) / 1300+</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item mb-2 border-0 shadow-sm rounded">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#kategoriB{{ $item->id }}">
                                                    B. Kepemilikan Aset
                                                </button>
                                            </h2>
                                            <div id="kategoriB{{ $item->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionSensus{{ $item->id }}">
                                                <div class="accordion-body bg-white">
                                                    <div class="mb-2">
                                                        <label class="small fw-bold">Kendaraan <span class="text-danger">*</span></label>
                                                        <select name="kendaraan" class="form-select form-select-sm" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="Tidak punya">Tidak punya</option>
                                                            <option value="Sepeda / 1 Motor Butut">Sepeda / 1 Motor Butut</option>
                                                            <option value="1 Motor Baru (Kredit/Lunas)">1 Motor Baru (Kredit/Lunas)</option>
                                                            <option value="Mobil">Mobil</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="small fw-bold">Barang Elektronik <span class="text-danger">*</span></label>
                                                        <select name="elektronik" class="form-select form-select-sm" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="Tidak ada Kulkas/TV">Tidak ada Kulkas/TV</option>
                                                            <option value="Ada Kulkas / TV Tabung">Ada Kulkas / TV Tabung</option>
                                                            <option value="Ada AC / TV Layar Datar Besar">Ada AC / TV Layar Datar Besar</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="small fw-bold">Ternak/Lahan <span class="text-danger">*</span></label>
                                                        <select name="ternak_lahan" class="form-select form-select-sm" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="Tidak punya">Tidak punya</option>
                                                            <option value="Punya ternak kambing/sapi">Punya ternak kambing/sapi</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item mb-3 border-0 shadow-sm rounded">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#kategoriC{{ $item->id }}">
                                                    C. Sosial Ekonomi KK
                                                </button>
                                            </h2>
                                            <div id="kategoriC{{ $item->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionSensus{{ $item->id }}">
                                                <div class="accordion-body bg-white">
                                                    <div class="mb-2">
                                                        <label class="small fw-bold">Pendidikan Kepala Keluarga <span class="text-danger">*</span></label>
                                                        <select name="pendidikan_kk" class="form-select form-select-sm" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="SD / Tidak Sekolah">SD / Tidak Sekolah</option>
                                                            <option value="SMP/SMA">SMP/SMA</option>
                                                            <option value="Kuliah (D3/S1)">Kuliah (D3/S1)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="small fw-bold">Pekerjaan <span class="text-danger">*</span></label>
                                                        <select name="pekerjaan" class="form-select form-select-sm" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="Buruh Tani / Serabutan">Buruh Tani / Serabutan</option>
                                                            <option value="Karyawan Swasta / Pedagang Kecil">Karyawan Swasta / Pedagang Kecil</option>
                                                            <option value="PNS / TNI / POLRI">PNS / TNI / POLRI</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="small fw-bold">Jumlah Tanggungan <span class="text-danger">*</span></label>
                                                        <select name="jml_tanggungan" class="form-select form-select-sm" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="Banyak (> 3 anak/lansia)">Banyak (> 3 anak/lansia)</option>
                                                            <option value="Sedikit (1-2 orang)">Sedikit (1-2 orang)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="mb-2">
                                        <label class="small fw-bold">Unggah Bukti Observasi Lapangan (Opsional)</label>
                                        <input type="file" name="berkas_observasi" class="form-control form-control-sm border-secondary" accept=".pdf,.png,.jpg,.jpeg">
                                    </div>
                                    <div class="mb-3">
                                        <label class="small fw-bold">Catatan Petugas</label>
                                        <textarea name="catatan_observasi" class="form-control form-control-sm border-secondary" rows="2" placeholder="Tuliskan jika ada kendala di lapangan..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm"><i class="bi bi-calculator me-2"></i>Simpan Data & Hitung Skor Otomatis</button>
                                </form>

                            @elseif($item->status_verifikasi_admin == 'Menunggu Musdes')
                                <div class="alert alert-info small border-0 text-dark">Observasi dan Perhitungan Desil Selesai. Unggah Berita Acara Musdes untuk membuka kunci Keputusan Akhir.</div>
                                <form action="{{ route('verifikasi.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf @method('PUT') <input type="hidden" name="tahap" value="hasil_musdes">
                                    <div class="mb-3">
                                        <label class="small fw-bold">Unggah Berita Acara Musdes <span class="text-danger">*</span></label>
                                        <input type="file" name="berita_acara_musdes" class="form-control form-control-sm border-secondary" required>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100 fw-bold shadow-sm"><i class="bi bi-unlock-fill me-2"></i>Unggah & Buka Kunci Final</button>
                                </form>

                            @elseif($item->status_verifikasi_admin == 'Siap Keputusan')
                                <div class="alert alert-success small border-0 text-dark"><i class="bi bi-unlock-fill me-1"></i> Berkas lengkap. Kunci keputusan telah dibuka.</div>
                                <form action="{{ route('verifikasi.update', $item->id) }}" method="POST">
                                    @csrf @method('PUT') <input type="hidden" name="tahap" value="final">
                                    
                                    <div class="mb-3">
                                        <label class="small fw-bold">Jika Ditolak, beri alasan (Opsional):</label>
                                        <textarea name="keterangan_ditolak" class="form-control form-control-sm border-secondary" rows="2" placeholder="Isi jika forum Musdes memutuskan menolak data ini..."></textarea>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" name="status" value="Tidak Layak" class="btn btn-danger w-50 fw-bold shadow-sm" onclick="return confirm('Tolak pengajuan ini?')"><i class="bi bi-x-circle"></i> TOLAK</button>
                                        <button type="submit" name="status" value="Layak" class="btn btn-success w-50 fw-bold shadow-sm" onclick="return confirm('Setujui pengajuan ini?')"><i class="bi bi-check-circle"></i> SETUJUI</button>
                                    </div>
                                </form>

                            @else
                                <div class="alert alert-light text-center border shadow-sm rounded-4 mt-3 py-4">
                                    @if($item->status_verifikasi_admin == 'Layak')
                                        <i class="bi bi-shield-check display-4 text-success d-block mb-2"></i>
                                    @else
                                        <i class="bi bi-shield-x display-4 text-danger d-block mb-2"></i>
                                    @endif
                                    <h6 class="fw-bold text-dark">Tahapan Selesai</h6>
                                    <p class="small mb-0 text-muted">Status Akhir: <strong>{{ $item->status_verifikasi_admin }}</strong></p>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>