<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengajuan Bansos - RT</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* PALET WARNA KUSTOM */
        :root {
            --warna-paling-gelap: #2C3E50; 
            --warna-utama: #7D88DC; 
            --warna-soft: #BBD0EC; 
            --warna-background: #FEFCFB; 
        }

        body { 
            background-color: var(--warna-background) !important; 
            color: var(--warna-paling-gelap); 
            font-family: 'Poppins', sans-serif !important; 
        }

        .text-primary { color: var(--warna-utama) !important; }
        .bg-primary { background-color: var(--warna-utama) !important; color: #ffffff !important; }
        .border-primary { border-color: var(--warna-utama) !important; }

        .btn-primary { background-color: var(--warna-utama) !important; border-color: var(--warna-utama) !important; color: #ffffff !important; box-shadow: 0 4px 6px rgba(125, 136, 220, 0.2); }
        .btn-primary:hover { background-color: var(--warna-paling-gelap) !important; border-color: var(--warna-paling-gelap) !important; color: #ffffff !important; }

        .card { border: 1px solid var(--warna-soft) !important; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .step-number { width: 30px; height: 30px; background: var(--warna-utama); color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 10px; }
        .form-section-title { font-weight: 700; color: var(--warna-paling-gelap); margin-bottom: 20px; display: flex; align-items: center; }
        .readonly-input { background-color: #f8fafc; cursor: not-allowed; border-color: var(--warna-soft); }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1 text-primary">Form Pengajuan Bantuan</h4>
                    <p class="text-muted mb-0">Usulkan warga yang layak menerima bantuan sosial ke Admin Desa.</p>
                </div>
                <a href="{{ route('rt.dashboard') }}" class="btn btn-outline-secondary fw-bold"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4 rounded-4 border-0">
                    <h6 class="fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Pengajuan Gagal Dikirim!</h6>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card mb-4">
                    <div class="card-body p-4">
                        <h5 class="form-section-title"><span class="step-number">1</span> Identitas Warga</h5>
                        
                        <div class="alert alert-info d-flex align-items-center border-0" style="background-color: var(--warna-soft); color: var(--warna-paling-gelap);">
                            <i class="bi bi-info-circle-fill me-2 fs-4 text-primary"></i>
                            <div>Masukan NIK atau Nama Warga, lalu tekan <strong>Cari</strong>. Data akan terisi otomatis.</div>
                        </div>

                        <div class="input-group mb-4">
                            <input type="text" id="searchKeyword" class="form-control form-control-lg border-primary" placeholder="Ketik NIK atau Nama Lengkap Warga...">
                            <button class="btn btn-primary px-4 fw-bold" type="button" onclick="cariWarga()">
                                <i class="bi bi-search me-2"></i> CARI DATA
                            </button>
                        </div>

                        <div id="resultArea" style="display: none;">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">NIK</label>
                                    <input type="text" name="nik" id="nik" class="form-control readonly-input fw-bold text-primary" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" id="nama" class="form-control readonly-input fw-bold text-dark" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">No. Kartu Keluarga</label>
                                    <input type="text" id="no_kk" class="form-control readonly-input" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jumlah Anggota Keluarga</label>
                                    <input type="text" id="jumlah_keluarga" class="form-control readonly-input text-danger fw-bold" readonly>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Alamat Domisili</label>
                                    <textarea id="alamat" class="form-control readonly-input" rows="2" readonly></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body p-4">
                        <h5 class="form-section-title"><span class="step-number">2</span> Parameter Pengajuan</h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Jenis Bantuan <span class="text-danger">*</span></label>
                                <select name="id_bansos" class="form-select border-secondary" required>
                                    <option value="">-- Pilih Program --</option>
                                    @foreach($bansos as $b)
                                        <option value="{{ $b->id }}">{{ $b->nama_bansos }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Estimasi Penghasilan (Per Bulan) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-secondary">Rp</span>
                                    <input type="number" name="penghasilan" class="form-control border-secondary" placeholder="0" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Alasan Pengajuan (Rekomendasi RT) <span class="text-danger">*</span></label>
                                <textarea name="alasan" class="form-control border-secondary" rows="3" placeholder="Contoh: Kepala keluarga baru saja di-PHK, kondisi rumah memprihatinkan..." required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body p-4">
                        <h5 class="form-section-title"><span class="step-number">3</span> Lampiran Bukti Fisik</h5>
                        
                        <div class="row g-4">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Foto KTP <span class="text-danger">*</span></label>
                                <input type="file" name="foto_ktp" class="form-control border-secondary" accept="image/*" required>
                                <div class="form-text small">Wajib diisi. Format JPG/PNG.</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Foto KK <span class="text-danger">*</span></label>
                                <input type="file" name="foto_kk" class="form-control border-secondary" accept="image/*" required>
                                <div class="form-text small">Wajib diisi. Format JPG/PNG.</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Foto Rumah (Depan) <span class="text-danger">*</span></label>
                                <input type="file" name="foto_rumah_depan" class="form-control border-secondary" accept="image/*" required>
                                <div class="form-text small">Wajib diisi. Format JPG/PNG.</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Foto Rumah (Dalam)</label>
                                <input type="file" name="foto_rumah_dalam" class="form-control border-secondary" accept="image/*">
                                <div class="form-text small">Wajib diisi. Format JPG/PNG.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
                    <button type="reset" class="btn btn-light border px-4 fw-bold text-muted">Reset Form</button>
                    <button type="submit" class="btn btn-primary px-5 btn-lg fw-bold shadow-sm">
                        <i class="bi bi-send-fill me-2"></i> KIRIM USULAN KE ADMIN
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function cariWarga() {
        let keyword = document.getElementById('searchKeyword').value;
        if(!keyword) {
            alert('Silakan isi NIK atau Nama terlebih dahulu!');
            return;
        }

        fetch(`{{ route('api.warga.search') }}?keyword=${keyword}`)
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    document.getElementById('resultArea').style.display = 'block';
                    document.getElementById('nik').value = data.data.nik;
                    document.getElementById('nama').value = data.data.nama;
                    document.getElementById('no_kk').value = data.data.no_kk;
                    document.getElementById('jumlah_keluarga').value = data.data.jumlah_keluarga + ' Orang';
                    document.getElementById('alamat').value = data.data.alamat;
                } else {
                    alert('Data warga tidak ditemukan! Pastikan nama atau NIK benar.');
                    document.getElementById('resultArea').style.display = 'none';
                    document.getElementById('nik').value = '';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mencari data.');
            });
    }
</script>

</body>
</html>