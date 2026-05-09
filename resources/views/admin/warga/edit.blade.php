<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Warga - Admin SI Bansos</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --warna-paling-gelap: #2C3E50; 
            --warna-utama: #7D88DC; 
            --warna-soft: #BBD0EC; 
            --warna-background: #F8FAFC; /* Sedikit keabu-abuan agar form putih lebih menonjol */
        }

        body { background-color: var(--warna-background) !important; color: var(--warna-paling-gelap); font-family: 'Poppins', sans-serif !important; }
        .text-primary { color: var(--warna-utama) !important; }
        .bg-primary { background-color: var(--warna-utama) !important; color: #ffffff !important; }
        .btn-primary { background-color: var(--warna-utama) !important; border-color: var(--warna-utama) !important; color: #ffffff !important; }
        .btn-primary:hover { background-color: var(--warna-paling-gelap) !important; border-color: var(--warna-paling-gelap) !important; }
        
        .card { border: 1px solid #e2e8f0 !important; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); }
        .form-control, .form-select { border-radius: 8px; padding: 10px 15px; border-color: #e2e8f0; font-size: 0.95rem; }
        .form-control:focus, .form-select:focus { border-color: var(--warna-utama); box-shadow: 0 0 0 0.25rem rgba(125, 136, 220, 0.25); }
        
        /* GAYA KHUSUS PEMISAH SEKSI FORMULIR */
        .section-title { 
            font-size: 0.85rem; 
            font-weight: 700; 
            color: var(--warna-utama); 
            text-transform: uppercase; 
            margin-bottom: 1.2rem; 
            margin-top: 2.5rem; 
            border-bottom: 2px solid var(--warna-soft); 
            padding-bottom: 0.5rem;
        }
        .section-title:first-of-type { margin-top: 0; }
    </style>
</head>
<body>

<div class="container py-5 col-lg-10 col-xl-8">
    
    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Data Warga</h4>
            <p class="text-muted mb-0">Perbarui informasi kependudukan warga.</p>
        </div>
        <a href="{{ route('warga.index') }}" class="btn btn-secondary fw-bold shadow-sm rounded-3 px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM CARD -->
    <div class="card border-0 bg-white p-4 p-md-5">
        <form action="{{ route('warga.update', $warga->nik) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- A. IDENTITAS KEPENDUDUKAN -->
            <div class="section-title">A. IDENTITAS KEPENDUDUKAN</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">NIK (Nomor Induk Kependudukan)</label>
                    <input type="text" name="nik" class="form-control bg-light text-muted" value="{{ $warga->nik }}" readonly>
                    <small class="text-muted" style="font-size: 0.75rem;">NIK tidak dapat diubah untuk menjaga integritas data.</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Nomor Kartu Keluarga (KK) <span class="text-danger">*</span></label>
                    <input type="text" name="no_kk" class="form-control" value="{{ old('no_kk', $warga->no_kk ?? '') }}" required>
                </div>
                <div class="col-12 mt-3">
                    <label class="form-label small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $warga->nama_lengkap ?? '') }}" required>
                </div>
            </div>

            <!-- B. DATA PRIBADI -->
            <div class="section-title">B. DATA PRIBADI</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $warga->tempat_lahir ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $warga->tanggal_lahir ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="L" {{ old('jenis_kelamin', $warga->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $warga->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label small fw-bold">Agama</label>
                    <select name="agama" class="form-select">
                        <option value="Islam" {{ old('agama', $warga->agama ?? '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('agama', $warga->agama ?? '') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('agama', $warga->agama ?? '') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama', $warga->agama ?? '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('agama', $warga->agama ?? '') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('agama', $warga->agama ?? '') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                </div>
                <div class="col-md-6 mt-3">
                    <label class="form-label small fw-bold">Pendidikan Terakhir</label>
                    <select name="pendidikan" class="form-select">
                        <option value="Tidak Sekolah" {{ old('pendidikan', $warga->pendidikan ?? '') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                        <option value="SD" {{ old('pendidikan', $warga->pendidikan ?? '') == 'SD' ? 'selected' : '' }}>SD / Sederajat</option>
                        <option value="SMP" {{ old('pendidikan', $warga->pendidikan ?? '') == 'SMP' ? 'selected' : '' }}>SMP / Sederajat</option>
                        <option value="SMA" {{ old('pendidikan', $warga->pendidikan ?? '') == 'SMA' ? 'selected' : '' }}>SMA / Sederajat</option>
                        <option value="D1/D2/D3" {{ old('pendidikan', $warga->pendidikan ?? '') == 'D1/D2/D3' ? 'selected' : '' }}>D1 / D2 / D3</option>
                        <option value="S1/D4" {{ old('pendidikan', $warga->pendidikan ?? '') == 'S1/D4' ? 'selected' : '' }}>S1 / D4</option>
                        <option value="S2/S3" {{ old('pendidikan', $warga->pendidikan ?? '') == 'S2/S3' ? 'selected' : '' }}>S2 / S3</option>
                    </select>
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label small fw-bold">Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $warga->pekerjaan ?? '') }}">
                </div>
                <div class="col-md-6 mt-3">
                    <label class="form-label small fw-bold">Status Perkawinan</label>
                    <select name="status_perkawinan" class="form-select">
                        <option value="Belum Kawin" {{ old('status_perkawinan', $warga->status_perkawinan ?? '') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                        <option value="Kawin" {{ old('status_perkawinan', $warga->status_perkawinan ?? '') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                        <option value="Cerai Hidup" {{ old('status_perkawinan', $warga->status_perkawinan ?? '') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                        <option value="Cerai Mati" {{ old('status_perkawinan', $warga->status_perkawinan ?? '') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                    </select>
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label small fw-bold">Hubungan Keluarga</label>
                    <select name="hubungan_keluarga" class="form-select">
                        <option value="Kepala Keluarga" {{ old('hubungan_keluarga', $warga->hubungan_keluarga ?? '') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                        <option value="Istri" {{ old('hubungan_keluarga', $warga->hubungan_keluarga ?? '') == 'Istri' ? 'selected' : '' }}>Istri</option>
                        <option value="Anak" {{ old('hubungan_keluarga', $warga->hubungan_keluarga ?? '') == 'Anak' ? 'selected' : '' }}>Anak</option>
                        <option value="Lainnya" {{ old('hubungan_keluarga', $warga->hubungan_keluarga ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="col-md-6 mt-3">
                    <label class="form-label small fw-bold">Kewarganegaraan</label>
                    <select name="kewarganegaraan" class="form-select">
                        <option value="WNI" {{ old('kewarganegaraan', $warga->kewarganegaraan ?? '') == 'WNI' ? 'selected' : '' }}>WNI</option>
                        <option value="WNA" {{ old('kewarganegaraan', $warga->kewarganegaraan ?? '') == 'WNA' ? 'selected' : '' }}>WNA</option>
                    </select>
                </div>
            </div>

            <!-- C. ALAMAT LENGKAP -->
            <div class="section-title">C. ALAMAT LENGKAP</div>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label small fw-bold">Alamat Jalan / Dusun <span class="text-danger">*</span></label>
                    <textarea name="alamat_lengkap" class="form-control" rows="2" required>{{ old('alamat_lengkap', $warga->alamat_lengkap ?? '') }}</textarea>
                </div>
                <div class="col-md-6 mt-3">
                    <label class="form-label small fw-bold">RT <span class="text-danger">*</span></label>
                    <input type="text" name="rt" class="form-control" value="{{ old('rt', $warga->rt ?? '') }}" required>
                </div>
                <div class="col-md-6 mt-3">
                    <label class="form-label small fw-bold">RW <span class="text-danger">*</span></label>
                    <input type="text" name="rw" class="form-control" value="{{ old('rw', $warga->rw ?? '') }}" required>
                </div>
            </div>

            <div class="text-end mt-5 pt-4 border-top">
                <button type="submit" class="btn btn-primary fw-bold px-5 py-2 shadow-sm rounded-3">
                    <i class="bi bi-save me-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>