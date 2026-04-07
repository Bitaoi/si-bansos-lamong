<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Warga - Admin SI Bansos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f3f4f6; font-family: sans-serif; }
        
        /* Sidebar & Nav */
        .sidebar { min-height: 100vh; background: #1e293b; color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; }
        .nav-link:hover, .nav-link.active { background: #0d6efd; color: white; }
        .nav-link i { width: 24px; display: inline-block; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; padding: 10px 20px; letter-spacing: 0.5px; }

        /* Table Styling */
        .table-custom thead th { background-color: #f8fafc; color: #64748b; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; border-bottom: 2px solid #e2e8f0; }
        .table-custom tbody td { vertical-align: middle; border-bottom: 1px solid #f1f5f9; padding: 1rem 0.75rem; font-size: 0.95rem; }
        
        /* Button & Card */
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .btn-action { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; }
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
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                </li>
                
                <div class="sidebar-heading mt-3">Master Data</div>
                <li class="nav-item">
                    <a href="{{ route('warga.index') }}" class="nav-link active">
                        <i class="bi bi-people-fill"></i> Data Warga
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('jenis-bansos.index') }}" class="nav-link">
                        <i class="bi bi-gift-fill"></i> Jenis Bansos
                    </a>
                </li>

                <div class="sidebar-heading mt-3">Transaksi</div>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-file-earmark-text-fill"></i> Verifikasi Pengajuan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="bi bi-truck"></i> Penyaluran
                    </a>
                </li>

                <li class="nav-item mt-5">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link bg-danger text-white w-100 text-start border-0 shadow-sm">
                            <i class="bi bi-box-arrow-right"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
            
            <div class="d-md-none d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold"><i class="bi bi-people-fill me-2"></i>Data Warga</h5>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-danger"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Data Kependudukan</h4>
                    <p class="text-muted mb-0">Kelola data warga penerima bantuan sosial.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('warga.template') }}" class="btn btn-outline-success">
                        <i class="bi bi-file-earmark-spreadsheet"></i> Template
                    </a>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="bi bi-file-earmark-arrow-up"></i> Import Excel
                    </button>
                    <a href="{{ route('warga.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Warga
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">NIK</th>
                                    <th>Nama Lengkap</th>
                                    <th>Alamat Domisili</th>
                                    <th>RT / RW</th>
                                    <th>Pekerjaan</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($wargas as $warga)
                                <tr>
                                    <td class="ps-4 fw-bold text-primary">{{ $warga->nik }}</td>
                                    <td>
                                        <div class="fw-bold text-dark d-flex align-items-center gap-2">
                                            {{ $warga->nama_lengkap }}
                                            @if($warga->desil)
                                                @php
                                                    $warna = $warga->desil == 1 ? 'danger' : ($warga->desil == 2 ? 'warning text-dark' : ($warga->desil == 3 ? 'info text-dark' : 'secondary'));
                                                @endphp
                                                <span class="badge bg-{{ $warna }} rounded-pill" style="font-size: 0.7rem;">Desil {{ $warga->desil }}</span>
                                            @endif
                                        </div>
                                        <small class="text-muted">{{ $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</small>
                                    </td>
                                    <td>{{ Str::limit($warga->alamat_lengkap, 30) }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $warga->rt }} / {{ $warga->rw }}</span></td>
                                    <td>{{ $warga->pekerjaan }}</td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-1">
                                            
                                            <button type="button" class="btn btn-action btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDesil{{ $warga->nik }}" title="Hitung Kelayakan (Desil)">
                                                <i class="bi bi-calculator"></i>
                                            </button>

                                            <a href="{{ route('warga.edit', $warga->nik) }}" class="btn btn-action btn-warning text-white btn-sm" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('warga.destroy', $warga->nik) }}" method="POST" onsubmit="return confirm('Hapus data warga ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-action btn-danger btn-sm" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalDesil{{ $warga->nik }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title fw-bold"><i class="bi bi-calculator me-2"></i>Penilaian Kelayakan (Desil)</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('warga.update_desil', $warga->nik) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-body p-4 text-start">
                                                    <div class="alert alert-light border mb-4">
                                                        Nama: <strong>{{ $warga->nama_lengkap }}</strong><br>
                                                        NIK: <strong>{{ $warga->nik }}</strong><br>
                                                        Desil Saat Ini: <span class="badge bg-dark">{{ $warga->desil ? 'Desil '.$warga->desil : 'Belum Dinilai' }}</span>
                                                    </div>

                                                    <p class="small text-muted mb-3">Centang kondisi di bawah ini untuk menghitung ulang skor kelayakan warga secara otomatis berdasarkan 14 Kriteria Kemiskinan BPS/DTSEN.</p>

                                                    <div class="row g-2">
                                                        @php
                                                            $kriteria_list = [
                                                                'Luas lantai bangunan tempat tinggal kurang dari 8m² per orang.',
                                                                'Jenis lantai tempat tinggal terbuat dari tanah/bambu/kayu murahan.',
                                                                'Jenis dinding tempat tinggal dari bambu/rumbia/kayu berkualitas rendah.',
                                                                'Tidak memiliki fasilitas buang air besar (MCK) sendiri.',
                                                                'Sumber penerangan rumah tangga tidak menggunakan listrik (PLN).',
                                                                'Sumber air minum berasal dari sumur/mata air tidak terlindung/sungai.',
                                                                'Bahan bakar untuk memasak sehari-hari adalah kayu bakar/arang.',
                                                                'Hanya mengkonsumsi daging/susu/ayam dalam satu kali seminggu.',
                                                                'Hanya membeli satu stel pakaian baru dalam setahun.',
                                                                'Hanya sanggup makan sebanyak satu atau dua kali dalam sehari.',
                                                                'Tidak sanggup membayar biaya pengobatan di puskesmas/poliklinik.',
                                                                'Sumber penghasilan KK adalah petani gurem, buruh bangunan/perkebunan, atau pendapatan di bawah Rp 600.000/bulan.',
                                                                'Pendidikan tertinggi Kepala Keluarga: Tidak sekolah / Tidak tamat SD.',
                                                                'Tidak memiliki tabungan/barang yang mudah dijual bernilai minimal Rp 500.000.'
                                                            ];
                                                        @endphp

                                                        @foreach($kriteria_list as $index => $kriteria)
                                                        <div class="col-md-6">
                                                            <label class="form-check p-2 border rounded h-100 bg-light text-wrap" style="cursor:pointer;">
                                                                <input class="form-check-input mt-1 ms-1 me-2" type="checkbox" name="checklist[]" value="{{ $kriteria }}">
                                                                <span class="form-check-label small" style="font-size: 0.8rem;">
                                                                    {{ $index + 1 }}. {{ $kriteria }}
                                                                </span>
                                                            </label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-save-fill me-1"></i> Simpan & Update Desil</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-people fs-1 d-block mb-3 opacity-25"></i>
                                        Belum ada data warga. Silakan tambah atau import data.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($wargas->hasPages())
                    <div class="card-footer bg-white py-3">
                        {{ $wargas->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-file-earmark-spreadsheet me-2"></i>Import Data Warga</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('warga.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih File Excel (.xlsx / .csv)</label>
                        <input type="file" name="file" class="form-control" required>
                        <small class="text-muted">Pastikan format sesuai template.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Upload & Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>