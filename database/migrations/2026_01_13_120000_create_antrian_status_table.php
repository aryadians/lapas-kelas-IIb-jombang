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
        Schema::create('antrian_status', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('sesi', ['pagi', 'siang']);
            $table->unsignedInteger('nomor_terpanggil')->default(0);
            $table->timestamps();

            $table->unique(['tanggal', 'sesi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrian_status');
    }
};
