<?php

namespace App\Console\Commands;

use App\Jobs\SendReminderNotification;
use App\Models\Kunjungan;
use App\Enums\KunjunganStatus;
use Illuminate\Console\Command;
use Carbon\Carbon;

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
    protected $description = 'Send H-1 reminders to visitors for approved visits.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to send visit reminders...');

        $tomorrow = Carbon::tomorrow();

        // Get approved visits scheduled for tomorrow
        $kunjungans = Kunjungan::where('tanggal_kunjungan', $tomorrow->toDateString())
                               ->where('status', KunjunganStatus::APPROVED)
                               ->get();

        if ($kunjungans->isEmpty()) {
            $this->info('No approved visits scheduled for tomorrow.');
            return Command::SUCCESS;
        }

        foreach ($kunjungans as $kunjungan) {
            // Dispatch the job to send the reminder notification
            SendReminderNotification::dispatch($kunjungan);
            $this->comment("Dispatched reminder for Kunjungan ID: {$kunjungan->id}");
        }

        $this->info('Finished dispatching visit reminders.');
        return Command::SUCCESS;
    }
}
