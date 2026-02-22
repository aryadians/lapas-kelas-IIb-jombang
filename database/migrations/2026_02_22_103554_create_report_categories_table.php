<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('icon', 50)->default('fa-file-alt'); // Font Awesome icon class
            $table->string('emoji', 10)->nullable();            // Optional emoji
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Seed default categories
        DB::table('report_categories')->insert([
            ['name' => 'LHKPN',       'icon' => 'fa-vault',               'emoji' => '🏦', 'sort_order' => 1,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'LAKIP',       'icon' => 'fa-chart-line',           'emoji' => '📈', 'sort_order' => 2,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Keuangan',    'icon' => 'fa-money-bill-transfer',  'emoji' => '💰', 'sort_order' => 3,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Renstra',     'icon' => 'fa-map',                  'emoji' => '🗺️', 'sort_order' => 4,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'RKT',         'icon' => 'fa-tasks',                'emoji' => '✅', 'sort_order' => 5,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Profil Lapas','icon' => 'fa-building',             'emoji' => '🏢', 'sort_order' => 6,  'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('report_categories');
    }
};
