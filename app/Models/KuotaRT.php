<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class KuotaRT extends Model {
    protected $table = 'kuota_rts';
    protected $fillable = ['id_bansos', 'id_periode', 'rt', 'rw', 'kuota', 'terpakai'];

    public function jenisBansos() {
        return $this->belongsTo(JenisBansos::class, 'id_bansos');
    }
}