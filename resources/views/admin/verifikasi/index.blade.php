<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pengajuan - Kasi Kesejahteraan SI Bansos</title>
    
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
        
        .timeline-doc { border-left: 3px solid var(--warna-utama); padding-left: 15px; margin-bottom: 15px; }

        .table-breakdown thead { background: #f8fafc; }
        .category-header { background: #f1f5f9; font-weight: 700; color: var(--warna-paling-gelap); font-size: 0.75rem; text-transform: uppercase; }
        .subtotal-row { background: rgba(125, 136, 220, 0.1); font-weight: 700; font-size: 0.8rem; }

        .section-card { background: #fff; border: 1px solid #eef2ff; border-radius: 10px; padding: 12px; margin-bottom: 14px; }
        .section-title { font-size: 0.85rem; font-weight: 700; color: var(--warna-paling-gelap); margin-bottom: 8px; }
        
        /* ========================================================= */
        /* PERBAIKAN POIN 2: UKURAN THUMBNAIL DIPERBESAR & SERAGAM   */
        /* ========================================================= */
        .img-evidence, .gallery-thumb, .thumb-grid img { 
            width: 100% !important; 
            height: 150px !important; /* Jauh lebih besar dari sebelumnya */
            object-fit: cover !important; 
            border-radius: 8px !important; 
            border: 2px solid #e2e8f0 !important; 
            cursor: zoom-in !important; 
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out !important; 
        }
        .img-evidence:hover, .gallery-thumb:hover, .thumb-grid img:hover { 
            transform: translateY(-5px) scale(1.03) !important; 
            box-shadow: 0 8px 15px rgba(0,0,0,0.15) !important;
            border-color: var(--warna-utama) !important;
            z-index: 10;
            position: relative;
        }

        @media(min-width: 768px) {
            .img-evidence, .gallery-thumb, .thumb-grid img { height: 200px !important; } /* Sangat besar di Desktop */
        }

        .file-note { font-size: 0.78rem; color: #667085; }
        .accordion-button { padding: 0.5rem 1rem; font-size: 0.92rem; }
        .modal-body { max-height: calc(100vh - 230px); overflow: auto; }
        .control-aside { position: sticky; top: 20px; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <h5 class="fw-bold mb-4 px-2 py-2 border-bottom text-white" style="border-color: var(--warna-soft) !important;">
                <i class=""></i>KASI KESEJAHTERAAN
            </h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('admin.rt.index') }}" class="nav-link"><i class="bi bi-person-badge-fill"></i> Akun RT</a></li>
                <div class="sidebar-heading mt-3">Master Data</div>
                <li class="nav-item"><a href="{{ route('warga.index') }}" class="nav-link"><i class="bi bi-people-fill"></i> Data Warga</a></li>
                <li class="nav-item"><a href="{{ route('jenis-bansos.index') }}" class="nav-link"><i class="bi bi-gift-fill"></i> Jenis Bansos</a></li>
                <li class="nav-item"><a href="{{ route('admin.jadwal.index') }}" class="nav-link"><i class="bi bi-calendar-event"></i> Jadwal Tahapan</a></li>
                <div class="sidebar-heading mt-3">Transaksi</div>
                <li class="nav-item"><a href="{{ route('verifikasi.index') }}" class="nav-link active"><i class="bi bi-file-earmark-check-fill"></i> Verifikasi Pengajuan</a></li>
                <li class="nav-item"><a href="{{ route('penyaluran.index') }}" class="nav-link"><i class="bi bi-truck"></i> Penyaluran</a></li>
                <li class="nav-item mt-5">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link text-white w-100 text-start border-0 shadow-sm" style="background-color: #dc3545; border-radius: 8px;"><i class="bi bi-box-arrow-right"></i> Keluar</button>
                    </form>
                </li>
            </ul>
        </div>
        
        <div class="col-md-9 col-lg-10 p-4">
            <h4 class="fw-bold mb-4">Verifikasi Kelayakan Pengajuan</h4>

            <div class="d-flex gap-2 mb-3 flex-column flex-sm-row align-items-sm-center">
                <div class="input-group w-100 w-sm-50 me-auto">
                    <span class="input-group-text bg-white border-primary"><i class="bi bi-search"></i></span>
                    <input id="searchInput" type="search" class="form-control border-start-0" placeholder="Cari nama, NIK, atau jenis bansos...">
                </div>

                <select id="statusFilter" class="form-select w-auto">
                    <option value="">Semua Status</option>
                    <option value="Proses">Proses</option>
                    <option value="Verifikasi Lapangan">Verifikasi Lapangan</option>
                    <option value="Menunggu Musdes">Menunggu Musdes</option>
                    <option value="Siap Keputusan">Siap Keputusan</option>
                    <option value="Layak">Layak</option>
                    <option value="Tidak Layak">Tidak Layak</option>
                </select>

                <button class="btn btn-outline-primary" id="clearFilters"><i class=""></i> Reset</button>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive p-2">
                    <table id="verifTable" class="table table-custom table-hover align-middle mb-0">
                        <thead>
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
                                <td><span class="fw-bold fst-italic text-dark">{{ $item->jenisBansos->nama_bansos ?? '-' }}</span></td>
                                
                                <td>
                                    @php
                                        $desil = $item->warga->desil; 
                                        $labelDesil = is_null($desil) ? 'Belum Ditentukan' : 'Desil '.$desil;
                                        $teksDesil = is_null($desil) ? 'Menunggu' : ($desil == 1 ? 'Sangat Miskin' : ($desil == 2 ? 'Miskin' : ($desil == 3 ? 'Hampir Miskin' : 'Rentan/Mampu')));
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
                                    <span class="badge {{ $currentBadge[0] }} fw-semibold">{{ $currentBadge[1] }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-primary btn-sm px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id }}"><i class="bi bi-search me-1"></i> Review</button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada pengajuan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            @if($pengajuans->hasPages())
                <div class="mt-3">{{ $pengajuans->links() }}</div>
            @endif
        </div>
    </div>
</div>

@foreach($pengajuans as $item)
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
                            <div class="step-icon"><i class="bi bi-1-circle"></i></div><div class="step-label">Pengajuan RT</div>
                        </div>
                        <div class="step {{ in_array($s, ['Menunggu Musdes','Siap Keputusan','Layak','Tidak Layak']) ? 'completed' : ($s == 'Verifikasi Lapangan' ? 'active' : '') }}">
                            <div class="step-icon"><i class="bi bi-2-circle"></i></div><div class="step-label">Observasi Lapangan</div>
                        </div>
                        <div class="step {{ in_array($s, ['Siap Keputusan','Layak','Tidak Layak']) ? 'completed' : ($s == 'Menunggu Musdes' ? 'active' : '') }}">
                            <div class="step-icon"><i class="bi bi-3-circle"></i></div><div class="step-label">Musdes</div>
                        </div>
                        <div class="step {{ $s == 'Layak' ? 'completed' : ($s == 'Tidak Layak' ? 'rejected' : ($s == 'Siap Keputusan' ? 'active' : '')) }}">
                            <div class="step-icon"><i class="bi bi-check2-all"></i></div><div class="step-label">Finalisasi</div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-7 border-end">
                            <section class="section-card">
                                <div class="section-title"><i class="bi bi-person-lines-fill me-2 text-primary"></i>DATA PEMOHON</div>
                                <div class="row mb-2">
                                    <div class="col-6"><small class="text-muted d-block">Nama Lengkap</small><strong class="text-dark">{{ $item->warga->nama_lengkap }}</strong></div>
                                    <div class="col-6"><small class="text-muted d-block">NIK</small><strong class="text-dark">{{ $item->nik }}</strong></div>
                                </div>
                                <div class="mb-2"><small class="text-muted d-block">Alasan RT</small><div class="bg-light text-dark p-2 rounded border"><em>{{ $item->alasan_pengajuan }}</em></div></div>
                                @if($item->surveiEkonomi)
                                    <div class="alert py-2 my-2 small border bg-light text-dark d-flex justify-content-between align-items-center">
                                        <span><strong>Skor Kelayakan (PMT):</strong> {{ $item->surveiEkonomi->total_skor }} Poin</span>
                                        <button type="button" class="btn btn-sm btn-outline-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalRincianSkor{{ $item->id }}"><i class="bi bi-calculator-fill me-1"></i> Rincian</button>
                                    </div>
                                @endif

                                <div class="mb-2">
                                    @php
                                        $desil = $item->warga->desil;
                                        $teksDesil = is_null($desil) ? 'Menunggu Observasi' : ($desil == 1 ? 'Sangat Miskin' : ($desil == 2 ? 'Miskin' : ($desil == 3 ? 'Hampir Miskin' : 'Rentan Miskin')));
                                        $labelDesil = is_null($desil) ? 'Belum Ditentukan' : 'Desil '.$desil;
                                    @endphp
                                    <small class="text-muted d-block mb-1">Status Kategori Warga</small>
                                    <div class="fw-semibold">{{ $teksDesil }} <span class="text-muted">({{ $labelDesil }})</span></div>
                                </div>
                            </section>

                            <section class="section-card">
                                <div class="section-title"><i class="bi bi-camera-fill me-2 text-primary"></i> FOTO KONDISI RUMAH - BERKAS RT</div>
                                <div class="row g-3 text-center mb-0">
                                    <div class="col-6">
                                        <a href="#" data-src="{{ asset('storage/'.$item->foto_rumah_depan) }}" class="image-preview-link d-block">
                                            <img loading="lazy" src="{{ asset('storage/'.$item->foto_rumah_depan) }}" class="img-evidence gallery-thumb" alt="Foto Tampak Depan">
                                        </a>
                                        <small class="d-block mt-2 fw-bold text-muted">Tampak Depan</small>
                                    </div>
                                    <div class="col-6">
                                        @if($item->foto_rumah_dalam)
                                            <a href="#" data-src="{{ asset('storage/'.$item->foto_rumah_dalam) }}" class="image-preview-link d-block">
                                                <img loading="lazy" src="{{ asset('storage/'.$item->foto_rumah_dalam) }}" class="img-evidence gallery-thumb" alt="Foto Interior">
                                            </a>
                                            <small class="d-block mt-2 fw-bold text-muted">Interior / Dalam</small>
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center border text-muted small" style="height: 150px; border-radius: 8px;">Tanpa Foto Interior</div>
                                            <small class="d-block mt-2 fw-bold text-muted">Interior / Dalam</small>
                                        @endif
                                    </div>
                                </div>
                            </section>

                            @if($item->surveiEkonomi && $item->surveiEkonomi->foto_lantai)
                                @php $se = $item->surveiEkonomi; @endphp
                                <section class="section-card">
                                    <div class="section-title"><i class="bi bi-images me-2 text-primary"></i> BUKTI FOTO OBSERVASI LAPANGAN</div>
                                    <div class="bg-light p-3 rounded border thumb-grid">
                                        @php
                                            $bacaFoto = function($data) {
                                                if (empty($data)) return [];
                                                if (is_array($data)) return $data;
                                                $decode = json_decode($data, true);
                                                return is_array($decode) ? $decode : [];
                                            };
                                            $galeri = [
                                                'Kondisi Lantai' => $bacaFoto($se->foto_lantai),
                                                'Kondisi Dinding' => $bacaFoto($se->foto_dinding),
                                                'Sumber Air' => $bacaFoto($se->foto_sumber_air),
                                                'Kondisi WC/Toilet' => $bacaFoto($se->foto_wc_air ?? $se->foto_wc ?? null),
                                                'Meteran Listrik' => $bacaFoto($se->foto_listrik),
                                                'Kendaraan' => $bacaFoto($se->foto_kendaraan),
                                                'Elektronik' => $bacaFoto($se->foto_elektronik),
                                                'Ternak/Lahan' => $bacaFoto($se->foto_ternak),
                                            ];
                                        @endphp

                                        @foreach($galeri as $kategoriNama => $kumpulanFoto)
                                            @if(is_array($kumpulanFoto) && count($kumpulanFoto) > 0)
                                                <div class="mb-4">
                                                    <strong class="d-block text-dark mb-2 px-1 border-start border-3 border-primary ps-2">{{ $kategoriNama }}</strong>
                                                    <div class="row g-3">
                                                        @foreach($kumpulanFoto as $foto)
                                                            <div class="col-6 col-md-4 text-center">
                                                                <a href="#" data-src="{{ asset('storage/'.$foto) }}" class="d-block position-relative image-preview-link">
                                                                    <img loading="lazy" src="{{ asset('storage/'.$foto) }}" class="shadow-sm w-100 gallery-thumb" alt="Bukti {{ $kategoriNama }}">
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </section>
                            @endif

                            @if($item->berkas_observasi || $item->berita_acara_musdes)
                                <section class="section-card">
                                    <div class="section-title"><i class="bi bi-folder-check me-2 text-primary"></i> ARSIP DOKUMEN</div>
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
                                </section>
                            @endif
                        </div>

                        <div class="col-md-5 bg-light p-3 rounded border control-aside">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-sliders me-2"></i>PANEL KENDALI TAHAPAN</h6>
                            
                            @if($item->status_verifikasi_admin == 'Proses')
                                <div class="alert alert-secondary small text-dark border-0">Data pengajuan baru masuk. Silakan jadwalkan kapan tim desa akan melakukan observasi ke lapangan.</div>
                                <form action="{{ route('verifikasi.update', $item->id) }}" method="POST" class="needs-validation" novalidate>
                                    @csrf @method('PUT') <input type="hidden" name="tahap" value="jadwal_observasi">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Tentukan Tanggal Observasi <span class="text-danger">*</span></label>
                                        <input type="date" name="tgl_observasi" class="form-control border-secondary" required>
                                        <div class="invalid-feedback">Tanggal observasi wajib diisi!</div>
                                    </div>
                                    <button type="submit" class="btn btn-warning w-100 fw-bold shadow-sm"><i class="bi bi-cursor-fill me-2"></i>Jadwalkan Observasi Lapangan</button>
                                </form>
                            
                            @elseif($item->status_verifikasi_admin == 'Verifikasi Lapangan')
                                <div class="alert alert-warning small border-0 mb-3 text-dark"><i class="bi bi-info-circle me-1"></i> Isi Parameter BPS & Unggah Foto Bukti (Bisa Pilih Banyak Foto).</div>
                                <form action="{{ route('verifikasi.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation form-review" novalidate>
                                    @csrf @method('PUT') <input type="hidden" name="tahap" value="hasil_observasi">
                                    
                                    @php $se = $item->surveiEkonomi; @endphp
                                    
                                    <div class="accordion mb-3" id="accordionSensus{{ $item->id }}">
                                        
                                        <div class="accordion-item border-0 shadow-sm rounded mb-2">
                                            <h2 class="accordion-header"><button class="accordion-button fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#kategoriA{{ $item->id }}">Point A. Kondisi Hunian</button></h2>
                                            <div id="kategoriA{{ $item->id }}" class="accordion-collapse collapse show bg-white p-3" data-bs-parent="#accordionSensus{{ $item->id }}">
                                                
                                                <div class="mb-2">
                                                    <label class="small fw-bold">1. Luas Lantai <span class="text-danger">*</span></label>
                                                    <select name="luas_lantai" class="form-select form-select-sm border-secondary" required>
                                                        <option value="">-- Pilih --</option>
                                                        <option value="< 8 m² per orang" {{ ($se->luas_lantai ?? '') == '< 8 m² per orang' ? 'selected' : '' }}>< 8 m² per orang</option>
                                                        <option value="> 8 m² per orang" {{ ($se->luas_lantai ?? '') == '> 8 m² per orang' ? 'selected' : '' }}>> 8 m² per orang</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3 bg-light p-2 rounded border">
                                                    <label class="small fw-bold text-dark">Foto Kondisi Lantai (Bisa pilih banyak) <span class="text-danger">*</span></label>
                                                    <input type="file" name="foto_lantai[]" multiple class="form-control form-control-sm border-secondary" required accept="image/*">
                                                    <div class="invalid-feedback">Wajib diunggah!</div>
                                                </div>
                                                
                                                <div class="mb-2">
                                                    <label class="small fw-bold">2. Jenis Lantai <span class="text-danger">*</span></label>
                                                    <select name="jenis_lantai" class="form-select form-select-sm border-secondary" required>
                                                        <option value="">-- Pilih --</option>
                                                        <option value="Tanah / Bambu" {{ ($se->jenis_lantai ?? '') == 'Tanah / Bambu' ? 'selected' : '' }}>Tanah / Bambu</option>
                                                        <option value="Semen / Plester" {{ ($se->jenis_lantai ?? '') == 'Semen / Plester' ? 'selected' : '' }}>Semen / Plester</option>
                                                        <option value="Keramik / Marmer" {{ ($se->jenis_lantai ?? '') == 'Keramik / Marmer' ? 'selected' : '' }}>Keramik / Marmer</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="mb-2">
                                                    <label class="small fw-bold">3. Jenis Dinding <span class="text-danger">*</span></label>
                                                    <select name="jenis_dinding" class="form-select form-select-sm border-secondary" required>
                                                        <option value="">-- Pilih --</option>
                                                        <option value="Bilik Bambu / Kayu Murah" {{ ($se->jenis_dinding ?? '') == 'Bilik Bambu / Kayu Murah' ? 'selected' : '' }}>Bilik Bambu / Kayu Murah</option>
                                                        <option value="Tembok Tanpa Plester" {{ ($se->jenis_dinding ?? '') == 'Tembok Tanpa Plester' ? 'selected' : '' }}>Tembok Tanpa Plester</option>
                                                        <option value="Tembok Bagus / Semen" {{ ($se->jenis_dinding ?? '') == 'Tembok Bagus / Semen' ? 'selected' : '' }}>Tembok Bagus / Semen</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3 bg-light p-2 rounded border">
                                                    <label class="small fw-bold text-dark">Foto Kondisi Dinding (Bisa pilih banyak) <span class="text-danger">*</span></label>
                                                    <input type="file" name="foto_dinding[]" multiple class="form-control form-control-sm border-secondary" required accept="image/*">
                                                    <div class="invalid-feedback">Wajib diunggah!</div>
                                                </div>
                                                
                                                <div class="mb-2">
                                                    <label class="small fw-bold">4. Sumber Air <span class="text-danger">*</span></label>
                                                    <select name="sumber_air" class="form-select form-select-sm border-secondary" required>
                                                        <option value="">-- Pilih --</option>
                                                        <option value="Sungai / Mata Air" {{ ($se->sumber_air ?? '') == 'Sungai / Mata Air' ? 'selected' : '' }}>Sungai / Mata Air</option>
                                                        <option value="Sumur / Pompa" {{ ($se->sumber_air ?? '') == 'Sumur / Pompa' ? 'selected' : '' }}>Sumur / Pompa</option>
                                                        <option value="PDAM" {{ ($se->sumber_air ?? '') == 'PDAM' ? 'selected' : '' }}>PDAM</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3 bg-light p-2 rounded border">
                                                    <label class="small fw-bold text-dark">Foto Sumber Air (Bisa pilih banyak) <span class="text-danger">*</span></label>
                                                    <input type="file" name="foto_sumber_air[]" multiple class="form-control form-control-sm border-secondary" required accept="image/*">
                                                    <div class="invalid-feedback">Wajib diunggah!</div>
                                                </div>

                                                <div class="mb-3 bg-light p-2 rounded border">
                                                    <label class="small fw-bold text-dark">Foto Kondisi WC/Toilet (Bisa pilih banyak) <span class="text-danger">*</span></label>
                                                    <input type="file" name="foto_wc_air[]" multiple class="form-control form-control-sm border-secondary" required accept="image/*">
                                                    <div class="invalid-feedback">Wajib diunggah!</div>
                                                </div>
                                                
                                                <div class="mb-2">
                                                    <label class="small fw-bold">5. Daya Listrik <span class="text-danger">*</span></label>
                                                    <select name="daya_listrik" class="form-select form-select-sm border-secondary" required>
                                                        <option value="">-- Pilih --</option>
                                                        <option value="Tidak Pakai/Numpang" {{ ($se->daya_listrik ?? '') == 'Tidak Pakai/Numpang' ? 'selected' : '' }}>Tidak Pakai/Numpang</option>
                                                        <option value="450 Watt (Subsidi)" {{ ($se->daya_listrik ?? '') == '450 Watt (Subsidi)' ? 'selected' : '' }}>450 Watt (Subsidi)</option>
                                                        <option value="900 Watt (Subsidi)" {{ ($se->daya_listrik ?? '') == '900 Watt (Subsidi)' ? 'selected' : '' }}>900 Watt (Subsidi)</option>
                                                        <option value="900 Watt (Non-Subsidi) / 1300+" {{ ($se->daya_listrik ?? '') == '900 Watt (Non-Subsidi) / 1300+' ? 'selected' : '' }}>900 Watt (Non-Subsidi) / 1300+</option>
                                                    </select>
                                                </div>
                                                <div class="mb-2 bg-light p-2 rounded border">
                                                    <label class="small fw-bold text-dark">Foto Meteran Listrik (Bisa pilih banyak) <span class="text-danger">*</span></label>
                                                    <input type="file" name="foto_listrik[]" multiple class="form-control form-control-sm border-secondary" required accept="image/*">
                                                    <div class="invalid-feedback">Wajib diunggah!</div>
                                                </div>

                                            </div>
                                        </div>
                                        
                                        <div class="accordion-item border-0 shadow-sm rounded mb-2">
                                            <h2 class="accordion-header"><button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#kategoriB{{ $item->id }}">Point B. Kepemilikan Aset</button></h2>
                                            <div id="kategoriB{{ $item->id }}" class="accordion-collapse collapse bg-white p-3" data-bs-parent="#accordionSensus{{ $item->id }}">
                                                
                                                <div class="mb-2">
                                                    <label class="small fw-bold">6. Kendaraan <span class="text-danger">*</span></label>
                                                    <select name="kendaraan" class="form-select form-select-sm border-secondary" required>
                                                        <option value="">-- Pilih --</option>
                                                        <option value="Tidak punya" {{ ($se->kendaraan ?? '') == 'Tidak punya' ? 'selected' : '' }}>Tidak punya</option>
                                                        <option value="Sepeda / 1 Motor Butut" {{ ($se->kendaraan ?? '') == 'Sepeda / 1 Motor Butut' ? 'selected' : '' }}>Sepeda / 1 Motor Butut</option>
                                                        <option value="1 Motor Baru (Kredit/Lunas)" {{ ($se->kendaraan ?? '') == '1 Motor Baru (Kredit/Lunas)' ? 'selected' : '' }}>1 Motor Baru (Kredit/Lunas)</option>
                                                        <option value="Mobil" {{ ($se->kendaraan ?? '') == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3 bg-light p-2 rounded border">
                                                    <label class="small fw-bold text-dark">Foto Kendaraan (Bisa pilih banyak) <span class="text-danger">*</span></label>
                                                    <input type="file" name="foto_kendaraan[]" multiple class="form-control form-control-sm border-secondary" required accept="image/*">
                                                    <div class="invalid-feedback">Wajib diunggah!</div>
                                                </div>
                                                
                                                <div class="mb-2">
                                                    <label class="small fw-bold">7. Elektronik <span class="text-danger">*</span></label>
                                                    <select name="elektronik" class="form-select form-select-sm border-secondary" required>
                                                        <option value="">-- Pilih --</option>
                                                        <option value="Tidak ada Kulkas/TV" {{ ($se->elektronik ?? '') == 'Tidak ada Kulkas/TV' ? 'selected' : '' }}>Tidak ada Kulkas/TV</option>
                                                        <option value="Ada Kulkas / TV Tabung" {{ ($se->elektronik ?? '') == 'Ada Kulkas / TV Tabung' ? 'selected' : '' }}>Ada Kulkas / TV Tabung</option>
                                                        <option value="Ada AC / TV Layar Datar Besar" {{ ($se->elektronik ?? '') == 'Ada AC / TV Layar Datar Besar' ? 'selected' : '' }}>Ada AC / TV Layar Datar Besar</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3 bg-light p-2 rounded border">
                                                    <label class="small fw-bold text-dark">Foto Elektronik (Bisa pilih banyak) <span class="text-danger">*</span></label>
                                                    <input type="file" name="foto_elektronik[]" multiple class="form-control form-control-sm border-secondary" required accept="image/*">
                                                    <div class="invalid-feedback">Wajib diunggah!</div>
                                                </div>
                                                
                                                <div class="mb-2">
                                                    <label class="small fw-bold">8. Ternak/Lahan <span class="text-danger">*</span></label>
                                                    <select name="ternak_lahan" class="form-select form-select-sm border-secondary" required>
                                                        <option value="">-- Pilih --</option>
                                                        <option value="Tidak punya" {{ ($se->ternak_lahan ?? '') == 'Tidak punya' ? 'selected' : '' }}>Tidak punya</option>
                                                        <option value="Punya ternak kambing/sapi" {{ ($se->ternak_lahan ?? '') == 'Punya ternak kambing/sapi' ? 'selected' : '' }}>Punya ternak kambing/sapi</option>
                                                    </select>
                                                </div>
                                                <div class="mb-2 bg-light p-2 rounded border">
                                                    <label class="small fw-bold text-dark">Foto Ternak/Lahan (Bisa pilih banyak) <span class="text-danger">*</span></label>
                                                    <input type="file" name="foto_ternak[]" multiple class="form-control form-control-sm border-secondary" required accept="image/*">
                                                    <div class="invalid-feedback">Wajib diunggah!</div>
                                                </div>

                                            </div>
                                        </div>
                                        
                                        <div class="accordion-item border-0 shadow-sm rounded">
                                            <h2 class="accordion-header"><button class="accordion-button collapsed fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#kategoriC{{ $item->id }}">Point C. Sosial Ekonomi</button></h2>
                                            <div id="kategoriC{{ $item->id }}" class="accordion-collapse collapse bg-white p-3" data-bs-parent="#accordionSensus{{ $item->id }}">
                                                <div class="mb-2"><label class="small fw-bold">9. Pendidikan KK <span class="text-danger">*</span></label><select name="pendidikan_kk" class="form-select form-select-sm border-secondary" required><option value="">-- Pilih --</option><option value="SD / Tidak Sekolah" {{ ($se->pendidikan_kk ?? '') == 'SD / Tidak Sekolah' ? 'selected' : '' }}>SD / Tidak Sekolah</option><option value="SMP/SMA" {{ ($se->pendidikan_kk ?? '') == 'SMP/SMA' ? 'selected' : '' }}>SMP/SMA</option><option value="Kuliah (D3/S1)" {{ ($se->pendidikan_kk ?? '') == 'Kuliah (D3/S1)' ? 'selected' : '' }}>Kuliah (D3/S1)</option></select></div>
                                                <div class="mb-2"><label class="small fw-bold">10. Pekerjaan KK <span class="text-danger">*</span></label><select name="pekerjaan" class="form-select form-select-sm border-secondary" required><option value="">-- Pilih --</option><option value="Buruh Tani / Serabutan" {{ ($se->pekerjaan ?? '') == 'Buruh Tani / Serabutan' ? 'selected' : '' }}>Buruh Tani / Serabutan</option><option value="Karyawan Swasta / Pedagang Kecil" {{ ($se->pekerjaan ?? '') == 'Karyawan Swasta / Pedagang Kecil' ? 'selected' : '' }}>Karyawan Swasta / Pedagang Kecil</option><option value="PNS / TNI / POLRI" {{ ($se->pekerjaan ?? '') == 'PNS / TNI / POLRI' ? 'selected' : '' }}>PNS / TNI / POLRI</option></select></div>
                                                <div class="mb-2"><label class="small fw-bold">11. Jml Tanggungan <span class="text-danger">*</span></label><select name="jml_tanggungan" class="form-select form-select-sm border-secondary" required><option value="">-- Pilih --</option><option value="Banyak (> 3 anak/lansia)" {{ ($se->jml_tanggungan ?? '') == 'Banyak (> 3 anak/lansia)' ? 'selected' : '' }}>Banyak (> 3 anak/lansia)</option><option value="Sedikit (1-2 orang)" {{ ($se->jml_tanggungan ?? '') == 'Sedikit (1-2 orang)' ? 'selected' : '' }}>Sedikit (1-2 orang)</option></select></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3"><label class="small fw-bold">Catatan Hasil Observasi Lapangan</label><textarea name="catatan_observasi" class="form-control form-control-sm border-secondary" rows="2" placeholder="Masukkan catatan tambahan...">{{ $item->catatan_observasi ?? '' }}</textarea></div>
                                    <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm"><i class="bi bi-calculator me-2"></i>Simpan Sensus & Kalkulasi Skor</button>
                                </form>

                            @elseif($item->status_verifikasi_admin == 'Menunggu Musdes')
                                <div class="alert alert-info small border-0 text-dark">Observasi Selesai. Unggah Berita Acara Musdes untuk membuka kunci Final.</div>
                                <form action="{{ route('verifikasi.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                    @csrf @method('PUT') <input type="hidden" name="tahap" value="hasil_musdes">
                                    <div class="mb-3">
                                        <label class="small fw-bold">Berita Acara Musdes <span class="text-danger">*</span></label>
                                        <input type="file" name="berita_acara_musdes" class="form-control form-control-sm border-secondary" required>
                                        <div class="invalid-feedback">File Berita Acara Wajib Diunggah!</div>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100 fw-bold shadow-sm"><i class="bi bi-unlock-fill me-2"></i>Unggah & Buka Kunci Final</button>
                                </form>

                            @elseif($item->status_verifikasi_admin == 'Siap Keputusan')
                                <div class="alert alert-success small border-0 text-dark">Kunci keputusan terbuka.</div>
                                <form action="{{ route('verifikasi.update', $item->id) }}" method="POST" id="formFinal{{ $item->id }}">
                                    @csrf @method('PUT') <input type="hidden" name="tahap" value="final">
                                    <div class="mb-3">
                                        <label class="small text-danger fw-bold">Alasan Penolakan (Wajib diisi jika ditolak):</label>
                                        <textarea name="keterangan_ditolak" id="alasanTolak{{ $item->id }}" class="form-control form-control-sm border-secondary" rows="2" placeholder="Tulis alasan jika Anda memilih tombol Tolak..."></textarea>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-danger w-50 fw-bold shadow-sm" onclick="validasiTolak({{ $item->id }})"><i class="bi bi-x-circle"></i> TOLAK</button>
                                        <button type="button" class="btn btn-success w-50 fw-bold shadow-sm" onclick="konfirmasiSetuju({{ $item->id }})"><i class="bi bi-check-circle"></i> SETUJUI</button>
                                    </div>
                                </form>
                            @else
                                <div class="alert alert-light text-center border shadow-sm rounded-4 mt-3 py-4">
                                    <i class="bi {{ $item->status_verifikasi_admin == 'Layak' ? 'bi-shield-check text-success' : 'bi-shield-x text-danger' }} display-4 d-block mb-2"></i>
                                    <h6 class="fw-bold text-dark">Selesai</h6>
                                    <p class="small mb-0 text-muted">Status Akhir: <strong>{{ $item->status_verifikasi_admin }}</strong></p>
                                    @if($item->keterangan_ditolak)<p class="text-danger small mt-2">Alasan Penolakan: {{ $item->keterangan_ditolak }}</p>@endif
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($item->surveiEkonomi)
        @php
            $se = $item->surveiEkonomi;
            $s_luas = ($se->luas_lantai == '> 8 m² per orang') ? 10 : 0;
            $s_lantai = 0; if ($se->jenis_lantai == 'Semen / Plester') $s_lantai = 5; elseif ($se->jenis_lantai == 'Keramik / Marmer') $s_lantai = 15;
            $s_dinding = 0; if ($se->jenis_dinding == 'Tembok Tanpa Plester') $s_dinding = 5; elseif ($se->jenis_dinding == 'Tembok Bagus / Semen') $s_dinding = 10;
            $s_air = 0; if ($se->sumber_air == 'Sumur / Pompa') $s_air = 5; elseif ($se->sumber_air == 'PDAM') $s_air = 10;
            $s_listrik = 0; if ($se->daya_listrik == '900 Watt (Subsidi)') $s_listrik = 5; elseif ($se->daya_listrik == '900 Watt (Non-Subsidi) / 1300+') $s_listrik = 20;
            $subtotalA = $s_luas + $s_lantai + $s_dinding + $s_air + $s_listrik;

            $s_kendaraan = 0; if ($se->kendaraan == 'Sepeda / 1 Motor Butut') $s_kendaraan = 5; elseif ($se->kendaraan == '1 Motor Baru (Kredit/Lunas)') $s_kendaraan = 15; elseif ($se->kendaraan == 'Mobil') $s_kendaraan = 50;
            $s_elektronik = 0; if ($se->elektronik == 'Ada Kulkas / TV Tabung') $s_elektronik = 5; elseif ($se->elektronik == 'Ada AC / TV Layar Datar Besar') $s_elektronik = 15;
            $s_ternak = ($se->ternak_lahan == 'Punya ternak kambing/sapi') ? 10 : 0;
            $subtotalB = $s_kendaraan + $s_elektronik + $s_ternak;

            $s_pendidikan = 0; if ($se->pendidikan_kk == 'SMP/SMA') $s_pendidikan = 5; elseif ($se->pendidikan_kk == 'Kuliah (D3/S1)') $s_pendidikan = 15;
            $s_kerja = 0; if ($se->pekerjaan == 'Karyawan Swasta / Pedagang Kecil') $s_kerja = 10; elseif ($se->pekerjaan == 'PNS / TNI / POLRI') $s_kerja = 50;
            $s_tanggungan = ($se->jml_tanggungan == 'Banyak (> 3 anak/lansia)') ? -5 : 0;
            $subtotalC = $s_pendidikan + $s_kerja + $s_tanggungan;
        @endphp

        <div class="modal fade" id="modalRincianSkor{{ $item->id }}" tabindex="-1" style="z-index: 1060;">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-light border-bottom px-4">
                        <div>
                            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-receipt me-2 text-primary"></i>Rincian Parameter Skor Desil</h5>
                            <small class="text-muted">{{ $item->warga->nama_lengkap }}</small>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0">
                        <table class="table table-sm table-breakdown mb-0" style="font-size: 0.8rem;">
                            <thead>
                                <tr>
                                    <th class="ps-4 py-3">Parameter Penilaian</th>
                                    <th class="py-3">Nilai Input</th>
                                    <th class="text-center py-3" width="15%">Poin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="category-header"><td colspan="3" class="ps-4 py-2">Point A. Kondisi Hunian & Fasilitas</td></tr>
                                <tr><td class="ps-4 text-muted">Luas Lantai</td><td>{{ $se->luas_lantai ?? '-' }}</td><td class="text-center fw-bold text-danger">{{ $s_luas }}</td></tr>
                                <tr><td class="ps-4 text-muted">Jenis Lantai</td><td>{{ $se->jenis_lantai ?? '-' }}</td><td class="text-center fw-bold text-danger">{{ $s_lantai }}</td></tr>
                                <tr><td class="ps-4 text-muted">Jenis Dinding</td><td>{{ $se->jenis_dinding ?? '-' }}</td><td class="text-center fw-bold text-danger">{{ $s_dinding }}</td></tr>
                                <tr><td class="ps-4 text-muted">Sumber Air</td><td>{{ $se->sumber_air ?? '-' }}</td><td class="text-center fw-bold text-danger">{{ $s_air }}</td></tr>
                                <tr><td class="ps-4 text-muted">Daya Listrik</td><td>{{ $se->daya_listrik ?? '-' }}</td><td class="text-center fw-bold text-danger">{{ $s_listrik }}</td></tr>
                                <tr class="subtotal-row"><td colspan="2" class="ps-4 text-primary">Subtotal Point A</td><td class="text-center text-primary fs-6">{{ $subtotalA }}</td></tr>

                                <tr class="category-header"><td colspan="3" class="ps-4 py-2">Point B. Kepemilikan Aset</td></tr>
                                <tr><td class="ps-4 text-muted">Kendaraan</td><td>{{ $se->kendaraan ?? '-' }}</td><td class="text-center fw-bold text-danger">{{ $s_kendaraan }}</td></tr>
                                <tr><td class="ps-4 text-muted">Elektronik</td><td>{{ $se->elektronik ?? '-' }}</td><td class="text-center fw-bold text-danger">{{ $s_elektronik }}</td></tr>
                                <tr><td class="ps-4 text-muted">Ternak/Lahan</td><td>{{ $se->ternak_lahan ?? '-' }}</td><td class="text-center fw-bold text-danger">{{ $s_ternak }}</td></tr>
                                <tr class="subtotal-row"><td colspan="2" class="ps-4 text-primary">Subtotal Point B</td><td class="text-center text-primary fs-6">{{ $subtotalB }}</td></tr>

                                <tr class="category-header"><td colspan="3" class="ps-4 py-2">Point C. Sosial Ekonomi</td></tr>
                                <tr><td class="ps-4 text-muted">Pendidikan KK</td><td>{{ $se->pendidikan_kk ?? '-' }}</td><td class="text-center fw-bold text-danger">{{ $s_pendidikan }}</td></tr>
                                <tr><td class="ps-4 text-muted">Pekerjaan KK</td><td>{{ $se->pekerjaan ?? '-' }}</td><td class="text-center fw-bold text-danger">{{ $s_kerja }}</td></tr>
                                <tr><td class="ps-4 text-muted">Jml Tanggungan</td><td>{{ $se->jml_tanggungan ?? '-' }}</td><td class="text-center fw-bold text-danger">{{ $s_tanggungan }}</td></tr>
                                <tr class="subtotal-row"><td colspan="2" class="ps-4 text-primary">Subtotal Point C</td><td class="text-center text-primary fs-6">{{ $subtotalC }}</td></tr>
                            </tbody>
                            <tfoot class="bg-primary text-white">
                                <tr>
                                    <td colspan="2" class="ps-4 py-3 fw-bold text-end">TOTAL SKOR AKUMULASI KESELURUHAN :</td>
                                    <td class="text-center py-3 fw-bold fs-5">{{ $item->surveiEkonomi->total_skor }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function validasiTolak(id) {
        const alasan = document.getElementById('alasanTolak' + id).value.trim();
        if (alasan === '') {
            Swal.fire({
                icon: 'warning', title: 'Data Belum Lengkap!', text: 'Alasan Penolakan Wajib Diisi.',
                confirmButtonColor: '#dc3545', customClass: { popup: 'rounded-4 shadow-lg' }
            });
        } else {
            Swal.fire({
                title: 'Tolak pengajuan ini?', text: "Anda yakin ingin menolak pengajuan warga ini?",
                icon: 'question', showCancelButton: true, confirmButtonText: '<i class="bi bi-x-circle"></i> Ya, Tolak',
                cancelButtonText: 'Batal', confirmButtonColor: '#dc3545', cancelButtonColor: '#6c757d'
            }).then((result) => {
                if(result.isConfirmed) {
                    const form = document.getElementById('formFinal' + id);
                    const inputStatus = document.createElement('input');
                    inputStatus.type = 'hidden'; inputStatus.name = 'status'; inputStatus.value = 'Tidak Layak';
                    form.appendChild(inputStatus); form.submit();
                }
            });
        }
    }

    function konfirmasiSetuju(id) {
        Swal.fire({
            title: 'Setujui Pengajuan?', text: "Apakah Anda yakin warga ini layak menerima bantuan sosial?",
            icon: 'question', showCancelButton: true, confirmButtonColor: '#198754', cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-check-circle"></i> Ya, Setujui', cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-4 shadow-lg' }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('formFinal' + id);
                const inputStatus = document.createElement('input');
                inputStatus.type = 'hidden'; inputStatus.name = 'status'; inputStatus.value = 'Layak';
                form.appendChild(inputStatus); form.submit();
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        @if($errors->any())
            Swal.fire({
                icon: 'warning', title: 'Data Belum Lengkap!', text: '{{ $errors->first() }}',
                confirmButtonColor: '#dc3545', customClass: { popup: 'rounded-4 shadow-lg' }
            });
        @endif

        @if(session('success'))
            let pesan = "{!! session('success') !!}";
            if(pesan.includes('DISETUJUI')) {
                Swal.fire({
                    title: '<span class="text-success fw-bold">PENGAJUAN DISETUJUI! 🎉</span>',
                    html: `<div class="p-3 bg-success bg-opacity-10 rounded-3 border border-success border-opacity-25 mb-3 mt-2"><h6 class="text-success fw-bold mb-0">${pesan}</h6></div><p class="text-muted small mb-0">Selamat! Warga tersebut kini resmi disetujui untuk menerima bantuan.</p>`,
                    icon: 'success', confirmButtonText: '<i class="bi bi-hand-thumbs-up-fill me-1"></i> Selesai', confirmButtonColor: '#198754',
                    customClass: { popup: 'rounded-4 shadow-lg border-0' }
                });
            } else if(pesan.includes('DITOLAK')) {
                Swal.fire({
                    title: '<span class="text-danger fw-bold">PENGAJUAN DITOLAK ❌</span>', html: `<p class="text-muted mb-0">${pesan}</p>`,
                    icon: 'error', confirmButtonText: 'Tutup', confirmButtonColor: '#dc3545',
                    customClass: { popup: 'rounded-4 shadow-lg' }
                });
            } else {
                Swal.fire({
                    title: 'Berhasil!', text: pesan, icon: 'success', confirmButtonText: 'Tutup', confirmButtonColor: '#7D88DC',
                    customClass: { popup: 'rounded-4 shadow-lg' }
                });
            }
        @endif

        const formsValidate = document.querySelectorAll('.needs-validation');
        Array.from(formsValidate).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault(); event.stopPropagation();
                    const firstInvalid = form.querySelector(':invalid');
                    if (firstInvalid) {
                        const collapseParent = firstInvalid.closest('.accordion-collapse');
                        if (collapseParent && !collapseParent.classList.contains('show')) {
                            new bootstrap.Collapse(collapseParent, { toggle: false }).show();
                        }
                        Swal.fire({
                            icon: 'warning', title: 'Gagal Menyimpan!', text: 'Ada parameter BPS atau Bukti Foto Kategori yang belum diisi. Periksa bagian bergaris merah.',
                            confirmButtonColor: '#dc3545', confirmButtonText: '<i class="bi bi-pencil-square me-2"></i> Lengkapi Data'
                        });
                    }
                }
                form.classList.add('was-validated');
            }, false);
        });

        // Simple client-side search & status filter for quicker review
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const clearBtn = document.getElementById('clearFilters');
        const table = document.getElementById('verifTable');
        const rows = table ? Array.from(table.querySelectorAll('tbody tr')) : [];

        function applyFilters() {
            const q = (searchInput?.value || '').toLowerCase().trim();
            const status = statusFilter?.value || '';
            rows.forEach(row => {
                const text = (row.textContent || '').toLowerCase();
                const rowStatus = row.dataset.status || '';
                const matchQuery = q === '' || text.includes(q);
                const matchStatus = status === '' || rowStatus === status;
                row.style.display = (matchQuery && matchStatus) ? '' : 'none';
            });
        }

        let debounce;
        if (searchInput) searchInput.addEventListener('input', () => { clearTimeout(debounce); debounce = setTimeout(applyFilters, 200); });
        if (statusFilter) statusFilter.addEventListener('change', applyFilters);
        if (clearBtn) clearBtn.addEventListener('click', () => { if (searchInput) searchInput.value=''; if (statusFilter) statusFilter.value=''; applyFilters(); });
    });
</script>

<div class="modal fade" id="imagePreviewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 position-relative text-center">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3 bg-white rounded-circle shadow" data-bs-dismiss="modal" aria-label="Close" style="z-index: 1050; padding: 10px;"></button>
                <div class="d-flex align-items-center justify-content-center p-2 bg-dark bg-opacity-75 rounded-3">
                    <img id="previewImage" src="" alt="Preview" class="rounded shadow-lg" style="width: 100%; height: 85vh; object-fit: contain;">
                </div>
                <div id="previewCaption" class="text-center mt-3 text-white fw-bold fs-5 text-shadow"></div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const modalEl = document.getElementById('imagePreviewModal');
        const previewImage = document.getElementById('previewImage');
        const previewCaption = document.getElementById('previewCaption');
        const bsModal = new bootstrap.Modal(modalEl);

        document.querySelectorAll('.image-preview-link').forEach(link => {
            link.addEventListener('click', function(e){
                e.preventDefault();
                const src = this.dataset.src || this.querySelector('img')?.src;
                const alt = this.querySelector('img')?.alt || '';
                if (src) {
                    previewImage.src = src;
                    previewCaption.textContent = alt;
                    bsModal.show();
                }
            });
        });
    });
</script>
</body>
</html>