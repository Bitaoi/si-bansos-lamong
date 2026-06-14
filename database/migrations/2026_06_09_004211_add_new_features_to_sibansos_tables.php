<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // KITA HAPUS pembuatan periode_bansos & kuota_rts di sini 
        // karena sudah dibuat di file migrasi terpisah yang lebih baru.

        // Modifikasi tabel Warga (Status Keluarga Fleksibel)
        Schema::table('wargas', function (Blueprint $table) {
            if (!Schema::hasColumn('wargas', 'status_keluarga')) {
                $table->string('status_keluarga', 50)->default('Anggota Keluarga')->after('hubungan_keluarga');
            }
        });
    }

    public function down()
    {
        Schema::table('wargas', function (Blueprint $table) {
            if (Schema::hasColumn('wargas', 'status_keluarga')) {
                $table->dropColumn('status_keluarga');
            }
        });
    }
};