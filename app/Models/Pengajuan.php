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
        'alasan_pengajuan',
        'estimasi_penghasilan',
        'checklist_kriteria',
        'foto_ktp_kk',
        'foto_rumah_depan',
        'foto_rumah_dalam',
        'status_verifikasi_admin',
        'keterangan_ditolak',
        'berkas_observasi',
        'catatan_observasi',
        'berita_acara_musdes',
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
        // PERBAIKAN DISINI:
        // Parameter ke-3 dikembalikan ke 'id' (sesuai database)
        // Parameter ke-2 tetap 'id_bansos' (Foreign Key di tabel pengajuan)
        return $this->belongsTo(JenisBansos::class, 'id_bansos', 'id');
    }

    public function pengusul()
    {
        // Kalau User sudah fix pakai id_user, biarkan ini.
        // Tapi kalau User juga pakai id default, ubah jadi 'id'.
        // Berdasarkan chat sebelumnya, User pakai 'id_user', jadi ini biarkan.
        return $this->belongsTo(User::class, 'id_user_pengusul', 'id_user');
    }

    public function surveiEkonomi()
    {
        // Karena pengajuan bisa memiliki 1 hasil survei, kita gunakan hasOne
        // Asumsi di tabel survei_ekonomis foreign key-nya adalah 'pengajuan_id'
        return $this->hasOne(surveiEkonomi::class, 'pengajuan_id', 'id');
    }
}