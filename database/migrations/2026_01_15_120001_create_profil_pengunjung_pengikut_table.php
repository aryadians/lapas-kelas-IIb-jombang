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
        Schema::create('profil_pengunjung_pengikut', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_pengunjung_id')->constrained('profil_pengunjungs')->onDelete('cascade');
            $table->foreignId('pengikut_id')->constrained('pengikuts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_pengunjung_pengikut');
    }
};
