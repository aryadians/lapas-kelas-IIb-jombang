<?php

use App\Console\Commands\AutoUpdateAntrian;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('app:send-visit-reminders')->dailyAt('07:00');
Schedule::command(AutoUpdateAntrian::class)->everyMinute();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
