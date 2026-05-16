<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Bansos</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #2C3E50; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #2C3E50; font-size: 16pt; }
        .header p { margin: 5px 0 0 0; color: #666; font-size: 10pt; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 6px; text-align: left; }
        th { background-color: #7D88DC; color: white; text-align: center; font-weight: bold; }
        .text-center { text-align: center; }
        .text-success { color: green; font-weight: bold; }
        .text-danger { color: red; font-weight: bold; }
        .text-warning { color: orange; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN REKAPITULASI BANTUAN SOSIAL</h1>
        <p>Pemerintah Desa Lamong - Periode: {{ $namaBulan }} {{ $tahunFilter }}</p>
        <p style="font-size: 9pt;">Dibuat oleh: {{ Auth::user()->role }} | Tgl Cetak: {{ date('d-m-Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tgl Pengajuan</th>
                <th style="width: 15%;">NIK</th>
                <th style="width: 20%;">Nama Lengkap</th>
                <th style="width: 15%;">Program Bansos</th>
                <th style="width: 30%;">Status Verifikasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuans as $key => $p)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td class="text-center">{{ $p->tgl_pengajuan->format('d/m/Y') }}</td>
                <td class="text-center">{{ $p->nik }}</td>
                <td>{{ $p->warga->nama_lengkap ?? 'Terhapus' }}</td>
                <td class="text-center">{{ $p->jenisBansos->nama_bansos ?? '-' }}</td>
                <td>
                    @if($p->status_verifikasi_admin == 'Layak')
                        <span class="text-success">Layak / Disetujui</span>
                    @elseif($p->status_verifikasi_admin == 'Tidak Layak')
                        <span class="text-danger">Ditolak</span>
                    @else
                        <span class="text-warning">Dalam Proses</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">Tidak ada data pengajuan pada periode ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>