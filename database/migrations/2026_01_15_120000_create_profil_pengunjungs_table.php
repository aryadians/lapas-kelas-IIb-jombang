<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profil_pengunjungs', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique(); // NIK sebagai identifier unik
            $table->string('nama');
            $table->string('nomor_hp');
            $table->string('email')->nullable();
            $table->string('alamat')->nullable();
            $table->string('jenis_kelamin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_pengunjungs');
    }
};
