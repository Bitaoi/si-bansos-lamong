<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\WargaImport;
use Maatwebsite\Excel\Facades\Excel;

class WargaController extends Controller
{
    // =================================================================
    // 1. DAFTAR WARGA (Pagination Fixed)
    // =================================================================
    public function index()
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        
        // Menggunakan paginate(10) agar fungsi links() di view bekerja
        $wargas = Warga::latest()->paginate(10);
        
        return view('admin.warga.index', compact('wargas'));
    }

    // =================================================================
    // 2. FORM TAMBAH
    // =================================================================
    public function create()
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        return view('admin.warga.create');
    }

    // =================================================================
    // 3. SIMPAN DATA BARU
    // =================================================================
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

    // =================================================================
    // 4. FORM EDIT
    // =================================================================
    public function edit($nik)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        
        // Cari warga berdasarkan NIK
        $warga = Warga::where('nik', $nik)->firstOrFail();
        
        return view('admin.warga.edit', compact('warga'));
    }

    // =================================================================
    // 5. UPDATE DATA (Validasi Unik Fixed)
    // =================================================================
    public function update(Request $request, $nik)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        // Ambil data lama sebelum diupdate
        $warga = Warga::where('nik', $nik)->firstOrFail();

        $request->validate([
            // PERBAIKAN PENTING: Ignore NIK lama saat cek unique
            // Format: unique:tabel,kolom,nilai_ignore,nama_kolom_primary
            'nik' => 'required|numeric|digits:16|unique:wargas,nik,'.$warga->nik.',nik',
            
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

        // Gunakan where('nik', $nik) untuk update karena NIK adalah string/custom primary key
        Warga::where('nik', $nik)->update([
            'nik' => $request->nik,
            'no_kk' => $request->no_kk,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'status_kawin' => $request->status_kawin,
            'hubungan_keluarga' => $request->hubungan_keluarga,
            'kewarganegaraan' => $request->kewarganegaraan,
            'alamat_lengkap' => $request->alamat_lengkap,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'nama_bank' => $request->nama_bank,
            'no_rekening' => $request->no_rekening
        ]);
        
        return redirect()->route('warga.index')->with('success', 'Data Warga berhasil diperbarui!');
    }

    // =================================================================
    // 6. HAPUS DATA
    // =================================================================
    public function destroy($nik)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        
        Warga::where('nik', $nik)->delete();
        
        return redirect()->route('warga.index')->with('success', 'Data Warga berhasil dihapus!');
    }

    // =================================================================
    // 7. DOWNLOAD TEMPLATE (Lengkap dengan Header)
    // =================================================================
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

    // =================================================================
    // 8. IMPORT EXCEL
    // =================================================================
    public function import(Request $request) 
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        
        // Nama input file di view adalah 'file'
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        
        try {
            Excel::import(new WargaImport, $request->file('file'));
            return redirect()->route('warga.index')->with('success', 'Sukses! Data Warga berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->route('warga.index')->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    // =================================================================
    // 9. DAFTAR WARGA KHUSUS RT (Filter Otomatis Wilayah)
    // =================================================================
    public function indexRT()
    {
        $user = Auth::user();
        if ($user->role !== 'RT') { abort(403); }

        // 1. Pecah format wilayah (Contoh: "001/005" menjadi RT "001" dan RW "005")
        $wilayah = explode('/', $user->wilayah_rt_rw);
        $rt = $wilayah[0] ?? '';
        $rw = $wilayah[1] ?? '';

        // 2. Query Filter: Hanya ambil warga yang RT dan RW-nya cocok
        // (Bisa juga ditambahkan toleransi jika format Excel warga berupa integer seperti "1" alih-alih "001")
        $wargas = Warga::where(function($query) use ($rt) {
                            $query->where('rt', $rt)->orWhere('rt', (int)$rt);
                       })
                       ->where(function($query) use ($rw) {
                            $query->where('rw', $rw)->orWhere('rw', (int)$rw);
                       })
                       ->latest()
                       ->paginate(10);

        return view('rt.warga.index', compact('wargas', 'rt', 'rw'));
    }

    // =================================================================
    // PENILAIAN SPK DESIL OLEH ADMIN
    // =================================================================
    public function updateDesil(Request $request, $nik)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        // Ganti findOrFail($id) menjadi pencarian berdasarkan NIK
        $warga = Warga::where('nik', $nik)->firstOrFail();

        // Ambil data checklist dari modal
        $daftarCentang = $request->checklist ?? [];
        $totalSkor = count($daftarCentang); 
        
        // Logika IF-ELSE Penentuan Desil
        if ($totalSkor >= 11) {
            $desil = 1; // Sangat Miskin
        } elseif ($totalSkor >= 8 && $totalSkor <= 10) {
            $desil = 2; // Miskin
        } elseif ($totalSkor >= 5 && $totalSkor <= 7) {
            $desil = 3; // Hampir Miskin
        } else {
            $desil = 4; // Tidak Miskin / Rentan
        }

        // Update angka desil ke database
        $warga->update(['desil' => $desil]);

        $kategori = ['1' => 'Sangat Miskin', '2' => 'Miskin', '3' => 'Hampir Miskin', '4' => 'Rentan/Mampu'];
        
        return back()->with('success', "Penilaian berhasil! Warga a.n {$warga->nama_lengkap} ditetapkan sebagai Desil {$desil} ({$kategori[$desil]}).");
    }
}