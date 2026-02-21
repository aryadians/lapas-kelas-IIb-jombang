<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\VisitSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

class DynamicMailServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Pastikan tabel sudah ada (hindari error saat migrate/seed pertama kali)
        try {
            if (!Schema::hasTable('visit_settings')) {
                return;
            }

            $mailSettings = VisitSetting::whereIn('key', [
                'mail_host', 'mail_port', 'mail_username', 'mail_password',
                'mail_encryption', 'mail_from_address', 'admin_email'
            ])->pluck('value', 'key');

            // Hanya override jika ada data di database dan tidak kosong
            if ($mailSettings->isNotEmpty()) {
                if ($mailSettings->get('mail_host')) {
                    Config::set('mail.mailers.smtp.host', $mailSettings->get('mail_host'));
                }
                if ($mailSettings->get('mail_port')) {
                    Config::set('mail.mailers.smtp.port', (int) $mailSettings->get('mail_port'));
                }
                if ($mailSettings->get('mail_username')) {
                    Config::set('mail.mailers.smtp.username', $mailSettings->get('mail_username'));
                }
                if ($mailSettings->get('mail_password')) {
                    Config::set('mail.mailers.smtp.password', $mailSettings->get('mail_password'));
                }
                if ($mailSettings->get('mail_encryption')) {
                    Config::set('mail.mailers.smtp.encryption', $mailSettings->get('mail_encryption'));
                }
                if ($mailSettings->get('mail_from_address')) {
                    Config::set('mail.from.address', $mailSettings->get('mail_from_address'));
                    Config::set('mail.from.name', config('app.name', 'Lapas Jombang'));
                }
            }
        } catch (\Exception $e) {
            // Silently fail — jangan crash app saat DB belum ready
        }
    }
}
