<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuotaWilayah extends Model
{
    use HasFactory;
    
    protected $table = 'kuota_wilayahs';
    protected $fillable = ['id_bansos', 'rt', 'rw', 'kuota_maksimal', 'kuota_terpakai'];

    public function jenisBansos()
    {
        return $this->belongsTo(JenisBansos::class, 'id_bansos', 'id');
    }
}