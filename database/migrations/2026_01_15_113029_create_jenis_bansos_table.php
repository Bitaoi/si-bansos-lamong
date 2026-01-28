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
    Schema::create('jenis_bansos', function (Blueprint $table) {
        $table->id('id_bansos'); // Primary Key Auto Increment [cite: 1068]
        $table->string('nama_bansos', 50);
        $table->integer('kuota');
        $table->string('periode', 20);
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_bansos');
    }
};
