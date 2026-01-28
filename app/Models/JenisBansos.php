<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBansos extends Model
{
    use HasFactory;

    protected $table = 'jenis_bansos';

    // KITA HAPUS baris 'protected $primaryKey' 
    // Karena default Laravel sudah otomatis mendeteksi kolom 'id' sebagai primary key.

    protected $fillable = [
        'nama_bansos',
        'kriteria',
    ];

    // Relasi ke Pengajuan kita simpan dulu (di-comment), 
    // Nanti kita aktifkan setelah Model Pengajuan dibuat agar tidak error.
    /*
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class);
    }
    */
}