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

        foreach ($kunjungans as $kunjungan) {
            $data = [
                '{nama}' => $kunjungan->nama_pengunjung,
                '{tanggal}' => $request->tanggal,
                '{alasan}' => $request->alasan
            ];
            
            $waBody = strtr($template->whatsapp_body, $data);
            $wa->sendMessage($kunjungan->no_wa_pengunjung, $waBody);
            
            if ($kunjungan->email_pengunjung) {
                $emailBody = strtr($template->email_body, $data);
                Mail::to($kunjungan->email_pengunjung)->send(new BroadcastMail($template->email_subject, $emailBody));
            }
        }
        return redirect()->back()->with('success', 'Broadcast telah dikirim ke ' . $kunjungans->count() . ' pengunjung.');
    }
}
