<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Bansos</title>
    
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
        .bg-primary { background-color: var(--warna-utama) !important; color: #ffffff !important; }
        .btn-primary { background-color: var(--warna-utama) !important; border-color: var(--warna-utama) !important; color: #ffffff !important; }
        .btn-primary:hover { background-color: var(--warna-paling-gelap) !important; border-color: var(--warna-paling-gelap) !important; }
        .sidebar { min-height: 100vh; background: var(--warna-paling-gelap); color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-radius: 8px; margin-bottom: 5px; font-weight: 500; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: var(--warna-utama); color: white; }
        .nav-link i { width: 24px; display: inline-block; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: var(--warna-soft); font-weight: 700; padding: 10px 20px; letter-spacing: 0.5px; opacity: 0.8; }
        .card { border: 1px solid var(--warna-soft) !important; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .form-control, .form-select { border-radius: 8px; padding: 10px 15px; border-color: #e2e8f0; }
        .form-control:focus, .form-select:focus { border-color: var(--warna-utama); box-shadow: 0 0 0 0.25rem rgba(125, 136, 220, 0.25); }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 sidebar p-3 d-none d-md-block">
            <h5 class="fw-bold mb-4 px-2 py-2 border-bottom text-white" style="border-color: var(--warna-soft) !important;">
                <i class="bi bi-shield-lock-fill me-2"></i>KASI KESEJAHTERAAN DESA
            </h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('admin.rt.index') }}" class="nav-link"><i class="bi bi-person-badge-fill"></i> Manajemen Akun RT</a></li>
                <div class="sidebar-heading mt-3">Master Data</div>
                <li class="nav-item"><a href="{{ route('warga.index') }}" class="nav-link"><i class="bi bi-people-fill"></i> Data Warga</a></li>
                <li class="nav-item"><a href="{{ route('jenis-bansos.index') }}" class="nav-link active"><i class="bi bi-gift-fill"></i> Jenis Bansos</a></li>
                <li class="nav-item"><a href="{{ route('admin.jadwal.index') }}" class="nav-link"><i class="bi bi-calendar-event"></i> Jadwal Tahapan</a></li>
                <div class="sidebar-heading mt-3">Transaksi</div>
                <li class="nav-item"><a href="{{ route('verifikasi.index') }}" class="nav-link"><i class="bi bi-file-earmark-check-fill"></i> Verifikasi Pengajuan</a></li>
                <li class="nav-item"><a href="{{ route('penyaluran.index') }}" class="nav-link"><i class="bi bi-truck"></i> Penyaluran</a></li>
            </ul>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Tambah Program Bansos</h4>
                    <p class="text-muted mb-0">Buat program bantuan sosial baru dan atur kriteria kelayakannya.</p>
                </div>
                <a href="{{ route('jenis-bansos.index') }}" class="btn btn-outline-secondary fw-bold shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
                <form action="{{ route('jenis-bansos.store') }}" method="POST">
                    @csrf
                    
                    <h6 class="fw-bold text-primary mb-3"><i class="bi bi-info-circle me-2"></i>Informasi Dasar Bansos</h6>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Nama Program Bansos <span class="text-danger">*</span></label>
                            <input type="text" name="nama_bansos" class="form-control" placeholder="Cth: Program Keluarga Harapan (PKH)" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Kode / Singkatan <span class="text-danger">*</span></label>
                            <input type="text" name="kode_bansos" class="form-control" placeholder="Cth: PKH-2026" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Sumber Dana <span class="text-danger">*</span></label>
                            <input type="text" name="sumber_dana" class="form-control" placeholder="Cth: APBN / Dana Desa / APBD" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Deskripsi Singkat Bantuan</label>
                        <textarea name="deskripsi_bantuan" class="form-control" rows="2" placeholder="Jelaskan secara singkat tujuan program bantuan ini..."></textarea>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Bentuk Penyerahan <span class="text-danger">*</span></label>
                            <select name="bentuk_penyerahan" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="Uang Tunai">Uang Tunai</option>
                                <option value="Transfer Bank">Transfer Bank / KKS</option>
                                <option value="Barang / Sembako">Barang / Sembako</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Nominal/Nilai (Rp) <span class="text-danger">*</span></label>
                            <input type="text" name="nominal" class="form-control" placeholder="Cth: 600.000" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Frekuensi Penyaluran <span class="text-danger">*</span></label>
                            <input type="text" name="frekuensi" class="form-control" placeholder="Cth: 3 Bulan Sekali" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Tahun Anggaran <span class="text-danger">*</span></label>
                            <input type="number" name="tahun_anggaran" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                    </div>

                    <hr class="text-muted my-4">

                    <h6 class="fw-bold text-primary mb-3"><i class="bi bi-ui-checks-grid me-2"></i>Kriteria Penerima Layak</h6>
                    
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold small text-muted">Kriteria Sasaran (Berdasarkan Desil)</label>
                        <div class="row g-3 bg-light p-3 rounded-3 border" style="border-color: #e2e8f0 !important;">
                            @for($i = 1; $i <= 10; $i++)
                            <div class="col-6 col-md-4 col-lg-2">
                                <div class="form-check">
                                    <input class="form-check-input border-secondary shadow-sm" type="checkbox" name="kriteria_desil[]" value="{{ $i }}" id="desil{{ $i }}">
                                    <label class="form-check-label text-dark" for="desil{{ $i }}">
                                        Desil {{ $i }}
                                    </label>
                                </div>
                            </div>
                            @endfor
                        </div>
                        <div class="form-text mt-2"><i class="bi bi-exclamation-triangle-fill text-warning me-1"></i> Centang desil mana saja yang berhak menerima bantuan ini.</div>
                    </div>

                    <div class="mb-4 mt-3">
                        <label class="form-label small fw-bold">Deskripsi Kriteria Tambahan (Selain Desil)</label>
                        <textarea name="kriteria_lainnya" class="form-control" rows="2" placeholder="Cth: Diutamakan lansia di atas 60 tahun, janda/duda, atau memiliki balita/anak sekolah..."></textarea>
                    </div>

                    <h6 class="fw-bold text-primary mb-3 mt-4"><i class="bi bi-people me-2"></i>Alokasi Kuota</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Kuota Maksimal (Angka)</label>
                            <input type="number" name="kuota" class="form-control" placeholder="Cth: 150">
                        </div>
                        <div class="col-md-9">
                            <label class="form-label small fw-bold">Sasaran / Deskripsi Kuota Tambahan</label>
                            <input type="text" name="deskripsi_kuota" class="form-control" placeholder="Cth: Menjangkau anak yatim piatu di seluruh Indonesia sesuai validasi data DTSEN...">
                        </div>
                    </div>

                    <div class="text-end mt-5">
                        <button type="reset" class="btn btn-light fw-bold me-2 px-4 shadow-sm border">Reset</button>
                        <button type="submit" class="btn btn-primary fw-bold px-5 shadow-sm">
                            <i class="bi bi-save me-2"></i>Simpan Program
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Pop-up jika ada Error Validasi (Form kosong/salah)
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Data Belum Lengkap!',
                html: `
                    <div class="text-danger mb-2">Mohon periksa kembali isian form Anda:</div>
                    <ul style="text-align: left; font-size: 0.9rem; margin-bottom: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Saya Mengerti',
                customClass: { popup: 'rounded-4 shadow-lg' }
            });
        @endif

        // Pop-up jika Berhasil (Opsional, untuk notif sukses)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#7D88DC',
                customClass: { popup: 'rounded-4 shadow-lg' }
            });
        @endif
    });
</script>
</html>