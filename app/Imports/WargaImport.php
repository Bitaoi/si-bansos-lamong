<?php

namespace App\Imports;

use App\Models\Warga;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class WargaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 1. Lewati baris kosong jika NIK tidak ada
        if (!isset($row['nik']) || empty($row['nik'])) {
            return null;
        }

        // 2. Bersihkan NIK dan KK
        $nik = str_replace("'", "", $row['nik']);
        $no_kk = isset($row['nkk']) ? str_replace("'", "", $row['nkk']) : '-';

        // 3. Format Tanggal Lahir (Mengatasi format angka Excel atau string Y-m-d)
        $tanggal_lahir = $row['tanggal_lahir'] ?? null;
        if (is_numeric($tanggal_lahir)) {
            $tanggal_lahir = Date::excelToDateTimeObject($tanggal_lahir)->format('Y-m-d');
        }

        // 4. Terjemahkan Status Kawin (S = Kawin, B = Belum Kawin, dll)
        $sts_kawin = 'Belum Diisi';
        if (isset($row['sts_kawin'])) {
            $s = strtoupper(trim($row['sts_kawin']));
            if ($s == 'S') $sts_kawin = 'Kawin';
            elseif ($s == 'B') $sts_kawin = 'Belum Kawin';
            elseif ($s == 'P') $sts_kawin = 'Cerai Hidup';
            else $sts_kawin = $s;
        }

        // 5. Cek Duplikasi NIK (Agar data yang sudah ada tidak error saat diimport ulang)
        $wargaAda = Warga::where('nik', $nik)->first();
        if ($wargaAda) {
            return null; // Skip jika NIK sudah ada
        }

        // 6. Masukkan ke Database
        return new Warga([
            'nik'               => $nik,
            'no_kk'             => $no_kk,
            'nama_lengkap'      => $row['nama'] ?? 'Tanpa Nama', // Dari header 'NAMA'
            'jenis_kelamin'     => isset($row['kelamin']) ? strtoupper(trim($row['kelamin'])) : 'L',
            'tempat_lahir'      => $row['tempat_lahir'] ?? '-',
            'tanggal_lahir'     => $tanggal_lahir ?? '1970-01-01',
            
            // Kolom yang TIDAK ADA di file Excel diisi default
            'agama'             => 'Belum Diisi',
            'pendidikan'        => 'Belum Diisi',
            'pekerjaan'         => 'Belum Diisi', 
            'hubungan_keluarga' => 'Belum Diisi', 
            'kewarganegaraan'   => 'WNI',
            'golongan_darah'    => '-',
            'nama_bank'         => null,
            'no_rekening'       => null,
            
            'status_kawin'      => $sts_kawin,
            'alamat_lengkap'    => $row['alamat'] ?? '-',
            'rt'                => $row['rt'] ?? '-',
            'rw'                => $row['rw'] ?? '-',
        ]);
    }
}