<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Periode Bansos - Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root { --warna-paling-gelap: #2C3E50; --warna-utama: #7D88DC; --warna-soft: #BBD0EC; --warna-background: #FEFCFB; }
        body { background-color: var(--warna-background) !important; color: var(--warna-paling-gelap); font-family: 'Poppins', sans-serif !important; }
        .text-primary { color: var(--warna-utama) !important; }
        .bg-primary { background-color: var(--warna-utama) !important; color: #ffffff !important; }
        .btn-primary { background-color: var(--warna-utama) !important; border-color: var(--warna-utama) !important; color: #ffffff !important; box-shadow: 0 4px 6px rgba(125, 136, 220, 0.2); }
        .btn-primary:hover { background-color: var(--warna-paling-gelap) !important; border-color: var(--warna-paling-gelap) !important; color: #ffffff !important; }
        .sidebar { min-height: 100vh; background: var(--warna-paling-gelap); color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: var(--warna-utama); color: white; }
        .nav-link i { width: 24px; display: inline-block; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: var(--warna-soft); font-weight: 700; padding: 10px 20px; opacity: 0.8; }
        .table-custom thead th { background-color: var(--warna-soft); color: var(--warna-paling-gelap); font-weight: 600; font-size: 0.85rem; border-bottom: 2px solid var(--warna-utama); text-transform: uppercase; }
        .table-custom tbody td { vertical-align: middle; padding: 1rem 0.75rem; border-bottom: 1px solid #f1f5f9; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <h5 class="fw-bold mb-4 px-2 py-2 border-bottom border-secondary text-white">KASI KESEJAHTERAAN</h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('admin.rt.index') }}" class="nav-link"><i class="bi bi-person-badge-fill"></i> Akun RT</a></li>
                
                <div class="sidebar-heading mt-3">Data Warga</div>
                <li class="nav-item"><a href="{{ route('warga.index') }}" class="nav-link"><i class="bi bi-people-fill"></i> Data Warga</a></li>
                <li class="nav-item"><a href="{{ route('jenis-bansos.index') }}" class="nav-link"><i class="bi bi-gift-fill"></i> Jenis Bansos</a></li>
                <li class="nav-item"><a href="{{ route('admin.jadwal.index') }}" class="nav-link"><i class="bi bi-calendar-event"></i> Jadwal Tahapan</a></li>
                <li class="nav-item"><a href="{{ route('admin.periode.index') }}" class="nav-link active"><i class="bi bi-calendar-range-fill"></i> Periode Bansos</a></li>
                
                <div class="sidebar-heading mt-3">Transaksi</div>
                <li class="nav-item"><a href="{{ route('verifikasi.index') }}" class="nav-link"><i class="bi bi-file-earmark-check-fill"></i> Verifikasi</a></li>
                <li class="nav-item"><a href="{{ route('penyaluran.index') }}" class="nav-link"><i class="bi bi-truck"></i> Penyaluran</a></li>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-0">Manajemen Periode Bantuan</h3>
                    <p class="text-muted small">Kelola masa berlaku pengajuan dan alokasi bantuan per periode.</p>
                </div>
                <button class="btn btn-primary fw-bold shadow-sm rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-circle me-2"></i> Buat Periode Baru
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0"><i class="bi bi-exclamation-triangle-fill me-2"></i>Terdapat kesalahan pengisian form. <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif

            <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--warna-soft) !important;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Nama Periode</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Berakhir</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($periodes as $p)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">{{ $p->nama_periode }}</td>
                                    <td>{{ \Carbon\Carbon::parse($p->tanggal_mulai)->translatedFormat('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($p->tanggal_akhir)->translatedFormat('d M Y') }}</td>
                                    <td>
                                        @if($p->status == 'Aktif')
                                            <span class="badge bg-success bg-opacity-10 border border-success text-success px-3 py-2 rounded-pill"><i class="bi bi-record-circle-fill me-1"></i> Aktif Berjalan</span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 border border-secondary text-secondary px-3 py-2 rounded-pill"><i class="bi bi-door-closed-fill me-1"></i> Ditutup</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <button type="button" class="btn btn-sm btn-outline-info rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalInfoKuota{{ $p->id }}" title="Lihat Distribusi Kuota RT">
                                            <i class="bi bi-pie-chart-fill"></i>
                                        </button>
                                        
                                        <button class="btn btn-sm btn-outline-primary rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $p->id }}"><i class="bi bi-pencil-square"></i></button>
                                        <form action="{{ route('admin.periode.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus periode ini secara permanen? Data pengajuan yang terikat mungkin akan terdampak.');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger rounded-pill fw-bold"><i class="bi bi-trash3-fill"></i></button>
                                        </form>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalInfoKuota{{ $p->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-4 text-dark">
                                            <div class="modal-header border-bottom-0 pb-0">
                                                <h5 class="fw-bold"><i class="bi bi-pie-chart-fill text-info me-2"></i>Distribusi Kuota RT ({{ $p->nama_periode }})</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="table-responsive border rounded-3">
                                                    <table class="table table-hover align-middle mb-0 text-center">
                                                        <thead class="table-light small text-secondary">
                                                            <tr>
                                                                <th>Program Bansos</th>
                                                                <th>Wilayah (RT/RW)</th>
                                                                <th>Kuota Utama Dibagikan</th>
                                                                <th>Sisa Kuota Belum Dipakai</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $kuotaPeriodeIni = isset($kuotaWilayahs) ? $kuotaWilayahs->where('id_periode', $p->id) : collect();
                                                            @endphp
                                                            @forelse($kuotaPeriodeIni as $k)
                                                            <tr>
                                                                <td class="fw-bold text-start ps-3">{{ $k->jenisBansos->nama_bansos ?? '-' }}</td>
                                                                <td>{{ $k->rt }} / {{ $k->rw }}</td>
                                                                <td><span class="badge bg-primary rounded-pill px-3">{{ $k->kuota }} KPM</span></td>
                                                                <td><span class="badge bg-success rounded-pill px-3">{{ $k->kuota - $k->terpakai }} KPM</span></td>
                                                            </tr>
                                                            @empty
                                                            <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada kuota RT yang dibagikan untuk periode ini.</td></tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top-0 pt-0 pb-4 pe-4">
                                                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modalEdit{{ $p->id }}" tabindex="-1">                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-4 text-dark">
                                            <div class="modal-header border-bottom-0 pb-0">
                                                <h5 class="fw-bold"><i class="bi bi-pencil-square text-primary me-2"></i>Edit Periode</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.periode.update', $p->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-body p-4">
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Nama Periode</label>
                                                        <input type="text" name="nama_periode" class="form-control" value="{{ $p->nama_periode }}" required>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label small fw-bold">Tgl Mulai</label>
                                                            <input type="date" name="tanggal_mulai" class="form-control" value="{{ $p->tanggal_mulai }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label small fw-bold">Tgl Akhir</label>
                                                            <input type="date" name="tanggal_akhir" class="form-control" value="{{ $p->tanggal_akhir }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold">Status Periode</label>
                                                        <select name="status" class="form-select">
                                                            <option value="Aktif" {{ $p->status == 'Aktif' ? 'selected' : '' }}>Aktif Berjalan</option>
                                                            <option value="Tutup" {{ $p->status == 'Tutup' ? 'selected' : '' }}>Ditutup</option>
                                                        </select>
                                                        <small class="text-danger d-block mt-2">*Perhatian: Jika diset Aktif, periode lain akan otomatis dinonaktifkan (Ditutup).</small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top-0 pt-0 pb-4 pe-4">
                                                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data periode yang dibuat.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 text-dark">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="fw-bold"><i class="bi bi-plus-circle text-primary me-2"></i>Buat Periode Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.periode.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Periode</label>
                        <input type="text" name="nama_periode" class="form-control" placeholder="Cth: Tahap 1 - Bulan Januari 2026" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Tanggal Berakhir</label>
                            <input type="date" name="tanggal_akhir" class="form-control" required>
                        </div>
                    </div>
                    <div class="alert alert-info border-0 p-3 small mb-0 mt-2 rounded-3">
                        <i class="bi bi-info-circle-fill me-1"></i> Periode baru yang ditambahkan akan <b>otomatis menjadi periode Aktif</b>, dan periode sebelumnya akan otomatis ditutup.
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 pb-4 pe-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Buat Periode</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>