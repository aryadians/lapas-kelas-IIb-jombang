<?php

namespace Tests\Feature;

use App\Enums\KunjunganStatus;
use App\Models\Kunjungan;
use App\Models\User;
use App\Models\Wbp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Jobs\SendWhatsAppPendingNotification;
use App\Jobs\SendWhatsAppApprovedNotification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

class FullFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_complete_visit_flow_registration_to_approval()
    {
        $this->withoutMiddleware();

        // 0. Setup Configuration & Mocking
        Storage::fake('public');
        Queue::fake();
        Config::set('kunjungan.quota_hari_biasa', 50);

        // Create WBP
        $wbp = Wbp::factory()->create(['nama' => 'Napi Test', 'no_registrasi' => 'B.123']);

        // Create Admin User
        $admin = User::factory()->create(['role' => 'admin']);

        // 1. GUEST REGISTRATION
        $response = $this->post(route('kunjungan.store'), [
            'nama_pengunjung'   => 'John Doe',
            'nik_ktp'           => '1234567890123456',
            'nomor_hp'          => '08123456789',
            'email_pengunjung'  => 'john@example.com',
            'alamat_lengkap'    => 'Jl. Test No. 1',
            'jenis_kelamin'     => 'Laki-laki',
            'hubungan'          => 'Teman',
            'wbp_id'            => $wbp->id,
            'tanggal_kunjungan' => now()->addDay()->format('Y-m-d'), // Besok
            'foto_ktp'          => UploadedFile::fake()->image('ktp.jpg'),
            'sesi'              => 'pagi'
        ]);

        // Debug validation errors if any
        if ($response->getSession()->has('errors')) {
            dump($response->getSession()->get('errors')->all());
        }
        if ($response->getSession()->has('error')) {
            dump('Session Error:', $response->getSession()->get('error'));
        }

        // Assert Redirect Success
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('kunjungan.create'));
        $response->assertSessionHas('success');

        // Check DB
        $this->assertDatabaseHas('kunjungans', [
            'nama_pengunjung' => 'John Doe',
            'nik_ktp' => '1234567890123456',
            'status' => KunjunganStatus::PENDING->value,
        ]);

        $kunjungan = Kunjungan::where('nik_ktp', '1234567890123456')->first();
        $this->assertNotNull($kunjungan->foto_ktp, 'Foto KTP (Base64) harus tersimpan');

        // Check Redis Quota Decrement
        // The key format depends on the date. 
        $dateKey = now()->addDay()->format('Y-m-d');
        // Initial quota check puts it in cache, then decrement.
        // If config is 50, after decrement it should be 49.
        $this->assertEquals(49, Cache::get("quota:{$dateKey}:all") ?? Cache::get("quota:{$dateKey}:pagi"));

        // Check Pending Notification Job
        Queue::assertPushed(SendWhatsAppPendingNotification::class);

        // 2. ADMIN APPROVAL
        $responseAdmin = $this->actingAs($admin)
            ->put(route('admin.kunjungan.update', $kunjungan->id), [
                'status' => KunjunganStatus::APPROVED->value
            ]);

        $responseAdmin->assertRedirect();
        $responseAdmin->assertSessionHas('success');

        // Check DB Status Updated
        $this->assertDatabaseHas('kunjungans', [
            'id' => $kunjungan->id,
            'status' => KunjunganStatus::APPROVED->value,
        ]);

        // Check Approved Notification Job
        Queue::assertPushed(SendWhatsAppApprovedNotification::class);

        // Check QR Code Generated (Mocked Storage)
        // Note: The controller/service uses Storage::disk('public')->put(...)
        // In test, Storage::fake('public') captures this.
        // Depending on logic, it might generate .png or .svg
        $exists = Storage::disk('public')->exists("qrcodes/{$kunjungan->id}.png") || 
                  Storage::disk('public')->exists("qrcodes/{$kunjungan->id}.svg");
        
        $this->assertTrue($exists, 'QR Code file should be generated in storage');
    }
}