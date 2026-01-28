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
    Schema::create('pengajuans', function (Blueprint $table) {
        $table->id('id_pengajuan');
        // Foreign Key ke Warga (NIK) [cite: 1088]
        $table->string('nik', 16);
        $table->foreign('nik')->references('nik')->on('wargas')->onDelete('cascade');

        // Foreign Key ke Jenis Bansos [cite: 1091]
        $table->unsignedBigInteger('id_bansos');
        $table->foreign('id_bansos')->references('id_bansos')->on('jenis_bansos');

        // Foreign Key ke User (RT Pengusul) [cite: 1085]
        $table->unsignedBigInteger('id_user_pengusul');
        $table->foreign('id_user_pengusul')->references('id_user')->on('users');

        $table->date('tgl_pengajuan');
        $table->string('status_verifikasi_admin', 20)->default('Proses'); // Default status
        $table->string('file_dokumen_pendukung')->nullable(); // Tambahan dari ERD Gambar 3.16 
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
