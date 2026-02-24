<?php

namespace Tests\Feature;

use App\Models\Kunjungan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\UploadedFile;
use App\Models\Wbp;
use Tests\TestCase;
use Carbon\Carbon;

class KunjunganRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private function validKunjunganData($overrides = [])
    {
        $wbp = Wbp::factory()->create();

        // Create a default dynamic schedule for Tuesdays to support the tests
        if (!\App\Models\VisitSchedule::where('day_of_week', Carbon::TUESDAY)->exists()) {
             \App\Models\VisitSchedule::factory()->create([
                 'day_of_week' => Carbon::TUESDAY,
                 'day_name' => 'Selasa',
                 'is_open' => true,
                 'quota_online_morning' => 50,
                 'quota_online_afternoon' => 50,
             ]);
        }
        
        // Also ensure Monday is present for specific tests
        if (!\App\Models\VisitSchedule::where('day_of_week', Carbon::MONDAY)->exists()) {
             \App\Models\VisitSchedule::factory()->create([
                 'day_of_week' => Carbon::MONDAY,
                 'day_name' => 'Senin',
                 'is_open' => true,
                 'quota_online_morning' => 50,
                 'quota_online_afternoon' => 50,
             ]);
        }

        return array_merge([
            'nama_pengunjung'    => 'John Doe',
            'nik_ktp'            => '1234567890123456',
            'nomor_hp'           => '081234567890',
            'email_pengunjung'   => 'john@example.com',
            'alamat_lengkap'     => 'Some Address',
            'jenis_kelamin'      => 'Laki-laki',
            'wbp_id'             => $wbp->id,
            'hubungan'           => 'Teman',
            'tanggal_kunjungan'  => Carbon::now()->next(Carbon::TUESDAY)->format('Y-m-d'),
            'sesi'               => null,
            'foto_ktp'           => UploadedFile::fake()->image('ktp.jpg'),
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

        // Sanity check: ensure one existing registration is present
        $this->assertEquals(1, Kunjungan::whereDate('tanggal_kunjungan', $date->format('Y-m-d'))->count());

        $response = $this->post(route('kunjungan.store'), $this->validKunjunganData(['tanggal_kunjungan' => $date->format('Y-m-d')]));

        // After posting, ensure no new registration was created and validation error present
        $this->assertEquals(1, Kunjungan::whereDate('tanggal_kunjungan', $date->format('Y-m-d'))->count());
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

        // Special case: when tanggal_kunjungan is in the past, controller returns a general 'error' message
        if ($field === 'tanggal_kunjungan' && $value && Carbon::parse($value)->isPast()) {
            $response->assertSessionHas('error');
        } else {
            $response->assertSessionHasErrors($field);
        }

        $this->assertDatabaseCount('kunjungans', 0);
    }

    public static function validation_provider()
    {
        return [
            'nama_pengunjung is null' => ['nama_pengunjung', null],
            'nik_ktp is null' => ['nik_ktp', null],
            'nik_ktp is not 16 digits' => ['nik_ktp', '12345'],
            'nik_ktp contains letters' => ['nik_ktp', '123456789012345a'],
            'nomor_hp is null' => ['nomor_hp', null],
            'tanggal_kunjungan is null' => ['tanggal_kunjungan', null],
            'tanggal_kunjungan is in the past' => ['tanggal_kunjungan', Carbon::yesterday()->format('Y-m-d')],
            'hubungan is null' => ['hubungan', null],
        ];
    }
}
