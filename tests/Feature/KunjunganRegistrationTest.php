<?php

namespace Tests\Feature;

use App\Models\Kunjungan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use Carbon\Carbon;

class KunjunganRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper function to generate valid data for a Kunjungan post request.
     */
    private function validKunjunganData($overrides = [])
    {
        return array_merge([
            'nama_pengunjung'    => 'John Doe',
            'nik_pengunjung'     => '1234567890123456',
            'no_wa_pengunjung'   => '081234567890',
            'email_pengunjung'   => 'john@example.com',
            'alamat_pengunjung'  => 'Some Address',
            'nama_wbp'           => 'Jane Doe',
            'hubungan'           => 'Teman',
            'tanggal_kunjungan'  => Carbon::now()->next(Carbon::TUESDAY)->format('Y-m-d'),
        ], $overrides);
    }

    /** @test */
    public function a_visitor_can_register_on_a_valid_weekday()
    {
        $date = Carbon::now()->next(Carbon::TUESDAY);
        $data = $this->validKunjunganData(['tanggal_kunjungan' => $date->format('Y-m-d')]);

        $response = $this->post(route('kunjungan.store'), $data);

        $response->assertRedirect(route('kunjungan.create'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('kunjungans', [
            'nama_pengunjung' => 'John Doe',
            'nomor_antrian_harian' => 1,
            'sesi' => null
        ]);
    }

    /** @test */
    public function registration_is_blocked_when_weekday_quota_is_full()
    {
        config(['kunjungan.quota_hari_biasa' => 1]);
        $date = Carbon::now()->next(Carbon::TUESDAY);

        Kunjungan::factory()->create(['tanggal_kunjungan' => $date->format('Y-m-d')]);

        $response = $this->post(route('kunjungan.store'), $this->validKunjunganData(['tanggal_kunjungan' => $date->format('Y-m-d')]));

        $response->assertSessionHasErrors('tanggal_kunjungan');
    }
    
    /** @test */
    public function a_visitor_can_register_for_a_monday_session()
    {
        $date = Carbon::now()->next(Carbon::MONDAY);
        $data = $this->validKunjunganData([
            'tanggal_kunjungan' => $date->format('Y-m-d'),
            'sesi' => 'pagi',
        ]);

        $response = $this->post(route('kunjungan.store'), $data);

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('kunjungans', [
            'nama_pengunjung' => 'John Doe',
            'sesi' => 'pagi',
        ]);
    }

    /** @test */
    public function registration_is_blocked_if_selected_monday_session_is_full()
    {
        config(['kunjungan.quota_senin_pagi' => 1]);
        $date = Carbon::now()->next(Carbon::MONDAY);

        Kunjungan::factory()->create([
            'tanggal_kunjungan' => $date->format('Y-m-d'),
            'sesi' => 'pagi'
        ]);

        $response = $this->post(route('kunjungan.store'), $this->validKunjunganData([
            'tanggal_kunjungan' => $date->format('Y-m-d'),
            'sesi' => 'pagi'
        ]));

        $response->assertSessionHasErrors('sesi');
    }

    /** @test */
    public function registration_requires_a_session_on_monday()
    {
        $date = Carbon::now()->next(Carbon::MONDAY);
        $data = $this->validKunjunganData([
            'tanggal_kunjungan' => $date->format('Y-m-d'),
            'sesi' => null, // Explicitly set to null
        ]);

        $response = $this->post(route('kunjungan.store'), $data);

        $response->assertSessionHasErrors('sesi');
    }

    /** @test */
    public function registration_is_blocked_on_weekends()
    {
        $date = Carbon::now()->next(Carbon::FRIDAY);
        
        $response = $this->post(route('kunjungan.store'), $this->validKunjunganData(['tanggal_kunjungan' => $date->format('Y-m-d')]));

        $response->assertSessionHasErrors('tanggal_kunjungan');
    }

    /**
     * @test
     * @dataProvider validation_provider
     */
    public function test_registration_fails_with_invalid_data($field, $value)
    {
        $data = $this->validKunjunganData([$field => $value]);

        $response = $this->post(route('kunjungan.store'), $data);

        $response->assertSessionHasErrors($field);
        $this->assertDatabaseCount('kunjungans', 0);
    }

    public function validation_provider()
    {
        return [
            'nama_pengunjung is null' => ['nama_pengunjung', null],
            'nik_pengunjung is null' => ['nik_pengunjung', null],
            'nik_pengunjung is not 16 digits' => ['nik_pengunjung', '12345'],
            'nik_pengunjung contains letters' => ['nik_pengunjung', '123456789012345a'],
            'no_wa_pengunjung is null' => ['no_wa_pengunjung', null],
            'tanggal_kunjungan is null' => ['tanggal_kunjungan', null],
            'tanggal_kunjungan is in the past' => ['tanggal_kunjungan', Carbon::yesterday()->format('Y-m-d')],
            'hubungan is null' => ['hubungan', null],
        ];
    }
}
