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
        $keyword = $request->get('keyword');
        $query = Warga::query();

        if ($keyword) {
            $query->where('nik', 'LIKE', "%{$keyword}%")
                  ->orWhere('nama_lengkap', 'LIKE', "%{$keyword}%");
        }

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
        
        // 1. Ambil semua anggota keluarga berdasarkan KK yang sama, urutkan dari yang tertua
        $anggotaKeluarga = Warga::where('no_kk', $warga->no_kk)
                            ->orderBy('tanggal_lahir', 'asc')
                            ->get();

        // 2. LOGIKA PENENTUAN STRUKTUR KELUARGA OTOMATIS (DISEMPURNAKAN)
        // Kepala Keluarga: Laki-laki tertua. Jika tidak ada laki-laki, ambil orang tertua di KK.
        $kepalaKeluarga = $anggotaKeluarga->filter(function($item) {
            return in_array(strtolower($item->jenis_kelamin), ['l', 'laki-laki', 'laki - laki']);
        })->first() ?? $anggotaKeluarga->first();

        // Istri: Perempuan tertua yang BUKAN Kepala Keluarga, dan status perkawinannya BUKAN "Belum Kawin"
        $istri = $anggotaKeluarga->filter(function($item) use ($kepalaKeluarga) {
            $isPerempuan = in_array(strtolower($item->jenis_kelamin), ['p', 'perempuan']);
            $bukanKk = $item->nik !== $kepalaKeluarga->nik;
            $sudahKawin = !str_contains(strtolower($item->status_perkawinan ?? ''), 'belum kawin');
            return $isPerempuan && $bukanKk && $sudahKawin;
        })->first();

        // 3. Terapkan peran otomatis ke masing-masing anggota keluarga
        foreach ($anggotaKeluarga as $ak) {
            $peran = $ak->status_keluarga;

            // Jika status kependudukan di database masih kosong/umum, lakukan klasifikasi pintar
            if (in_array($peran, ['Belum Diisi', '-', 'Anggota Keluarga', null, ''])) {
                if ($ak->nik === $kepalaKeluarga->nik) {
                    $peran = ($anggotaKeluarga->count() == 1) ? 'Kepala Keluarga (Mandiri)' : 'Kepala Keluarga';
                } elseif ($istri && $ak->nik === $istri->nik) {
                    $peran = 'Istri';
                } else {
                    // REVISI UTAMA: Mengubah dari label "Anak" menjadi "Anggota Keluarga" agar lebih universal & akurat
                    $peran = 'Anggota Keluarga';
                }
            }
            $ak->peran_otomatis = $peran;
        }

        // 4. Urutkan Tampilan di Form: Kepala Keluarga -> Istri -> Anggota Keluarga lainnya
        $urutanPeran = ['Kepala Keluarga (Mandiri)' => 1, 'Kepala Keluarga' => 2, 'Istri' => 3, 'Anggota Keluarga' => 4];
        $anggotaKeluarga = $anggotaKeluarga->sortBy(function($ak) use ($urutanPeran) {
            return $urutanPeran[$ak->peran_otomatis] ?? 5;
        })->values();
        
        return view('admin.warga.edit', compact('warga', 'anggotaKeluarga'));
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
            'alamat_lengkap' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
        ]);

        $warga->update($request->except(['nik', 'jumlah_keluarga']));

        $jumlahKeluargaAktual = Warga::where('no_kk', $warga->no_kk)->count();
        Warga::where('no_kk', $warga->no_kk)->update([
            'jumlah_keluarga' => $jumlahKeluargaAktual
        ]);

        return redirect()->route('warga.index')->with('success', 'Data Warga berhasil diperbarui, dan status tanggungan keluarga telah disinkronkan otomatis!');
    }

    public function destroy($nik)
    {
        $warga = Warga::where('nik', $nik)->firstOrFail();
        $warga->delete();
        return redirect()->route('warga.index')->with('success', 'Data Warga berhasil dihapus!');
    }

    public function downloadTemplate()
    {
        $filepath = public_path('template/Template_Import_Warga.xlsx');
        return response()->download($filepath, 'Template_Import_Warga.xlsx');
    }

    public function import(Request $request)
    {
        if (!$request->hasFile('file_excel')) {
            return redirect()->back()->with('error', 'GAGAL: File tidak ditemukan atau ukuran file terlalu besar (Maksimal 2MB).');
        }

        $file = $request->file('file_excel');
        $extension = strtolower($file->getClientOriginalExtension());

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
            return redirect()->route('warga.index')->with('error', "Gagal Import. Cek Baris Excel ke-" . $failures[0]->row() . ": " . $failures[0]->errors()[0]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('warga.index')->with('error', 'Terjadi kesalahan pembacaan sistem: ' . $e->getMessage());
        }
    }
    
    public function indexRT(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'RT') { abort(403); }

        $wilayah = explode('/', $user->wilayah_rt_rw);
        $rt = $wilayah[0] ?? '-'; 
        $rw = $wilayah[1] ?? '-'; 

        $keyword = $request->get('search');
        $query = Warga::where('rt', $rt);

        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('nik', 'LIKE', "%{$keyword}%")
                  ->orWhere('nama_lengkap', 'LIKE', "%{$keyword}%");
            });
        }

        $wargas = $query->paginate(15)->withQueryString();
        return view('rt.warga.index', compact('wargas', 'rt', 'rw'));
    }
}