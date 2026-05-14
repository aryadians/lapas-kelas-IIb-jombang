<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Kunjungan;
use App\Models\Wbp;
use App\Models\WbpRestriction;
use App\Mail\RestrictionBroadcastMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendRestrictionNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $kunjunganId;
    protected $wbpId;
    protected $restrictionId;

    /**
     * Create a new job instance.
     */
    public function __construct($kunjunganId, $wbpId, $restrictionId)
    {
        $this->kunjunganId = $kunjunganId;
        $this->wbpId = $wbpId;
        $this->restrictionId = $restrictionId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $kunjungan = Kunjungan::find($this->kunjunganId);
        $wbp = Wbp::find($this->wbpId);
        $restriction = WbpRestriction::find($this->restrictionId);

        if (!$kunjungan || !$wbp || !$restriction) {
            return;
        }

        // 1. Send Email if available
        if (!empty($kunjungan->email_pengunjung)) {
            try {
                Mail::to($kunjungan->email_pengunjung)->send(new RestrictionBroadcastMail($kunjungan, $wbp, $restriction));
            } catch (\Exception $e) {
                Log::error("Failed sending restriction email to {$kunjungan->email_pengunjung}: " . $e->getMessage());
            }
        }

        // 2. Send WhatsApp
        if (!empty($kunjungan->no_wa_pengunjung)) {
            try {
                $start = \Carbon\Carbon::parse($restriction->start_date)->format('d/m/Y');
                $end = \Carbon\Carbon::parse($restriction->end_date)->format('d/m/Y');
                $tglVisit = \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d/m/Y');

                $waService = app(\App\Services\WhatsAppService::class);
                $message = "⚠️ *PEMBERITAHUAN PENTING LAPAS JOMBANG*\n\n"
                         . "Yth. Sdr/i *{$kunjungan->nama_pengunjung}*,\n\n"
                         . "Mohon maaf, pendaftaran kunjungan Anda pada tanggal *$tglVisit* (Kode: {$kunjungan->kode_booking}) terpaksa kami *BATALKAN* secara otomatis.\n\n"
                         . "Hal ini karena WBP atas nama *{$wbp->nama}* saat ini sedang dalam status *{$restriction->type}* (berlaku $start s.d. $end), sehingga tidak dapat menerima kunjungan.\n\n"
                         . "Silakan mendaftar kembali setelah masa pembatasan berakhir. Terima kasih atas pengertiannya.\n\n"
                         . "Salam,\nLayanan Kunjungan Lapas Kelas IIB Jombang";

                $waService->sendMessage($kunjungan->no_wa_pengunjung, $message);
            } catch (\Exception $e) {
                Log::error("Failed sending restriction WA to {$kunjungan->no_wa_pengunjung}: " . $e->getMessage());
            }
        }
    }
}
