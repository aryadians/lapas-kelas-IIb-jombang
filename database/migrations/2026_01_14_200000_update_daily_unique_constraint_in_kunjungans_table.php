<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only attempt to drop the existing daily unique key on non-sqlite drivers
        if (Schema::getConnection()->getDriverName() !== 'sqlite') {
            try {
                Schema::table('kunjungans', function (Blueprint $table) {
                    $table->dropUnique('kunjungan_unik_per_hari');
                });
            } catch (\Exception $e) {
                // Index might not exist, proceed
            }
        }

        // Add the new session-based unique key
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            // SQLite: create index only if not exists (safer for tests)
            DB::statement("CREATE UNIQUE INDEX IF NOT EXISTS kunjungan_unik_per_sesi ON kunjungans(tanggal_kunjungan, sesi, nomor_antrian_harian)");
        } else {
            try {
                Schema::table('kunjungans', function (Blueprint $table) {
                    $table->unique(['tanggal_kunjungan', 'sesi', 'nomor_antrian_harian'], 'kunjungan_unik_per_sesi');
                });
            } catch (\Exception $e) {
                // Index might already exist
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the session-based unique key
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            DB::statement("DROP INDEX IF EXISTS kunjungan_unik_per_sesi");
            DB::statement("CREATE UNIQUE INDEX IF NOT EXISTS kunjungan_unik_per_hari ON kunjungans(tanggal_kunjungan, nomor_antrian_harian)");
        } else {
            Schema::table('kunjungans', function (Blueprint $table) {
                $table->dropUnique('kunjungan_unik_per_sesi');
                $table->unique(['tanggal_kunjungan', 'nomor_antrian_harian'], 'kunjungan_unik_per_hari');
            });
        }
    }
};
