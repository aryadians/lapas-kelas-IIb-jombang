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
            $table->longText('foto_ktp')->nullable()->change();
        });

        Schema::table('pengikuts', function (Blueprint $table) {
            $table->longText('foto_ktp')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->longText('foto_ktp')->nullable(false)->change();
        });

        Schema::table('pengikuts', function (Blueprint $table) {
            $table->longText('foto_ktp')->nullable(false)->change();
        });
    }
};
