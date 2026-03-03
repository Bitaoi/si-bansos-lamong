<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'wargas';
    protected $primaryKey = 'nik';

    // Karena primary key NIK berupa string dan bukan auto-increment
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nik', 'no_kk', 'nama_lengkap', 
        'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama',
        'pendidikan', 'pekerjaan', 'status_kawin', 'hubungan_keluarga',
        'kewarganegaraan', 'alamat_lengkap', 'rt', 'rw', 'golongan_darah',
        'nama_bank', 'no_rekening'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date', // Ini kuncinya! Ubah string jadi Date otomatis
    ];

    // Relasi: satu warga dapat memiliki banyak pengajuan
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class, 'nik', 'nik');
    }
}
