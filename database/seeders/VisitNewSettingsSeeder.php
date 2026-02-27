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
                'display_name' => 'Batas Maksimal Pendaftaran / Edit (H-N Hari)', 
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
            ],
            // DATA TAMBAHAN FITUR MANAJEMEN LAPAS TAHAP II
            [
                'key' => 'terms_conditions',
                'value' => '<p><strong>Syarat & Ketentuan Kunjungan Lapas:</strong></p><ol><li>Pengunjung wajib membawa KTP/KK asli.</li><li>Berpakaian rapi dan sopan (tidak menggunakan celana pendek/sandal jepit).</li><li>Dilarang membawa alat komunikasi (Handphone), senjata tajam, uang tunai berlebih, dan narkoba.</li><li>Patuhi jadwal sesi yang dipilih.</li></ol>',
                'display_name' => 'Syarat & Ketentuan Kunjungan Publik',
                'type' => 'text'
            ],
            [
                'key' => 'helpdesk_whatsapp',
                'value' => '6281234567890',
                'display_name' => 'Nomor WhatsApp Helpdesk/Pengaduan',
                'type' => 'string'
            ],
            [
                'key' => 'api_token_fonnte',
                'value' => '',
                'display_name' => 'Token API Fonnte (WhatsApp Gateway)',
                'type' => 'string'
            ],
            [
                'key' => 'jam_buka_pagi',
                'value' => '08:00',
                'display_name' => 'Jam Buka Pelayanan (Sesi Pagi)',
                'type' => 'string'
            ],
            [
                'key' => 'jam_tutup_pagi',
                'value' => '11:00',
                'display_name' => 'Jam Tutup Pelayanan (Sesi Pagi)',
                'type' => 'string'
            ],
            [
                'key' => 'jam_buka_siang',
                'value' => '13:00',
                'display_name' => 'Jam Buka Pelayanan (Sesi Siang)',
                'type' => 'string'
            ],
            [
                'key' => 'jam_tutup_siang',
                'value' => '15:00',
                'display_name' => 'Jam Tutup Pelayanan (Sesi Siang)',
                'type' => 'string'
            ],
            // KONFIGURASI EMAIL (GMAIL SMTP)
            [
                'key' => 'mail_host',
                'value' => 'smtp.gmail.com',
                'display_name' => 'SMTP Host',
                'type' => 'string'
            ],
            [
                'key' => 'mail_port',
                'value' => '587',
                'display_name' => 'SMTP Port',
                'type' => 'number'
            ],
            [
                'key' => 'mail_username',
                'value' => 'tundjungm@gmail.com',
                'display_name' => 'Email Pengirim (Username SMTP)',
                'type' => 'string'
            ],
            [
                'key' => 'mail_password',
                'value' => 'dwvpktuptruvlkqe',
                'display_name' => 'App Password Gmail (SMTP)',
                'type' => 'string'
            ],
            [
                'key' => 'mail_encryption',
                'value' => 'tls',
                'display_name' => 'Enkripsi Email',
                'type' => 'string'
            ],
            [
                'key' => 'mail_from_address',
                'value' => 'tundjungm@gmail.com',
                'display_name' => 'Alamat Email Pengirim (From)',
                'type' => 'string'
            ],
            [
                'key' => 'admin_email',
                'value' => 'tundjungm@gmail.com',
                'display_name' => 'Email Admin / Penerima Notifikasi',
                'type' => 'string'
            ],
            [
                'key' => 'monday_registration_special',
                'value' => '0',
                'display_name' => 'Pendaftaran Khusus Hari Senin (Jumat-Minggu)',
                'type' => 'boolean'
            ]
        ];

        foreach ($settings as $setting) {
            VisitSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
