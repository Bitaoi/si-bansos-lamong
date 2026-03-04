<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jenis Bantuan Sosial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* Menggunakan Style yang sama persis dengan Create */
        body { background-color: #f3f4f6 !important; font-family: 'Inter', sans-serif; color: #333; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important; }
        .card-header { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important; color: white; border-radius: 12px 12px 0 0 !important; padding: 1.25rem 1.5rem; font-weight: 600; letter-spacing: 0.5px; }
        .form-label { font-weight: 500; color: #4b5563; font-size: 0.9rem; margin-bottom: 0.4rem; }
        .form-control, .form-select { border-radius: 8px; border: 1px solid #d1d5db; padding: 0.6rem 0.8rem; font-size: 0.95rem; transition: all 0.2s ease-in-out; }
        .form-control:focus, .form-select:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15); }
        h6.text-primary { color: #0d6efd !important; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; font-size: 0.85rem; margin-top: 10px; border-bottom: 2px solid #e5e7eb !important; }
        .btn { border-radius: 8px; padding: 0.6rem 1.2rem; font-weight: 500; font-size: 0.95rem; transition: all 0.2s; }
        .btn-primary { background-color: #0d6efd; border: none; box-shadow: 0 2px 4px rgba(13, 110, 253, 0.3); }
        .btn-primary:hover { background-color: #0b5ed7; transform: translateY(-1px); box-shadow: 0 4px 6px rgba(13, 110, 253, 0.4); }
        .btn-secondary { background-color: #f3f4f6; color: #4b5563; border: 1px solid #d1d5db; }
        .btn-secondary:hover { background-color: #e5e7eb; color: #1f2937; }
        .form-check-input { width: 3em; height: 1.5em; cursor: pointer; }
        .form-check-input:checked { background-color: #198754; border-color: #198754; }
        .form-check-label { margin-left: 10px; margin-top: 4px; cursor: pointer; font-weight: 500; }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Jenis Bantuan Sosial</h5>
            <a href="{{ route('jenis-bansos.index') }}" class="btn btn-sm btn-light text-primary fw-bold">Kembali</a>
        </div>
        <div class="card-body p-4">
            
            <form action="{{ route('jenis-bansos.update', $bansos->id) }}" method="POST">
                @csrf 
                @method('PUT') <h6 class="text-primary border-bottom pb-2 mb-3">I. Identitas Bantuan</h6>
                <div class="row mb-3">
                    <div class="col-md-5">
                        <label class="form-label font-weight-bold">Nama Bansos</label>
                        <input type="text" name="nama_bansos" class="form-control" value="{{ $bansos->nama_bansos }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Kode/Singkatan</label>
                        <input type="text" name="kode_bansos" class="form-control text-uppercase" value="{{ $bansos->kode_bansos }}">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Sumber Dana</label>
                        <select name="sumber_dana" class="form-select" required>
                            <option value="">-- Pilih Sumber --</option>
                            <option value="Pusat" {{ $bansos->sumber_dana == 'Pusat' ? 'selected' : '' }}>Pemerintah Pusat (Kemensos)</option>
                            <option value="Provinsi" {{ $bansos->sumber_dana == 'Provinsi' ? 'selected' : '' }}>Pemerintah Provinsi</option>
                            <option value="Kabupaten" {{ $bansos->sumber_dana == 'Kabupaten' ? 'selected' : '' }}>Pemerintah Kabupaten</option>
                            <option value="Dana Desa" {{ $bansos->sumber_dana == 'Dana Desa' ? 'selected' : '' }}>Dana Desa</option>
                            <option value="Swasta" {{ $bansos->sumber_dana == 'Swasta' ? 'selected' : '' }}>Lainnya/CSR</option>
                        </select>
                    </div>
                    <div class="col-12 mt-2">
                        <label class="form-label">Deskripsi Singkat</label>
                        <textarea name="deskripsi" class="form-control" rows="1">{{ $bansos->deskripsi }}</textarea>
                    </div>
                </div>

                <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">II. Detail & Nominal</h6>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Bentuk Bantuan</label>
                        <select name="bentuk_bantuan" class="form-select" required>
                            <option value="Tunai" {{ $bansos->bentuk_bantuan == 'Tunai' ? 'selected' : '' }}>Uang Tunai</option>
                            <option value="Barang" {{ $bansos->bentuk_bantuan == 'Barang' ? 'selected' : '' }}>Barang/Sembako</option>
                            <option value="Jasa" {{ $bansos->bentuk_bantuan == 'Jasa' ? 'selected' : '' }}>Layanan/Jasa</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nominal/Jumlah</label>
                        <input type="text" name="nominal" class="form-control" value="{{ $bansos->nominal }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Frekuensi Penyaluran</label>
                        <select name="frekuensi" class="form-select" required>
                            <option value="Bulanan" {{ $bansos->frekuensi == 'Bulanan' ? 'selected' : '' }}>Setiap Bulan</option>
                            <option value="Triwulan" {{ $bansos->frekuensi == 'Triwulan' ? 'selected' : '' }}>Triwulan (3 Bulan)</option>
                            <option value="Tahunan" {{ $bansos->frekuensi == 'Tahunan' ? 'selected' : '' }}>Tahunan</option>
                            <option value="Insidental" {{ $bansos->frekuensi == 'Insidental' ? 'selected' : '' }}>Insidental</option>
                        </select>
                    </div>
                </div>

                <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">III. Kriteria & Status</h6>
                
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Kriteria Penerima</label>
                        <textarea name="kriteria_penerima" class="form-control" rows="3" required>{{ $bansos->kriteria_penerima }}</textarea>
                        
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Batas Gaji Maksimal (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="batas_penghasilan" class="form-control" value="{{ $bansos->batas_penghasilan }}">
                                </div>
                            </div>
                            <div class="col-md-6 d-flex align-items-center mt-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="syarat_dtks" value="1" id="switchDTKS" {{ $bansos->syarat_dtks == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label text-danger fw-bold" for="switchDTKS">Wajib Terdaftar DTKS?</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 bg-white border rounded p-3">
                        <div class="mb-3">
                            <label class="form-label">Tahun Anggaran</label>
                            <input type="number" name="tahun_anggaran" class="form-control" value="{{ $bansos->tahun_anggaran }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kuota (Orang)</label>
                            <input type="number" name="kuota_penerima" class="form-control" value="{{ $bansos->kuota_penerima }}">
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="radio" name="status" value="Aktif" id="statusAktif" {{ $bansos->status == 'Aktif' ? 'checked' : '' }}>
                            <label class="form-check-label text-success fw-bold" for="statusAktif">Program Aktif</label>
                        </div>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="radio" name="status" value="Non-Aktif" id="statusNon" {{ $bansos->status == 'Non-Aktif' ? 'checked' : '' }}>
                            <label class="form-check-label text-muted" for="statusNon">Non-Aktif (Arsip)</label>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                    <button type="submit" class="btn btn-warning text-white px-4"><i class="bi bi-pencil-square me-2"></i>Perbarui Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>