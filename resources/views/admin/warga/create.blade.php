<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Warga - Admin SI Bansos</title>
    
    <!-- FONT POPPINS & BOOTSTRAP -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --warna-paling-gelap: #2C3E50; 
            --warna-utama: #7D88DC; 
            --warna-soft: #BBD0EC; 
            --warna-background: #F8FAFC; 
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
            <h4 class="fw-bold mb-1">Tambah Data Warga</h4>
            <p class="text-muted mb-0">Masukkan data kependudukan warga baru secara lengkap.</p>
        </div>
        <a href="{{ route('warga.index') }}" class="btn btn-secondary fw-bold shadow-sm rounded-3 px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM CARD -->
    <div class="card border-0 bg-white p-4 p-md-5">
        <form action="{{ route('warga.store') }}" method="POST">
            @csrf

            <!-- A. IDENTITAS KEPENDUDUKAN -->
            <div class="section-title">A. Identitas Kependudukan</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">NIK (Nomor Induk Kependudukan) <span class="text-danger">*</span></label>
                    <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" placeholder="16 Digit Angka" maxlength="16" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Nomor Kartu Keluarga (KK) <span class="text-danger">*</span></label>
                    <input type="text" name="no_kk" class="form-control" value="{{ old('no_kk') }}" placeholder="16 Digit Angka" maxlength="16" required>
                </div>
                <div class="col-12 mt-3">
                    <label class="form-label small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" placeholder="Sesuai KTP" required>
                </div>
            </div>

            <!-- B. DATA PRIBADI -->
            <div class="section-title">B. Data Pribadi</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Tempat Lahir <span class="text-danger">*</span></label>
                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="col-md-4 mt-3">
                    <label class="form-label small fw-bold">Golongan Darah</label>
                    <select name="golongan_darah" class="form-select">
                        <option value="-">-</option>
                        <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                    </select>
                </div>
                <div class="col-md-4 mt-3">
                    <label class="form-label small fw-bold">Agama <span class="text-danger">*</span></label>
                    <select name="agama" class="form-select" required>
                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                </div>
                <div class="col-md-4 mt-3">
                    <label class="form-label small fw-bold">Kewarganegaraan</label>
                    <select name="kewarganegaraan" class="form-select">
                        <option value="WNI" selected>WNI</option>
                        <option value="WNA" {{ old('kewarganegaraan') == 'WNA' ? 'selected' : '' }}>WNA</option>
                    </select>
                </div>
            </div>

            <!-- C. STATUS SOSIAL -->
            <div class="section-title">C. Status Sosial</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Pendidikan Terakhir <span class="text-danger">*</span></label>
                    <select name="pendidikan" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="Tidak/Belum Sekolah" {{ old('pendidikan') == 'Tidak/Belum Sekolah' ? 'selected' : '' }}>Tidak/Belum Sekolah</option>
                        <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD / Sederajat</option>
                        <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP / Sederajat</option>
                        <option value="SMA" {{ old('pendidikan') == 'SMA' ? 'selected' : '' }}>SMA / Sederajat</option>
                        <option value="D3" {{ old('pendidikan') == 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="S1" {{ old('pendidikan') == 'S1' ? 'selected' : '' }}>S1 / D4</option>
                        <option value="S2" {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Pekerjaan <span class="text-danger">*</span></label>
                    <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan') }}" placeholder="Contoh: Petani, Buruh, PNS" required>
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label small fw-bold">Status Perkawinan <span class="text-danger">*</span></label>
                    <select name="status_kawin" class="form-select" required>
                        <option value="Belum Kawin" {{ old('status_kawin') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                        <option value="Kawin" {{ old('status_kawin') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                        <option value="Cerai Hidup" {{ old('status_kawin') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                        <option value="Cerai Mati" {{ old('status_kawin') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                    </select>
                </div>
                <div class="col-md-6 mt-3">
                    <label class="form-label small fw-bold">Hubungan Dalam Keluarga <span class="text-danger">*</span></label>
                    <select name="hubungan_keluarga" class="form-select" required>
                        <option value="Kepala Keluarga" {{ old('hubungan_keluarga') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                        <option value="Istri" {{ old('hubungan_keluarga') == 'Istri' ? 'selected' : '' }}>Istri</option>
                        <option value="Anak" {{ old('hubungan_keluarga') == 'Anak' ? 'selected' : '' }}>Anak</option>
                        <option value="Famili Lain" {{ old('hubungan_keluarga') == 'Famili Lain' ? 'selected' : '' }}>Famili Lain</option>
                    </select>
                </div>
            </div>

            <!-- D. ALAMAT DOMISILI -->
            <div class="section-title">D. Alamat Domisili</div>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label small fw-bold">Alamat Lengkap (Jalan/Dusun) <span class="text-danger">*</span></label>
                    <textarea name="alamat_lengkap" class="form-control" rows="2" placeholder="Nama Jalan, Nomor Rumah, Dusun" required>{{ old('alamat_lengkap') }}</textarea>
                </div>
                <div class="col-md-6 mt-3">
                    <label class="form-label small fw-bold">RT <span class="text-danger">*</span></label>
                    <input type="number" name="rt" class="form-control" placeholder="01" value="{{ old('rt') }}" required>
                </div>
                <div class="col-md-6 mt-3">
                    <label class="form-label small fw-bold">RW <span class="text-danger">*</span></label>
                    <input type="number" name="rw" class="form-control" placeholder="01" value="{{ old('rw') }}" required>
                </div>
            </div>

            <!-- E. INFORMASI REKENING BANK -->
            <div class="section-title">E. Informasi Rekening Bank</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Nama Bank</label>
                    <select name="nama_bank" class="form-select">
                        <option value="">-- Pilih Bank (Kosongkan jika tidak ada) --</option>
                        <option value="BRI" {{ old('nama_bank') == 'BRI' ? 'selected' : '' }}>BRI (Bank Rakyat Indonesia)</option>
                        <option value="BNI" {{ old('nama_bank') == 'BNI' ? 'selected' : '' }}>BNI (Bank Negara Indonesia)</option>
                        <option value="Mandiri" {{ old('nama_bank') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                        <option value="BCA" {{ old('nama_bank') == 'BCA' ? 'selected' : '' }}>BCA (Bank Central Asia)</option>
                        <option value="Bank Jatim" {{ old('nama_bank') == 'Bank Jatim' ? 'selected' : '' }}>Bank Jatim</option>
                        <option value="BSI" {{ old('nama_bank') == 'BSI' ? 'selected' : '' }}>BSI (Bank Syariah Indonesia)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Nomor Rekening</label>
                    <input type="text" name="no_rekening" class="form-control" value="{{ old('no_rekening') }}" placeholder="Contoh: 1234xxxx">
                </div>
            </div>
            
            <div class="text-end mt-5 pt-4 border-top">
                <a href="{{ route('warga.index') }}" class="btn btn-light fw-bold px-4 py-2 me-2 border text-muted">Batal</a>
                <button type="submit" class="btn btn-primary fw-bold px-5 py-2 shadow-sm rounded-3">
                    <i class="bi bi-save me-2"></i>Simpan Data Warga
                </button>
            </div>
        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>