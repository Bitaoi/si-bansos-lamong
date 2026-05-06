<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Penyaluran Bansos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8fafc; }
        .timeline-card { border: none; border-radius: 15px; transition: transform 0.3s; }
        .timeline-card:hover { transform: translateY(-5px); }
        
        /* Animasi Berkedip untuk Jadwal Aktif */
        .pulse-active {
            animation: pulse-animation 2s infinite;
            border: 3px solid #0d6efd !important;
        }
        @keyframes pulse-animation {
            0% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.5); }
            70% { box-shadow: 0 0 0 15px rgba(13, 110, 253, 0); }
            100% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0); }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark py-3">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
        </div>
    </nav>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Siklus Tahapan Bansos Bulanan</h2>
            <p class="text-muted">Proses pengusulan hingga pengesahan dilakukan secara bertahap setiap bulannya sesuai kalender di bawah ini.</p>
            <div class="badge bg-primary fs-5 mt-2">Hari ini: Tanggal {{ $hariIni }}</div>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($jadwal as $item)
                @php 
                    $isActive = ($hariIni >= $item->hari_mulai && $hariIni <= $item->hari_selesai); 
                @endphp
                <div class="col-md-4">
                    <div class="card timeline-card h-100 shadow-sm {{ $isActive ? 'pulse-active' : '' }}" style="border-top: 8px solid {{ $item->warna_bg }};">
                        <div class="card-body text-center p-4">
                            @if($isActive)
                                <span class="badge bg-primary mb-3"><i class="bi bi-broadcast me-1"></i> Sedang Berlangsung</span>
                            @endif
                            <h5 class="fw-bold">{{ $item->nama_tahapan }}</h5>
                            <h2 class="display-5 fw-bold" style="color: {{ $item->warna_bg }};">Tgl {{ $item->hari_mulai }}-{{ $item->hari_selesai > 30 ? 'Akhir' : $item->hari_selesai }}</h2>
                            <p class="text-muted mt-3 mb-0">{{ $item->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>