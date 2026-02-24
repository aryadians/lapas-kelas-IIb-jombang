<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VisitSchedule>
 */
class VisitScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dayOfWeek = $this->faker->numberBetween(1, 6);
        $dayNames = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            0 => 'Minggu',
        ];

        return [
            'day_of_week' => $dayOfWeek,
            'day_name' => $dayNames[$dayOfWeek],
            'is_open' => true,
            'quota_online_morning' => 50,
            'quota_offline_morning' => 50,
            'quota_online_afternoon' => 50,
            'quota_offline_afternoon' => 50,
            'allowed_kode_tahanan' => null,
        ];
    }
}
