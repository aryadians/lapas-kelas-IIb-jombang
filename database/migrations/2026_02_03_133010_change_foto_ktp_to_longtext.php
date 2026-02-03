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
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->longText('foto_ktp')->change();
        });

        Schema::table('pengikuts', function (Blueprint $table) {
            $table->longText('foto_ktp')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->string('foto_ktp')->change();
        });

        Schema::table('pengikuts', function (Blueprint $table) {
            $table->string('foto_ktp')->change();
        });
    }
};