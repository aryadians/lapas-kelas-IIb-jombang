<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\AntrianStatus;
use App\Models\Kunjungan;
use App\Enums\KunjunganStatus as EnumKunjunganStatus;
use App\Events\AntrianUpdated;
use Illuminate\Support\Facades\Log;

class AutoUpdateAntrian extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'antrian:auto-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically update the called queue number based on a set interval.';

    /**
     * The duration of each visit in minutes.
     *
     * @var int
     */
    const VISIT_DURATION_MINUTES = 15;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $today = $now->format('Y-m-d');
        $visitingDays = [
            Carbon::MONDAY,
            Carbon::TUESDAY,
            Carbon::WEDNESDAY,
            Carbon::THURSDAY,
        ];

        // 1. Cek apakah hari ini adalah hari kunjungan
        if (!in_array($now->dayOfWeek, $visitingDays)) {
            $this->info('Not a visiting day. Exiting.');
            return 0;
        }

        // 2. Tentukan sesi saat ini
        $sesi = null;
        if ($now->hour >= 8 && $now->hour < 12) {
            $sesi = 'pagi';
        } elseif ($now->hour >= 13 && $now->hour < 15) { // Assuming afternoon session ends at 15:00
            $sesi = 'siang';
        }

        if (!$sesi) {
            $this->info('Not within a session time. Exiting.');
            return 0;
        }

        $this->info("Running for session: {$sesi}");

        // 3. Dapatkan status antrian saat ini
        $antrianStatus = AntrianStatus::firstOrCreate(
            ['tanggal' => $today, 'sesi' => $sesi],
            ['nomor_terpanggil' => 0]
        );

        // 4. Dapatkan jumlah total antrian yang disetujui untuk sesi ini
        $totalAntrian = Kunjungan::where('tanggal_kunjungan', $today)
            ->where('sesi', $sesi)
            ->where('status', EnumKunjunganStatus::APPROVED)
            ->count();

        if ($totalAntrian == 0) {
            $this->info('No approved visits for this session. Exiting.');
            return 0;
        }

        // 5. Jika nomor terpanggil sudah maksimal, jangan lakukan apa-apa
        if ($antrianStatus->nomor_terpanggil >= $totalAntrian) {
            $this->info('Maximum queue number reached. Exiting.');
            return 0;
        }

        // 6. Logika untuk pemanggilan pertama atau berikutnya
        $timeSinceLastUpdate = $antrianStatus->updated_at->diffInMinutes($now);

        // Jika ini pemanggilan pertama (nomor 0) dan sesi baru saja dimulai
        $isFirstCall = $antrianStatus->nomor_terpanggil == 0;
        $sessionJustStarted = ($sesi === 'pagi' && $now->hour === 8 && $now->minute < self::VISIT_DURATION_MINUTES) ||
                              ($sesi === 'siang' && $now->hour === 13 && $now->minute < self::VISIT_DURATION_MINUTES);

        if ($isFirstCall && $sessionJustStarted) {
             $this->callNextNumber($antrianStatus);
        }
        // Jika bukan pemanggilan pertama dan sudah waktunya untuk nomor berikutnya
        elseif (!$isFirstCall && $timeSinceLastUpdate >= self::VISIT_DURATION_MINUTES) {
            $this->callNextNumber($antrianStatus);
        } else {
            $this->info('Not time for the next number yet. Time since last call: ' . $timeSinceLastUpdate . ' mins.');
        }

        return 0;
    }

    /**
     * Increments the queue number and dispatches the event.
     *
     * @param AntrianStatus $antrianStatus
     */
    private function callNextNumber(AntrianStatus $antrianStatus)
    {
        $newNumber = $antrianStatus->nomor_terpanggil + 1;
        $antrianStatus->update(['nomor_terpanggil' => $newNumber]);

        AntrianUpdated::dispatch($antrianStatus->sesi, $newNumber);

        Log::info("Auto-updated queue for session '{$antrianStatus->sesi}' to number {$newNumber}.");
        $this->info("Updated queue for session '{$antrianStatus->sesi}' to number {$newNumber}.");
    }
}
