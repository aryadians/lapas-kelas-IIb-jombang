<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('broadcast_restriction_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('triggered_by', ['scheduler', 'manual'])->default('manual');
            $table->unsignedBigInteger('triggered_by_user_id')->nullable(); // null = scheduler
            $table->foreign('triggered_by_user_id')->references('id')->on('users')->nullOnDelete();
            $table->integer('total_wbp_processed')->default(0);
            $table->integer('total_wbp_no_restriction')->default(0);
            $table->integer('total_kunjungan_cancelled')->default(0);
            $table->integer('total_notifications_queued')->default(0);
            $table->enum('status', ['success', 'no_impact', 'partial_error', 'failed'])->default('success');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('broadcast_restriction_log_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('broadcast_restriction_log_id');
            $table->foreign('broadcast_restriction_log_id', 'fk_br_log_id')
                  ->references('id')
                  ->on('broadcast_restriction_logs')
                  ->cascadeOnDelete();
            $table->unsignedBigInteger('wbp_id')->nullable();
            $table->string('wbp_nama');
            $table->string('restriction_type')->nullable();
            $table->date('restriction_start')->nullable();
            $table->date('restriction_end')->nullable();
            $table->unsignedBigInteger('kunjungan_id')->nullable();
            $table->string('kode_booking')->nullable();
            $table->date('tanggal_kunjungan')->nullable();
            $table->string('pengunjung_nama')->nullable();
            $table->string('pengunjung_wa')->nullable();
            $table->string('pengunjung_email')->nullable();
            $table->boolean('wa_queued')->default(false);
            $table->boolean('email_queued')->default(false);
            $table->string('action')->default('cancelled'); // cancelled / skipped / no_restriction
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('broadcast_restriction_log_details');
        Schema::dropIfExists('broadcast_restriction_logs');
    }
};
