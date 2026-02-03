<?php

namespace Database\Factories;

use App\Models\Kunjungan;
use App\Models\Wbp;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Enums\KunjunganStatus;

class KunjunganFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Kunjungan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama_pengunjung' => $this->faker->name(),
            'nik_ktp' => $this->faker->numerify('################'),
            'no_wa_pengunjung' => $this->faker->phoneNumber(),
            'email_pengunjung' => $this->faker->unique()->safeEmail(),
            'alamat_pengunjung' => $this->faker->address(),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'wbp_id' => Wbp::factory(),
            'hubungan' => $this->faker->randomElement(['Keluarga', 'Teman']),
            'tanggal_kunjungan' => $this->faker->dateTimeBetween('-1 month', 'now'), // Changed to past dates for charts
            'sesi' => 'pagi',
            'status' => KunjunganStatus::APPROVED, // Approved by default for charts
            'kode_kunjungan' => 'VIS-' . strtoupper(Str::random(6)),
            'qr_token' => Str::uuid(),
            'nomor_antrian_harian' => $this->faker->numberBetween(1, 100),
            'preferred_notification_channel' => 'email',
            'foto_ktp' => 'uploads/ktp/default.jpg',
            // Sync timestamps for charts
            'created_at' => function (array $attributes) {
                return $attributes['tanggal_kunjungan'];
            },
            'updated_at' => function (array $attributes) {
                return $attributes['tanggal_kunjungan'];
            },
        ];
    }
}