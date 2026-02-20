<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\KunjunganStatusMail;
use App\Models\Kunjungan;
use App\Models\Wbp;
use App\Models\Pengikut;
use App\Enums\KunjunganStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Services\WhatsAppService;
use App\Jobs\SendWhatsAppPendingNotification;
use App\Jobs\SendWhatsAppApprovedNotification;
use App\Jobs\SendWhatsAppRejectedNotification;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use App\Models\ProfilPengunjung;

use App\Http\Requests\StoreKunjunganRequest;
use App\Services\KunjunganService;

class KunjunganController extends Controller
{
    // =========================================================================
    // HALAMAN PUBLIK (GUEST)
    // =========================================================================

    public function create()
    {
        // Ambil hari-hari yang buka dari database
        $openDays = \App\Models\VisitSchedule::where('is_open', true)->pluck('day_name')->toArray();
        
        // Ambil Batas H-N Pendaftaran
        $leadTime = (int) \App\Models\VisitSetting::where('key', 'registration_lead_time')->value('value') ?? 1;

        // Mapping nama hari ke bahasa Indonesia untuk pencocokan
        $dayMapping = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];

        $datesByDay = [];
        foreach ($dayMapping as $ind) {
            if (in_array($ind, $openDays)) {
                $datesByDay[$ind] = [];
            }
        }

        // Mulai menghitung dari hari ini + leadTime
        $date = Carbon::today()->addDays($leadTime);

