<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTemplate extends Model
{
    use HasFactory;

    protected $table = 'surat_templates';
    
    protected $fillable = [
        'judul_surat',
        'tipe',
        'konten_html',
        'is_active',
    ];
}