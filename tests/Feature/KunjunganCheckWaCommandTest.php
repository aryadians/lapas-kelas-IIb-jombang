<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Kunjungan;
use App\Enums\KunjunganStatus;

class KunjunganCheckWaCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_shows_normalized_numbers()
    {
        $k1 = Kunjungan::factory()->create(['no_wa_pengunjung' => '0812 3456 789']); // should -> 628123456789
        $k2 = Kunjungan::factory()->create(['no_wa_pengunjung' => '+62 812-8888-9999']); // should -> 6281288889999
        $k3 = Kunjungan::factory()->create(['no_wa_pengunjung' => '81234567890']); // should -> 6281234567890

        $expected1 = $this->normalizePhoneNumber($k1->no_wa_pengunjung);
        $expected2 = $this->normalizePhoneNumber($k2->no_wa_pengunjung);
        $expected3 = $this->normalizePhoneNumber($k3->no_wa_pengunjung);

        $this->artisan('kunjungan:check-wa --limit=10')
            ->assertExitCode(0)
            ->expectsOutputToContain($expected1)
            ->expectsOutputToContain($expected2)
            ->expectsOutputToContain($expected3);
    }

    public function test_invalid_only_flag_filters_valid_numbers()
    {
        $kGood = Kunjungan::factory()->create(['no_wa_pengunjung' => '08123456789']); // good
        $kBad = Kunjungan::factory()->create(['no_wa_pengunjung' => '12345']); // bad

        $expectedBad = $this->normalizePhoneNumber($kBad->no_wa_pengunjung);

        $this->artisan('kunjungan:check-wa --limit=10 --invalid-only')
            ->assertExitCode(0)
            ->expectsOutputToContain($expectedBad)
            ->expectsOutputToContain('no');
    }

    private function normalizePhoneNumber($number)
    {
        $num = (string) $number;
        $num = preg_replace('/[^0-9]/', '', $num);
        if (str_starts_with($num, '08')) {
            return '62' . substr($num, 2);
        }
        if (str_starts_with($num, '0')) {
            return '62' . substr($num, 1);
        }
        if (str_starts_with($num, '8')) {
            return '62' . $num;
        }
        return $num;
    }
}
