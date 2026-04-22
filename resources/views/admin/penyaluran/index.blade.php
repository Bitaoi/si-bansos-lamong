<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penyaluran Bansos - Admin SI Bansos</title>
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

        body { background-color: var(--warna-background) !important; color: var(--warna-paling-gelap); font-family: sans-serif; }
        .text-primary { color: var(--warna-utama) !important; }
        .bg-primary { background-color: var(--warna-utama) !important; color: #ffffff !important; }
        .border-primary { border-color: var(--warna-utama) !important; }
        .btn-primary { background-color: var(--warna-utama) !important; border-color: var(--warna-utama) !important; color: #ffffff !important; box-shadow: 0 4px 6px rgba(125, 136, 220, 0.2); }
        .btn-primary:hover { background-color: var(--warna-paling-gelap) !important; border-color: var(--warna-paling-gelap) !important; color: #ffffff !important; }
        
        .sidebar { min-height: 100vh; background: var(--warna-paling-gelap); color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: var(--warna-utama); color: white; }
        .nav-link i { width: 24px; display: inline-block; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: var(--warna-soft); font-weight: 700; padding: 10px 20px; letter-spacing: 0.5px; opacity: 0.8; }

        .card { border: 1px solid var(--warna-soft) !important; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .table-custom thead th { background-color: var(--warna-soft); color: var(--warna-paling-gelap); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; border-bottom: 2px solid var(--warna-utama); }
        .table-custom tbody td { vertical-align: middle; border-bottom: 1px solid #f1f5f9; padding: 1rem 0.75rem; }
        
        .nav-tabs .nav-link { color: var(--warna-paling-gelap); font-weight: bold; border-radius: 10px 10px 0 0; }
        .nav-tabs .nav-link.active { color: var(--warna-utama); border-color: var(--warna-soft) var(--warna-soft) white; }
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
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('admin.rt.index') }}" class="nav-link"><i class="bi bi-person-badge-fill"></i> Manajemen Akun RT</a></li>
                <div class="sidebar-heading mt-3">Master Data</div>
                <li class="nav-item"><a href="{{ route('warga.index') }}" class="nav-link"><i class="bi bi-people-fill"></i> Data Warga</a></li>
                <li class="nav-item"><a href="{{ route('jenis-bansos.index') }}" class="nav-link"><i class="bi bi-gift-fill"></i> Jenis Bansos</a></li>
                <div class="sidebar-heading mt-3">Transaksi</div>
                <li class="nav-item"><a href="{{ route('verifikasi.index') }}" class="nav-link"><i class="bi bi-file-earmark-check-fill"></i> Verifikasi Pengajuan</a></li>
                <li class="nav-item"><a href="{{ route('penyaluran.index') }}" class="nav-link active"><i class="bi bi-truck"></i> Penyaluran</a></li>
                <li class="nav-item mt-5">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf <button class="nav-link text-white w-100 text-start border-0 shadow-sm" style="background-color: #dc3545;"><i class="bi bi-box-arrow-right"></i> Keluar</button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Penyaluran Bantuan</h4>
                    <p class="text-muted mb-0">Catat bukti serah terima bansos kepada warga yang telah disetujui.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
            @endif

            <ul class="nav nav-tabs border-bottom-0 mb-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active px-4 py-3" id="antrean-tab" data-bs-toggle="tab" data-bs-target="#antrean" type="button" role="tab">
                        <i class="bi"></i>Antrean Penyaluran <span class="badge bg-danger ms-2 rounded-pill">{{ $antrean->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-4 py-3" id="riwayat-tab" data-bs-toggle="tab" data-bs-target="#riwayat" type="button" role="tab">
                        <i class="bi"></i>Riwayat Disalurkan
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                
                <div class="tab-pane fade show active" id="antrean" role="tabpanel">
                    <div class="card border-0 shadow-sm bg-white overflow-hidden rounded-4 border-top-0" style="border-top-left-radius: 0;">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-custom table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">Tgl Persetujuan</th>
                                            <th>Nama Warga</th>
                                            <th>Jenis Bansos</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-end pe-4">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($antrean as $item)
                                        <tr>
                                            <td class="ps-4 small text-muted">{{ $item->updated_at->format('d M Y') }}</td>
                                            <td class="fw-bold">{{ $item->warga->nama_lengkap ?? '-' }}</td>
                                            <td><span class="badge" style="background-color: var(--warna-soft); color: var(--warna-paling-gelap);">{{ $item->jenisBansos->nama_bansos ?? '-' }}</span></td>
                                            <td class="text-center"><span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i> Menunggu Diambil</span></td>
                                            <td class="text-end pe-4">
                                                <button class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalSalur{{ $item->id }}">
                                                    <i class="bi bi-box-seam me-1"></i> Input Penyaluran
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="5" class="text-center py-5 text-muted"><i class="bi bi-emoji-smile fs-1 d-block mb-3 opacity-25"></i>Semua antrean telah disalurkan!</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="riwayat" role="tabpanel">
                    <div class="card border-0 shadow-sm bg-white overflow-hidden rounded-4 border-top-0" style="border-top-left-radius: 0;">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-custom table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">Tgl Diterima</th>
                                            <th>Penerima</th>
                                            <th>Bansos</th>
                                            <th>Bukti Foto</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($riwayat as $row)
                                        <tr>
                                            <td class="ps-4 small text-muted"><i class="bi bi-calendar-check me-1 text-success"></i> {{ $row->tgl_terima->format('d M Y') }}</td>
                                            <td class="fw-bold text-dark">{{ $row->pengajuan->warga->nama_lengkap ?? '-' }}</td>
                                            <td><span class="badge border bg-light text-dark">{{ $row->pengajuan->jenisBansos->nama_bansos ?? '-' }}</span></td>
                                            <td>
                                                <a href="{{ asset('storage/'.$row->foto_bukti) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-image me-1"></i> Lihat
                                                </a>
                                            </td>
                                            <td class="small text-muted">{{ $row->keterangan ?? '-' }}</td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="5" class="text-center py-5 text-muted"><i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>Belum ada data penyaluran.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@foreach($antrean as $item)
<div class="modal fade" id="modalSalur{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:none; border-radius:15px; overflow:hidden;">
            <div class="modal-header text-white" style="background-color: var(--warna-paling-gelap);">
                <h5 class="modal-title fw-bold"><i class="bi bi-box-seam me-2"></i>Form Penyaluran Bansos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('penyaluran.store', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4 text-start">
                    
                    <div class="alert py-2 mb-4 d-flex align-items-center border-0" style="background-color: var(--warna-soft);">
                        <i class="bi bi-person-check fs-3 me-3 text-dark"></i>
                        <div>
                            <strong class="d-block text-dark">{{ $item->warga->nama_lengkap }}</strong>
                            <small class="text-dark">{{ $item->jenisBansos->nama_bansos }}</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tanggal Serah Terima <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_terima" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Upload Foto Bukti Penerimaan <span class="text-danger">*</span></label>
                        <input type="file" name="foto_bukti" class="form-control" accept="image/*" required>
                        <small class="text-muted" style="font-size: 0.7rem;">Wajib foto warga memegang bantuan/uang tunai (Max 2MB).</small>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small fw-bold">Keterangan Tambahan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Misal: Diambil oleh anggota keluarga (istri) karena pemohon sakit..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan Bukti</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>