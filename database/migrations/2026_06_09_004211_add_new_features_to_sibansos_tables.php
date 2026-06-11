<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Tabel Periode Bantuan
        Schema::create('periode_bansos', function (Blueprint $table) {
            $table->id();
            $table->string('nama_periode'); // Contoh: "Tahap 1 - Januari 2026"
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            $table->enum('status', ['Aktif', 'Tutup'])->default('Aktif');
            $table->timestamps();
        });

        // 2. Tabel Kuota Berjenjang per RT
        Schema::create('kuota_rts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_bansos')->constrained('jenis_bansos')->onDelete('cascade');
            $table->foreignId('id_periode')->constrained('periode_bansos')->onDelete('cascade');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->integer('kuota');
            $table->integer('terpakai')->default(0);
            $table->timestamps();
        });

        // 3. Modifikasi tabel Warga (Status Keluarga Fleksibel)
        Schema::table('wargas', function (Blueprint $table) {
            // Menambahkan status_keluarga (Kepala Keluarga, Anggota Keluarga, Hidup Mandiri)
            $table->string('status_keluarga', 50)->default('Anggota Keluarga')->after('hubungan_keluarga');
        });

        // 4. Modifikasi tabel Pengajuan (Relasi ke Periode)
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->foreignId('id_periode')->nullable()->constrained('periode_bansos')->onDelete('cascade')->after('id_bansos');
        });
    }

    public function down()
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropForeign(['id_periode']);
            $table->dropColumn('id_periode');
        });
        Schema::table('wargas', function (Blueprint $table) {
            $table->dropColumn('status_keluarga');
        });
        Schema::dropIfExists('kuota_rts');
        Schema::dropIfExists('periode_bansos');
    }
};