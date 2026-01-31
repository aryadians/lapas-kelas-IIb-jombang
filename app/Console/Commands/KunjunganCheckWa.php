<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Kunjungan;

class KunjunganCheckWa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * --invalid-only : show only numbers that fail validation after normalization
     * --limit : limit number of rows processed
     */
    protected $signature = 'kunjungan:check-wa {--invalid-only} {--limit=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and normalize WhatsApp numbers for Kunjungan records (show original -> normalized)';

    public function handle()
    {
        $limit = (int) $this->option('limit');
        $invalidOnly = (bool) $this->option('invalid-only');

        $this->info("Fetching up to {$limit} kunjungan with WhatsApp numbers...");

        $kunjungans = Kunjungan::whereNotNull('no_wa_pengunjung')
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get(['id', 'no_wa_pengunjung', 'email_pengunjung', 'preferred_notification_channel']);

        if ($kunjungans->isEmpty()) {
            $this->info('No kunjungan with WhatsApp numbers found.');
            return 0;
        }

        $rows = [];

        foreach ($kunjungans as $k) {
            $original = (string) $k->no_wa_pengunjung;
            $normalized = $this->normalizePhoneNumber($original);

            // Consider valid if starts with 62 and has 9-14 digits after 62 (total 11-16)
            $isValid = preg_match('/^62[0-9]{8,13}$/', $normalized) === 1;

            if ($invalidOnly && $isValid) {
                continue;
            }

            $rows[] = [
                'id' => $k->id,
                'original' => $original,
                'normalized' => $normalized,
                'valid' => $isValid ? 'yes' : 'no',
                'preferred_channel' => $k->preferred_notification_channel ?? '-',
            ];
        }

        if (empty($rows)) {
            $this->info('No rows to display (maybe all numbers are valid and --invalid-only was provided).');
            return 0;
        }

        $this->table(['id', 'original', 'normalized', 'valid', 'preferred_channel'], $rows);

        $invalidCount = collect($rows)->where('valid', 'no')->count();
        $this->info("Processed: " . count($rows) . ", invalid: {$invalidCount}");

        return 0;
    }

    private function normalizePhoneNumber($number)
    {
        $number = (string) $number;
        // Remove non-digits
        $number = preg_replace('/[^0-9]/', '', $number);

        if (empty($number)) {
            return '';
        }

        if (str_starts_with($number, '08')) {
            return '62' . substr($number, 2);
        }

        if (str_starts_with($number, '0')) {
            return '62' . substr($number, 1);
        }

        if (str_starts_with($number, '8')) {
            return '62' . $number;
        }

        // already starts with country code (e.g., 62...)
        return $number;
    }
}
