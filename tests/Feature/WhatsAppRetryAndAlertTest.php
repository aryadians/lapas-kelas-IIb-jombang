<?php

namespace Tests\Feature;

use App\Jobs\SendWhatsAppApprovedNotification;
use App\Models\Kunjungan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class WhatsAppRetryAndAlertTest extends TestCase
{
    public function test_retry_and_admin_alert_on_repeated_provider_rejections()
    {
        Mail::fake();

        $kunjungan = Kunjungan::factory()->create(['no_wa_pengunjung' => '0812 3456 789']);

        $job = new SendWhatsAppApprovedNotification($kunjungan, null);

        // Fake service that always returns status:false
        $mockResponse = new class {
            public function body() { return json_encode(['status' => false, 'reason' => 'request invalid on disconnected device', 'requestid' => 999]); }
            public function successful() { return true; }
        };

        $whatsAppServiceMock = $this->mock(\App\Services\WhatsAppService::class, function ($mock) use ($mockResponse) {
            $mock->shouldReceive('formatPhoneNumber')->andReturnUsing(function ($s) { return preg_replace('/\D+/', '', $s); });
            $mock->shouldReceive('sendApproved')->andReturn($mockResponse);
        });

        $normalized = '08123456789';
        $normalized = preg_replace('/\D+/', '', $kunjungan->no_wa_pengunjung);
        $key = "wa_failures:{$normalized}";
        $alertKey = "wa_alerted:{$normalized}";
        Cache::forget($key);
        Cache::forget($alertKey);

        // First two attempts should increment and throw
        $this->expectException(\Exception::class);
        $job->handle($whatsAppServiceMock);

        $this->expectException(\Exception::class);
        $job->handle($whatsAppServiceMock);

        // Third attempt should send admin mail and not throw (job will call fail())
        $job->handle($whatsAppServiceMock);

        $this->assertNotNull(Cache::get($key));
        $this->assertEquals(3, Cache::get($key));

        Mail::assertSent(\App\Mail\WhatsAppProviderFailure::class, function ($mail) use ($normalized) {
            return str_contains($mail->subject, $normalized) || (isset($mail->details) && ($mail->details['target'] ?? '') === $normalized);
        });

        // Alert key should be set to avoid duplicate alerts
        $this->assertTrue((bool) Cache::get($alertKey));
    }
}
