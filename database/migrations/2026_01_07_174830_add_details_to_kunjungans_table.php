<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            // Cek dulu biar tidak error "Duplicate column"
            if (!Schema::hasColumn('kunjungans', 'nik_ktp')) {
                $table->string('nik_ktp', 16)->after('nama_pengunjung')->nullable();
            }
            if (!Schema::hasColumn('kunjungans', 'foto_ktp')) {
                $table->string('foto_ktp')->after('tanggal_kunjungan')->nullable();
            }
            if (!Schema::hasColumn('kunjungans', 'pengikut_laki')) {
                $table->integer('pengikut_laki')->default(0)->after('hubungan');
                $table->integer('pengikut_perempuan')->default(0)->after('pengikut_laki');
                $table->integer('pengikut_anak')->default(0)->after('pengikut_perempuan');
            }

            // Hapus kolom lama jika ada (opsional, biar bersih)
            if (Schema::hasColumn('kunjungans', 'total_pengikut')) {
                $table->dropColumn(['total_pengikut', 'data_pengikut']);
            }
        });
    }

    public function down()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->dropColumn(['nik_ktp', 'foto_ktp', 'pengikut_laki', 'pengikut_perempuan', 'pengikut_anak']);
        });
    }
};
