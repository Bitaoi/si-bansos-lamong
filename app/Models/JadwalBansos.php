<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalBansos extends Model
{
    protected $table = 'jadwal_bansos';
    protected $fillable = ['nama_tahapan', 'deskripsi', 'hari_mulai', 'hari_selesai', 'warga_bg'];
}
