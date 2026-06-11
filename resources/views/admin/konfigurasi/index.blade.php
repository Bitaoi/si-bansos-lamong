<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Konfigurasi - Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root { --warna-paling-gelap: #2C3E50; --warna-utama: #7D88DC; --warna-soft: #BBD0EC; --warna-background: #FEFCFB; }
        body { background-color: var(--warna-background) !important; color: var(--warna-paling-gelap); font-family: 'Poppins', sans-serif !important; }
        .text-primary { color: var(--warna-utama) !important; }
        .bg-primary { background-color: var(--warna-utama) !important; color: #ffffff !important; }
        .btn-primary { background-color: var(--warna-utama) !important; border-color: var(--warna-utama) !important; color: #ffffff !important; }
        .btn-primary:hover { background-color: var(--warna-paling-gelap) !important; }
        .sidebar { min-height: 100vh; background: var(--warna-paling-gelap); color: white; }
        .nav-link-sidebar { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; text-decoration: none; display: block; }
        .nav-link-sidebar:hover, .nav-link-sidebar.active { background: var(--warna-utama); color: white; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: var(--warna-soft); font-weight: 700; padding: 10px 20px; opacity: 0.8; }
        
        /* Custom Tabs Styling */
        .nav-tabs .nav-link { color: #6c757d; font-weight: 600; border: none; border-bottom: 3px solid transparent; padding: 12px 25px; transition: 0.3s; }
        .nav-tabs .nav-link:hover { border-color: var(--warna-soft); color: var(--warna-utama); }
        .nav-tabs .nav-link.active { color: var(--warna-utama); border-color: var(--warna-utama); background-color: transparent; }
        .table-custom thead th { background-color: var(--warna-soft); color: var(--warna-paling-gelap); font-weight: 600; font-size: 0.85rem; border-bottom: 2px solid var(--warna-utama); text-transform: uppercase; }
        .table-custom tbody td { vertical-align: middle; padding: 1rem 0.75rem; border-bottom: 1px solid #f1f5f9; }
        
        /* Form Label Custom */
        .form-label { font-size: 0.85rem; font-weight: 600; color: var(--warna-paling-gelap); }
        .section-title { font-size: 0.95rem; font-weight: 700; color: var(--warna-utama); margin-bottom: 15px; border-bottom: 1px dashed #e2e8f0; padding-bottom: 10px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <h5 class="fw-bold mb-4 px-2 py-2 border-bottom border-secondary text-white">KASI KESEJAHTERAAN</h5>
            <div class="nav flex-column">
                <a href="{{ route('admin.dashboard') }}" class="nav-link-sidebar"><i class="bi bi-grid-fill me-2"></i> Dashboard</a>
                <a href="{{ route('admin.rt.index') }}" class="nav-link-sidebar"><i class="bi bi-person-badge-fill me-2"></i> Akun RT</a>
                
                <div class="sidebar-heading mt-3">Data Warga</div>
                <a href="{{ route('warga.index') }}" class="nav-link-sidebar"><i class="bi bi-people-fill me-2"></i> Data Warga</a>
                
                <div class="sidebar-heading mt-3">Pengaturan Master</div>
                <a href="{{ route('admin.konfigurasi') }}" class="nav-link-sidebar active"><i class="bi bi-sliders me-2"></i> Pusat Konfigurasi</a>
                
                <div class="sidebar-heading mt-3">Transaksi</div>
                <a href="{{ route('verifikasi.index') }}" class="nav-link-sidebar"><i class="bi bi-file-earmark-check-fill me-2"></i> Verifikasi</a>
                <a href="{{ route('penyaluran.index') }}" class="nav-link-sidebar"><i class="bi bi-truck me-2"></i> Penyaluran</a>
                
                <li class="nav-item mt-5 mt-auto">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link-sidebar text-white w-100 text-start border-0 bg-danger rounded-3 shadow-sm mt-3">
                            <i class="bi bi-box-arrow-right"></i> Keluar
                        </button>
                    </form>
                </li>
            </div>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-0">Pusat Konfigurasi Sistem</h3>
                    <p class="text-muted small">Kelola Program Bansos, Periode, dan Jadwal Tahapan di satu tempat.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white pt-3 pb-0 border-bottom-0 rounded-top-4">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item"><button class="nav-link active" id="bansos-tab" data-bs-toggle="tab" data-bs-target="#bansos" type="button"><i class="bi bi-gift-fill me-2"></i>Program Bansos</button></li>
                        <li class="nav-item"><button class="nav-link" id="periode-tab" data-bs-toggle="tab" data-bs-target="#periode" type="button"><i class="bi bi-calendar-range-fill me-2"></i>Periode Bantuan</button></li>
                        <li class="nav-item"><button class="nav-link" id="jadwal-tab" data-bs-toggle="tab" data-bs-target="#jadwal" type="button"><i class="bi bi-clock-history me-2"></i>Jadwal Tahapan</button></li>
                    </ul>
                </div>

                <div class="card-body p-0">
                    <div class="tab-content" id="myTabContent">
                        
                        <div class="tab-pane fade show active p-4" id="bansos">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div><h5 class="fw-bold mb-0">Data Master Program Bansos</h5></div>
                                <button class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahBansos"><i class="bi bi-plus-circle me-1"></i> Tambah Program</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-custom mb-0">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama Program</th>
                                            <th>Sumber Dana</th>
                                            <th>Kuota Global</th>
                                            <th>Status</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($jenisBansos as $b)
                                        <tr>
                                            <td class="fw-bold">{{ $b->kode_bansos }}</td>
                                            <td>{{ $b->nama_bansos }}</td>
                                            <td>{{ $b->sumber_dana ?? '-' }}</td>
                                            <td>{{ $b->kuota_penerima }} KPM</td>
                                            <td><span class="badge {{ $b->status == 'Aktif' ? 'bg-success' : 'bg-danger' }}">{{ $b->status }}</span></td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalEditBansos{{ $b->id }}"><i class="bi bi-pencil"></i></button>
                                                <form action="{{ route('jenis-bansos.destroy', $b->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus bansos ini?');">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="6" class="text-center py-3">Data belum tersedia.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade p-4" id="periode">
                            <div class="d-flex justify-content-between mb-3">
                                <div><h5 class="fw-bold mb-0">Manajemen Periode</h5></div>
                                <button class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahPeriode"><i class="bi bi-plus-circle me-1"></i> Tambah Periode</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-custom mb-0">
                                    <thead>
                                        <tr><th>Nama Periode</th><th>Tgl Mulai</th><th>Tgl Selesai</th><th>Status</th><th class="text-end">Aksi</th></tr>
                                    </thead>
                                    <tbody>
                                        @forelse($periodes as $p)
                                        <tr>
                                            <td class="fw-bold">{{ $p->nama_periode }}</td><td>{{ $p->tanggal_mulai }}</td><td>{{ $p->tanggal_akhir }}</td>
                                            <td><span class="badge {{ $p->status == 'Aktif' ? 'bg-success' : 'bg-secondary' }}">{{ $p->status }}</span></td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill me-1" data-bs-toggle="modal" data-bs-target="#modalKuotaRT{{ $p->id }}">
                                                    <i class="bi bi-person-fill-gear me-1"></i> Kuota RT
                                                </button>
                                                <form action="{{ route('admin.periode.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?');">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger rounded-pill"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="5" class="text-center py-3">Data belum tersedia.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade p-4" id="jadwal">
                            <div class="d-flex justify-content-between mb-3">
                                <div><h5 class="fw-bold mb-0">Siklus Tahapan</h5></div>
                                <button class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal"><i class="bi bi-plus-circle me-1"></i> Tambah Jadwal</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-custom mb-0">
                                    <thead>
                                        <tr><th>Periode Terikat</th><th>Nama Tahapan</th><th>Rentang Tanggal</th><th>Warna Label</th><th class="text-end">Aksi</th></tr>
                                    </thead>
                                    <tbody>
                                        @forelse($jadwals as $j)
                                        <tr>
                                            <td><span class="badge bg-secondary">{{ $j->periode->nama_periode ?? 'Global' }}</span></td>
                                            <td class="fw-bold">{{ $j->nama_tahapan }}</td>
                                            <td>Tgl {{ $j->hari_mulai }} s/d {{ $j->hari_selesai }}</td>
                                            <td><span class="badge" style="background-color: {{ $j->warna_bg }}; color: white;">{{ $j->warna_bg }}</span></td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalEditJadwal{{ $j->id }}"><i class="bi bi-pencil"></i></button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="5" class="text-center py-3">Data belum tersedia.</td></tr>
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

<div class="modal fade" id="modalTambahBansos" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <form action="{{ route('jenis-bansos.store') }}" method="POST" class="modal-content border-0 shadow-lg rounded-4 text-dark">
            @csrf
            <div class="modal-header bg-light border-bottom-0 pb-3">
                <div>
                    <h5 class="fw-bold mb-0"><i class="bi bi-gift-fill text-primary me-2"></i>Tambah Program Bansos</h5>
                    <small class="text-muted">Buat program bantuan sosial baru dan atur kriteria kelayakannya.</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body p-4 bg-white">
                <div class="section-title"><i class="bi bi-info-circle me-2"></i>Informasi Dasar Bansos</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Nama Program Bansos <span class="text-danger">*</span></label>
                        <input type="text" name="nama_bansos" class="form-control" placeholder="Cth: Program Keluarga Harapan (PKH)" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kode / Singkatan <span class="text-danger">*</span></label>
                        <input type="text" name="kode_bansos" class="form-control" placeholder="Cth: PKH-2026" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Sumber Dana <span class="text-danger">*</span></label>
                        <input type="text" name="sumber_dana" class="form-control" placeholder="Cth: APBN / Dana Desa / APBD" required>
                    </div>
                    
                    <div class="col-md-12">
                        <label class="form-label">Deskripsi Singkat Bantuan</label>
                        <textarea name="deskripsi_singkat" class="form-control" rows="2" placeholder="Jelaskan secara singkat tujuan program bantuan ini..."></textarea>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Bentuk Penyerahan <span class="text-danger">*</span></label>
                        <select name="bentuk_penyerahan" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="Tunai">Tunai</option>
                            <option value="Sembako/Barang">Sembako / Barang</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nominal/Nilai (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="nominal" class="form-control" placeholder="Cth: 600000" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Frekuensi Penyaluran <span class="text-danger">*</span></label>
                        <input type="text" name="frekuensi_penyaluran" class="form-control" placeholder="Cth: 3 Bulan Sekali" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tahun Anggaran <span class="text-danger">*</span></label>
                        <input type="number" name="tahun_anggaran" class="form-control" placeholder="Cth: 2026" required>
                    </div>
                </div>

                <div class="section-title mt-4"><i class="bi bi-ui-checks-grid me-2"></i>Kriteria Penerima Layak</div>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label mb-2">Kriteria Sasaran (Berdasarkan Desil)</label>
                        <div class="card bg-light border-0 p-3">
                            <div class="row">
                                @for($i = 1; $i <= 10; $i++)
                                <div class="col-md-2 col-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kriteria_desil[]" value="{{ $i }}" id="desilTambah{{ $i }}">
                                        <label class="form-check-label" for="desilTambah{{ $i }}">Desil {{ $i }}</label>
                                    </div>
                                </div>
                                @endfor
                            </div>
                            <small class="text-warning mt-2"><i class="bi bi-exclamation-triangle-fill"></i> Centang desil mana saja yang berhak menerima bantuan ini.</small>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="form-label">Deskripsi Kriteria Tambahan (Selain Desil)</label>
                        <textarea name="kriteria_tambahan" class="form-control" rows="2" placeholder="Cth: Diutamakan lansia di atas 60 tahun, janda/duda, atau memiliki balita..."></textarea>
                    </div>
                </div>

                <div class="section-title mt-4"><i class="bi bi-people me-2"></i>Alokasi Kuota & Status</div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Kuota Maksimal (Angka) <span class="text-danger">*</span></label>
                        <input type="number" name="kuota_penerima" class="form-control" placeholder="Cth: 150" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sasaran / Deskripsi Kuota Tambahan</label>
                        <input type="text" name="sasaran_kuota" class="form-control" placeholder="Cth: Menjangkau anak yatim piatu di seluruh desa...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status Aktif <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer bg-light border-top-0 py-3 pe-4">
                <button type="reset" class="btn btn-outline-secondary rounded-pill px-4 fw-bold">Reset</button>
                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm"><i class="bi bi-save me-2"></i>Simpan Program</button>
            </div>
        </form>
    </div>
</div>

@foreach($jenisBansos as $b)
<div class="modal fade" id="modalEditBansos{{ $b->id }}" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <form action="{{ route('jenis-bansos.update', $b->id) }}" method="POST" class="modal-content border-0 shadow-lg rounded-4 text-dark">
            @csrf @method('PUT')
            <div class="modal-header bg-light border-bottom-0 pb-3">
                <div>
                    <h5 class="fw-bold mb-0"><i class="bi bi-pencil-square text-primary me-2"></i>Edit Program Bansos</h5>
                    <small class="text-muted">Perbarui data program bantuan sosial.</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body p-4 bg-white">
                <div class="section-title"><i class="bi bi-info-circle me-2"></i>Informasi Dasar Bansos</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Nama Program Bansos <span class="text-danger">*</span></label>
                        <input type="text" name="nama_bansos" class="form-control" value="{{ $b->nama_bansos }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kode / Singkatan <span class="text-danger">*</span></label>
                        <input type="text" name="kode_bansos" class="form-control" value="{{ $b->kode_bansos }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Sumber Dana <span class="text-danger">*</span></label>
                        <input type="text" name="sumber_dana" class="form-control" value="{{ $b->sumber_dana ?? '' }}" required>
                    </div>
                    
                    <div class="col-md-12">
                        <label class="form-label">Deskripsi Singkat Bantuan</label>
                        <textarea name="deskripsi_singkat" class="form-control" rows="2">{{ $b->deskripsi_singkat ?? '' }}</textarea>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Bentuk Penyerahan <span class="text-danger">*</span></label>
                        <select name="bentuk_penyerahan" class="form-select" required>
                            <option value="Tunai" {{ ($b->bentuk_penyerahan ?? '') == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                            <option value="Sembako/Barang" {{ ($b->bentuk_penyerahan ?? '') == 'Sembako/Barang' ? 'selected' : '' }}>Sembako / Barang</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nominal/Nilai (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="nominal" class="form-control" value="{{ $b->nominal ?? '' }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Frekuensi Penyaluran <span class="text-danger">*</span></label>
                        <input type="text" name="frekuensi_penyaluran" class="form-control" value="{{ $b->frekuensi_penyaluran ?? '' }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tahun Anggaran <span class="text-danger">*</span></label>
                        <input type="number" name="tahun_anggaran" class="form-control" value="{{ $b->tahun_anggaran ?? '' }}" required>
                    </div>
                </div>

                <div class="section-title mt-4"><i class="bi bi-ui-checks-grid me-2"></i>Kriteria Penerima Layak</div>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label mb-2">Kriteria Sasaran (Berdasarkan Desil)</label>
                        <div class="card bg-light border-0 p-3">
                            <div class="row">
                                @php
                                    $desilTersimpan = is_string($b->kriteria_desil) ? json_decode($b->kriteria_desil, true) : ($b->kriteria_desil ?? []);
                                    if(!is_array($desilTersimpan)) $desilTersimpan = [];
                                @endphp
                                @for($i = 1; $i <= 10; $i++)
                                <div class="col-md-2 col-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kriteria_desil[]" value="{{ $i }}" id="desilEdit{{ $b->id }}_{{ $i }}" {{ in_array($i, $desilTersimpan) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="desilEdit{{ $b->id }}_{{ $i }}">Desil {{ $i }}</label>
                                    </div>
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="form-label">Deskripsi Kriteria Tambahan</label>
                        <textarea name="kriteria_tambahan" class="form-control" rows="2">{{ $b->kriteria_tambahan ?? '' }}</textarea>
                    </div>
                </div>

                <div class="section-title mt-4"><i class="bi bi-people me-2"></i>Alokasi Kuota & Status</div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Kuota Maksimal (Angka) <span class="text-danger">*</span></label>
                        <input type="number" name="kuota_penerima" class="form-control" value="{{ $b->kuota_penerima }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sasaran / Deskripsi Kuota Tambahan</label>
                        <input type="text" name="sasaran_kuota" class="form-control" value="{{ $b->sasaran_kuota ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status Aktif <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="Aktif" {{ $b->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ $b->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer bg-light border-top-0 py-3 pe-4">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm"><i class="bi bi-save me-2"></i>Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<div class="modal fade" id="modalTambahPeriode" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.periode.store') }}" method="POST" class="modal-content border-0 shadow-lg rounded-4 text-dark">
            @csrf
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="fw-bold"><i class="bi bi-calendar-plus text-primary me-2"></i>Buat Periode Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label">Nama Periode</label>
                    <input type="text" name="nama_periode" class="form-control" placeholder="Cth: Tahap 1 - 2026" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Berakhir</label>
                        <input type="date" name="tanggal_akhir" class="form-control" required>
                    </div>
                </div>
                <div class="alert alert-info border-0 p-3 small mb-0 rounded-3">
                    <i class="bi bi-info-circle-fill me-1"></i> Periode baru otomatis diaktifkan dan yang lama akan ditutup.
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 pe-4">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalTambahJadwal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="#" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="fw-bold"><i class="bi bi-clock-plus text-primary me-2"></i>Tambah Jadwal Tahapan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label">Nama Tahapan</label>
                    <input type="text" name="nama_tahapan" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label">Tgl Mulai (1-31)</label><input type="number" min="1" max="31" name="hari_mulai" class="form-control" required></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Tgl Selesai (1-31)</label><input type="number" min="1" max="31" name="hari_selesai" class="form-control" required></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Warna Label Background</label>
                    <input type="color" name="warna_bg" class="form-control form-control-color w-100" value="#7D88DC">
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 pe-4">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold" disabled>Fungsi Simpan Belum Tersedia di Route</button>
            </div>
        </form>
    </div>
</div>

@foreach($jadwals as $j)
<div class="modal fade" id="modalEditJadwal{{ $j->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.jadwal.update', $j->id) }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            @csrf @method('PUT')
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="fw-bold"><i class="bi bi-pencil-square text-primary me-2"></i>Edit Jadwal Tahapan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label">Nama Tahapan</label>
                    <input type="text" name="nama_tahapan" class="form-control" value="{{ $j->nama_tahapan }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label">Tgl Mulai (1-31)</label><input type="number" min="1" max="31" name="hari_mulai" class="form-control" value="{{ $j->hari_mulai }}" required></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Tgl Selesai (1-31)</label><input type="number" min="1" max="31" name="hari_selesai" class="form-control" value="{{ $j->hari_selesai }}" required></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="2">{{ $j->deskripsi }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Warna Label</label>
                    <input type="color" name="warna_bg" class="form-control form-control-color w-100" value="{{ $j->warna_bg }}">
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 pe-4">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@foreach($periodes as $p)
<div class="modal fade" id="modalKuotaRT{{ $p->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.konfigurasi.store-kuota-rt') }}" method="POST" class="modal-content border-0 shadow-lg rounded-4 text-dark">
            @csrf
            <div class="modal-header bg-light border-bottom-0 pb-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-person-fill-gear text-primary me-2"></i>Atur Jatah Kuota RT</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body p-4">
                <input type="hidden" name="id_periode" value="{{ $p->id }}">

                <div class="mb-3">
                    <label class="form-label">Target Periode Aktif</label>
                    <input type="text" class="form-control bg-light fw-bold text-primary" value="{{ $p->nama_periode }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Program Bantuan Sosial <span class="text-danger">*</span></label>
                    <select name="id_bansos" class="form-select" required>
                        <option value="">-- Pilih Jenis Bansos --</option>
                        @foreach($jenisBansos as $b)
                            <option value="{{ $b->id }}">{{ $b->kode_bansos }} - {{ $b->nama_bansos }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ketua RT Penerima Kuota <span class="text-danger">*</span></label>
                    <select name="id_user" class="form-select" required>
                        <option value="">-- Pilih Wilayah RT / RW --</option>
                        @foreach($daftar_rt as $rt)
                            <option value="{{ $rt->id_user }}">RT {{ $rt->wilayah_rt_rw ?? '-' }} ({{ $rt->username }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Batas Pagu Kuota Usulan <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" name="kuota" class="form-control" min="1" placeholder="Cth: 10" required>
                        <span class="input-group-text fw-bold">KPM / KK</span>
                    </div>
                    <small class="text-muted d-block mt-1">Mengunci batas jumlah maksimal warga yang boleh diajukan oleh RT ini pada periode tersebut.</small>
                </div>
            </div>

            <div class="modal-footer bg-light border-top-0 py-3 pe-4">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm"><i class="bi bi-shield-check me-1"></i>Simpan Alokasi</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var triggerTabList = [].slice.call(document.querySelectorAll('#myTab button'))
        triggerTabList.forEach(function (triggerEl) {
            triggerEl.addEventListener('shown.bs.tab', function (event) {
                localStorage.setItem('activeKonfigTab', event.target.getAttribute('data-bs-target'));
            });
        });

        var activeTab = localStorage.getItem('activeKonfigTab');
        if (activeTab) {
            var tab = new bootstrap.Tab(document.querySelector('#myTab button[data-bs-target="' + activeTab + '"]'));
            tab.show();
        }
    });
</script>

</body>
</html>