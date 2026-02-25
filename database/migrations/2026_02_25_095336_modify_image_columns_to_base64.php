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
        // 1. Modifikasi tabel kunjungans
        Schema::table('kunjungans', function (Blueprint $table) {
            // Ubah foto_ktp ke longText jika belum (sudah ada migrasi sebelumnya tapi kita pastikan lagi)
            $table->longText('foto_ktp')->nullable()->change();
            
            // Tambah kolom barcode untuk simpan render QR Code dalam Base64
            if (!Schema::hasColumn('kunjungans', 'barcode')) {
                $table->longText('barcode')->nullable()->after('qr_token');
            }
        });

        // 2. Modifikasi tabel profil_pengunjungs
        Schema::table('profil_pengunjungs', function (Blueprint $table) {
            // Tambah kolom image untuk foto profil/KTP master
            if (!Schema::hasColumn('profil_pengunjungs', 'image')) {
                $table->longText('image')->nullable();
            }
            
            // Tambah kolom barcode jika diperlukan di profil
            if (!Schema::hasColumn('profil_pengunjungs', 'barcode')) {
                $table->longText('barcode')->nullable();
            }
        });

        // 3. Modifikasi tabel pengikuts
        Schema::table('pengikuts', function (Blueprint $table) {
            $table->longText('foto_ktp')->nullable()->change();
            
            if (!Schema::hasColumn('pengikuts', 'barcode')) {
                $table->longText('barcode')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kunjungans', function (Blueprint $table) {
            $table->dropColumn('barcode');
        });

        Schema::table('profil_pengunjungs', function (Blueprint $table) {
            $table->dropColumn(['image', 'barcode']);
        });

        Schema::table('pengikuts', function (Blueprint $table) {
            $table->dropColumn('barcode');
        });
    }
};
