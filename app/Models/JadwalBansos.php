<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalBansos extends Model
{
    use HasFactory;

    protected $table = 'jadwal_bansos';

    // PASTIKAN 'id_periode' ADA DI DALAM SINI
    protected $fillable = [
        'id_periode', 
        'nama_tahapan', 
        'hari_mulai', 
        'hari_selesai', 
        'deskripsi', 
        'warna_bg'
    ];

    // ===========================================
    // INI ADALAH FUNGSI RELASI YANG HILANG
    // ===========================================
    public function periode()
    {
        return $this->belongsTo(PeriodeBansos::class, 'id_periode');
    }
}