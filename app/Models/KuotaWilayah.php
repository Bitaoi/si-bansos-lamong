<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuotaWilayah extends Model
{
    use HasFactory;
    
    protected $table = 'kuota_wilayahs';
    
    // Ganti $fillable menjadi $guarded kosong agar semua data (termasuk id_periode) aman masuk
    protected $guarded = [];

    public function jenisBansos()
    {
        return $this->belongsTo(JenisBansos::class, 'id_bansos', 'id');
    }

    public function periode()
    {
        return $this->belongsTo(PeriodeBansos::class, 'id_periode', 'id');
    }
}