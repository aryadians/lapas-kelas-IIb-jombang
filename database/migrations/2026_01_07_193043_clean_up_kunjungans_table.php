<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            // HAPUS KOLOM LAMA YANG MENYEBABKAN ERROR
            if (Schema::hasColumn('kunjungans', 'nik_pengunjung')) {
                $table->dropColumn('nik_pengunjung');
            }
            if (Schema::hasColumn('kunjungans', 'no_wa_pengunjung')) {
                // Kita rename saja biar data lama aman, atau drop jika ingin bersih
                // Disini kita drop saja karena kita sudah punya 'no_wa_pengunjung' di kode
                // Oh tunggu, di kode kita pakai 'no_wa_pengunjung' juga.
                // Masalahnya error tadi bilang 'nik_pengunjung'.
            }

            // PASTIKAN KOLOM BARU ADA & BOLEH NULL (SAFEGUARD)
            if (Schema::hasColumn('kunjungans', 'nik_ktp')) {
                $table->string('nik_ktp', 16)->nullable()->change();
            }
        });
    }

    public function down()
    {
        // ...
    }
};
