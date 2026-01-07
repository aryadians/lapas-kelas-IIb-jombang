<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            // Menambahkan kolom jenis_kelamin setelah kolom nik_ktp
            if (!Schema::hasColumn('kunjungans', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->after('nik_ktp')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->dropColumn('jenis_kelamin');
        });
    }
};
