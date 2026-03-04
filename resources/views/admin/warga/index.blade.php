<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Warga - SI Bansos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
</head>
<body>

<div class="container-fluid mt-5 px-4"> <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Kelola Data Kependudukan</h3>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
            
            <a href="{{ route('warga.template') }}" class="btn btn-info text-white ms-2">
                 Download Template
            </a>

            <button type="button" class="btn btn-success ms-2" data-bs-toggle="modal" data-bs-target="#importModal">
                 Import Excel
            </button>

            <a href="{{ route('warga.create') }}" class="btn btn-primary ms-2">+ Tambah Manual</a>
        </div>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            Data Warga Desa Lamong
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tabelWarga" class="table table-bordered table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>L/P</th>
                            <th>No. KK</th>
                            <th>Tempat/Tgl Lahir</th>
                            <th>Alamat</th>
                            <th>RT/RW</th>
                            <th>Agama</th>
                            <th>Pendidikan</th>
                            <th>Pekerjaan</th>
                            <th>Status Kawin</th>
                            <th>Hubungan</th>
                            <th>Gol. Darah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wargas as $warga)
                        <tr>
                            <td>{{ $warga->nik }}</td>
                            <td>{{ $warga->nama_lengkap }}</td>
                            <td>{{ $warga->jenis_kelamin }}</td>
                            <td>{{ $warga->no_kk }}</td>
                            <td>{{ $warga->tempat_lahir }}, {{ $warga->tanggal_lahir->format('d-m-Y') }}</td>
                            <td>{{ $warga->alamat_lengkap }}</td>
                            <td>{{ $warga->rt }}/{{ $warga->rw }}</td>
                            
                            <td>{{ $warga->agama }}</td>
                            <td>{{ $warga->pendidikan }}</td>
                            <td>{{ $warga->pekerjaan }}</td>
                            <td>{{ $warga->status_kawin }}</td>
                            <td>{{ $warga->hubungan_keluarga }}</td>
                            <td>{{ $warga->golongan_darah }}</td>
                            
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-warning btn-sm">Edit</button>
                                    <form action="{{ route('warga.destroy', $warga->nik) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Import Data Warga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('warga.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Pilih File Excel</label>
                        <input class="form-control" type="file" name="file_excel" required>
                    </div>
                    <small class="text-muted">Gunakan tombol "Download Template" untuk melihat format kolom yang benar.</small>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script> <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script> <script>
    $(document).ready(function() {
        var table = $('#tabelWarga').DataTable({
            lengthChange: false, // Matikan dropdown "Show 10 entries" bawaan
            buttons: [ 
                {
                    extend: 'excel',
                    text: 'Export Excel',
                    className: 'btn btn-success btn-sm'
                },
                {
                    extend: 'colvis',
                    text: 'Tampilkan Kolom', // Tombol Show/Hide
                    className: 'btn btn-secondary btn-sm'
                }
            ],
            // Atur kolom mana yang mau disembunyikan secara default agar tabel rapi
            columnDefs: [
                {
                    targets: [3, 7, 8, 9, 10, 11, 12], // Index kolom (mulai dari 0)
                    visible: false // Sembunyikan No KK, Agama, dll di awal
                }
            ]
        });

        // Pindahkan tombol DataTables ke dalam layout Bootstrap agar rapi
        table.buttons().container()
            .appendTo( '#tabelWarga_wrapper .col-md-6:eq(0)' );
    });
</script>

</body>
</html>