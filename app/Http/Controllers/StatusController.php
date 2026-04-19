<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        $nik = $request->nik;
        $pengajuan = null;
        $dicari = false;

        if ($nik) {
            $dicari = true;
            $pengajuan = Pengajuan::with(['jenisBansos', 'warga'])
                        ->where('nik', $nik)
                        ->latest('tgl_pengajuan')
                        ->first();
        }

        return view('status', compact('pengajuan', 'nik', 'dicari'));
    }
}