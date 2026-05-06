<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBansos extends Model
{
    use HasFactory;
    
    protected $table = 'jenis_bansos';

    protected $fillable = [
        'nama_bansos', 
        'kode_bansos', 
        'sumber_dana',
        'deskripsi_bantuan',
        'bentuk_penyerahan',
        'nominal', 
        'frekuensi', 
        'tahun_anggaran',
        'kuota',
        'deskripsi_kuota', 
        'kriteria_desil'   
    ];

    // Beri tahu Laravel untuk mengubah JSON dari DB menjadi Array otomatis
    protected $casts = [
        'kriteria_desil' => 'array',
    ];
    
    // (Relasi yang sudah ada biarkan saja)
    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'id_bansos');
    }
}