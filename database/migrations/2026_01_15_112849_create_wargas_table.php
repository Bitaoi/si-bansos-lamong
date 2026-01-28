<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('wargas', function (Blueprint $table) {
        // 1. Identitas Utama
        $table->string('nik', 16)->primary(); // Primary Key
        $table->string('no_kk', 16);
        $table->string('nama_lengkap', 100);

        // 2. Info Dasar
        $table->enum('jenis_kelamin', ['L', 'P']); // L = Laki-laki, P = Perempuan
        $table->string('tempat_lahir', 50);
        $table->date('tanggal_lahir');
        $table->string('agama', 20); // Islam, Kristen, dll

        // 3. Info Tambahan
        $table->string('pendidikan', 50); // SD, SMP, S1, dll
        $table->string('pekerjaan', 50);
        $table->string('status_kawin', 20); // Belum Kawin, Kawin, Cerai Hidup, Cerai Mati
        $table->string('hubungan_keluarga', 50); // Kepala Keluarga, Istri, Anak
        $table->string('kewarganegaraan', 20)->default('WNI');
        
        // 4. Alamat & Medis
        $table->text('alamat_lengkap'); // Jalan, RT/RW digabung atau dipisah boleh. Disini saya gabung stringnya
        $table->string('rt', 3);
        $table->string('rw', 3);
        $table->string('golongan_darah', 5)->nullable(); // A, B, AB, O, -

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wargas');
    }
};
