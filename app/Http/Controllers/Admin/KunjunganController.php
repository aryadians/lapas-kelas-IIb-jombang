<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Wbp;
use App\Enums\KunjunganStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\KunjunganStatusMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel; // ADDED
use App\Exports\KunjunganExport;   // ADDED

class KunjunganController extends Controller
{
    /**
     * Menampilkan daftar kunjungan dengan filter.
     */
    public function index(Request $request)
    {
        // Jangan ambil kolom foto_ktp di index karena ukurannya besar (Base64)
        // Ini akan mempercepat loading tabel secara signifikan
        $query = Kunjungan::select(
            'id', 'profil_pengunjung_id', 'kode_kunjungan', 'nama_pengunjung', 
            'nik_ktp', 'tanggal_kunjungan', 'sesi', 'status', 'nomor_antrian_harian',
            'wbp_id', 'registration_type', 'created_at'
        )->with('wbp');

        // 1. Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 2. Filter Tanggal
        if ($request->filled('tanggal_kunjungan')) {
            $query->whereDate('tanggal_kunjungan', $request->input('tanggal_kunjungan'));
        }

        // 3. Filter Sesi
        if ($request->filled('sesi')) {
            $query->where('sesi', $request->sesi);
        }

        // 4. Search (Nama Pengunjung, WBP, NIK)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pengunjung', 'like', '%' . $search . '%')
                    ->orWhereHas('wbp', function ($wbpQuery) use ($search) {
                        $wbpQuery->where('nama', 'like', '%' . $search . '%');
                    })
                    ->orWhere('nik_ktp', 'like', '%' . $search . '%');
            });
        }

        // Urutkan terbaru & Pagination
        $kunjungans = $query->latest()->paginate(15)->withQueryString();

        return view('admin.kunjungan.index', compact('kunjungans'));
    }

    /**
     * Update status kunjungan (Approved/Rejected).
     */
    public function update(Request $request, $id)
    {
        // 1. Cari Data
        $kunjungan = Kunjungan::findOrFail($id);

        // 2. Validasi Input
        $request->validate([
            'status' => 'required|in:approved,rejected,pending,completed,called,in_progress',
        ]);

        $statusBaru = $request->status;
        $updateData = ['status' => $statusBaru];

        // 3. Generate QR Token jika Approved & belum punya token
        if ($statusBaru === KunjunganStatus::APPROVED->value && is_null($kunjungan->qr_token)) {
            $updateData['qr_token'] = Str::random(40);
        }

        // 3b. Hapus QR Token jika ditolak
        if ($statusBaru === KunjunganStatus::REJECTED->value) {
            $updateData['qr_token'] = null;
        }

        // 4. Update Database
        $kunjungan->update($updateData);

        // Refresh data agar variabel $kunjungan memuat data terbaru (termasuk token QR baru)
        $kunjungan->refresh();

        // 5. Logika Kirim Email
        // Email dikirim HANYA jika status Approved atau Rejected
        if (in_array($statusBaru, [KunjunganStatus::APPROVED->value, KunjunganStatus::REJECTED->value])) {

            if (!empty($kunjungan->email_pengunjung)) {
                try {
                    // Gunakan Mail::send (Sync) agar langsung terkirim
                    // Pastikan config .env QUEUE_CONNECTION=sync
                    Mail::to($kunjungan->email_pengunjung)
                        ->send(new KunjunganStatusMail($kunjungan));
                } catch (\Exception $e) {
                    // Catat error di storage/logs/laravel.log
                    Log::error("Gagal mengirim email ke {$kunjungan->email_pengunjung}: " . $e->getMessage());

                    // Beri pesan warning ke admin, tapi jangan error screen
                    return redirect()->back()->with('warning', 'Status berhasil diubah, namun email notifikasi gagal terkirim. Cek Log atau Logo/QR Code.');
                }
            }
        }

        return redirect()->route('admin.kunjungan.index')->with('success', 'Status kunjungan berhasil diperbarui.');
    }

    /**
     * Hapus satu data kunjungan.
     */
    public function destroy($id)
    {
        $kunjungan = Kunjungan::findOrFail($id);
        $kunjungan->delete();

        return redirect()->route('admin.kunjungan.index')->with('success', 'Data kunjungan berhasil dihapus.');
    }

    /**
     * Menampilkan detail kunjungan.
     */
    public function show($id)
    {
        $kunjungan = Kunjungan::with(['wbp', 'pengikuts'])->findOrFail($id);
        return view('admin.kunjungan.show', compact('kunjungan'));
    }

    /**
     * Update Masal (Bulk Action).
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:kunjungans,id',
            'status' => 'required|in:approved,rejected,completed,called,in_progress',
        ]);

        $ids = $request->input('ids');
        $status = $request->input('status');

        $kunjungans = Kunjungan::with('wbp')->whereIn('id', $ids)->get();
        $count = 0;

        foreach ($kunjungans as $kunjungan) {
            $updateData = ['status' => $status];

            // Generate Token jika Approved
            if ($status === KunjunganStatus::APPROVED->value && is_null($kunjungan->qr_token)) {
                $updateData['qr_token'] = Str::random(40);
            }

            $kunjungan->update($updateData);

            // Kirim Email
            try {
                if (!empty($kunjungan->email_pengunjung)) {
                    Mail::to($kunjungan->email_pengunjung)->send(new KunjunganStatusMail($kunjungan));
                }
            } catch (\Exception $e) {
                Log::error("Bulk Update Email Error ID {$kunjungan->id}: " . $e->getMessage());
            }

            $count++;
        }

        return redirect()->route('admin.kunjungan.index')->with('success', "$count data kunjungan berhasil diperbarui.");
    }

    /**
     * Hapus Masal (Bulk Delete).
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:kunjungans,id',
        ]);

        $ids = $request->input('ids');
        Kunjungan::whereIn('id', $ids)->delete();

        return redirect()->route('admin.kunjungan.index')->with('success', count($ids) . ' data kunjungan berhasil dihapus.');
    }

    /**
     * Form Verifikasi QR Code.
     */
    public function showVerificationForm()
    {
        return view('admin.kunjungan.verifikasi');
    }

    /**
     * Proses Verifikasi QR Code.
     */
    public function verifyQrCode(Request $request)
    {
        $request->validate([
            'qr_token' => 'required|string',
        ]);

        $token = trim($request->qr_token);
        $kunjungan = Kunjungan::with(['wbp', 'pengikuts'])->where('qr_token', $token)->first();

        if ($kunjungan) {
            $message = 'Kunjungan valid dan sudah disetujui sebelumnya.';
            // Automatically approve if status is pending
            if ($kunjungan->status === KunjunganStatus::PENDING) {
                $kunjungan->status = KunjunganStatus::APPROVED;
                $kunjungan->save();
                $message = 'Kunjungan berhasil disetujui secara otomatis!';
            }

            // Handle AJAX requests separately
            if ($request->wantsJson()) {
                // Return the full kunjungan object, which includes the ID and relations
                return response()->json([
                    'status' => 'success',
                    'message' => $message,
                    'kunjungan' => $kunjungan->load('wbp'), // Ensure wbp relation is loaded
                ]);
            }

            // For standard web requests, reuse the verification view and show success
            return view('admin.kunjungan.verifikasi', [
                'kunjungan' => $kunjungan,
                'status_verifikasi' => 'success',
                'approval_message' => $message,
            ]);
        } else {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Token QR Code tidak valid atau tidak ditemukan.'
                ], 404);
            }
            
            return view('admin.kunjungan.verifikasi', [
                'kunjungan' => null,
                'status_verifikasi' => 'failed'
            ])->withErrors(['qr_token' => 'Token QR Code tidak valid atau tidak ditemukan.']);
        }
    }

    /**
     * Menampilkan halaman kalender kunjungan.
     */
    public function kalender()
    {
        return view('admin.kunjungan.kalender');
    }

    /**
     * Menyediakan data kunjungan untuk FullCalendar.
     */
    public function kalenderData()
    {
        // 1. Ambil hanya kunjungan yang sudah disetujui.
        $kunjungans = Kunjungan::with('wbp')->where('status', KunjunganStatus::APPROVED)->get();

        $events = [];

        // 2. Definisikan jam sesi
        $sesiTimes = [
            'pagi' => ['start' => '08:00:00', 'end' => '12:00:00'],
            'siang' => ['start' => '13:00:00', 'end' => '16:00:00'],
        ];

        foreach ($kunjungans as $kunjungan) {
            // Ambil tanggal dari record
            $date = $kunjungan->tanggal_kunjungan->toDateString();
            
            // Ambil sesi (lowercase) dan cek di definisi
            $sesi = strtolower($kunjungan->sesi);

            if (isset($sesiTimes[$sesi])) {
                $times = $sesiTimes[$sesi];

                // 3. Buat format event untuk FullCalendar
                $events[] = [
                    'title' => 'Pengunjung: ' . $kunjungan->nama_pengunjung . ' (WBP: ' . $kunjungan->wbp->nama . ')',
                    'start' => $date . 'T' . $times['start'],
                    'end'   => $date . 'T' . $times['end'],
                    'url'   => route('admin.kunjungan.show', $kunjungan->id),
                    'backgroundColor' => $kunjungan->registration_type === 'offline' ? '#20c997' : '#28a745', // Hijau beda untuk offline
                    'borderColor' => $kunjungan->registration_type === 'offline' ? '#20c997' : '#28a745'
                ];
            }
        }

        // 4. Return sebagai JSON
        return response()->json($events);
    }

    /**
     * Handle export requests (Excel, PDF).
     */
    public function export(Request $request)
    {
        $request->validate([
            'type' => 'required|in:excel,pdf',
            'period' => 'required|in:day,week,month,all',
            'date' => 'nullable|date',
        ]);

        $type = $request->input('type');
        $period = $request->input('period');
        $date = $request->input('date'); // This could be null

        switch ($type) {
            case 'excel':
                return $this->exportExcel($period, $date);
            case 'pdf':
                return $this->exportPdf($period, $date);
            default:
                return back()->with('error', 'Unsupported export type.');
        }
    }

    /**
     * Export Kunjungan data to Excel.
     */
    protected function exportExcel(string $period, ?string $date)
    {
        $filename = 'Laporan_Kunjungan_' . ucfirst($period);
        if ($date) {
            $filename .= '_' . \Carbon\Carbon::parse($date)->format('Ymd');
        }
        $filename .= '.xlsx';

        return Excel::download(new KunjunganExport($period, $date), $filename);
    }

    /**
     * Export Kunjungan data to PDF. (Placeholder)
     */
    protected function exportPdf(string $period, ?string $date)
    {
        // For PDF export, you would typically use a library like barryvdh/laravel-dompdf
        // and render a view into PDF. This is a placeholder for now.
        return back()->with('info', 'PDF export is not yet implemented.');
    }

    /**
     * Menampilkan form untuk pendaftaran kunjungan offline oleh admin.
     */
    public function createOffline()
    {
        $wbps = Wbp::orderBy('nama')->get();
        return view('admin.kunjungan.create_offline', compact('wbps'));
    }

    /**
     * Menampilkan halaman sukses setelah pendaftaran offline.
     */
    public function offlineSuccess(Kunjungan $kunjungan)
    {
        return view('admin.kunjungan.offline_success', compact('kunjungan'));
    }

    /**
     * Menyimpan data pendaftaran kunjungan offline dari admin.
     */
    public function storeOffline(Request $request)
    {
        $request->validate([
            'wbp_id' => 'required|exists:wbps,id',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'sesi' => 'required|in:pagi,siang',
            'nama_pengunjung' => 'required|string|max:255',
            'nik_ktp' => 'required|string|digits:16',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat_pengunjung' => 'required|string',
            'hubungan' => 'required|string|max:100',
            'no_wa_pengunjung' => 'nullable|string|max:20',
            'email_pengunjung' => 'nullable|email',
            'pengikut_laki' => 'nullable|integer|min:0',
            'pengikut_perempuan' => 'nullable|integer|min:0',
            'pengikut_anak' => 'nullable|integer|min:0',
            'barang_bawaan' => 'nullable|string',
        ]);

        // Custom validation for total pengikut
        $totalPengikut = ($request->pengikut_laki ?? 0) + ($request->pengikut_perempuan ?? 0) + ($request->pengikut_anak ?? 0);
        if ($totalPengikut > 4) {
            return redirect()->back()->withInput()->withErrors(['total_pengikut' => 'Jumlah total pengikut tidak boleh melebihi 4 orang.']);
        }

        $tanggalKunjungan = Carbon::parse($request->tanggal_kunjungan);

        // Cek Kuota Offline (maksimal 20 per hari)
        $offlineCount = Kunjungan::where('tanggal_kunjungan', $tanggalKunjungan->toDateString())
            ->where('registration_type', 'offline')
            ->count();

        if ($offlineCount >= 20) {
            return redirect()->back()->withInput()->with('error', 'Kuota pendaftaran offline untuk tanggal tersebut sudah penuh.');
        }

        // Generate Kode Kunjungan Unik
        $kodeKunjungan = 'LJK-' . strtoupper(Str::random(8));
        while (Kunjungan::where('kode_kunjungan', $kodeKunjungan)->exists()) {
            $kodeKunjungan = 'LJK-' . strtoupper(Str::random(8));
        }

        // Ambil Nomor Antrian Harian Terakhir (berdasarkan sesi)
        $lastQueue = Kunjungan::where('tanggal_kunjungan', $tanggalKunjungan->toDateString())
            ->where('sesi', $request->sesi) // Ditambahkan filter sesi
            ->lockForUpdate()
            ->orderBy('nomor_antrian_harian', 'desc')
            ->first();

        $nomorAntrian = $lastQueue ? $lastQueue->nomor_antrian_harian + 1 : 1;
        
        // Buat Kunjungan Baru
        $kunjungan = Kunjungan::create([
            'wbp_id' => $request->wbp_id,
            'tanggal_kunjungan' => $tanggalKunjungan,
            'sesi' => $request->sesi,
            'nama_pengunjung' => $request->nama_pengunjung,
            'nik_ktp' => $request->nik_ktp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat_pengunjung' => $request->alamat_pengunjung,
            'hubungan' => $request->hubungan,
            'no_wa_pengunjung' => $request->no_wa_pengunjung,
            'email_pengunjung' => $request->email_pengunjung,
            'pengikut_laki' => $request->pengikut_laki ?? 0,
            'pengikut_perempuan' => $request->pengikut_perempuan ?? 0,
            'pengikut_anak' => $request->pengikut_anak ?? 0,
            'barang_bawaan' => $request->barang_bawaan,
            'status' => KunjunganStatus::APPROVED, // Langsung disetujui
            'registration_type' => 'offline', // Tandai sebagai offline
            'nomor_antrian_harian' => $nomorAntrian,
            'qr_token' => Str::random(40), // Langsung generate QR
            'kode_kunjungan' => $kodeKunjungan,
        ]);

        return redirect()->route('admin.kunjungan.offline.success', $kunjungan->id)
            ->with('success', 'Pendaftaran kunjungan offline berhasil dibuat dan langsung disetujui.');
    }
}
