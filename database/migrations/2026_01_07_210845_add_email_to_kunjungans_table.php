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
        if (!Schema::hasColumn('kunjungans', 'email_pengunjung')) {
            $table->string('email_pengunjung')->after('nama_pengunjung')->nullable();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            //
        });
    }
};
