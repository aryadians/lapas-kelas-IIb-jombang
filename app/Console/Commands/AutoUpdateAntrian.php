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

        // 2. Tentukan sesi saat ini berdasarkan jam operasional dari pengaturan admin
        $jamBukaPagi = \App\Models\VisitSetting::where('key', 'jam_buka_pagi')->value('value') ?? '08:00';
        $jamTutupPagi = \App\Models\VisitSetting::where('key', 'jam_tutup_pagi')->value('value') ?? '11:00';
        $jamBukaSiang = \App\Models\VisitSetting::where('key', 'jam_buka_siang')->value('value') ?? '13:00';
        $jamTutupSiang = \App\Models\VisitSetting::where('key', 'jam_tutup_siang')->value('value') ?? '15:00';

        $currentTime = $now->format('H:i');
        $sesi = null;
        if ($currentTime >= $jamBukaPagi && $currentTime < $jamTutupPagi) {
            $sesi = 'pagi';
        } elseif ($currentTime >= $jamBukaSiang && $currentTime < $jamTutupSiang) {
            $sesi = 'siang';
        }

        if (!$sesi) {
            $this->info('Not within a session time. Exiting.');
            return 0;
        }

        $this->info("Running for session: {$sesi}");

        // Ambill Setting Durasi & Toleransi Batal
        $visitDurationMinutes = (int) \App\Models\VisitSetting::where('key', 'visit_duration_minutes')->value('value') ?? 15;
        $arrivalToleranceMinutes = (int) \App\Models\VisitSetting::where('key', 'arrival_tolerance_minutes')->value('value') ?? 15;

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

        // LOGIKA AUTO-BATAL: Batalin antrian nomor sebelumnya yang belum datang (masih APPROVED)
        $timeSinceLastUpdate = $antrianStatus->updated_at->diffInMinutes($now);
        
        $expiredKunjungans = Kunjungan::where('tanggal_kunjungan', $today)
            ->where('sesi', $sesi)
            ->where('status', EnumKunjunganStatus::APPROVED)
            ->where('nomor_antrian_harian', '<=', $antrianStatus->nomor_terpanggil)
            ->get();

        foreach ($expiredKunjungans as $kunjungan) {
            $numbersPassed = max(0, $antrianStatus->nomor_terpanggil - $kunjungan->nomor_antrian_harian);
            $minutesSinceCalled = $timeSinceLastUpdate + ($numbersPassed * $visitDurationMinutes);

            if ($minutesSinceCalled >= $arrivalToleranceMinutes) {
                $kunjungan->status = EnumKunjunganStatus::REJECTED;
                $kunjungan->catatan_admin = "Dibatalkan otomatis oleh sistem karena melewati batas toleransi keterlambatan ({$arrivalToleranceMinutes} Menit).";
                $kunjungan->save();
                $this->info("Kunjungan ID {$kunjungan->id} (No. Antrian {$kunjungan->nomor_antrian_harian}) cancelled automatically.");
            }
        }

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
        $isFirstCall = $antrianStatus->nomor_terpanggil == 0;
        $sessionJustStarted = ($sesi === 'pagi' && $now->hour === 8 && $now->minute < $visitDurationMinutes) ||
                              ($sesi === 'siang' && $now->hour === 13 && $now->minute < $visitDurationMinutes);

        if ($isFirstCall && $sessionJustStarted) {
             $this->callNextNumber($antrianStatus);
        }
        // Jika bukan pemanggilan pertama dan sudah waktunya untuk nomor berikutnya
        elseif (!$isFirstCall && $timeSinceLastUpdate >= $visitDurationMinutes) {
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

        $payload = [
            'nomor' => $newNumber,
            'loket' => null,
            'status' => 'auto',
            'sesi' => $antrianStatus->sesi,
        ];
        AntrianUpdated::dispatch($payload);

        Log::info("Auto-updated queue for session '{$antrianStatus->sesi}' to number {$newNumber}.");
        $this->info("Updated queue for session '{$antrianStatus->sesi}' to number {$newNumber}.");
    }
}
