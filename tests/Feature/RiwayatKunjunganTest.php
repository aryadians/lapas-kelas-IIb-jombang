<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Kunjungan;
use App\Models\Wbp;

class RiwayatKunjunganTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_only_see_their_own_visit_history()
    {
        // 1. Setup
        $this->artisan('migrate');
        
        $userA = User::factory()->create(['email' => 'user_a@example.com']);
        $userB = User::factory()->create(['email' => 'user_b@example.com']);

        // WBP to be visited
        $wbpA = Wbp::factory()->create(['nama' => 'WBP Milik User A']);
        $wbpB = Wbp::factory()->create(['nama' => 'WBP Milik User B']);

        // Create visits associated with each user's email
        $visitA = Kunjungan::factory()->create([
            'email_pengunjung' => $userA->email,
            'wbp_id' => $wbpA->id,
        ]);
        
        $visitB = Kunjungan::factory()->create([
            'email_pengunjung' => $userB->email,
            'wbp_id' => $wbpB->id,
        ]);

        // 2. Action
        // Act as User A and visit the history page
        $response = $this->actingAs($userA)->get(route('kunjungan.riwayat'));

        // 3. Assertions
        $response->assertOk();
        $response->assertViewIs('guest.kunjungan.riwayat');
        
        // Assert can see own visit's data
        $response->assertSee($wbpA->nama);

        // Assert cannot see User B's visit's data
        $response->assertDontSee($wbpB->nama);
    }
}