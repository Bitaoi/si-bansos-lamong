<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Warga - SI Bansos</title>
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
        .readonly-input { background-color: #f8fafc; cursor: not-allowed; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1"><i class="bi bi-person-lines-fill text-primary me-2"></i>Edit Data Penduduk</h4>
                    <p class="text-muted mb-0 small">Ubah informasi kependudukan warga Desa Lamong.</p>
                </div>
                <a href="{{ route('warga.index') }}" class="btn btn-outline-secondary fw-bold rounded-pill"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm p-4 mb-4">
                <form action="{{ route('warga.update', $warga->nik) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <h6 class="fw-bold mb-3 border-bottom pb-2 text-primary">A. Data Kependudukan (Wajib Sesuai KK)</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Nomor Induk Kependudukan (NIK)</label>
                            <input type="text" class="form-control readonly-input fw-bold text-danger" value="{{ $warga->nik }}" readonly disabled>
                            <small class="text-muted" style="font-size: 0.7rem;">NIK adalah kunci unik dan tidak bisa diubah.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor Kartu Keluarga (KK)</label>
                            <input type="number" name="no_kk" class="form-control" value="{{ old('no_kk', $warga->no_kk) }}" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control fw-bold" value="{{ old('nama_lengkap', $warga->nama_lengkap) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="Laki-laki" {{ $warga->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ $warga->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $warga->tempat_lahir) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $warga->tanggal_lahir) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Perkawinan</label>
                            <select name="status_perkawinan" class="form-select" required>
                                <option value="Belum Kawin" {{ $warga->status_perkawinan == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                <option value="Kawin" {{ $warga->status_perkawinan == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                <option value="Cerai Hidup" {{ $warga->status_perkawinan == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                <option value="Cerai Mati" {{ $warga->status_perkawinan == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                            </select>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3 border-bottom pb-2 text-primary">B. Profil Sosial & Wilayah</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Agama</label>
                            <select name="agama" class="form-select" required>
                                @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agm)
                                    <option value="{{ $agm }}" {{ $warga->agama == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pendidikan Terakhir</label>
                            <select name="pendidikan" class="form-select" required>
                                @foreach(['Tidak/Belum Sekolah', 'SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'Diploma', 'S1', 'S2', 'S3'] as $pend)
                                    <option value="{{ $pend }}" {{ $warga->pendidikan == $pend ? 'selected' : '' }}>{{ $pend }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pekerjaan Utama</label>
                            <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $warga->pekerjaan) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jumlah Tanggungan Keluarga</label>
                            <div class="input-group">
                                <input type="number" name="jumlah_keluarga" class="form-control" min="1" value="{{ old('jumlah_keluarga', $warga->jumlah_keluarga) }}" required>
                                <span class="input-group-text bg-light border-secondary">Orang</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">RT</label>
                            <input type="text" name="rt" class="form-control" placeholder="Contoh: 001" maxlength="3" value="{{ old('rt', $warga->rt) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">RW</label>
                            <input type="text" name="rw" class="form-control" placeholder="Contoh: 005" maxlength="3" value="{{ old('rw', $warga->rw) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Lengkap Domisili</label>
                            <textarea name="alamat_lengkap" class="form-control" rows="2" required>{{ old('alamat_lengkap', $warga->alamat_lengkap) }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-4">
                        <a href="{{ route('warga.index') }}" class="btn btn-light fw-bold px-4 border">Batal</a>
                        <button type="submit" class="btn btn-primary fw-bold px-5 shadow-sm"><i class="bi bi-save me-2"></i> Simpan Perubahan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>