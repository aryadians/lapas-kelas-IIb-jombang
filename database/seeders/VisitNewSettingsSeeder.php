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
        ];

        foreach ($settings as $setting) {
            VisitSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
