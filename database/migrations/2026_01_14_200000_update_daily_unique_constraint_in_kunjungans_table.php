<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            // Drop the daily unique key if it exists
            $table->dropUnique('kunjungan_unik_per_hari');

            // Add the new session-based unique key
            $table->unique(['tanggal_kunjungan', 'sesi', 'nomor_antrian_harian'], 'kunjungan_unik_per_sesi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            // Drop the session-based unique key
            $table->dropUnique('kunjungan_unik_per_sesi');

            // Re-add the daily unique key for rollback
            $table->unique(['tanggal_kunjungan', 'nomor_antrian_harian'], 'kunjungan_unik_per_hari');
        });
    }
};
