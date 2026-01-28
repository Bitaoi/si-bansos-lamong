<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Warga - SI Bansos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5" style="max-width: 900px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Tambah Data Warga</h3>
        <a href="{{ route('warga.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Formulir Biodata Penduduk</h5>
        </div>
        <div class="card-body">
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('warga.store') }}" method="POST">
                @csrf

                <h6 class="text-primary border-bottom pb-2 mb-3">A. Identitas Kependudukan</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">NIK (Nomor Induk Kependudukan) <span class="text-danger">*</span></label>
                        <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" placeholder="16 Digit Angka" maxlength="16" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor Kartu Keluarga (KK) <span class="text-danger">*</span></label>
                        <input type="text" name="no_kk" class="form-control" value="{{ old('no_kk') }}" placeholder="16 Digit Angka" maxlength="16" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" placeholder="Sesuai KTP" required>
                </div>

                <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">B. Data Pribadi</h6>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Golongan Darah</label>
                        <select name="golongan_darah" class="form-select">
                            <option value="-">-</option>
                            <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                            <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Agama</label>
                        <select name="agama" class="form-select" required>
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kewarganegaraan</label>
                        <select name="kewarganegaraan" class="form-select">
                            <option value="WNI" selected>WNI</option>
                            <option value="WNA">WNA</option>
                        </select>
                    </div>
                </div>

                <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">C. Status Sosial</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Pendidikan Terakhir</label>
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
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan') }}" placeholder="Contoh: Petani, Buruh, PNS" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Status Perkawinan</label>
                        <select name="status_kawin" class="form-select" required>
                            <option value="Belum Kawin" {{ old('status_kawin') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="Kawin" {{ old('status_kawin') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                            <option value="Cerai Hidup" {{ old('status_kawin') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                            <option value="Cerai Mati" {{ old('status_kawin') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Hubungan Dalam Keluarga</label>
                        <select name="hubungan_keluarga" class="form-select" required>
                            <option value="Kepala Keluarga" {{ old('hubungan_keluarga') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                            <option value="Istri" {{ old('hubungan_keluarga') == 'Istri' ? 'selected' : '' }}>Istri</option>
                            <option value="Anak" {{ old('hubungan_keluarga') == 'Anak' ? 'selected' : '' }}>Anak</option>
                            <option value="Famili Lain" {{ old('hubungan_keluarga') == 'Famili Lain' ? 'selected' : '' }}>Famili Lain</option>
                        </select>
                    </div>
                </div>

                <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">D. Alamat Domisili</h6>
                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap (Jalan/Dusun)</label>
                    <textarea name="alamat_lengkap" class="form-control" rows="2" placeholder="Nama Jalan, Nomor Rumah, Dusun" required>{{ old('alamat_lengkap') }}</textarea>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">RT</label>
                        <input type="number" name="rt" class="form-control" placeholder="01" value="{{ old('rt') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">RW</label>
                        <input type="number" name="rw" class="form-control" placeholder="01" value="{{ old('rw') }}" required>
                    </div>
                </div>
                
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">Simpan Data Warga</button>
                    <a href="{{ route('warga.index') }}" class="btn btn-light border">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>