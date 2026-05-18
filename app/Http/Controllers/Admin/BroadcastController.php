<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BroadcastTemplate;
use App\Models\Kunjungan;
use App\Services\WhatsAppService;
use App\Mail\BroadcastMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BroadcastController extends Controller
{
    public function index()
    {
        $template = BroadcastTemplate::firstOrCreate(
            ['name' => 'Emergency Closure'],
            [
                'whatsapp_body' => "Halo *{nama}*,\n\nMohon maaf, kunjungan tanggal *{tanggal}* dibatalkan mendadak dikarenakan *{alasan}*.\n\nTerima kasih.",
                'email_subject' => "Informasi Pembatalan Kunjungan",
                'email_body' => "<p>Halo <strong>{nama}</strong>,</p><p>Mohon maaf, kunjungan tanggal <strong>{tanggal}</strong> dibatalkan mendadak dikarenakan <strong>{alasan}</strong>.</p>"
            ]
        );
        return view('admin.broadcast.index', compact('template'));
    }

    public function update(Request $request, BroadcastTemplate $template)
    {
        $template->update($request->all());
        return redirect()->back()->with('success', 'Template berhasil diperbarui.');
    }

    public function send(Request $request)
    {
        $request->validate(['tanggal' => 'required|date', 'alasan' => 'required']);
        
        $kunjungans = Kunjungan::whereDate('tanggal_kunjungan', $request->tanggal)
            ->whereIn('status', ['pending', 'approved'])
            ->get();

        $template = BroadcastTemplate::where('name', 'Emergency Closure')->first();
        $wa = new WhatsAppService();

        $failed = [];
        $sentCount = 0;

        foreach ($kunjungans as $kunjungan) {
            $data = [
                '{nama}' => $kunjungan->nama_pengunjung,
                '{tanggal}' => $request->tanggal,
                '{alasan}' => $request->alasan
            ];
            
            // WA
            $waBody = strtr($template->whatsapp_body, $data);
            $waResponse = $wa->sendMessage($kunjungan->no_wa_pengunjung, $waBody);
            
            $waSuccess = $waResponse && method_exists($waResponse, 'successful') && $waResponse->successful();
            
            // Email
            $emailSuccess = false;
            if ($kunjungan->email_pengunjung) {
                try {
                    $emailBody = strtr($template->email_body, $data);
                    Mail::to($kunjungan->email_pengunjung)->send(new BroadcastMail($template->email_subject, $emailBody));
                    $emailSuccess = true;
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Broadcast Email Gagal ke " . $kunjungan->email_pengunjung . ": " . $e->getMessage());
                }
            }

            if ($waSuccess || $emailSuccess) {
                $sentCount++;
            } else {
                $failed[] = $kunjungan->nama_pengunjung . " (" . $kunjungan->no_wa_pengunjung . ")";
            }
        }

        $message = "Broadcast telah dikirim ke $sentCount pengunjung.";
        if (!empty($failed)) {
            $message .= " Gagal ke: " . implode(', ', $failed);
        }
        
        return redirect()->back()->with('success', $message);
    }
}
