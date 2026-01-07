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
        Schema::table('kunjungans', function (Blueprint $table) {
            // Kita cek dulu, kalau kolom belum ada, baru dibuat
            if (!Schema::hasColumn('kunjungans', 'barang_bawaan')) {
                // Menambahkan kolom 'barang_bawaan' yang boleh kosong (nullable)
                // diletakkan setelah kolom 'alamat_pengunjung' biar rapi
                $table->string('barang_bawaan')->nullable()->after('alamat_pengunjung');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            // Ini untuk menghapus kolom jika migrasi dibatalkan (rollback)
            if (Schema::hasColumn('kunjungans', 'barang_bawaan')) {
                $table->dropColumn('barang_bawaan');
            }
        });
    }
};
