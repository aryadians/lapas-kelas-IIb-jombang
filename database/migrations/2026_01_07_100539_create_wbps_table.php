<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wbps', function (Blueprint $table) {
            $table->id();
            // Kolom A: Nama Lengkap
            $table->string('nama');
            // Kolom B: No Registrasi (Unik)
            $table->string('no_registrasi')->unique();
            // Kolom C: Tgl Masuk
            $table->date('tanggal_masuk')->nullable();
            // Kolom D: Tgl Ekspirasi
            $table->date('tanggal_ekspirasi')->nullable();
            // Kolom E-J: Alias (Kita gabung jadi satu kolom string)
            $table->string('nama_panggilan')->nullable();
            // Kolom K: Blok
            $table->string('blok')->nullable();
            // Kolom L: Lokasi Sel
            $table->string('kamar')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wbps');
    }
};
