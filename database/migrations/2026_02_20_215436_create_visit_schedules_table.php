<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visit_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('day_of_week'); // 0: Minggu, 1: Senin, dst
            $table->string('day_name');     // Senin, Selasa, dst
            $table->boolean('is_open')->default(true);
            
            // Kuota Online
            $table->integer('quota_online_morning')->default(150);
            $table->integer('quota_online_afternoon')->default(0);
            
            // Kuota Offline
            $table->integer('quota_offline_morning')->default(20);
            $table->integer('quota_offline_afternoon')->default(0);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_schedules');
    }
};
