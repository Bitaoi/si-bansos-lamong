<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penyalurans', function (Blueprint $table) {
            // Kita tambah 3 status log
            $table->boolean('undangan_dikirim')->default(false)->after('keterangan');
            $table->boolean('surat_diambil')->default(false)->after('undangan_dikirim');
            $table->boolean('bantuan_cair')->default(false)->after('surat_diambil');
        });
    }

    public function down(): void
    {
        Schema::table('penyalurans', function (Blueprint $table) {
            $table->dropColumn(['undangan_dikirim', 'surat_diambil', 'bantuan_cair']);
        });
    }
};