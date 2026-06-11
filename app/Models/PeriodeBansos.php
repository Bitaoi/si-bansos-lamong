<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PeriodeBansos extends Model {
    protected $table = 'periode_bansos';
    protected $fillable = ['nama_periode', 'tanggal_mulai', 'tanggal_akhir', 'status'];

    public function pengajuan() {
        return $this->hasMany(Pengajuan::class, 'id_periode');
    }
}