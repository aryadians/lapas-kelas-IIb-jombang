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
            // Drop the old session-based unique key
            $table->dropUnique('kunjungan_unik_per_sesi');

            // Add the new daily unique key
            $table->unique(['tanggal_kunjungan', 'nomor_antrian_harian'], 'kunjungan_unik_per_hari');
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
            // Drop the new daily unique key
            $table->dropUnique('kunjungan_unik_per_hari');

            // Re-add the old session-based unique key
            $table->unique(['tanggal_kunjungan', 'sesi', 'nomor_antrian_harian'], 'kunjungan_unik_per_sesi');
        });
    }
};
