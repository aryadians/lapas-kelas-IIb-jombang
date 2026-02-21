<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VisitSetting;

class VisitNewSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'registration_lead_time', 
                'value' => '1', 
                'display_name' => 'Batas Minimal Pendaftaran (H-N Hari)', 
                'type' => 'number'
            ],
            [
                'key' => 'enable_guest_edit', 
                'value' => '0', 
                'display_name' => 'Izinkan Pengunjung Edit Pendaftaran', 
                'type' => 'boolean'
            ],
            [
                'key' => 'edit_lead_time', 
                'value' => '2', 
                'display_name' => 'Batas Maksimal Edit (H-N Hari sebelum kunjungan)', 
                'type' => 'number'
            ],
            [
                'key' => 'max_followers_allowed',
                'value' => '4',
                'display_name' => 'Batas Maksimal Pengikut Rombongan',
                'type' => 'number'
            ],
            [
                'key' => 'visit_duration_minutes',
                'value' => '30',
                'display_name' => 'Durasi Waktu Kunjungan (Menit)',
                'type' => 'number'
            ],
            [
                'key' => 'arrival_tolerance_minutes',
                'value' => '15',
                'display_name' => 'Batas Toleransi Keterlambatan (Menit)',
                'type' => 'number'
            ],
            [
                'key' => 'is_emergency_closed',
                'value' => '0',
                'display_name' => 'Tutup Darurat Semua Pendaftaran',
                'type' => 'boolean'
            ],
            [
                'key' => 'announcement_guest_page',
                'value' => '',
                'display_name' => 'Teks Pengumuman/Spanduk Darurat',
                'type' => 'text'
            ]
        ];

        foreach ($settings as $setting) {
            VisitSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
