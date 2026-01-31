<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Kunjungan;
use App\Enums\KunjunganStatus;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class KunjunganTestNotify extends Command
{
    protected $signature = 'kunjungan:test-notify {--channel=whatsapp} {--status=approved}';
    protected $description = 'Create a test Kunjungan and change status to trigger notifications; prints relevant log lines.';

    public function handle()
    {
        $channel = $this->option('channel'); // 'whatsapp', 'email', 'both'
        $statusOption = strtolower($this->option('status'));

        $kunjungan = Kunjungan::factory()->create([
            'no_wa_pengunjung' => '0812 3456 789',
            'email_pengunjung' => 'test+kunjungan@example.test',
            'preferred_notification_channel' => $channel,
            'status' => KunjunganStatus::PENDING,
        ]);

        $this->info("Created test Kunjungan ID: {$kunjungan->id}, channel: {$channel}");

        // Update status
        $newStatus = match ($statusOption) {
            'approved' => KunjunganStatus::APPROVED,
            'rejected' => KunjunganStatus::REJECTED,
            'completed' => KunjunganStatus::COMPLETED,
            default => KunjunganStatus::APPROVED,
        };

        $kunjungan->status = $newStatus;
        $kunjungan->save();

        $statusValue = is_object($newStatus) && property_exists($newStatus, 'value') ? $newStatus->value : (string)$newStatus;
        $this->info("Updated status to: {$statusValue} (should trigger notifications)");

        // Wait briefly to allow sync jobs/log writes (should be immediate with QUEUE_CONNECTION=sync)
        sleep(1);

        $logPath = storage_path('logs/laravel.log');
        if (!file_exists($logPath)) {
            $this->warn('Log file not found: ' . $logPath);
            return 0;
        }

        $lines = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $lines = array_reverse($lines);

        $this->info('Last relevant log lines:');
        $count = 0;
        foreach ($lines as $line) {
            if (str_contains($line, "Kunjungan ID: {$kunjungan->id}") || str_contains($line, "{$kunjungan->no_wa_pengunjung}") || str_contains($line, 'Mencoba kirim WA')) {
                $this->line($line);
                $count++;
            }
            if ($count >= 10) break;
        }

        if ($count === 0) {
            $this->warn('No matching log lines found. Check that QUEUE_CONNECTION=sync and that logs are being written.');
        }

        $this->info('Done.');
        return 0;
    }
}
