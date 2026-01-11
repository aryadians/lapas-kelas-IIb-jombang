<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Kunjungan;
use App\Mail\KunjunganStatusMail;
use Tests\TestCase;

class AdminKunjunganTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Force the migrations to run for the testing database.
        $this->artisan('migrate');

        // Create an admin user
        $this->admin = User::factory()->create(['role' => 'admin']);
        // Seed the database with necessary data if needed, e.g., UserSeeder for roles
    }

    /**
     * Test admin can approve a visit and a QR token is generated.
     */
    public function test_admin_can_approve_visit_and_qr_token_is_generated(): void
    {
        Mail::fake();

        // Create a pending visit
        $kunjungan = Kunjungan::factory()->create(['status' => 'pending', 'qr_token' => null]);

        // Act as the admin and hit the update endpoint
        $response = $this->actingAs($this->admin)
                         ->patch(route('admin.kunjungan.update', $kunjungan), [
                             'status' => 'approved',
                         ]);

        // Assertions
        $response->assertRedirect(route('admin.kunjungan.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('kunjungans', [
            'id' => $kunjungan->id,
            'status' => 'approved',
        ]);

        $kunjungan->refresh();
        $this->assertNotNull($kunjungan->qr_token);
        $this->assertIsString($kunjungan->qr_token);

        Mail::assertSent(KunjunganStatusMail::class, function ($mail) use ($kunjungan) {
            return $mail->kunjungan->id === $kunjungan->id;
        });
    }

    /**
     * Test admin can verify a valid QR token.
     */
    public function test_admin_can_verify_a_valid_qr_token(): void
    {
        // Create an approved visit with a token
        $kunjungan = Kunjungan::factory()->create([
            'status' => 'approved',
            'qr_token' => 'valid-token-123',
            'nama_pengunjung' => 'Budi Hartono'
        ]);

        // Act as the admin and hit the verification endpoint
        $response = $this->actingAs($this->admin)
                         ->post(route('admin.kunjungan.verifikasi.submit'), [
                             'qr_token' => 'valid-token-123',
                         ]);

        // Assertions
        $response->assertOk();
        $response->assertViewIs('admin.kunjungan.verifikasi');
        $response->assertSee('Kunjungan Ditemukan');
        $response->assertSee('Budi Hartono');
    }

    /**
     * Test admin sees an error for an invalid QR token.
     */
    public function test_admin_gets_error_for_invalid_qr_token(): void
    {
        // Act as the admin and hit the verification endpoint with a non-existent token
        $response = $this->actingAs($this->admin)
                         ->post(route('admin.kunjungan.verifikasi.submit'), [
                             'qr_token' => 'invalid-token-xyz',
                         ]);
        
        // Assertions
        $response->assertOk();
        $response->assertViewIs('admin.kunjungan.verifikasi');
        $response->assertSee('Token Tidak Ditemukan');
    }

    /**
     * Test admin can reject a visit.
     */
    public function test_admin_can_reject_visit(): void
    {
        Mail::fake();

        // Create a pending visit
        $kunjungan = Kunjungan::factory()->create(['status' => 'pending']);

        // Act as the admin and hit the update endpoint to reject
        $response = $this->actingAs($this->admin)
                         ->patch(route('admin.kunjungan.update', $kunjungan), [
                             'status' => 'rejected',
                         ]);

        // Assertions
        $response->assertRedirect(route('admin.kunjungan.index'));
        $response->assertSessionHas('success');

        $kunjungan->refresh();
        $this->assertEquals('rejected', $kunjungan->status);
        $this->assertNull($kunjungan->qr_token);

        Mail::assertSent(KunjunganStatusMail::class, function ($mail) use ($kunjungan) {
            return $mail->kunjungan->id === $kunjungan->id;
        });
    }

    /**
     * Test admin can delete a visit.
     */
    public function test_admin_can_delete_visit(): void
    {
        // Create a visit
        $kunjungan = Kunjungan::factory()->create();

        // Act as the admin and hit the destroy endpoint
        $response = $this->actingAs($this->admin)
                         ->delete(route('admin.kunjungan.destroy', $kunjungan));

        // Assertions
        $response->assertRedirect(route('admin.kunjungan.index'));
        $response->assertSessionHas('success', 'Data kunjungan berhasil dihapus.');
        $this->assertDatabaseMissing('kunjungans', ['id' => $kunjungan->id]);
    }

    /**
     * Test admin can bulk approve visits.
     */
    public function test_admin_can_bulk_approve_visits(): void
    {
        $kunjungans = Kunjungan::factory(3)->create(['status' => 'pending']);
        $ids = $kunjungans->pluck('id')->toArray();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.kunjungan.bulk-update'), [
                'ids' => $ids,
                'status' => 'approved',
            ]);

        $response->assertRedirect(route('admin.kunjungan.index'));
        $response->assertSessionHas('success');

        foreach ($kunjungans as $kunjungan) {
            $this->assertDatabaseHas('kunjungans', [
                'id' => $kunjungan->id,
                'status' => 'approved',
            ]);
        }
    }

    /**
     * Test admin can bulk reject visits.
     */
    public function test_admin_can_bulk_reject_visits(): void
    {
        $kunjungans = Kunjungan::factory(3)->create(['status' => 'pending']);
        $ids = $kunjungans->pluck('id')->toArray();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.kunjungan.bulk-update'), [
                'ids' => $ids,
                'status' => 'rejected',
            ]);

        $response->assertRedirect(route('admin.kunjungan.index'));
        $response->assertSessionHas('success');

        foreach ($kunjungans as $kunjungan) {
            $this->assertDatabaseHas('kunjungans', [
                'id' => $kunjungan->id,
                'status' => 'rejected',
            ]);
        }
    }

    /**
     * Test admin can bulk delete visits.
     */
    public function test_admin_can_bulk_delete_visits(): void
    {
        $kunjungans = Kunjungan::factory(3)->create();
        $ids = $kunjungans->pluck('id')->toArray();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.kunjungan.bulk-delete'), [
                'ids' => $ids,
            ]);

        $response->assertRedirect(route('admin.kunjungan.index'));
        $response->assertSessionHas('success');

        foreach ($kunjungans as $kunjungan) {
            $this->assertDatabaseMissing('kunjungans', ['id' => $kunjungan->id]);
        }
    }
}
