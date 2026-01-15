<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Kunjungan;
use App\Jobs\SendReminderNotification;
use Carbon\Carbon;
use App\Enums\KunjunganStatus;

class SendVisitReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-visit-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for approved visits scheduled for the next day.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching approved visits for tomorrow...');

        $tomorrow = Carbon::tomorrow()->toDateString();

        $kunjungans = Kunjungan::where('status', KunjunganStatus::APPROVED)
            ->whereDate('tanggal_kunjungan', $tomorrow)
            ->get();

        if ($kunjungans->isEmpty()) {
            $this->info('No approved visits for tomorrow found.');
            return 0;
        }

        $this->info("Found {$kunjungans->count()} visits. Dispatching reminder jobs...");

        foreach ($kunjungans as $kunjungan) {
            SendReminderNotification::dispatch($kunjungan);
            $this->info("Dispatched reminder for Kunjungan ID: {$kunjungan->id}");
        }

        $this->info('All reminder jobs have been dispatched.');
        return 0;
    }
}