<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('survei_ekonomis', function (Blueprint $table) {
            // Menggunakan tipe 'text' agar bisa menyimpan JSON array untuk multiple files
            $table->text('foto_lantai')->nullable()->after('luas_lantai');
            $table->text('foto_dinding')->nullable()->after('jenis_dinding');
            $table->text('foto_sumber_air')->nullable()->after('sumber_air'); // Dipisah
            $table->text('foto_wc')->nullable()->after('foto_sumber_air');    // Kolom WC baru
            $table->text('foto_listrik')->nullable()->after('daya_listrik');
            $table->text('foto_kendaraan')->nullable()->after('kendaraan');   
            $table->text('foto_elektronik')->nullable()->after('elektronik'); 
            $table->text('foto_ternak')->nullable()->after('ternak_lahan');   
        });
    }

    public function down()
    {
        Schema::table('survei_ekonomis', function (Blueprint $table) {
            $table->dropColumn([
                'foto_lantai', 'foto_dinding', 'foto_sumber_air', 'foto_wc', 
                'foto_listrik', 'foto_kendaraan', 'foto_elektronik', 'foto_ternak'
            ]);
        });
    }
};