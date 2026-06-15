<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration untuk menambah kolom.
     */
    public function up(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            // Menambahkan kolom tgl_observasi dengan tipe dateTime/date
            // Posisinya diletakkan setelah kolom status_verifikasi_admin agar rapi
            $table->date('tgl_observasi')->nullable()->after('status_verifikasi_admin');
        });
    }

    /**
     * Rollback migration jika dibatalkan.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            // Menghapus kolom jika di-rollback
            $table->dropColumn('tgl_observasi');
        });
    }
};