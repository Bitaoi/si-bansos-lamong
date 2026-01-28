<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyaluran extends Model
{
    use HasFactory;

    protected $table = 'penyalurans';
    protected $primaryKey = 'id_penyaluran';

    protected $fillable = [
        'id_pengajuan',
        'tgl_terima',
        'foto_bukti',
        'keterangan',
    ];

    // Agar tgl_terima otomatis dianggap Tanggal
    protected $casts = [
        'tgl_terima' => 'date',
    ];

    // Relasi balik ke Pengajuan
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'id_pengajuan', 'id_pengajuan');
    }
}