<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBansos extends Model
{
    use HasFactory;
    
    protected $table = 'jenis_bansos';

    // PERBAIKAN: Kurung sikunya dibiarkan KOSONG. 
    // Artinya: "Tidak ada kolom yang dilarang, izinkan semuanya masuk ke database."
    protected $guarded = [];

    // Beri tahu Laravel untuk mengubah JSON dari DB menjadi Array otomatis
    protected $casts = [
        'kriteria_desil' => 'array',
    ];
    
    // (Relasi yang sudah ada biarkan saja)
    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'id_bansos');
    }
    
    // Fungsi untuk menghitung sisa kuota secara otomatis
    public function getSisaKuotaAttribute()
    {
        // Hitung pengajuan yang sudah disetujui (Layak)
        $terpakai = $this->pengajuan()->where('status_verifikasi_admin', 'Layak')->count();
        return $this->kuota - $terpakai;
    }
}