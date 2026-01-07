<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->foreignId('wbp_id')->nullable()->constrained('wbps')->onDelete('cascade');
            $table->integer('total_pengikut')->default(0);
            $table->json('data_pengikut')->nullable(); // Simpan array nama & barang
        });
    }

    public function down()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->dropForeign(['wbp_id']);
            $table->dropColumn(['wbp_id', 'total_pengikut', 'data_pengikut']);
        });
    }
};
