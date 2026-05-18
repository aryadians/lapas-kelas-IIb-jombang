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
        $oldWa = "Halo *{nama}*,\n\nMohon maaf, kunjungan tanggal *{tanggal}* dibatalkan mendadak dikarenakan *{alasan}*.\n\nTerima kasih.";
        $oldEmail = "<p>Halo <strong>{nama}</strong>,</p><p>Mohon maaf, kunjungan tanggal <strong>{tanggal}</strong> dibatalkan mendadak dikarenakan <strong>{alasan}</strong>.</p>";

        $oldEmailSubject = "Informasi Pembatalan Kunjungan";

        $newWa = "📢 *PENGUMUMAN PENTING: PEMBATALAN KUNJUNGAN LAPAS JOMBANG* 📢\n\nHalo Bapak/Ibu *{nama}*,\n\nKami menginformasikan bahwa jadwal kunjungan Anda yang terdaftar pada:\n📅 Tanggal: *{tanggal}*\n\n*DIBATALKAN* dikarenakan adanya kendala teknis/operasional berupa:\nℹ️ *{alasan}*\n\nKami memohon maaf yang sebesar-besarnya atas ketidaknyamanan ini. Pembatalan ini dilakukan demi menjaga keamanan, ketertiban, dan kualitas pelayanan di Lapas Kelas IIB Jombang.\n\n*Langkah Selanjutnya:*\nBapak/Ibu dapat melakukan pendaftaran ulang untuk jadwal kunjungan di hari berikutnya melalui sistem aplikasi kami secara berkala.\n\nJika ada pertanyaan lebih lanjut, silakan hubungi layanan informasi resmi Lapas Jombang.\n\nTerima kasih atas pengertian dan kerjasamanya.\n\n*Hormat kami,*\n*Admin Layanan Kunjungan Lapas Kelas IIB Jombang*";
        $newEmail = '<div style="font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;">
    <h2 style="color: #e11d48; text-align: center;">📢 PENGUMUMAN PENTING</h2>
    <p>Halo Bapak/Ibu <strong>{nama}</strong>,</p>
    <p>Kami dari <strong>Lapas Kelas IIB Jombang</strong> ingin menginformasikan bahwa jadwal kunjungan Anda yang telah terdaftar pada:</p>
    <div style="background-color: #f9fafb; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #e11d48;">
        <p style="margin: 0;">📅 <strong>Tanggal:</strong> {tanggal}</p>
        <p style="margin: 0; color: #e11d48;">⚠️ <strong>Status:</strong> DIBATALKAN</p>
        <p style="margin: 0;">ℹ️ <strong>Alasan:</strong> {alasan}</p>
    </div>
    <p>Kami memohon maaf yang sebesar-besarnya atas ketidaknyamanan yang ditimbulkan. Pembatalan ini harus kami lakukan dikarenakan situasi mendesak demi menjaga keamanan dan ketertiban di lingkungan Lapas.</p>
    <p><strong>Langkah Selanjutnya:</strong></p>
    <ul>
        <li>Bapak/Ibu dapat melakukan pendaftaran kunjungan kembali untuk hari lain melalui website resmi kami.</li>
        <li>Pastikan untuk selalu mengecek status kunjungan Anda secara berkala pada aplikasi.</li>
    </ul>
    <p>Terima kasih atas perhatian dan kerjasama Bapak/Ibu.</p>
    <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
    <p style="font-size: 12px; color: #777; text-align: center;">
        Hormat kami,<br>
        <strong>Tim Layanan Kunjungan Lapas Kelas IIB Jombang</strong><br>
        Jl. KH. Wahid Hasyim No. 170, Jombang, Jawa Timur
    </p>
</div>';

        $template = BroadcastTemplate::where('name', 'Emergency Closure')->first();

        if (!$template) {
            $template = BroadcastTemplate::create([
                'name' => 'Emergency Closure',
                'whatsapp_body' => $newWa,
                'email_subject' => 'Informasi Pembatalan Kunjungan - Lapas Jombang',
                'email_body' => $newEmail
            ]);
        } elseif ($template->whatsapp_body === $oldWa || $template->email_body === $oldEmail || $template->email_subject === $oldEmailSubject) {
            // Update to new default if it was using any of the old ones
            $template->update([
                'whatsapp_body' => $newWa,
                'email_body' => $newEmail,
                'email_subject' => 'Informasi Pembatalan Kunjungan - Lapas Jombang',
            ]);
        }

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

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada item yang dipilih.'], 400);
        }

        try {
            BroadcastLog::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => count($ids) . ' riwayat broadcast berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus: ' . $e->getMessage()], 500);
        }
    }
}
