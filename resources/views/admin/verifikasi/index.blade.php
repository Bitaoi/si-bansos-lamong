<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pengajuan - Admin SI Bansos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f3f4f6; font-family: sans-serif; }
        .sidebar { min-height: 100vh; background: #1e293b; color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; }
        .nav-link:hover, .nav-link.active { background: #0d6efd; color: white; }
        .nav-link i { width: 24px; display: inline-block; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; padding: 10px 20px; letter-spacing: 0.5px; }
        
        /* Table & Badge */
        .table-custom thead th { background-color: #f8fafc; color: #64748b; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; border-bottom: 2px solid #e2e8f0; }
        .table-custom tbody td { vertical-align: middle; padding: 1rem 0.75rem; font-size: 0.95rem; }
        .badge-status { padding: 6px 12px; border-radius: 50px; font-weight: 600; font-size: 0.75rem; }
        
        /* Modal Photo */
        .img-evidence { width: 100%; height: 200px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; }
        .checklist-item { background: #f8f9fa; padding: 8px 12px; border-radius: 6px; margin-bottom: 5px; font-size: 0.9rem; border-left: 4px solid #0d6efd; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <h5 class="fw-bold mb-4 px-2 py-2 border-bottom border-secondary text-white">
                <i class="bi bi-shield-lock-fill me-2"></i>ADMIN PANEL
            </h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                <div class="sidebar-heading mt-3">Master Data</div>
                <li class="nav-item"><a href="{{ route('warga.index') }}" class="nav-link"><i class="bi bi-people-fill"></i> Data Warga</a></li>
                <li class="nav-item"><a href="{{ route('jenis-bansos.index') }}" class="nav-link"><i class="bi bi-gift-fill"></i> Jenis Bansos</a></li>
                <div class="sidebar-heading mt-3">Transaksi</div>
                <li class="nav-item"><a href="{{ route('verifikasi.index') }}" class="nav-link active"><i class="bi bi-file-earmark-check-fill"></i> Verifikasi Pengajuan</a></li>
                <li class="nav-item mt-5">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="nav-link bg-danger text-white w-100 text-start border-0"><i class="bi bi-box-arrow-right"></i> Keluar</button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Verifikasi Pengajuan</h4>
                    <p class="text-muted mb-0">Tinjau usulan bantuan dari RT sebelum disalurkan.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Tgl Pengajuan</th>
                                    <th>Nama Warga (NIK)</th>
                                    <th>Jenis Bansos</th>
                                    <th>Pengusul (RT)</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuans as $item)
                                <tr>
                                    <td class="ps-4 text-muted small">{{ \Carbon\Carbon::parse($item->tgl_pengajuan)->format('d M Y') }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $item->warga->nama_lengkap ?? '-' }}</div>
                                        <small class="text-muted">{{ $item->nik }}</small>
                                    </td>
                                    <td><span class="badge bg-light text-primary border">{{ $item->jenisBansos->nama_bansos ?? '-' }}</span></td>
                                    <td>
                                        <div class="small fw-bold">{{ $item->pengusul->nama_lengkap ?? '-' }}</div>
                                        <small class="text-muted">Wilayah: {{ $item->pengusul->wilayah_rt_rw ?? '-' }}</small>
                                    </td>
                                    <td>
                                        @if($item->status_verifikasi_admin == 'Proses')
                                            <span class="badge bg-warning text-dark badge-status"><i class="bi bi-hourglass-split"></i> Menunggu Review</span>
                                        @elseif($item->status_verifikasi_admin == 'Layak')
                                            <span class="badge bg-success badge-status"><i class="bi bi-check-circle"></i> Disetujui</span>
                                        @else
                                            <span class="badge bg-danger badge-status"><i class="bi bi-x-circle"></i> Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-primary btn-sm px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id }}">
                                            <i class="bi bi-eye-fill me-1"></i> Detail & Aksi
                                        </button>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title fw-bold">Detail Pengajuan #{{ $item->id }}</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                
                                                <div class="row g-4">
                                                    <div class="col-md-6 border-end">
                                                        <h6 class="fw-bold text-primary mb-3">DATA PEMOHON</h6>
                                                        <table class="table table-sm table-borderless">
                                                            <tr><td class="text-muted">Nama:</td><td class="fw-bold">{{ $item->warga->nama_lengkap }}</td></tr>
                                                            <tr><td class="text-muted">NIK:</td><td>{{ $item->nik }}</td></tr>
                                                            <tr><td class="text-muted">Alamat:</td><td>{{ $item->warga->alamat_lengkap }}</td></tr>
                                                            <tr><td class="text-muted">Estimasi Pendapatan:</td><td class="fw-bold text-success">Rp {{ number_format($item->estimasi_penghasilan, 0, ',', '.') }}</td></tr>
                                                        </table>

                                                        <h6 class="fw-bold text-primary mb-3 mt-4">ALASAN & KRITERIA</h6>
                                                        <div class="bg-light p-3 rounded mb-3 border">
                                                            <i class="bi bi-quote text-secondary me-2"></i>
                                                            <em>{{ $item->alasan_pengajuan }}</em>
                                                        </div>
                                                        
                                                        @if($item->checklist_kriteria && is_array($item->checklist_kriteria))
                                                            @foreach($item->checklist_kriteria as $kriteria)
                                                                <div class="checklist-item">{{ $kriteria }}</div>
                                                            @endforeach
                                                        @elseif($item->checklist_kriteria && is_string($item->checklist_kriteria))
                                                            <div class="checklist-item">{{ $item->checklist_kriteria }}</div>
                                                        @else
                                                            <small class="text-muted">- Tidak ada checklist -</small>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold text-primary mb-3">BUKTI FISIK</h6>
                                                        <div class="mb-3">
                                                            <label class="small text-muted mb-1">Foto KTP & KK</label>
                                                            <img src="{{ asset('storage/'.$item->foto_ktp_kk) }}" class="img-evidence" alt="KTP">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <label class="small text-muted mb-1">Rumah Depan</label>
                                                                <img src="{{ asset('storage/'.$item->foto_rumah_depan) }}" class="img-evidence" alt="Rumah">
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="small text-muted mb-1">Rumah Dalam</label>
                                                                @if($item->foto_rumah_dalam)
                                                                    <img src="{{ asset('storage/'.$item->foto_rumah_dalam) }}" class="img-evidence" alt="Dalam">
                                                                @else
                                                                    <div class="bg-light border rounded h-100 d-flex align-items-center justify-content-center text-muted small">Tidak ada foto</div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer bg-light justify-content-between">
                                                <div class="text-muted small fst-italic">
                                                    Diajukan oleh: {{ $item->pengusul->nama_lengkap }} ({{ \Carbon\Carbon::parse($item->tgl_pengajuan)->diffForHumans() }})
                                                </div>

                                                @if($item->status_verifikasi_admin == 'Proses')
                                                    <div class="d-flex gap-2">
                                                        <form action="{{ route('verifikasi.update', $item->id) }}" method="POST">
                                                            @csrf @method('PUT')
                                                            <input type="hidden" name="status" value="Tidak Layak">
                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin MENOLAK pengajuan ini?')">
                                                                <i class="bi bi-x-circle me-1"></i> TOLAK (Tidak Layak)
                                                            </button>
                                                        </form>
                                                        
                                                        <form action="{{ route('verifikasi.update', $item->id) }}" method="POST">
                                                            @csrf @method('PUT')
                                                            <input type="hidden" name="status" value="Layak">
                                                            <button type="submit" class="btn btn-success" onclick="return confirm('Yakin data valid dan DISETUJUI?')">
                                                                <i class="bi bi-check-circle me-1"></i> SETUJUI (Layak)
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <button class="btn btn-secondary" disabled>Sudah Diverifikasi</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                        Belum ada pengajuan masuk.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($pengajuans->hasPages())
                    <div class="card-footer bg-white py-3">
                        {{ $pengajuans->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>