<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib import Auth
use App\Imports\WargaImport;
use App\Exports\WargaTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

class WargaController extends Controller
{
    // 1. Menampilkan Daftar Warga
    public function index()
    {
        // KEAMANAN: Cek Admin
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Akses Ditolak.');
        }

        $wargas = Warga::latest()->get(); 
        return view('admin.warga.index', compact('wargas'));
    }

    // 2. Menampilkan Form Tambah Warga
    public function create()
    {
        // KEAMANAN: Cek Admin
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
            // golongan_darah boleh kosong (nullable)
        ]);

        Warga::create($request->all());
        return redirect()->route('warga.index')->with('success', 'Data Warga berhasil ditambahkan!');
    }

    // Fungsi Download Template Excel
    public function downloadTemplate()
    {
        // Kita buat file excel sederhana dengan header saja
        $headers = [
            'nik', 'no_kk', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 
            'tanggal_lahir', 'agama', 'pendidikan', 'pekerjaan', 'status_kawin', 
            'hubungan_keluarga', 'kewarganegaraan', 'alamat_lengkap', 'rt', 'rw', 'golongan_darah'
        ];
        
        // Menggunakan library Excel untuk download instan tanpa buat file class baru
        return Excel::download(new class($headers) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            protected $headers;
            public function __construct($headers) { $this->headers = $headers; }
            public function collection() { return collect([]); } // Data kosong
            public function headings(): array { return $this->headers; }
        }, 'template_warga.xlsx');
    }

    // 4. Menghapus Data Warga
    public function destroy($nik)
    {
        // KEAMANAN: Cek Admin
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Akses Ditolak.');
        }

        Warga::where('nik', $nik)->delete();
        return redirect()->route('warga.index')
                         ->with('success', 'Data Warga berhasil dihapus!');
    }

    // --- TAMBAHAN BARU: FUNGSI IMPORT ---
    public function import(Request $request) 
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new WargaImport, $request->file('file_excel'));
            return redirect()->route('warga.index')->with('success', 'Sukses! Data Warga berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->route('warga.index')->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}