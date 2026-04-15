<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SurveiEkonomi extends Model {
    protected $fillable = [
        'pengajuan_id', 'jenis_lantai', 'jenis_dinding', 
        'sumber_air', 'daya_listrik', 'kepemilikan_aset', 
        'total_skor', 'desil_hasil'
    ];

    public function pengajuan() {
        return $this->belongsTo(Pengajuan::class);
    }
}