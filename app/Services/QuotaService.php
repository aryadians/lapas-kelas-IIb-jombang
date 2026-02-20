<?php

namespace App\Services;

use App\Enums\KunjunganStatus;
use App\Models\Kunjungan;
use App\Models\VisitSchedule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class QuotaService
{
    /**
     * Check if quota is available for a given date and session.
     */
    public function checkAvailability(string $date, ?string $session = null, string $type = 'online'): bool
    {
        // 1. Cek apakah hari tersebut BUKA
        if (!$this->isDayOpen($date)) {
            return false;
        }

        $key = $this->getCacheKey($date, $session, $type);
        
        $remaining = Cache::remember($key, 300, function () use ($date, $session, $type) {
            return $this->calculateRemainingQuotaFromDb($date, $session, $type);
        });

        return $remaining > 0;
    }

    public function isDayOpen(string $date): bool
    {
        $dayOfWeek = Carbon::parse($date)->dayOfWeek;
        $schedule = VisitSchedule::where('day_of_week', $dayOfWeek)->first();
        return $schedule ? $schedule->is_open : false;
    }

    public function decrementQuota(string $date, ?string $session = null, string $type = 'online'): int
    {
        $key = $this->getCacheKey($date, $session, $type);
        if (!Cache::has($key)) {
            $this->checkAvailability($date, $session, $type);
        }
        return Cache::decrement($key);
    }

    private function calculateRemainingQuotaFromDb(string $date, ?string $session, string $type): int
    {
        $max = $this->getMaxQuota($date, $session, $type);

        $query = Kunjungan::whereDate('tanggal_kunjungan', $date)
            ->where('registration_type', $type)
            ->whereIn('status', [KunjunganStatus::PENDING, KunjunganStatus::APPROVED]);

        if ($session) {
            $query->where('sesi', $session);
        }

        $used = $query->count();
        return max(0, $max - $used);
    }

    public function getMaxQuota(string $dateStr, ?string $session, string $type = 'online'): int
    {
        $dayOfWeek = Carbon::parse($dateStr)->dayOfWeek;
        $schedule = VisitSchedule::where('day_of_week', $dayOfWeek)->first();

        if (!$schedule) return 0;

        $sessionKey = ($session === 'siang') ? 'afternoon' : 'morning';
        $column = "quota_{$type}_{$sessionKey}";

        return $schedule->$column ?? 0;
    }

    private function getCacheKey(string $date, ?string $session, string $type): string
    {
        return "quota:{$type}:{$date}:" . ($session ?? 'morning');
    }
}
