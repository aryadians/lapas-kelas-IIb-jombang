<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Models\VisitSetting;

class TestMailConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email? : Alamat email tujuan pengetesan}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek koneksi SMTP Mail menggunakan konfigurasi dinamis dari database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('--- PENGECEKAN KONFIGURASI EMAIL ---');

        // Ambil data langsung dari database untuk verifikasi
        $settings = VisitSetting::whereIn('key', [
            'mail_host', 'mail_port', 'mail_username', 'mail_password',
            'mail_encryption', 'mail_from_address'
        ])->pluck('value', 'key');

        $this->table(['Setting', 'Value (Database)', 'Value (Laravel Config)'], [
            ['Host', $settings->get('mail_host'), config('mail.mailers.smtp.host')],
            ['Port', $settings->get('mail_port'), config('mail.mailers.smtp.port')],
            ['Username', $settings->get('mail_username'), config('mail.mailers.smtp.username')],
            ['Password', '********', '********'], // Sembunyikan password
            ['Encryption', $settings->get('mail_encryption'), config('mail.mailers.smtp.encryption')],
            ['From Address', $settings->get('mail_from_address'), config('mail.from.address')],
        ]);

        $recipient = $this->argument('email') ?: $settings->get('mail_from_address');

        if (!$recipient) {
            $this->error('Email tujuan tidak ditemukan. Masukkan sebagai argumen atau set mail_from_address di database.');
            return Command::FAILURE;
        }

        $this->info("\nMencoba mengirim email test ke: $recipient ...");

        try {
            Mail::raw('Ini adalah email pengetesan koneksi SMTP dari Sistem Lapas Jombang.', function ($message) use ($recipient) {
                $message->to($recipient)
                        ->subject('Test Koneksi SMTP Lapas Jombang');
            });

            $this->info('✅ BERHASIL! Email telah berhasil terkirim.');
            $this->info('Cek kotak masuk (atau spam) di ' . $recipient);
            
        } catch (\Exception $e) {
            $this->error('❌ GAGAL MENGIRIM EMAIL!');
            $this->newLine();
            $this->warn('DETAIL ERROR:');
            $this->line($e->getMessage());
            
            $this->newLine();
            $this->info('Saran Perbaikan:');
            if (str_contains($e->getMessage(), '535-5.7.8')) {
                $this->line('- Username atau App Password salah.');
                $this->line('- Pastikan kolom Enkripsi hanya berisi "tls" atau "ssl" (tanpa tambahan teks).');
            } elseif (str_contains($e->getMessage(), 'Connection could not be established')) {
                $this->line('- Host atau Port salah.');
                $this->line('- Port 587 butuh enkripsi "tls". Port 465 butuh enkripsi "ssl".');
            }
        }

        return Command::SUCCESS;
    }
}
