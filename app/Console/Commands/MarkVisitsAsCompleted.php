<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Kunjungan;
use App\Enums\KunjunganStatus;
use Carbon\Carbon;

class MarkVisitsAsCompleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mark-visits-as-completed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark yesterday\'s approved visits as completed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $yesterday = Carbon::yesterday()->toDateString();
        
        $visits = Kunjungan::where('status', KunjunganStatus::APPROVED)
                           ->whereDate('tanggal_kunjungan', $yesterday)
                           ->get();

        if ($visits->isEmpty()) {
            $this->info('No approved visits from yesterday to mark as completed.');
            return;
        }

        $count = 0;
        foreach ($visits as $visit) {
            $visit->status = KunjunganStatus::COMPLETED;
            $visit->save(); // This will trigger the observer
            $count++;
        }

        $this->info("Successfully marked {$count} visits as completed.");
    }
}
