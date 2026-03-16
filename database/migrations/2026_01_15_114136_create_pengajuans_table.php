<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id(); // ID Pengajuan
            
            // 1. Relasi ke Warga (NIK)
            $table->string('nik', 16);
            $table->foreign('nik')->references('nik')->on('wargas')->onDelete('cascade');

            // 2. Relasi ke Jenis Bansos 
            // (Mengarah ke kolom 'id' di tabel jenis_bansos yang sudah kita perbaiki sebelumnya)
            $table->unsignedBigInteger('id_bansos');
            $table->foreign('id_bansos')->references('id')->on('jenis_bansos')->onDelete('cascade');
            
            // 3. Relasi ke User / RT Pengusul (PERBAIKAN UTAMA DISINI)
            // Karena tabel users pakai 'id_user', maka references-nya WAJIB 'id_user' juga.
            $table->unsignedBigInteger('id_user_pengusul');
            $table->foreign('id_user_pengusul')->references('id_user')->on('users')->onDelete('cascade');

            $table->date('tgl_pengajuan');
            
            // Pengajuan Bantuan
            $table->text('alasan_pengajuan'); 
            $table->decimal('estimasi_penghasilan', 15, 2); 
            $table->json('checklist_kriteria')->nullable(); // Menyimpan checklist (Lansia, Sewa, dll)

            // bukti fisik
            $table->string('foto_ktp_kk')->nullable();
            $table->string('foto_rumah_depan')->nullable();
            $table->string('foto_rumah_dalam')->nullable();
            
            // Status & Dokumen
            $table->enum('status_verifikasi_admin', ['Proses', 'Verifikasi Lapangan', 'Menunggu Musdes', 'Siap Keputusan', 'Layak', 'Tidak Layak'])->default('Proses');
            $table->string('file_dokumen_pendukung')->nullable(); 
            $table->text('keterangan_ditolak')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};