<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\QuotaService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use App\Models\Kunjungan;
use App\Enums\KunjunganStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuotaServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_check_availability_calculates_from_db_initial()
    {
        // Setup Config
        Config::set('kunjungan.quota_hari_biasa', 10);
        
        // Seed 3 existing visits
        Kunjungan::factory()->count(3)->create([
            'tanggal_kunjungan' => '2025-01-01',
            'status' => KunjunganStatus::PENDING,
        ]);

        $service = new QuotaService();
        
        // Should calculate 10 - 3 = 7 available
        $available = $service->checkAvailability('2025-01-01');
        
        $this->assertTrue($available);
        
        // Cache should be set
        $this->assertTrue(Cache::has('quota:2025-01-01:all'));
        $this->assertEquals(7, Cache::get('quota:2025-01-01:all'));
    }

    public function test_decrement_quota_works()
    {
        Config::set('kunjungan.quota_hari_biasa', 10);
        $service = new QuotaService();

        // Init cache (10 remaining)
        $service->checkAvailability('2025-01-02');
        
        $newVal = $service->decrementQuota('2025-01-02');
        
        $this->assertEquals(9, $newVal);
        $this->assertEquals(9, Cache::get('quota:2025-01-02:all'));
    }

    public function test_check_availability_returns_false_when_full()
    {
        Config::set('kunjungan.quota_hari_biasa', 2);
        Kunjungan::factory()->count(2)->create([
            'tanggal_kunjungan' => '2025-01-03',
            'status' => KunjunganStatus::APPROVED,
        ]);

        $service = new QuotaService();
        $available = $service->checkAvailability('2025-01-03');
        
        $this->assertFalse($available);
        $this->assertEquals(0, Cache::get('quota:2025-01-03:all'));
    }
}
