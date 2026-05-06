<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JadwalBansosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\JadwalBansos::insert([
            [
                'nama_tahapan' => 'Usulan & Musdes',
                'deskripsi' => 'Penginputan data warga baru oleh Operator Desa dan pelaksanaan Musyawarah Desa (Musdes).',
                'hari_mulai' => 1,
                'hari_selesai' => 11,
                'warna_bg' => '#198754' // Hijau
            ],
            [
                'nama_tahapan' => 'Cutoff & Pembaruan DTSEN',
                'deskripsi' => 'Batas akhir usulan tiap bulan dan sinkronisasi data oleh Dinas Sosial Kabupaten.',
                'hari_mulai' => 12,
                'hari_selesai' => 14,
                'warna_bg' => '#fd7e14' // Orange
            ],
            [
                'nama_tahapan' => 'Pengesahan Kepala OPD',
                'deskripsi' => 'Verifikasi akhir dan Pengesahan Usulan Bantuan Sosial oleh Kepala Daerah/Kemensos.',
                'hari_mulai' => 15,
                'hari_selesai' => 31,
                'warna_bg' => '#d63384' // Pink
            ]
        ]);
    }
}