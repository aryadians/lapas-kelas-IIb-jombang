<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            // Hapus kolom 'nama_wbp' karena sudah pakai 'wbp_id'
            if (Schema::hasColumn('kunjungans', 'nama_wbp')) {
                $table->dropColumn('nama_wbp');
            }
        });
    }

    public function down()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->string('nama_wbp')->nullable();
        });
    }
};
