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
        // Ambil jadwal yang buka dari Cache (1 menit agar lebih realtime)
        $openSchedules = \Illuminate\Support\Facades\Cache::remember('open_schedules', 60, function() {
            return \App\Models\VisitSchedule::where('is_open', true)->get();
        });
        $openDays = $openSchedules->pluck('day_name')->toArray();
        
        // Ambil Batas H-N Pendaftaran & Konfigurasi dari Cache (10 detik agar perubahan admin cepat terlihat)
        $visitSettings = \Illuminate\Support\Facades\Cache::remember('visit_settings', 10, function() {
            return \App\Models\VisitSetting::pluck('value', 'key')->toArray();
        });

        $leadTime = (int) ($visitSettings['registration_lead_time'] ?? 1);
        $maxFollowers = (int) ($visitSettings['max_followers_allowed'] ?? 4);
        $isEmergencyClosed = ($visitSettings['is_emergency_closed'] ?? '0') == '1';
        $announcement = $visitSettings['announcement_guest_page'] ?? null;
        $generalAnnouncement = $visitSettings['general_announcement'] ?? '';
        $isGeneralAnnouncementActive = ($visitSettings['is_general_announcement_active'] ?? '0') == '1';
        $termsConditions = $visitSettings['terms_conditions'] ?? '';
        $helpdeskWhatsapp = $visitSettings['helpdesk_whatsapp'] ?? '';
        $maxLeadTime = (int) ($visitSettings['edit_lead_time'] ?? 14);

        if ($maxLeadTime < $leadTime) { 
            $maxLeadTime = $leadTime + 1; // Fallback jika setting salah
        }

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
        $allowedCodesByDay = [];
        $sessionsByDay = [];
        $openDays = [];
        
        foreach ($openSchedules as $schedule) {
            $dayName = $schedule->day_name;
            $datesByDay[$dayName] = [];
            $openDays[] = $dayName;
            $allowedCodesByDay[$dayName] = is_array($schedule->allowed_kode_tahanan) ? $schedule->allowed_kode_tahanan : [];
            
            // Determine which sessions are open based on online quotas for guest registration
            $sessions = [];
            if ($schedule->quota_online_morning > 0) $sessions[] = 'pagi';
            if ($schedule->quota_online_afternoon > 0) $sessions[] = 'siang';
            $sessionsByDay[$dayName] = $sessions;
        }

        // Hitung hari libur (yang tidak ada di jadwal buka)
        $allDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $closedDays = array_diff($allDays, $openDays);
        
        // Format string "X, Y & Z LIBUR"
        $closedDaysStringLower = '';
        if (count($closedDays) > 0) {
            $lastDay = array_pop($closedDays);
            if (count($closedDays) > 0) {
                $closedDaysString = strtoupper(implode(', ', $closedDays) . ' & ' . $lastDay . ' LIBUR');
                $closedDaysStringLower = implode(', ', $closedDays) . ', & ' . $lastDay;
            } else {
                $closedDaysString = strtoupper($lastDay . ' LIBUR');
                $closedDaysStringLower = $lastDay;
            }
        }
        // Duplicate block removed

        // Mulai menghitung dari hari ini + leadTime
        // Contoh: Jika leadTime 1, maka pendaftaran dimulai dari H+1 (besok).
        $date = Carbon::today()->addDays($leadTime);
        $maxDate = Carbon::today()->addDays($maxLeadTime);

        // Ambil hari dari range leadTime sampai maxLeadTime
        $isMondaySpecial = ($visitSettings['monday_registration_special'] ?? '0') == '1';
        $isTodayFridayToSunday = now()->isFriday() || now()->isSaturday() || now()->isSunday();

        for ($i = $leadTime; $i <= $maxLeadTime; $i++) {
            $currentDate = Carbon::today()->addDays($i);
            $dayOfWeek = $currentDate->dayOfWeek;
            $dayNameIndo = $dayMapping[$dayOfWeek];

            if (in_array($dayNameIndo, $openDays)) {
                // Tidak lagi dibatasi 4, tapi murni dari setting admin (Maks hari)
                $datesByDay[$dayNameIndo][] = [
                    'value' => $currentDate->format('Y-m-d'),
                    'label' => $currentDate->translatedFormat('d F Y'),
                ];
            }
        }

        // TAMBAHAN KHUSUS HARI SENIN
        if ($isMondaySpecial && $isTodayFridayToSunday) {
            $nextMonday = now()->next(Carbon::MONDAY);
            $dayNameIndo = $dayMapping[Carbon::MONDAY];
            
            // Cek apakah Senin tersebut sudah masuk dalam list (untuk menghindari duplikat jika leadTime pendek)
            $isMondayExists = false;
            if (isset($datesByDay[$dayNameIndo])) {
                foreach ($datesByDay[$dayNameIndo] as $existing) {
                    if ($existing['value'] === $nextMonday->format('Y-m-d')) {
                        $isMondayExists = true;
                        break;
                    }
                }
            }

            if (!$isMondayExists && in_array($dayNameIndo, $openDays)) {
                // Tambahkan Senin mendatang ke awal list tanggal Senin
                $newMonday = [
                    'value' => $nextMonday->format('Y-m-d'),
                    'label' => $nextMonday->translatedFormat('d F Y'),
                ];
                
                if (!isset($datesByDay[$dayNameIndo])) {
                    $datesByDay[$dayNameIndo] = [];
                }
                
                // Unshift agar muncul paling depan jika ada Senin berikutnya lagi
                array_unshift($datesByDay[$dayNameIndo], $newMonday);
            }
        }

        return view('guest.kunjungan.create', [
            'openSchedules' => $openSchedules,
            'datesByDay' => $datesByDay,
            'sessionsByDay' => $sessionsByDay,
            'allowedCodesByDay' => $allowedCodesByDay,
            'leadTime' => $leadTime,
            'maxFollowers' => $maxFollowers,
            'isEmergencyClosed' => $isEmergencyClosed,
            'announcement' => $announcement,
            'generalAnnouncement' => $generalAnnouncement,
            'isGeneralAnnouncementActive' => $isGeneralAnnouncementActive,
            'termsConditions' => $termsConditions,
            'helpdeskWhatsapp' => $helpdeskWhatsapp,
            'closedDaysString' => $closedDaysString,
            'closedDaysStringLower' => $closedDaysStringLower,
            'visitSettings' => $visitSettings,
        ]);
    }

    public function searchWbp(Request $request)
    {
        $search = $request->get('q');
        $tanggal = $request->filled('tanggal') ? $request->get('tanggal') : now()->toDateString();

        $wbps = Wbp::query()
            ->with(['restrictions' => function($q) use ($tanggal) {
                $q->whereDate('start_date', '<=', $tanggal)
                  ->whereDate('end_date', '>=', $tanggal);
            }])
            // Tampilkan semua WBP tanpa filter status
            ->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('no_registrasi', 'LIKE', "%{$search}%");
            })
            ->limit(10)->get();

        $results = $wbps->map(function ($wbp) {
            $restriction = $wbp->restrictions->first();
            $is_restricted = $restriction ? true : false;
            $restriction_message = $is_restricted ? "Maaf, WBP sedang dalam masa {$restriction->type} hingga " . \Carbon\Carbon::parse($restriction->end_date)->format('d/m/Y') . " dan tidak dapat dikunjungi." : null;

            // Kita sembunyikan No Reg dan Blok demi privasi publik
            // Tapi tetap kirim kode_tahanan untuk logika validasi jadwal di frontend
            return [
                'id' => $wbp->id,
                'nama' => $wbp->nama,
                'kode_tahanan' => $wbp->kode_tahanan ?? '',
                'is_restricted' => $is_restricted,
                'restriction_message' => $restriction_message
            ];
        });
        return response()->json($results);
    }

    public function store(StoreKunjunganRequest $request, KunjunganService $kunjunganService, \App\Services\RegistrationValidationService $validationService, \App\Services\QuotaService $quotaService)
    {
        $validatedData = $request->validated();

        // Gabungkan Alamat yang dipisah menjadi Alamat Lengkap
        $validatedData['alamat_lengkap'] = sprintf(
            "%s, RT %s / RW %s, Desa %s, Kec. %s, Kab. %s",
            $validatedData['alamat'],
            $validatedData['rt'],
            $validatedData['rw'],
            $validatedData['desa'],
            $validatedData['kecamatan'],
            $validatedData['kabupaten']
        );
        
        $validationResult = $validationService->validate($validatedData);

        if (!$validationResult['isValid']) {
            if ($validationResult['field'] === 'global') {
                return back()->with('error', $validationResult['message'])->withInput();
            }
            return back()->withErrors([$validationResult['field'] => $validationResult['message']])->withInput();
        }

        $tanggal = Carbon::parse($validatedData['tanggal_kunjungan']);
        $dateStr = $tanggal->format('Y-m-d');
        $sesi = (isset($validatedData['sesi']) && !is_null($validatedData['sesi']) && trim((string)$validatedData['sesi']) !== '') ? strtolower(trim($validatedData['sesi'])) : 'pagi';
        $validatedData['sesi'] = $sesi; // Paksa nilai null/kosong menjadi 'pagi' sesuai hitungan default, agar database tidak menyimpan null

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
                        
                        // Simpan Base64 ke database
                        $kunjungan->update(['barcode' => 'data:image/png;base64,' . base64_encode($qrContent)]);
                    } catch (\Exception $e) {
                        $qrContent = QrCode::format('svg')->size(400)->margin(2)->generate($kunjungan->qr_token);
                        $qrCodePath = 'qrcodes/' . $kunjungan->id . '.svg';
                        Storage::disk('public')->put($qrCodePath, $qrContent);
                    }
                    $fullQrPath = Storage::disk('public')->path($qrCodePath);
                } else {
                    // Jika file ada tapi kolom barcode kosong, isi juga
                    if (empty($kunjungan->barcode)) {
                        $qrContent = file_get_contents($fullQrPath);
                        $mimeType = str_ends_with($qrCodePath, '.svg') ? 'image/svg+xml' : 'image/png';
                        $kunjungan->update(['barcode' => 'data:' . $mimeType . ';base64,' . base64_encode($qrContent)]);
                    }
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

    public function status($id)
    {
        $kunjungan = Kunjungan::with(['wbp', 'pengikuts'])->findOrFail($id);
        return view('guest.kunjungan.status', compact('kunjungan'));
    }

    public function checkStatus(Request $request)
    {
        if ($request->has('keyword')) {
            $keyword = trim($request->get('keyword'));
            
            // Cari kunjungan terbaru berdasarkan Kode atau NIK
            $kunjungan = Kunjungan::where('kode_kunjungan', $keyword)
                ->orWhere('nik_ktp', $keyword)
                ->latest()
                ->first();

            if ($kunjungan) {
                return redirect()->route('kunjungan.status', $kunjungan->id);
            } else {
                // Jika tidak ditemukan di tabel kunjungan, coba cari di profil (mungkin belum pernah kunjungan tapi sudah punya profil)
                $profil = ProfilPengunjung::where('nik', $keyword)->first();
                $message = 'Data kunjungan tidak ditemukan. Periksa Kode Booking atau NIK Anda.';
                if ($profil) {
                    $message = "Profil atas nama {$profil->nama} ditemukan, namun belum ada riwayat kunjungan aktif. Silakan lakukan pendaftaran baru.";
                }
                
                return back()->with('error', $message)->withInput();
            }
        }

        return view('guest.kunjungan.cek_status');
    }

    public function findProfilByNik($nik)
    {
        // Bersihkan input
        $nik = preg_replace('/[^0-9]/', '', $nik);
        
        if (strlen($nik) !== 16) {
            return response()->json(['success' => false, 'message' => 'Format NIK tidak valid.'], 400);
        }

        $profil = ProfilPengunjung::where('nik', $nik)->first();

        if ($profil) {
            return response()->json([
                'success' => true,
                'data' => [
                    'nama' => $profil->nama,
                    'nik' => $profil->nik,
                    'nomor_hp' => $profil->nomor_hp,
                    'email' => $profil->email,
                    'alamat' => $profil->alamat,
                    'rt' => $profil->rt,
                    'rw' => $profil->rw,
                    'desa' => $profil->desa,
                    'kecamatan' => $profil->kecamatan,
                    'kabupaten' => $profil->kabupaten,
                    'jenis_kelamin' => $profil->jenis_kelamin,
                ]
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Profil tidak ditemukan'], 404);
    }

    public function getQuotaStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_kunjungan' => 'required|date_format:Y-m-d',
            'sesi' => 'nullable|string',
            'type' => 'nullable|in:online,offline',
        ]);

        if ($validator->fails()) return response()->json(['error' => 'Invalid'], 400);

        $validated = $validator->validated();
        $dateStr = $validated['tanggal_kunjungan'];
        $sesi = $validated['sesi'] ?? 'pagi';
        $type = $validated['type'] ?? 'online';

        $quotaService = new \App\Services\QuotaService();
        
        // Cek apakah hari buka
        if (!$quotaService->isDayOpen($dateStr)) {
            return response()->json(['sisa_kuota' => 0, 'status' => 'closed']);
        }

        $maxQuota = $quotaService->getMaxQuota($dateStr, $sesi, $type);
        
        // Hitung penggunaan dari DB
        $usedCount = Kunjungan::whereDate('tanggal_kunjungan', $dateStr)
            ->where('registration_type', $type)
            ->where('sesi', $sesi)
            ->whereIn('status', [
                KunjunganStatus::PENDING, 
                KunjunganStatus::APPROVED, 
                KunjunganStatus::CALLED, 
                KunjunganStatus::IN_PROGRESS, 
                KunjunganStatus::COMPLETED
            ])
            ->count();

        $finalSisa = max(0, $maxQuota - $usedCount);
        
        return response()->json([
            'sisa_kuota' => $finalSisa,
            'max_kuota' => $maxQuota,
            'used_count' => $usedCount
        ]);
    }

    public function printProof($id)
    {
        $kunjungan = Kunjungan::with(['wbp', 'pengikuts'])->findOrFail($id);
        
        // Cek status untuk menentukan template
        if ($kunjungan->status == KunjunganStatus::PENDING) {
            return view('guest.kunjungan.print_pending', compact('kunjungan'));
        }

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
}
