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
        Schema::table('visit_schedules', function (Blueprint $table) {
            $table->text('allowed_kode_tahanan')->nullable()->after('quota_offline_afternoon')->comment('Comma-separated allowed kode tahanan, e.g. A, B');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visit_schedules', function (Blueprint $table) {
            $table->dropColumn('allowed_kode_tahanan');
        });
    }
};
