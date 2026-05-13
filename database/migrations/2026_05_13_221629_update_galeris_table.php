<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galeris', function (Blueprint $table) {
            $table->decimal('price', 15, 2)->nullable();
            $table->string('material')->nullable();
            $table->string('dimension')->nullable();
            $table->string('status')->default('Tersedia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galeris', function (Blueprint $table) {
            $table->dropColumn(['price', 'material', 'dimension', 'status']);
        });
    }
};
