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

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
