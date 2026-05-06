<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_bansos', function (Blueprint $table) {
            $table->string('sumber_dana')->nullable()->after('kode_bansos');
            $table->text('deskripsi_bantuan')->nullable()->after('sumber_dana');
            $table->string('bentuk_penyerahan')->nullable()->after('deskripsi_bantuan');
            $table->text('kriteria_lainnya')->nullable()->after('kriteria_desil');
        });
    }

    public function down(): void
    {
        Schema::table('jenis_bansos', function (Blueprint $table) {
            $table->dropColumn([
                'sumber_dana', 
                'deskripsi_bantuan', 
                'bentuk_penyerahan', 
                'kriteria_lainnya'
            ]);
        });
    }
};