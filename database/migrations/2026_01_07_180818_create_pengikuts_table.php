<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengikuts', function (Blueprint $table) {
            $table->id();
            // Hubungkan ke tabel kunjungan
            $table->foreignId('kunjungan_id')->constrained('kunjungans')->onDelete('cascade');

            $table->string('nama');
            $table->string('nik', 16)->nullable();
            $table->string('hubungan')->nullable();
            $table->string('barang_bawaan')->nullable(); // Misal: Baju, Makanan
            $table->string('foto_ktp')->nullable(); // Path foto

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengikuts');
    }
};
