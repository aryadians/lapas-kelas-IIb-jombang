<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $data = [
            ['title' => 'Kunjungan Warga Binaan', 'description' => 'Suasana pelayanan kunjungan.', 'image_path' => 'data:image/jpeg;base64,', 'order_index' => 1, 'is_active' => true],
            ['title' => 'Kegiatan Kerja', 'description' => 'Pelatihan keterampilan WBP.', 'image_path' => 'data:image/jpeg;base64,', 'order_index' => 2, 'is_active' => true],
        ];

        \App\Models\Galeri::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \App\Models\Galeri::truncate();
    }
};
