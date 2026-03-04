<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuans';

    protected $fillable = [
        'nik',
        'id_bansos',
        'id_user_pengusul',
        'tgl_pengajuan',
        
        // Kolom Baru
        'alasan_pengajuan',
        'estimasi_penghasilan',
        'checklist_kriteria', // Akan disimpan sebagai JSON
        'foto_ktp_kk',
        'foto_rumah_depan',
        'foto_rumah_dalam',
        
        'status_verifikasi_admin',
        'keterangan_ditolak'
    ];

    protected $casts = [
        'checklist_kriteria' => 'array',
        'tgl_pengajuan' => 'date'
    ];

    // ================= RELASI =================

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'nik', 'nik');
    }

    public function jenisBansos()
    {
        return $this->belongsTo(JenisBansos::class, 'id_bansos', 'id');
    }

    public function pengusul()
    {
        // PERBAIKAN DISINI:
        // Parameter ke-3 diganti dari 'id' menjadi 'id_user'
        return $this->belongsTo(User::class, 'id_user_pengusul', 'id_user');
    }
}