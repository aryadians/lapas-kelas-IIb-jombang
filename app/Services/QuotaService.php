<?php

namespace App\Services;

use App\Enums\KunjunganStatus;
use App\Models\Kunjungan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class QuotaService
{
    /**
     * Check if quota is available for a given date and session.
     * 
     * @param string $date (Y-m-d)
     * @param string|null $session
     * @return bool
     */
    public function checkAvailability(string $date, ?string $session = null): bool
    {
        $key = $this->getCacheKey($date, $session);
        
        // Atomic check in Redis
        // If key doesn't exist, we calculate from DB and set it
        $remaining = Cache::remember($key, 300, function () use ($date, $session) {
            return $this->calculateRemainingQuotaFromDb($date, $session);
        });

        return $remaining > 0;
    }

    /**
     * Decrement the quota by 1.
     * Should be called AFTER successful DB insertion.
     * 
     * @param string $date
     * @param string|null $session
     * @return int New remaining quota
     */
    public function decrementQuota(string $date, ?string $session = null): int
    {
        $key = $this->getCacheKey($date, $session);
        
        // Ensure key exists before decrementing
        if (!Cache::has($key)) {
            $this->checkAvailability($date, $session);
        }

        $newVal = Cache::decrement($key);
        Log::info("Quota decremented for $key. New value: $newVal");
        
        return $newVal;
    }

    /**
     * Increment the quota (e.g., if visit is Rejected/Cancelled).
     */
    public function incrementQuota(string $date, ?string $session = null): int
    {
        $key = $this->getCacheKey($date, $session);
        
        // Ensure key exists
        if (!Cache::has($key)) {
            $this->checkAvailability($date, $session);
        }

        $newVal = Cache::increment($key);
        // Ensure we don't exceed max quota (sanity check)
        $max = $this->getMaxQuota($date, $session);
        if ($newVal > $max) {
            Cache::put($key, $max, 300);
            return $max;
        }

        return $newVal;
    }

    private function calculateRemainingQuotaFromDb(string $date, ?string $session): int
    {
        $max = $this->getMaxQuota($date, $session);

        $query = Kunjungan::whereDate('tanggal_kunjungan', $date)
            ->whereIn('status', [KunjunganStatus::PENDING->value, KunjunganStatus::APPROVED->value]);

        if ($session) {
            $query->where('sesi', $session);
        }

        $used = $query->count();
        $remaining = max(0, $max - $used);

        Log::info("Quota initialized from DB for $date ($session). Max: $max, Used: $used, Remaining: $remaining");

        return $remaining;
    }

    private function getMaxQuota(string $dateStr, ?string $session): int
    {
        $date = Carbon::parse($dateStr);
        
        if ($date->isMonday()) {
            return ($session === 'siang') 
                ? config('kunjungan.quota_senin_siang', 40) 
                : config('kunjungan.quota_senin_pagi', 120);
        }

        return config('kunjungan.quota_hari_biasa', 150);
    }

    private function getCacheKey(string $date, ?string $session): string
    {
        // Example: quota:2024-01-01:pagi
        return "quota:{$date}:" . ($session ?? 'all');
    }
}
