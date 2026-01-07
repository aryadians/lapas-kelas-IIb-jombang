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
            // Menambah kolom wbp_id setelah kolom id
            $table->foreignId('wbp_id')->after('id')->constrained('wbps')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->dropForeign(['wbp_id']);
            $table->dropColumn('wbp_id');
        });
    }
};
