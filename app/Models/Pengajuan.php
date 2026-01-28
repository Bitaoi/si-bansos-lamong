<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuans';
    protected $primaryKey = 'id_pengajuan';

    protected $fillable = [
        'nik',
        'id_bansos',
        'id_user_pengusul',
        'tgl_pengajuan',
        'status_verifikasi_admin', // Proses, Layak, Tidak Layak
        'file_dokumen_pendukung',
    ];

    // Agar tgl_pengajuan otomatis dianggap sebagai Tanggal oleh Laravel
    protected $casts = [
        'tgl_pengajuan' => 'date',
    ];

    // --- RELASI (BelongsTo) ---

    // Milik Warga siapa?
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'nik', 'nik');
    }

    // Jenis Bansos apa?
    public function jenisBansos()
    {
        return $this->belongsTo(JenisBansos::class, 'id_bansos', 'id_bansos');
    }

    // Siapa RT pengusulnya?
    public function userPengusul()
    {
        return $this->belongsTo(User::class, 'id_user_pengusul', 'id_user');
    }

    // --- RELASI (HasOne) ---
    
    
    public function penyaluran()
    {
        return $this->hasOne(Penyaluran::class, 'id_pengajuan', 'id_pengajuan');
    }
}