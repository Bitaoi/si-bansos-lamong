<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengajuan Bansos - RT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f3f4f6; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .step-number { width: 30px; height: 30px; background: #0d6efd; color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 10px; }
        .form-section-title { font-weight: 700; color: #334155; margin-bottom: 20px; display: flex; align-items: center; }
        .readonly-input { background-color: #e9ecef; cursor: not-allowed; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Form Pengajuan Bantuan</h4>
                    <p class="text-muted mb-0">Usulkan warga yang layak menerima bantuan sosial.</p>
                </div>
                <a href="{{ route('rt.dashboard') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>

            <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card mb-4">
                    <div class="card-body p-4">
                        <h5 class="form-section-title"><span class="step-number">1</span> Identitas Warga</h5>
                        
                        <div class="alert alert-info d-flex align-items-center">
                            <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                            <div>Masukan NIK atau Nama Warga, lalu tekan <strong>Cari</strong>. Data akan terisi otomatis.</div>
                        </div>

                        <div class="input-group mb-4">
                            <input type="text" id="searchKeyword" class="form-control form-control-lg" placeholder="Ketik NIK atau Nama Lengkap Warga...">
                            <button class="btn btn-primary px-4" type="button" onclick="cariWarga()">
                                <i class="bi bi-search me-2"></i> CARI DATA
                            </button>
                        </div>

                        <div id="resultArea" style="display: none;">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">NIK</label>
                                    <input type="text" name="nik" id="nik" class="form-control readonly-input" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" id="nama" class="form-control readonly-input" readonly>
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
                                <select name="id_bansos" class="form-select" required>
                                    <option value="">-- Pilih Program --</option>
                                    @foreach($bansos as $b)
                                        <option value="{{ $b->id }}">{{ $b->nama_bansos }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Estimasi Penghasilan (Per Bulan) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="penghasilan" class="form-control" placeholder="0" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Alasan Pengajuan (Rekomendasi RT) <span class="text-danger">*</span></label>
                                <textarea name="alasan" class="form-control" rows="3" placeholder="Contoh: Kepala keluarga baru saja di-PHK, kondisi rumah memprihatinkan..." required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body p-4">
                        <h5 class="form-section-title"><span class="step-number">3</span> Checklist Kriteria</h5>
                        <p class="text-muted small">Centang kondisi yang sesuai dengan warga tersebut:</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="checklist[]" value="Lansia/Disabilitas" id="check1">
                                    <label class="form-check-label" for="check1">Memiliki tanggungan Lansia/Disabilitas</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="checklist[]" value="Rumah Sewa/Bukan Milik" id="check2">
                                    <label class="form-check-label" for="check2">Rumah Kontrak/Sewa/Bukan Milik Sendiri</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="checklist[]" value="Tidak Punya Kendaraan" id="check3">
                                    <label class="form-check-label" for="check3">Tidak memiliki kendaraan roda empat (Mobil)</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="checklist[]" value="Penyakit Menahun" id="check4">
                                    <label class="form-check-label" for="check4">Anggota keluarga ada yang sakit menahun</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body p-4">
                        <h5 class="form-section-title"><span class="step-number">4</span> Lampiran Bukti Fisik</h5>
                        
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Foto KTP & KK</label>
                                <input type="file" name="foto_ktp" class="form-control" accept="image/*" required>
                                <div class="form-text small">Wajib diisi. Format JPG/PNG.</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Foto Rumah (Tampak Depan)</label>
                                <input type="file" name="foto_rumah_depan" class="form-control" accept="image/*" required>
                                <div class="form-text small">Wajib diisi.</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Foto Rumah (Bagian Dalam)</label>
                                <input type="file" name="foto_rumah_dalam" class="form-control" accept="image/*">
                                <div class="form-text small">Opsional.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
                    <button type="reset" class="btn btn-light border px-4">Reset</button>
                    <button type="submit" class="btn btn-primary px-5 btn-lg fw-bold">
                        <i class="bi bi-send-fill me-2"></i> KIRIM PENGAJUAN
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

        // Panggil API Search Laravel
        fetch(`{{ route('api.warga.search') }}?keyword=${keyword}`)
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    // Tampilkan Area Hasil
                    document.getElementById('resultArea').style.display = 'block';
                    
                    // Isi Form Otomatis
                    document.getElementById('nik').value = data.data.nik;
                    document.getElementById('nama').value = data.data.nama;
                    document.getElementById('no_kk').value = data.data.no_kk;
                    document.getElementById('jumlah_keluarga').value = data.data.jumlah_keluarga + ' Orang';
                    document.getElementById('alamat').value = data.data.alamat;
                } else {
                    alert('Data warga tidak ditemukan! Pastikan nama atau NIK benar.');
                    document.getElementById('resultArea').style.display = 'none';
                    document.getElementById('nik').value = ''; // Reset
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