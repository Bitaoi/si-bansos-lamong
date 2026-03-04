<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Imports\WargaImport;
use Maatwebsite\Excel\Facades\Excel;

class WargaController extends Controller
{
    // 1. Menampilkan Daftar Warga
    public function index()
    {
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Akses Ditolak.');
        }

        // PERBAIKAN UTAMA DISINI:
        // Ganti ->get() menjadi ->paginate(10)
        // Angka 10 artinya menampilkan 10 warga per halaman
        $wargas = Warga::latest()->paginate(10); 
        
        return view('admin.warga.index', compact('wargas'));
    }

    // 2. Menampilkan Form Tambah Warga
    public function create()
    {
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Akses Ditolak.');
        }

        return view('admin.warga.create');
    }

    // 3. Menyimpan Data Warga ke Database
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $request->validate([
            'nik' => 'required|numeric|digits:16|unique:wargas,nik',
            'no_kk' => 'required|numeric|digits:16',
            'nama_lengkap' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required',
            'pendidikan' => 'required',
            'pekerjaan' => 'required',
            'status_kawin' => 'required',
            'hubungan_keluarga' => 'required',
            'kewarganegaraan' => 'required',
            'alamat_lengkap' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'nama_bank' => 'nullable|string',
            'no_rekening' => 'nullable|numeric'
        ]);

        Warga::create($request->all());
        return redirect()->route('warga.index')->with('success', 'Data Warga berhasil ditambahkan!');
    }

    // 4. Menghapus Data Warga
    public function destroy($nik)
    {
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Akses Ditolak.');
        }

        Warga::where('nik', $nik)->delete();
        return redirect()->route('warga.index')
                         ->with('success', 'Data Warga berhasil dihapus!');
    }

    // 5. Download Template Excel
    public function downloadTemplate()
    {
        $headers = [
            'nik', 'no_kk', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 
            'tanggal_lahir', 'agama', 'pendidikan', 'pekerjaan', 'status_kawin', 
            'hubungan_keluarga', 'kewarganegaraan', 'alamat_lengkap', 'rt', 'rw', 'golongan_darah'
        ];
        
        return Excel::download(new class($headers) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            protected $headers;
            public function __construct($headers) { $this->headers = $headers; }
            public function collection() { return collect([]); } 
            public function headings(): array { return $this->headers; }
        }, 'template_warga.xlsx');
    }

    // 6. Import Data Warga
    public function import(Request $request) 
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        // PERBAIKAN KEDUA:
        // Sesuaikan nama field dengan view (name="file")
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv' 
        ]);

        try {
            Excel::import(new WargaImport, $request->file('file'));
            return redirect()->route('warga.index')->with('success', 'Sukses! Data Warga berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->route('warga.index')->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}