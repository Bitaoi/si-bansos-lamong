<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use Illuminate\Support\Facades\DB;
use App\Imports\WargaImport;
use Maatwebsite\Excel\Facades\Excel;

class WargaController extends Controller
{
    // =========================================================================
    // MENU DATA WARGA (UNTUK ADMIN)
    // =========================================================================
    
    public function index(Request $request)
    {
        // Fitur Pencarian untuk Admin
        $keyword = $request->get('keyword');

        // Gunakan $query builder agar pagination tidak error
        $query = Warga::query();

        if ($keyword) {
            $query->where('nik', 'LIKE', "%{$keyword}%")
                  ->orWhere('nama_lengkap', 'LIKE', "%{$keyword}%");
        }

        // Terapkan pagination ke variabel $warga
        $wargas = $query->latest()->paginate(10)->withQueryString();

        return view('admin.warga.index', compact('wargas', 'keyword'));
    }

    public function create()
    {
        return view('admin.warga.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16|unique:wargas,nik',
            'status_keluarga' => 'required|string|in:Kepala Keluarga,Anggota Keluarga,Hidup Mandiri',
            'nama_lengkap' => 'required|string|max:150',
            'no_kk' => 'required|digits:16',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'status_perkawinan' => 'required|string|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati,Belum Kawin (Mandiri)',
            'nama_ibu_kandung' => 'required|string|max:150',
            'jumlah_keluarga' => 'required|integer|min:1',
            'alamat_lengkap' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
        ], [
            'nik.unique' => 'Warga sudah TERDAFTAR di dalam Sistem. Silahkan input Data warga Baru.',
        ]);

        Warga::create($request->all());

        return redirect()->route('warga.index')->with('success', 'Data Warga berhasil ditambahkan!');
    }

    public function edit($nik)
    {
        $warga = Warga::where('nik', $nik)->firstOrFail();
        return view('admin.warga.edit', compact('warga'));
    }

    public function update(Request $request, $nik)
    {
        $warga = Warga::where('nik', $nik)->firstOrFail();

        $request->validate([
            'status_keluarga' => 'required|string|in:Kepala Keluarga,Anggota Keluarga,Hidup Mandiri',
            'nama_lengkap' => 'required|string|max:150',
            'no_kk' => 'required|digits:16',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'status_perkawinan' => 'required|string|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati,Belum Kawin (Mandiri)',
            'nama_ibu_kandung' => 'required|string|max:150',
            'jumlah_keluarga' => 'required|integer|min:1',
            'alamat_lengkap' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
        ]);

        $warga->update($request->except(['nik'])); // NIK tidak boleh diupdate

        return redirect()->route('warga.index')->with('success', 'Data Warga berhasil diperbarui!');
    }

    public function destroy($nik)
    {
        $warga = Warga::where('nik', $nik)->firstOrFail();
        $warga->delete();

        return redirect()->route('warga.index')->with('success', 'Data Warga berhasil dihapus!');
    }

    // =========================================================================
    // FITUR IMPORT EXCEL (ADMIN)
    // =========================================================================
    
    public function downloadTemplate()
    {
        $filepath = public_path('template/Template_Import_Warga.xlsx');
        return response()->download($filepath, 'Template_Import_Warga.xlsx');
    }

    public function import(Request $request)
    {
        // 1. Cek Manual: Mencegah file gagal masuk karena ukurannya melebihi batas 2MB
        if (!$request->hasFile('file_excel')) {
            return redirect()->back()->with('error', 'GAGAL: File tidak ditemukan atau ukuran file terlalu besar (Maksimal 2MB).');
        }

        $file = $request->file('file_excel');
        $extension = strtolower($file->getClientOriginalExtension());

        // 2. Cek Ekstensi Manual: Mencegah Laravel memblokir MIME Type bawaan Windows secara diam-diam
        if (!in_array($extension, ['xlsx', 'xls', 'csv'])) {
            return redirect()->back()->with('error', 'GAGAL: Format file tidak didukung! Harus berupa .xlsx, .xls, atau .csv');
        }

        try {
            DB::beginTransaction();
            
            Excel::import(new \App\Imports\WargaImport, $file);
            
            DB::commit();
            return redirect()->route('warga.index')->with('success', 'Luar Biasa! Data warga berhasil di-import massal!');
            
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            DB::rollBack();
            $failures = $e->failures();
            $pesanError = "Gagal Import. Cek Baris Excel ke-" . $failures[0]->row() . ": " . $failures[0]->errors()[0];
            return redirect()->route('warga.index')->with('error', $pesanError);
            
        } catch (\Exception $e) {
            DB::rollBack();
            // 3. TANGKAP ERROR: Akan memunculkan peringatan merah di layar jika format kolom berantakan
            return redirect()->route('warga.index')->with('error', 'Terjadi kesalahan pembacaan sistem: ' . $e->getMessage());
        }
    }
    
    // =========================================================================
    // MENU DATA WARGA (UNTUK RT)
    // =========================================================================
    
    public function indexRT(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'RT') {
            abort(403);
        }

        // 1. Ambil RT dan RW dari format wilayah_rt_rw (misal "001/005")
        $wilayah = explode('/', $user->wilayah_rt_rw);
        $rt = $wilayah[0] ?? '-'; 
        $rw = $wilayah[1] ?? '-'; 

        // 2. Tampilan Blade milikmu menggunakan input name="search"
        $keyword = $request->get('search');
        $query = Warga::where('rt', $rt);

        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('nik', 'LIKE', "%{$keyword}%")
                  ->orWhere('nama_lengkap', 'LIKE', "%{$keyword}%");
            });
        }

        // 3. Tampilan Blade mengharapkan variabel bernama $wargas (pakai 's')
        $wargas = $query->paginate(15)->withQueryString();
        
        // 4. Kirim semua variabel yang dibutuhkan oleh Blade ($wargas, $rt, dan $rw)
        return view('rt.warga.index', compact('wargas', 'rt', 'rw'));
    }
}