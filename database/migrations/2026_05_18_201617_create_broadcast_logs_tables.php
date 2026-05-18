<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('broadcast_logs', function (Blueprint $table) {
            $table->id();
            $table->string('target_date');
            $table->string('reason');
            $table->integer('sent_count');
            $table->integer('failed_count');
            $table->timestamps();
        });

        Schema::create('broadcast_failed_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('broadcast_log_id')->constrained('broadcast_logs')->onDelete('cascade');
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('broadcast_failed_logs');
        Schema::dropIfExists('broadcast_logs');
    }
};
