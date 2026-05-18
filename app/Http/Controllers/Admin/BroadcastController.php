<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BroadcastTemplate;
use App\Models\Kunjungan;
use App\Models\BroadcastLog;
use App\Models\BroadcastFailedLog;
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
        $logs = BroadcastLog::latest()->get();
        return view('admin.broadcast.index', compact('template', 'logs'));
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

        $sentCount = 0;
        $failedList = [];

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
                $failedList[] = [
                    'name' => $kunjungan->nama_pengunjung,
                    'phone' => $kunjungan->no_wa_pengunjung,
                    'email' => $kunjungan->email_pengunjung
                ];
            }
        }

        $log = BroadcastLog::create([
            'target_date' => $request->tanggal,
            'reason' => $request->alasan,
            'sent_count' => $sentCount,
            'failed_count' => count($failedList)
        ]);

        foreach ($failedList as $fail) {
            BroadcastFailedLog::create(array_merge($fail, ['broadcast_log_id' => $log->id]));
        }
        
        return redirect()->back()->with('success', 'Broadcast selesai dikirim. Berhasil: ' . $sentCount . ', Gagal: ' . count($failedList));
    }
}
