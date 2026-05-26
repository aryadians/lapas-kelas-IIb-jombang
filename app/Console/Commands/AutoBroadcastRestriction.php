<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Wbp;
use App\Models\Kunjungan;
use App\Models\BroadcastRestrictionLog;
use App\Models\BroadcastRestrictionLogDetail;
use App\Enums\KunjunganStatus;
use App\Jobs\SendRestrictionNotificationJob;

class AutoBroadcastRestriction extends Command
{
    protected $signature   = 'app:auto-broadcast-restriction {--manual : Jalankan manual (akan dicatat sebagai manual)}';
    protected $description = 'Broadcast otomatis pembatalan kunjungan untuk WBP yang sedang dalam masa pembatasan (mapenaling, sidang, dll).';

    public function handle(): int
    {
        $triggeredBy = $this->option('manual') ? 'manual' : 'scheduler';
        $startTime   = now();

        $this->info("🔔 [AutoBroadcastRestriction] Mulai dijalankan oleh: {$triggeredBy}");
        Log::info("[AutoBroadcastRestriction] START | triggered_by: {$triggeredBy} | waktu: {$startTime->toDateTimeString()}");

        $totalWbpProcessed       = 0;
        $totalWbpNoRestriction   = 0;
        $totalKunjunganCancelled = 0;
        $totalNotifQueued        = 0;
        $details                 = [];
        $hasError                = false;

        try {
            // Ambil semua WBP aktif yang memiliki restriction aktif/mendatang
            $wbps = Wbp::with(['latestRestriction', 'latestRestriction.wbp'])
                       ->whereHas('latestRestriction')
                       ->get();

            $this->info("WBP dengan pembatasan aktif: {$wbps->count()}");

            // Jika tidak ada WBP dengan restriction, cek apakah semua WBP tidak punya restriction
            if ($wbps->isEmpty()) {
                $allWbpCount = Wbp::count();
                $this->warn("Tidak ada WBP dengan restriction aktif. Total WBP: {$allWbpCount}");
                $totalWbpNoRestriction = $allWbpCount;
            }

            foreach ($wbps as $wbp) {
                $totalWbpProcessed++;
                $restriction = $wbp->latestRestriction;

                if (!$restriction) {
                    $totalWbpNoRestriction++;
                    $this->warn("  ⚠ WBP [{$wbp->id}] {$wbp->nama} — tidak ada restriction aktif.");
                    $details[] = [
                        'wbp_id'          => $wbp->id,
                        'wbp_nama'        => $wbp->nama,
                        'restriction_type'=> null,
                        'restriction_start'=> null,
                        'restriction_end' => null,
                        'kunjungan_id'    => null,
                        'kode_booking'    => null,
                        'tanggal_kunjungan'=> null,
                        'pengunjung_nama' => null,
                        'pengunjung_wa'   => null,
                        'pengunjung_email'=> null,
                        'wa_queued'       => false,
                        'email_queued'    => false,
                        'action'          => 'no_restriction',
                        'error_message'   => null,
                    ];
                    continue;
                }

                $this->line("  → WBP [{$wbp->id}] {$wbp->nama} | {$restriction->type} | {$restriction->start_date->toDateString()} s.d. {$restriction->end_date->toDateString()}");

                // Cari kunjungan yang overlapping dengan masa pembatasan
                $kunjungans = Kunjungan::with(['profilPengunjung'])
                    ->where('wbp_id', $wbp->id)
                    ->whereIn('status', [
                        KunjunganStatus::PENDING->value,
                        KunjunganStatus::APPROVED->value,
                    ])
                    ->whereDate('tanggal_kunjungan', '>=', $restriction->start_date)
                    ->whereDate('tanggal_kunjungan', '<=', $restriction->end_date)
                    ->get();

                $this->line("     Kunjungan terdampak: {$kunjungans->count()}");

                if ($kunjungans->isEmpty()) {
                    $details[] = [
                        'wbp_id'           => $wbp->id,
                        'wbp_nama'         => $wbp->nama,
                        'restriction_type' => $restriction->type,
                        'restriction_start' => $restriction->start_date,
                        'restriction_end'  => $restriction->end_date,
                        'kunjungan_id'     => null,
                        'kode_booking'     => null,
                        'tanggal_kunjungan' => null,
                        'pengunjung_nama'  => null,
                        'pengunjung_wa'    => null,
                        'pengunjung_email' => null,
                        'wa_queued'        => false,
                        'email_queued'     => false,
                        'action'           => 'no_kunjungan',
                        'error_message'    => null,
                    ];
                    continue;
                }

                foreach ($kunjungans as $kunjungan) {
                    try {
                        // Batalkan kunjungan tanpa trigger observer
                        $kunjungan->updateQuietly(['status' => KunjunganStatus::REJECTED]);

                        // Dispatch notifikasi ke queue
                        SendRestrictionNotificationJob::dispatch($kunjungan->id, $wbp->id, $restriction->id);
                        $totalNotifQueued++;

                        $profil = $kunjungan->profilPengunjung;

                        $details[] = [
                            'wbp_id'           => $wbp->id,
                            'wbp_nama'         => $wbp->nama,
                            'restriction_type' => $restriction->type,
                            'restriction_start' => $restriction->start_date,
                            'restriction_end'  => $restriction->end_date,
                            'kunjungan_id'     => $kunjungan->id,
                            'kode_booking'     => $kunjungan->kode_booking,
                            'tanggal_kunjungan' => $kunjungan->tanggal_kunjungan,
                            'pengunjung_nama'  => $profil?->nama ?? $kunjungan->nama_pengunjung ?? '-',
                            'pengunjung_wa'    => $profil?->nomor_hp ?? $kunjungan->no_wa_pengunjung ?? '-',
                            'pengunjung_email' => $profil?->email ?? $kunjungan->email_pengunjung ?? '-',
                            'wa_queued'        => true,
                            'email_queued'     => false, // tergantung job
                            'action'           => 'cancelled',
                            'error_message'    => null,
                        ];

                        $totalKunjunganCancelled++;
                        $this->info("     ✔ Kunjungan #{$kunjungan->id} ({$kunjungan->kode_booking}) dibatalkan & notif antri.");

                    } catch (\Exception $e) {
                        $hasError = true;
                        Log::error("[AutoBroadcastRestriction] Error pada kunjungan #{$kunjungan->id}: " . $e->getMessage());
                        $this->error("     ✘ Error kunjungan #{$kunjungan->id}: " . $e->getMessage());

                        $details[] = [
                            'wbp_id'           => $wbp->id,
                            'wbp_nama'         => $wbp->nama,
                            'restriction_type' => $restriction->type,
                            'restriction_start' => $restriction->start_date,
                            'restriction_end'  => $restriction->end_date,
                            'kunjungan_id'     => $kunjungan->id,
                            'kode_booking'     => $kunjungan->kode_booking,
                            'tanggal_kunjungan' => $kunjungan->tanggal_kunjungan,
                            'pengunjung_nama'  => null,
                            'pengunjung_wa'    => null,
                            'pengunjung_email' => null,
                            'wa_queued'        => false,
                            'email_queued'     => false,
                            'action'           => 'error',
                            'error_message'    => $e->getMessage(),
                        ];
                    }
                }
            }

            // Tentukan status akhir
            $status = 'success';
            if ($totalKunjunganCancelled === 0 && !$hasError) {
                $status = 'no_impact';
            } elseif ($hasError && $totalKunjunganCancelled > 0) {
                $status = 'partial_error';
            } elseif ($hasError && $totalKunjunganCancelled === 0) {
                $status = 'failed';
            }

            $notes = "Broadcast selesai dalam " . now()->diffInSeconds($startTime) . " detik. "
                   . "WBP diproses: {$totalWbpProcessed}. "
                   . "Tanpa restriction: {$totalWbpNoRestriction}. "
                   . "Kunjungan dibatalkan: {$totalKunjunganCancelled}. "
                   . "Notifikasi antri: {$totalNotifQueued}.";

            // Simpan log utama
            $log = BroadcastRestrictionLog::create([
                'triggered_by'               => $triggeredBy,
                'triggered_by_user_id'       => $triggeredBy === 'manual' ? auth()->id() : null,
                'total_wbp_processed'        => $totalWbpProcessed,
                'total_wbp_no_restriction'   => $totalWbpNoRestriction,
                'total_kunjungan_cancelled'  => $totalKunjunganCancelled,
                'total_notifications_queued' => $totalNotifQueued,
                'status'                     => $status,
                'notes'                      => $notes,
            ]);

            // Simpan detail log
            foreach ($details as $detail) {
                $detail['broadcast_restriction_log_id'] = $log->id;
                BroadcastRestrictionLogDetail::create($detail);
            }

            $this->info("✅ Log disimpan (ID: {$log->id}) | Status: {$status}");
            $this->info("📋 {$notes}");

            Log::info("[AutoBroadcastRestriction] DONE | log_id: {$log->id} | status: {$status} | {$notes}");

            return self::SUCCESS;

        } catch (\Exception $e) {
            Log::error("[AutoBroadcastRestriction] FATAL ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            $this->error("💥 FATAL ERROR: " . $e->getMessage());

            // Simpan log error
            BroadcastRestrictionLog::create([
                'triggered_by'               => $triggeredBy,
                'triggered_by_user_id'       => null,
                'total_wbp_processed'        => $totalWbpProcessed,
                'total_wbp_no_restriction'   => $totalWbpNoRestriction,
                'total_kunjungan_cancelled'  => $totalKunjunganCancelled,
                'total_notifications_queued' => $totalNotifQueued,
                'status'                     => 'failed',
                'notes'                      => 'FATAL ERROR: ' . $e->getMessage(),
            ]);

            return self::FAILURE;
        }
    }
}
