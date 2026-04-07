<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Akun RT - Admin SI Bansos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>body { background-color: #f3f4f6; }</style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold">Tambah Akun Ketua RT</h4>
                <a href="{{ route('admin.rt.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="{{ route('admin.rt.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap Ketua RT <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required placeholder="Contoh: Budi Santoso">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Wilayah (RT/RW) <span class="text-danger">*</span></label>
                            <input type="text" name="wilayah_rt_rw" class="form-control" value="{{ old('wilayah_rt_rw') }}" required placeholder="Contoh: 001/005">
                            <div class="form-text">Gunakan format angka 3 digit dipisah garis miring (RT/RW). Pastikan sama persis dengan data wilayah di Data Warga.</div>
                        </div>

                        <hr class="my-4">
                        <h6 class="fw-bold text-primary mb-3">Kredensial Login</h6>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" value="{{ old('username') }}" required placeholder="Contoh: rt001">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2"><i class="bi bi-save-fill me-2"></i>SIMPAN AKUN</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>