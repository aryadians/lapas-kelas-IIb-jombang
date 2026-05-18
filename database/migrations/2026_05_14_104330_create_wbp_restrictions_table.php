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
        Schema::create('wbp_restrictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wbp_id')->constrained('wbps')->cascadeOnDelete();
            $table->enum('type', ['Mapenaling', 'Strap Cell', 'Sidang', 'Lainnya']);
            $table->date('start_date');
            $table->date('end_date');
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wbp_restrictions');
    }
};
