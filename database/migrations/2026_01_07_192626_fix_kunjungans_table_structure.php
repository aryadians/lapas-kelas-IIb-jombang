<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            // 1. Cek & Tambah 'kode_kunjungan'
            if (!Schema::hasColumn('kunjungans', 'kode_kunjungan')) {
                $table->string('kode_kunjungan')->unique()->after('id')->nullable();
            }

            // 2. Cek & Tambah 'nomor_antrian_harian'
            if (!Schema::hasColumn('kunjungans', 'nomor_antrian_harian')) {
                $table->integer('nomor_antrian_harian')->after('kode_kunjungan')->nullable();
            }

            // 3. Cek & Tambah 'nik_ktp'
            if (!Schema::hasColumn('kunjungans', 'nik_ktp')) {
                $table->string('nik_ktp', 16)->after('nama_pengunjung')->nullable();
            }

            // 4. Cek & Tambah 'jenis_kelamin'
            if (!Schema::hasColumn('kunjungans', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->after('nik_ktp')->nullable();
            }

            // 5. Cek & Tambah 'foto_ktp'
            if (!Schema::hasColumn('kunjungans', 'foto_ktp')) {
                $table->string('foto_ktp')->after('status')->nullable();
            }

            // 6. Cek & Tambah 'qr_token'
            if (!Schema::hasColumn('kunjungans', 'qr_token')) {
                $table->string('qr_token')->after('foto_ktp')->nullable();
            }

            // 7. Cek & Tambah Statistik Pengikut
            if (!Schema::hasColumn('kunjungans', 'pengikut_laki')) {
                $table->integer('pengikut_laki')->default(0);
                $table->integer('pengikut_perempuan')->default(0);
                $table->integer('pengikut_anak')->default(0);
            }
        });
    }

    public function down()
    {
        // Tidak perlu drop column agar data aman
    }
};
