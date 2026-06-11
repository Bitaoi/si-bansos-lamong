<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Warga - SI Bansos</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --warna-utama: #7D88DC; --warna-soft: #BBD0EC; --warna-paling-gelap: #2C3E50;}
        body { font-family: 'Poppins', sans-serif; background-color: #FEFCFB; color: var(--warna-paling-gelap); }
        .text-primary { color: var(--warna-utama) !important; }
        .btn-primary { background-color: var(--warna-utama); border-color: var(--warna-utama); }
        .btn-primary:hover { background-color: #6a75ca; border-color: #6a75ca; }
        .card { border: 1px solid var(--warna-soft); border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .form-label { font-size: 0.85rem; font-weight: 600; color: #475569; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1"><i class="bi bi-person-plus-fill text-primary me-2"></i>Tambah Data Warga</h4>
                    <p class="text-muted mb-0 small">Masukkan informasi kependudukan warga Desa Lamong.</p>
                </div>
                <a href="{{ route('warga.index') }}" class="btn btn-outline-secondary fw-bold rounded-pill"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4" role="alert">
                    <strong><i class="bi bi-exclamation-triangle-fill me-2"></i>Gagal Menyimpan Data!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm p-4 mb-4">
                <form action="{{ route('warga.store') }}" method="POST">
                    @csrf
                    
                    <h6 class="fw-bold mb-3 border-bottom pb-2 text-primary">A. Data Kependudukan (Sesuai KK)</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nomor Induk Kependudukan (NIK)</label>
                            <input type="number" name="nik" class="form-control" value="{{ old('nik') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor Kartu Keluarga (KK)</label>
                            <input type="number" name="no_kk" class="form-control" value="{{ old('no_kk') }}" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status Perkawinan</label>
                            <select name="status_perkawinan" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                            </select>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3 border-bottom pb-2 text-primary">B. Profil Sosial & Wilayah</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Agama</label>
                            <select name="agama" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agm)
                                    <option value="{{ $agm }}" {{ old('agama') == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pendidikan Terakhir</label>
                            <select name="pendidikan" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                @foreach(['Tidak/Belum Sekolah', 'SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'Diploma', 'S1', 'S2', 'S3'] as $pend)
                                    <option value="{{ $pend }}" {{ old('pendidikan') == $pend ? 'selected' : '' }}>{{ $pend }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pekerjaan Utama</label>
                            <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan') }}" required>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label">Jumlah Tanggungan Keluarga</label>
                            <div class="input-group">
                                <input type="number" name="jumlah_keluarga" class="form-control" min="1" value="{{ old('jumlah_keluarga') }}" required>
                                <span class="input-group-text bg-light border-secondary">Orang</span>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label">RT</label>
                            <input type="text" name="rt" class="form-control" placeholder="Contoh: 001" maxlength="3" value="{{ old('rt') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">RW</label>
                            <input type="text" name="rw" class="form-control" placeholder="Contoh: 005" maxlength="3" value="{{ old('rw') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Lengkap Domisili</label>
                            <textarea name="alamat_lengkap" class="form-control" rows="2" required>{{ old('alamat_lengkap') }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-4">
                        <a href="{{ route('warga.index') }}" class="btn btn-light fw-bold px-4 border">Batal</a>
                        <button type="submit" class="btn btn-primary fw-bold px-5 shadow-sm"><i class="bi bi-save me-2"></i> Simpan Data Baru</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>