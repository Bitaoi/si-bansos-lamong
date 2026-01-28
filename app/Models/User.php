<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // Ini tidak dipakai karena tidak ada verifikasi email di proposal
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Menentukan nama tabel (opsional jika nama tabel jamak bahasa inggris, tapi bagus untuk kepastian)
     */
    protected $table = 'users';

    /**
     * PENTING: Mengubah Primary Key dari default 'id' ke 'id_user' 
     * Sesuai Tabel 3.8 
     */
    protected $primaryKey = 'id_user';

    /**
     * Daftar kolom yang boleh diisi secara massal (create/update)
     * Sesuai kolom di Tabel 3.8 
     */
    protected $fillable = [
        'username',
        'password',
        'role',
        'nama_lengkap',
        'wilayah_rt_rw',
    ];

    /**
     * Atribut yang harus disembunyikan saat data dikonversi ke Array/JSON
     * Password wajib disembunyikan untuk keamanan.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data otomatis
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed', // Otomatis hash password saat disimpan
        ];
    }

    /**
     * Relasi ke Tabel Pengajuan
     * Sesuai Relasi Antar Tabel (Gambar 3.16) [cite: 431, 439]
     * User (RT) bisa punya banyak pengajuan.
     */
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class, 'id_user_pengusul', 'id_user');
    }
}