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
        :root {
            --warna-paling-gelap: #2C3E50; 
            --warna-utama: #7D88DC; 
            --warna-soft: #BBD0EC; 
            --warna-background: #FEFCFB; 
        }

        body { background-color: var(--warna-background) !important; color: var(--warna-paling-gelap); font-family: 'Poppins', sans-serif !important; }
        .text-primary { color: var(--warna-utama) !important; }
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
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h4 class="fw-bold mb-1 text-primary">Form Pengajuan Bantuan</h4>
                    <p class="text-muted mb-2">Usulkan warga yang layak menerima bantuan sosial ke Admin Desa.</p>
                    
                    @if(isset($periodeAktif))
                    <div class="d-inline-block px-3 py-1 rounded-pill bg-success bg-opacity-10 border border-success text-success fw-bold small shadow-sm">
                        <i class="bi bi-calendar2-check-fill me-1"></i> Periode Berjalan: {{ $periodeAktif->nama_periode }}
                    </div>
                    @endif
                </div>
                <a href="{{ route('rt.dashboard') }}" class="btn btn-outline-secondary fw-bold mt-1"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>

            <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                @if(isset($periodeAktif))
                <input type="hidden" name="id_periode" value="{{ $periodeAktif->id }}">
                @endif

                <div class="card mb-4">
                    <div class="card-body p-4">
                        <h5 class="form-section-title"><span class="step-number">1</span> Identitas Warga</h5>
                        <div class="input-group mb-4">
                            <input type="text" id="searchKeyword" class="form-control form-control-lg border-primary" placeholder="Ketik NIK atau Nama Lengkap Warga..." value="{{ old('nik') }}">
                            <button class="btn btn-primary px-4 fw-bold" type="button" onclick="cariWarga()"><i class="bi bi-search me-2"></i> CARI DATA</button>
                        </div>
                        <div id="resultArea" style="display: {{ old('nik') ? 'block' : 'none' }};">
                            
                            <div id="alertSudahDaftar" class="alert alert-danger mb-4 fw-bold shadow-sm border-danger" style="display: none;">
                                <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i> 
                                PENOLAKAN SISTEM: Warga ini sudah terdaftar bantuan sosial di periode bulan ini. Tidak bisa diajukan kembali!
                            </div>

                            <input type="hidden" name="nik" id="nik" value="{{ old('nik') }}">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" id="nama" class="form-control readonly-input fw-bold text-dark" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Jumlah Anggota Keluarga</label>
                                    <input type="text" id="jumlah_keluarga" class="form-control readonly-input text-danger fw-bold mb-2" readonly>
                                    <ul id="list_anggota_keluarga" class="text-muted small ps-3 mb-0" style="list-style-type: decimal;">
                                    </ul>
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
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Jenis Bantuan <span class="text-danger">*</span></label>
                                <select name="id_bansos" class="form-select border-secondary" required>
                                    <option value="">-- Pilih Program --</option>
                                    @foreach($bansos as $b)
                                        <option value="{{ $b->id }}" {{ old('id_bansos') == $b->id ? 'selected' : '' }}>{{ $b->nama_bansos }} (Sisa: {{ $b->sisa_kuota_rt }} Orang)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Tanggal Pengajuan <span class="text-danger">*</span></label>
                                <input type="date" name="tgl_pengajuan" class="form-control border-secondary" required value="{{ old('tgl_pengajuan', date('Y-m-d')) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Estimasi Penghasilan <span class="text-danger">*</span></label>
                                <div class="input-group"><span class="input-group-text bg-light border-secondary">Rp</span><input type="number" name="penghasilan" class="form-control border-secondary" placeholder="0" value="{{ old('penghasilan') }}" required></div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Alasan Pengajuan (Rekomendasi RT) <span class="text-danger">*</span></label>
                                <textarea name="alasan" class="form-control border-secondary" rows="3" required>{{ old('alasan') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body p-4">
                        <h5 class="form-section-title"><span class="step-number">3</span> Lampiran Bukti Kondisi Rumah</h5>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Foto Rumah (Tampak Depan) <span class="text-danger">*</span></label>
                                <input type="file" name="foto_rumah_depan" class="form-control border-secondary" accept="image/*" required>
                                <div class="form-text small text-muted">Menampakkan kondisi keseluruhan bagian depan rumah.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Foto Rumah (Interior / Dalam)</label>
                                <input type="file" name="foto_rumah_dalam" class="form-control border-secondary" accept="image/*">
                                <div class="form-text small text-muted">Menampakkan kondisi lantai atau dinding bagian dalam rumah.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
                    <button type="reset" class="btn btn-light border px-4 fw-bold text-muted">Reset Form</button>
                    <button type="submit" id="btnSubmitPengajuan" class="btn btn-primary px-5 btn-lg fw-bold shadow-sm"><i class="bi bi-send-fill me-2"></i> KIRIM USULAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function cariWarga() {
        let keyword = document.getElementById('searchKeyword').value;
        if(!keyword) { alert('Silakan isi NIK atau Nama terlebih dahulu!'); return; }
        
        let btnCari = document.querySelector('button[onclick="cariWarga()"]');
        let originalText = btnCari.innerHTML;
        btnCari.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mencari...';
        btnCari.disabled = true;

        fetch(`{{ route('api.warga.search') }}?keyword=${keyword}`)
            .then(response => response.json())
            .then(data => {
                btnCari.innerHTML = originalText;
                btnCari.disabled = false;

                if(data.status === 'success') {
                    document.getElementById('resultArea').style.display = 'block';
                    
                    // Input Hidden & Readonly Data
                    document.getElementById('nik').value = data.data.nik_pendaftar;
                    document.getElementById('jumlah_keluarga').value = data.data.jumlah_keluarga + ' Orang';
                    document.getElementById('alamat').value = data.data.alamat;

                    // Menggabungkan Nama Lengkap + Status Otomatis yang sudah dihitung Controller
                    document.getElementById('nama').value = data.data.nama_pendaftar + " (" + data.data.peran_pendaftar + ")";

                    // Me-Render List Anggota Keluarga Beserta Status Otomatisnya
                    let listAnggotaHtml = '';
                    if(data.data.anggota_keluarga && data.data.anggota_keluarga.length > 0) {
                        data.data.anggota_keluarga.forEach(function(anggota) {
                            listAnggotaHtml += `<li class="mt-1"><span class="fw-bold text-dark">${anggota.nama}</span> - <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-2 py-1">${anggota.peran}</span></li>`;
                        });
                    }
                    document.getElementById('list_anggota_keluarga').innerHTML = listAnggotaHtml;

                    // LOGIKA CEK DAFTAR GANDA 1 KK
                    let alertPeringatan = document.getElementById('alertSudahDaftar');
                    let btnSubmit = document.getElementById('btnSubmitPengajuan');

                    if(data.data.blokir_kk) {
                        alertPeringatan.style.display = 'block';
                        alertPeringatan.innerHTML = `<i class="bi bi-shield-x fs-5 me-2"></i> ${data.data.pesan_blokir}`;
                        btnSubmit.disabled = true;
                        btnSubmit.innerHTML = '<i class="bi bi-x-circle me-2"></i> TIDAK BISA DIAJUKAN';
                        btnSubmit.classList.replace('btn-primary', 'btn-danger');
                        alertPeringatan.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        alertPeringatan.style.display = 'none';
                        btnSubmit.disabled = false;
                        btnSubmit.innerHTML = '<i class="bi bi-send-fill me-2"></i> KIRIM USULAN';
                        btnSubmit.classList.replace('btn-danger', 'btn-primary');
                    }

                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tidak Ditemukan',
                        text: 'Data warga tidak ditemukan! Pastikan NIK atau No. KK sudah benar.',
                    });
                    document.getElementById('resultArea').style.display = 'none';
                }
            })
            .catch(error => {
                btnCari.innerHTML = originalText;
                btnCari.disabled = false;
                Swal.fire('Error', 'Terjadi kesalahan pada server. Pastikan koneksi internet stabil.', 'error');
            });
    }

    document.addEventListener("DOMContentLoaded", function() {
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'PENDAFTARAN DITOLAK!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Tutup'
            });
        @endif
    });
</script>
</body>
</html>