<?php

namespace App\Imports;

use App\Models\Warga;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date; // Library untuk ubah angka 31118 jadi tanggal

class WargaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 1. BERSIHKAN TANDA PETIK DI NIK & KK
        // Kita pakai str_replace untuk membuang tanda '
        $nik = str_replace("'", "", $row['nik']);
        $no_kk = str_replace("'", "", $row['no_kk']);

        //2. Cek Rekening
        $no_rekening = isset($row['no_rekening']) ? str_replace("'", "", $row['no_rekening']) : null;

        // 2. PERBAIKI FORMAT TANGGAL
        // Cek apakah tanggalnya berupa angka Excel (misal: 31118)
        $tanggal_lahir = $row['tanggal_lahir'];
        if (is_numeric($tanggal_lahir)) {
            // Ubah angka Excel jadi format YYYY-MM-DD
            $tanggal_lahir = Date::excelToDateTimeObject($tanggal_lahir)->format('Y-m-d');
        }

        return new Warga([
            'nik'               => $nik,         // Pakai variable yang sudah bersih
            'no_kk'             => $no_kk,       // Pakai variable yang sudah bersih
            'nama_lengkap'      => $row['nama_lengkap'],
            'jenis_kelamin'     => $row['jenis_kelamin'],
            'tempat_lahir'      => $row['tempat_lahir'],
            'tanggal_lahir'     => $tanggal_lahir, // Pakai tanggal yang sudah diperbaiki
            'agama'             => $row['agama'],
            'pendidikan'        => $row['pendidikan'],
            'pekerjaan'         => $row['pekerjaan'],
            'status_kawin'      => $row['status_kawin'],
            'hubungan_keluarga' => $row['hubungan_keluarga'],
            'kewarganegaraan'   => $row['kewarganegaraan'],
            'alamat_lengkap'    => $row['alamat_lengkap'],
            'rt'                => $row['rt'],
            'rw'                => $row['rw'],
            'golongan_darah'    => $row['golongan_darah'],
            'nama_bank'         => $row['nama_bank'] ?? null,
            'no_rekening'       => $no_rekening,
        ]);
    }
}