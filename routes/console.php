<?php

use App\Console\Commands\AutoUpdateAntrian;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('app:send-visit-reminders')->dailyAt('07:00');
Schedule::command(AutoUpdateAntrian::class)->everyMinute();

// Scheduled Backups
Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run')->daily()->at('01:30');

// Database Cleanup (Hapus data pengunjung > 1 bulan)
Schedule::call(function () {
    (new \App\Http\Controllers\Admin\VisitorController())->deleteOldVisitors();
})->dailyAt('02:00');

// Auto-Delete Log Aktivitas > 1 Bulan (setiap tanggal 1 jam 03:00)
Schedule::call(function () {
    \Spatie\Activitylog\Models\Activity::where('created_at', '<', now()->subMonth())->delete();
    \Illuminate\Support\Facades\Log::info('[Scheduler] Log aktivitas lebih dari 1 bulan berhasil dihapus otomatis.');
})->monthlyOn(1, '03:00');


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
