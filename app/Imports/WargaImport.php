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
        // 1. Fleksibilitas nama kolom header
        $nik = $row['nik'] ?? $row['nik_ktp'] ?? null;
        $nkk = $row['nkk'] ?? $row['no_kk'] ?? null;
        $nama = $row['nama'] ?? $row['nama_lengkap'] ?? null;

        // 2. Lewati (skip) baris yang kosong
        if (!$nik || !$nama) return null;

        // 3. Cek Duplikasi NIK
        if (Warga::where('nik', $nik)->exists()) return null;

        // 4. PERBAIKAN: Format Jenis Kelamin (Sesuai ENUM database yaitu 'L' atau 'P')
        $kelaminRaw = strtoupper($row['kelamin'] ?? 'L');
        $kelamin = ($kelaminRaw == 'P' || $kelaminRaw == 'PEREMPUAN') ? 'P' : 'L';

        // 5. Translasi Tanggal Lahir khusus format .xlsx
        $tglLahir = null;
        if (isset($row['tanggal_lahir'])) {
            if (is_numeric($row['tanggal_lahir'])) {
                $tglLahir = Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d');
            } else {
                $tglLahir = date('Y-m-d', strtotime($row['tanggal_lahir']));
            }
        }

        // 6. Mapping data ke Database dengan penambahan default untuk kolom Wajib (NOT NULL)
        return new Warga([
            'nik'               => $nik,
            'no_kk'             => $nkk,
            'nama_lengkap'      => $nama,
            'tempat_lahir'      => $row['tempat_lahir'] ?? '-',
            'tanggal_lahir'     => $tglLahir ?? '1970-01-01', // Fallback tanggal
            
            'jenis_kelamin'     => $kelamin, // SEKARANG HANYA MENGIRIM 'L' atau 'P'
            
            // Kolom wajib di database yang tidak ada di CSV diberi nilai default
            'agama'             => $row['agama'] ?? 'Islam',
            'pendidikan'        => $row['pendidikan'] ?? 'Belum Diisi',
            'pekerjaan'         => $row['pekerjaan'] ?? 'Belum Diisi',
            
            'status_kawin'      => $row['sts_kawin'] ?? '-',
            'alamat_lengkap'    => $row['alamat'] ?? '-',
            
            'rt'                => isset($row['rt']) ? str_pad($row['rt'], 3, '0', STR_PAD_LEFT) : '000',
            'rw'                => isset($row['rw']) ? str_pad($row['rw'], 3, '0', STR_PAD_LEFT) : '000',
            
            'hubungan_keluarga' => 'Belum Diisi',
            'status_keluarga'   => 'Anggota Keluarga',
            'desil'             => null
        ]);
    }
}