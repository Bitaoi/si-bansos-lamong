<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Warga - Admin SI Bansos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f3f4f6; font-family: sans-serif; }
        
        /* Sidebar Styling (Sama dengan Index) */
        .sidebar { min-height: 100vh; background: #1e293b; color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; }
        .nav-link:hover, .nav-link.active { background: #0d6efd; color: white; }
        .nav-link i { width: 24px; display: inline-block; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; padding: 10px 20px; letter-spacing: 0.5px; }

        /* Form Styling */
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .form-label { font-weight: 600; color: #334155; font-size: 0.9rem; }
        .form-control, .form-select { padding: 0.6rem 0.8rem; border-radius: 8px; border-color: #cbd5e1; }
        .form-control:focus, .form-select:focus { border-color: #0d6efd; box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1); }
        h6.text-primary { font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; font-size: 0.85rem; margin-top: 1.5rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px; margin-bottom: 1rem; }
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
                </ul>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Edit Data Warga</h4>
                    <p class="text-muted mb-0">Perbarui informasi kependudukan warga.</p>
                </div>
                <a href="{{ route('warga.index') }}" class="btn btn-secondary shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    
                    <form action="{{ route('warga.update', $warga->nik) }}" method="POST">
                        @csrf
                        @method('PUT') <h6 class="text-primary text-uppercase">A. Identitas Kependudukan</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">NIK (Nomor Induk Kependudukan)</label>
                                <input type="text" name="nik" class="form-control bg-light" value="{{ old('nik', $warga->nik) }}" readonly>
                                <div class="form-text">NIK tidak dapat diubah untuk menjaga integritas data.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor Kartu Keluarga (KK) <span class="text-danger">*</span></label>
                                <input type="text" name="no_kk" class="form-control" value="{{ old('no_kk', $warga->no_kk) }}" required maxlength="16">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $warga->nama_lengkap) }}" required>
                        </div>

                        <h6 class="text-primary text-uppercase mt-4">B. Data Pribadi</h6>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $warga->tempat_lahir) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $warga->tanggal_lahir) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="L" {{ $warga->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ $warga->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                             <div class="col-md-6">
                                <label class="form-label">Agama</label>
                                <select name="agama" class="form-select" required>
                                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                        <option value="{{ $agama }}" {{ $warga->agama == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pendidikan Terakhir</label>
                                <select name="pendidikan" class="form-select" required>
                                    @foreach(['Tidak Sekolah', 'SD', 'SMP', 'SMA', 'D3', 'S1', 'S2'] as $p)
                                        <option value="{{ $p }}" {{ $warga->pendidikan == $p ? 'selected' : '' }}>{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $warga->pekerjaan) }}" required>
                            </div>
                             <div class="col-md-6">
                                <label class="form-label">Status Perkawinan</label>
                                <select name="status_kawin" class="form-select" required>
                                    @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $s)
                                        <option value="{{ $s }}" {{ $warga->status_kawin == $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                             <div class="col-md-6">
                                <label class="form-label">Hubungan Keluarga</label>
                                <select name="hubungan_keluarga" class="form-select" required>
                                    @foreach(['Kepala Keluarga', 'Istri', 'Anak', 'Famili Lain'] as $hk)
                                        <option value="{{ $hk }}" {{ $warga->hubungan_keluarga == $hk ? 'selected' : '' }}>{{ $hk }}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div class="col-md-6">
                                <label class="form-label">Kewarganegaraan</label>
                                <select name="kewarganegaraan" class="form-select" required>
                                    <option value="WNI" {{ $warga->kewarganegaraan == 'WNI' ? 'selected' : '' }}>WNI</option>
                                    <option value="WNA" {{ $warga->kewarganegaraan == 'WNA' ? 'selected' : '' }}>WNA</option>
                                </select>
                            </div>
                        </div>

                        <h6 class="text-primary text-uppercase mt-4">C. Alamat Domisili</h6>
                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap (Jalan/Dusun)</label>
                            <textarea name="alamat_lengkap" class="form-control" rows="2" required>{{ old('alamat_lengkap', $warga->alamat_lengkap) }}</textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">RT</label>
                                <input type="text" name="rt" class="form-control" value="{{ old('rt', $warga->rt) }}" required placeholder="001">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">RW</label>
                                <input type="text" name="rw" class="form-control" value="{{ old('rw', $warga->rw) }}" required placeholder="001">
                            </div>
                        </div>

                        <h6 class="text-primary text-uppercase mt-4">D. Informasi Rekening (Opsional)</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Bank</label>
                                <select name="nama_bank" class="form-select">
                                    <option value="">-- Tidak Ada --</option>
                                    @foreach(['BRI', 'BNI', 'Mandiri', 'BCA', 'Jatim'] as $bank)
                                        <option value="{{ $bank }}" {{ $warga->nama_bank == $bank ? 'selected' : '' }}>{{ $bank }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor Rekening</label>
                                <input type="text" name="no_rekening" class="form-control" value="{{ old('no_rekening', $warga->no_rekening) }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-5 pt-3 border-top">
                            <a href="{{ route('warga.index') }}" class="btn btn-light border">Batal</a>
                            <button type="submit" class="btn btn-warning px-4 fw-bold">
                                <i class="bi bi-pencil-square me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>