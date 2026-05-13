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
        $data = [
            [
                'title' => 'Miniatur Kapal Pinisi',
                'description' => 'Miniatur detail dibuat dari limbah kayu jati berkualitas. Dibuat dengan ketelitian tinggi oleh warga binaan, mencerminkan nilai seni budaya bahari Indonesia.',
                'image_path' => 'data:image/jpeg;base64,',
                'price' => 350000,
                'material' => 'Kayu Jati / Mahoni',
                'dimension' => '30cm x 10cm x 25cm',
                'status' => 'Tersedia',
                'order_index' => 1,
                'is_active' => true
            ],
            [
                'title' => 'Kotak Tisu Ukir',
                'description' => 'Kotak tisu estetik dengan ukiran khas Jombang.',
                'image_path' => 'data:image/jpeg;base64,',
                'price' => 75000,
                'material' => 'Kayu Pinus',
                'dimension' => '24cm x 12cm x 9cm',
                'status' => 'Tersedia',
                'order_index' => 2,
                'is_active' => true
            ]
        ];

        \App\Models\Galeri::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \App\Models\Galeri::whereIn('title', ['Miniatur Kapal Pinisi', 'Kotak Tisu Ukir'])->delete();
    }
};
