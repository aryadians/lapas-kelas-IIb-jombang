<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Exports\KunjunganExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ExportKunjunganCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:kunjungan {--filter=all : daily|weekly|monthly|all} {--date= : Custom date YYYY-MM-DD}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test export kunjungan to Excel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filter = $this->option('filter');
        $date = $this->option('date') ?: date('Y-m-d');

        $periodMap = [
            'daily' => 'day',
            'weekly' => 'week',
            'monthly' => 'month',
            'all' => 'all'
        ];

        $period = $periodMap[$filter] ?? 'all';
        $filename = 'export_test_' . $filter . '_' . date('YmdHis') . '.xlsx';
        $path = storage_path('app/public/' . $filename);

        $this->info("Exporting data with filter: $filter ($period) for date: $date");

        try {
            Excel::store(new KunjunganExport($period, $date), $filename, 'public');
            $this->info("Export successful! File saved to: storage/app/public/$filename");
        } catch (\Exception $e) {
            $this->error("Export failed: " . $e->getMessage());
        }
    }
}
