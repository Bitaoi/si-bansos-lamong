<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBansos extends Model
{
    use HasFactory;

    protected $table = 'jenis_bansos';

    // Daftarkan semua kolom baru dari migration/form di sini
    protected $fillable = [
        'nama_bansos',
        'kode_bansos',
        'sumber_dana',
        'deskripsi',
        'kriteria_penerima', // Ganti 'kriteria' jadi ini
        'syarat_dtks',
        'batas_penghasilan',
        'bentuk_bantuan',
        'nominal',
        'frekuensi',
        'tahun_anggaran',
        'kuota_penerima',
        'status',
    ];
}