        for ($i = 0; $i < 60; $i++) {
            $currentDate = $date->copy()->addDays($i);
            $dayOfWeek = $currentDate->dayOfWeek;
            $dayNameIndo = $dayMapping[$dayOfWeek];

            if (in_array($dayNameIndo, $openDays)) {
                if (count($datesByDay[$dayNameIndo]) < 4) {
                    $datesByDay[$dayNameIndo][] = [
                        'value' => $currentDate->format('Y-m-d'),
                        'label' => $currentDate->translatedFormat('d F Y'),
                    ];
                }
            }
        }
        return view('guest.kunjungan.create', ['datesByDay' => $datesByDay]);
    }

    public function searchWbp(Request $request)
    {
        $search = $request->get('q');
        $wbps = Wbp::query()
            ->where('nama', 'LIKE', "%{$search}%")
            ->orWhere('no_registrasi', 'LIKE', "%{$search}%")
            ->limit(10)->get();

        $results = $wbps->map(function ($wbp) {
            return [
                'id' => $wbp->id,
                'nama' => $wbp->nama,
                'no_registrasi' => $wbp->no_registrasi,
                'blok' => $wbp->blok ?? '-',
                'kamar' => $wbp->kamar ?? '-'
            ];
        });
        return response()->json($results);
    }

    public function store(StoreKunjunganRequest $request, KunjunganService $kunjunganService, \App\Services\QuotaService $quotaService)
    {
        $validatedData = $request->validated();
        $tanggal = Carbon::parse($validatedData['tanggal_kunjungan']);
        $dateStr = $tanggal->format('Y-m-d');

        // Prevent past dates
        if ($tanggal->isPast()) {
            return back()->with('error', 'Tanggal kunjungan tidak boleh di masa lalu.')->withInput();
        }

        // 0. CEK BATAS H-N PENDAFTARAN
        $leadTime = (int) \App\Models\VisitSetting::where('key', 'registration_lead_time')->value('value') ?? 1;
        $minDate = Carbon::today()->addDays($leadTime);
        if ($tanggal->lt($minDate)) {
            return back()->withErrors(['tanggal_kunjungan' => "Pendaftaran untuk tanggal ini sudah ditutup. Minimal pendaftaran adalah $leadTime hari sebelum kunjungan."])->withInput();
        }

        $sesi = (isset($validatedData['sesi']) && !is_null($validatedData['sesi']) && trim((string)$validatedData['sesi']) !== '') ? strtolower(trim($validatedData['sesi'])) : 'pagi'; 

        // 1. CEK APAKAH HARI TERSEBUT BUKA
        if (!$quotaService->isDayOpen($dateStr)) {
            return back()->withErrors(['tanggal_kunjungan' => 'Layanan kunjungan tidak tersedia (TUTUP) pada hari yang Anda pilih.'])->withInput();
        }

        // 2. CEK KUOTA (Online)
        if (!$quotaService->checkAvailability($dateStr, $sesi, 'online')) {
            return back()->withErrors(['sesi' => 'Mohon maaf, kuota pendaftaran online untuk jadwal ini sudah penuh.'])->withInput();
        }

        // 3. LOGIKA PEMBATASAN DINAMIS (NIK & WBP)
        $limitNik = (int) \App\Models\VisitSetting::where('key', 'limit_nik_per_week')->value('value') ?? 1;
        $limitWbp = (int) \App\Models\VisitSetting::where('key', 'limit_wbp_per_week')->value('value') ?? 1;

        $startWeek = $tanggal->copy()->subDays(6);

        // Cek Batasan WBP
        $wbpVisitCount = Kunjungan::where('wbp_id', $validatedData['wbp_id'])
            ->whereIn('status', [KunjunganStatus::PENDING, KunjunganStatus::APPROVED, KunjunganStatus::COMPLETED])
            ->whereBetween('tanggal_kunjungan', [$startWeek->format('Y-m-d'), $dateStr])
            ->count();

        if ($wbpVisitCount >= $limitWbp) {
            return back()->with('error', "Warga Binaan ini sudah mencapai batas maksimal dikunjungi ($limitWbp kali) dalam seminggu terakhir.")->withInput();
        }

        // Cek Batasan NIK
        $nikVisitCount = Kunjungan::where('nik_ktp', $validatedData['nik_ktp'])
            ->whereIn('status', [KunjunganStatus::PENDING, KunjunganStatus::APPROVED, KunjunganStatus::COMPLETED])
            ->whereBetween('tanggal_kunjungan', [$startWeek->format('Y-m-d'), $dateStr])
            ->count();

        if ($nikVisitCount >= $limitNik) {
            return back()->with('error', "NIK Anda sudah mencapai batas maksimal melakukan kunjungan ($limitNik kali) dalam seminggu terakhir.")->withInput();
        }

        // 4. SIMPAN DATA VIA SERVICE
        try {
            // Determine next queue number
            $maxAntrian = Kunjungan::where('tanggal_kunjungan', $validatedData['tanggal_kunjungan'])
                ->where('sesi', $sesi)
                ->lockForUpdate()
                ->max('nomor_antrian_harian');

            if ($sesi === 'siang') {
                $nomorAntrian = $maxAntrian ? ($maxAntrian + 1) : 121;
            } else {
                $nomorAntrian = ($maxAntrian ?? 0) + 1;
            }

            // Handle Files
            $fileKtp = $request->file('foto_ktp');
            $filesPengikut = $request->file('pengikut_foto');

            $kunjungan = $kunjunganService->storeRegistration(
                $validatedData,
                $fileKtp,
                $filesPengikut,
                $nomorAntrian
            );

            // Mark as online
            $kunjungan->update(['registration_type' => 'online']);

            // Decrement Quota in Redis
            $quotaService->decrementQuota($dateStr, $sesi, 'online');

            return redirect()->route('kunjungan.create')
                ->with('success', "PENDAFTARAN BERHASIL! Antrian Anda: " . ($kunjungan->registration_type === 'offline' ? 'B-' : 'A-') . str_pad($nomorAntrian, 3, '0', STR_PAD_LEFT))
                ->with('kunjungan_id', $kunjungan->id);

        } catch (\Exception $e) {
            Log::error('Error storing visit: ' . $e->getMessage());

            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                return back()->with('error_duplicate_entry', 'Terjadi kepadatan pada slot waktu yang Anda pilih. Mohon periksa kembali jadwal dan coba kirim ulang formulir.')->withInput();
            }

            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }
    }
    
    // UPDATE STATUS OLEH ADMIN
    public function update(Request $request, $id, WhatsAppService $whatsAppService)
    {
        $kunjungan = Kunjungan::findOrFail($id);
        $oldStatus = $kunjungan->status;
        $newStatus = $request->status;

        if ($oldStatus->value === $newStatus) return back();

        $kunjungan->status = $newStatus;
        $kunjungan->save();

        try {
            // Cek Path QR
            $qrCodePath = 'qrcodes/' . $kunjungan->id . '.png';
            if (!Storage::disk('public')->exists($qrCodePath)) {
                $pathSvg = 'qrcodes/' . $kunjungan->id . '.svg';
                if (Storage::disk('public')->exists($pathSvg)) {
                    $qrCodePath = $pathSvg;
                }
            }

            // Jika Approved & File tidak ada -> Generate Ulang
            if ($newStatus == KunjunganStatus::APPROVED->value) {
                $fullQrPath = Storage::disk('public')->path($qrCodePath);
                if (!file_exists($fullQrPath)) {
                    try {
                        $qrContent = QrCode::format('png')->size(400)->margin(2)->generate($kunjungan->qr_token);
                        $qrCodePath = 'qrcodes/' . $kunjungan->id . '.png';
                        Storage::disk('public')->put($qrCodePath, $qrContent);
                    } catch (\Exception $e) {
                        $qrContent = QrCode::format('svg')->size(400)->margin(2)->generate($kunjungan->qr_token);
                        $qrCodePath = 'qrcodes/' . $kunjungan->id . '.svg';
                        Storage::disk('public')->put($qrCodePath, $qrContent);
                    }
                    $fullQrPath = Storage::disk('public')->path($qrCodePath);
                }
            }

            // --- KIRIM NOTIFIKASI KE KEDUANYA ---

            if ($newStatus == KunjunganStatus::APPROVED->value) {
                // 1. WA Approved
                try {
                    SendWhatsAppApprovedNotification::dispatch($kunjungan, Storage::disk('public')->url($qrCodePath));
                } catch (\Exception $e) { Log::error('WA Error: ' . $e->getMessage()); }

                // 2. Email Approved
                try {
                    $fullQrPath = Storage::disk('public')->path($qrCodePath);
                    Mail::to($kunjungan->email_pengunjung)->send(new KunjunganStatusMail($kunjungan, $fullQrPath));
                } catch (\Exception $e) { Log::error('Email Error: ' . $e->getMessage()); }

            } elseif ($newStatus == KunjunganStatus::REJECTED->value) {
                // 1. WA Rejected
                try {
                    SendWhatsAppRejectedNotification::dispatch($kunjungan);
                } catch (\Exception $e) { Log::error('WA Error: ' . $e->getMessage()); }

                // 2. Email Rejected
                try {
                    Mail::to($kunjungan->email_pengunjung)->send(new KunjunganStatusMail($kunjungan, null));
                } catch (\Exception $e) { Log::error('Email Error: ' . $e->getMessage()); }
            }

        } catch (\Exception $e) {
            Log::error('Gagal kirim notifikasi update: ' . $e->getMessage());
        }

        return back()->with('success', 'Status diperbarui & notifikasi dikirim ke Email dan WhatsApp.');
    }

    public function status(Kunjungan $kunjungan)
    {
        return view('guest.kunjungan.status', compact('kunjungan'));
    }

    public function checkStatus(Request $request)
    {
        if ($request->has('keyword')) {
            $keyword = trim($request->get('keyword'));
            
            $kunjungan = Kunjungan::where('kode_kunjungan', $keyword)
                ->orWhere('nik_ktp', $keyword)
                ->latest()
                ->first();

            if ($kunjungan) {
                return redirect()->route('kunjungan.status', $kunjungan->id);
            } else {
                return back()->with('error', 'Data kunjungan tidak ditemukan. Periksa Kode Booking atau NIK Anda.');
            }
        }

        return view('guest.kunjungan.cek_status');
    }

    public function getQuotaStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_kunjungan' => 'required|date_format:Y-m-d',
            'sesi' => 'nullable|string',
        ]);

        if ($validator->fails()) return response()->json(['error' => 'Invalid'], 400);

        $validated = $validator->validated();
        $tanggal = Carbon::parse($validated['tanggal_kunjungan']);
        $sesi = $validated['sesi'] ?? 'pagi';

        // Gunakan QuotaService untuk data yang sinkron dengan Admin
        $quotaService = new \App\Services\QuotaService();
        $sisaKuota = $quotaService->getMaxQuota($validated['tanggal_kunjungan'], $sesi, 'online');
        
        $query = Kunjungan::where('tanggal_kunjungan', $validated['tanggal_kunjungan'])
            ->where('registration_type', 'online')
            ->whereIn('status', [KunjunganStatus::PENDING, KunjunganStatus::APPROVED]);

        if ($tanggal->isMonday()) {
            $query->where('sesi', $sesi);
        }

        $registeredCount = $query->count();
        $finalSisa = max(0, $sisaKuota - $registeredCount);
        
        return response()->json(['sisa_kuota' => $finalSisa]);
    }

    public function printProof(Kunjungan $kunjungan)
    {
        if (!in_array($kunjungan->status, [KunjunganStatus::APPROVED, KunjunganStatus::CALLED, KunjunganStatus::IN_PROGRESS])) {
            return redirect()->route('kunjungan.status', $kunjungan->id)
                ->with('error', 'Tiket belum tersedia.');
        }
        return view('guest.kunjungan.print', compact('kunjungan'));
    }

    public function verifikasiPage()
    {
        return view('admin.kunjungan.verifikasi');
    }

    public function riwayat()
    {
        $kunjungans = Kunjungan::with('wbp')
            ->where('email_pengunjung', auth()->user()->email ?? '')
            ->orderBy('tanggal_kunjungan', 'desc')
            ->paginate(10);

        return view('guest.kunjungan.riwayat', compact('kunjungans'));
    }

    public function verifikasiSubmit(Request $request, WhatsAppService $whatsAppService)
    {
        $token = trim($request->qr_token);
        // Remove '#' if present (common confusion with ID format)
        $token = ltrim($token, '#');

        $kunjungan = Kunjungan::with(['wbp', 'pengikuts'])
            ->where('qr_token', $token)
            ->orWhere('kode_kunjungan', $token)
            ->first();

        if ($kunjungan) {
            $message = 'Data ditemukan. Silakan lakukan verifikasi manual pada halaman detail/edit.';
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'kunjungan' => $kunjungan,
                    'message' => $message,
                    'redirect_url' => route('admin.kunjungan.edit', $kunjungan->id)
                ]);
            }

            return redirect()->route('admin.kunjungan.edit', $kunjungan->id)
                ->with('info', $message);
        } else {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token tidak valid atau tidak ditemukan.'
                ], 404);
            }

            return view('admin.kunjungan.verifikasi', [
                'status_verifikasi' => 'failed',
                'qr_token' => $token
            ]);
        }
    }

    public function findProfilByNik($nik)
    {
        if (!is_numeric($nik) || strlen($nik) !== 16) {
            return response()->json(['message' => 'Format NIK tidak valid.'], 400);
        }

        $profil = ProfilPengunjung::where('nik', $nik)->first();

        if ($profil) {
            return response()->json([
                'nama' => $profil->nama,
                'nik' => $profil->nik,
                'nomor_hp' => $profil->nomor_hp,
                'email' => $profil->email,
                'alamat' => $profil->alamat,
                'jenis_kelamin' => $profil->jenis_kelamin,
            ]);
        }

        return response()->json(['message' => 'Profil tidak ditemukan'], 404);
    }
}
