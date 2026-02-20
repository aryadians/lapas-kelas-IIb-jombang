<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VisitSchedule;
use App\Models\VisitSetting;

class VisitConfigSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Visit Schedules (Default: Jum-Min Tutup)
        $days = [
            ['day_of_week' => 1, 'day_name' => 'Senin', 'is_open' => true, 'online_morning' => 120, 'online_afternoon' => 40, 'offline_morning' => 15, 'offline_afternoon' => 5],
            ['day_of_week' => 2, 'day_name' => 'Selasa', 'is_open' => true, 'online_morning' => 150, 'online_afternoon' => 0, 'offline_morning' => 20, 'offline_afternoon' => 0],
            ['day_of_week' => 3, 'day_name' => 'Rabu', 'is_open' => true, 'online_morning' => 150, 'online_afternoon' => 0, 'offline_morning' => 20, 'offline_afternoon' => 0],
            ['day_of_week' => 4, 'day_name' => 'Kamis', 'is_open' => true, 'online_morning' => 150, 'online_afternoon' => 0, 'offline_morning' => 20, 'offline_afternoon' => 0],
            ['day_of_week' => 5, 'day_name' => 'Jumat', 'is_open' => false, 'online_morning' => 0, 'online_afternoon' => 0, 'offline_morning' => 0, 'offline_afternoon' => 0],
            ['day_of_week' => 6, 'day_name' => 'Sabtu', 'is_open' => false, 'online_morning' => 0, 'online_afternoon' => 0, 'offline_morning' => 0, 'offline_afternoon' => 0],
            ['day_of_week' => 0, 'day_name' => 'Minggu', 'is_open' => false, 'online_morning' => 0, 'online_afternoon' => 0, 'offline_morning' => 0, 'offline_afternoon' => 0],
        ];

        foreach ($days as $day) {
            VisitSchedule::updateOrCreate(
                ['day_of_week' => $day['day_of_week']],
                [
                    'day_name' => $day['day_name'],
                    'is_open' => $day['is_open'],
                    'quota_online_morning' => $day['online_morning'],
                    'quota_online_afternoon' => $day['online_afternoon'],
                    'quota_offline_morning' => $day['offline_morning'],
                    'quota_offline_afternoon' => $day['offline_afternoon'],
                ]
            );
        }

        // 2. Seed Global Rules
        $settings = [
            ['key' => 'limit_nik_per_week', 'value' => '1', 'display_name' => 'Batas Kunjungan NIK per Minggu', 'type' => 'number'],
            ['key' => 'limit_wbp_per_week', 'value' => '1', 'display_name' => 'Batas Kunjungan WBP per Minggu', 'type' => 'number'],
        ];

        foreach ($settings as $setting) {
            VisitSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
