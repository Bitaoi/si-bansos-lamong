<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('survei_ekonomis'); // Drop dulu jika sudah telanjur dibuat
        
        Schema::create('survei_ekonomis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuans')->onDelete('cascade');
            
            // A. Kondisi Tempat Tinggal
            $table->string('luas_lantai');
            $table->string('jenis_lantai');
            $table->string('jenis_dinding');
            $table->string('sumber_air');
            $table->string('daya_listrik');
            
            // B. Kepemilikan Aset
            $table->string('kendaraan');
            $table->string('elektronik');
            $table->string('ternak_lahan');
            
            // C. Sosial Ekonomi KK
            $table->string('pendidikan_kk');
            $table->string('pekerjaan');
            $table->string('jml_tanggungan');
            
            // Hasil Kalkulasi
            $table->integer('total_skor')->default(0);
            $table->integer('desil_hasil')->default(10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survei_ekonomis');
    }
};