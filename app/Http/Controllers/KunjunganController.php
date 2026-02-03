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
        $datesByDay = ['Senin' => [], 'Selasa' => [], 'Rabu' => [], 'Kamis' => []];
        $date = Carbon::today();
        $dayMapping = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis'];

        for ($i = 0; $i < 60; $i++) {
            $currentDate = $date->copy()->addDays($i);
            $dayOfWeek = $currentDate->dayOfWeek;

            if (array_key_exists($dayOfWeek, $dayMapping)) {
                $dayName = $dayMapping[$dayOfWeek];
                if (count($datesByDay[$dayName]) < 4) {
                    $datesByDay[$dayName][] = [
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
        // Log summary
        Log::debug('KunjunganStore request', array_merge($request->except(['foto_ktp','pengikut_foto']), ['files_count' => count($request->allFiles())]));

        $validatedData = $request->validated();
        $tanggal = Carbon::parse($validatedData['tanggal_kunjungan']);

        // Prevent past dates
        if ($tanggal->isPast()) {
            return back()->with('error', 'Tanggal kunjungan tidak boleh di masa lalu.')->withInput();
        }

        $sesi = (isset($validatedData['sesi']) && !is_null($validatedData['sesi']) && trim((string)$validatedData['sesi']) !== '') ? strtolower(trim($validatedData['sesi'])) : null; 
        $isMonday = $tanggal->isMonday();

        // 2. CEK KUOTA (Optimized via Redis)
        if (!$quotaService->checkAvailability($tanggal->format('Y-m-d'), $sesi)) {
            if ($isMonday) {
                return back()->withErrors(['sesi' => 'Mohon maaf, kuota untuk sesi yang Anda pilih sudah penuh.'])->withInput();
            }
            return back()->withErrors(['tanggal_kunjungan' => 'Mohon maaf, kuota untuk hari yang Anda pilih sudah penuh.'])->withInput();
        }

        // 3. LOGIKA BISNIS
        $requestDate = $tanggal->copy()->startOfDay();
        $today = Carbon::now()->startOfDay();
        $wbp = Wbp::find($validatedData['wbp_id']);

        if ($requestDate->isFriday() || $requestDate->isSaturday() || $requestDate->isSunday()) {
            return back()->withErrors(['tanggal_kunjungan' => 'Layanan kunjungan TUTUP pada hari Jumat-Minggu.'])->withInput();
        }

        if ($requestDate->isMonday()) {
            if (!($today->isFriday() || $today->isSaturday() || $today->isSunday())) {
                return back()->withErrors(['tanggal_kunjungan' => 'Pendaftaran untuk hari Senin hanya dibuka pada hari Jumat-Minggu sebelumnya.'])->withInput();
            }
            $diff = $today->diffInDays($requestDate, false);
            if ($diff < 1 || $diff > 3) {
                 return back()->withErrors(['tanggal_kunjungan' => 'Tanggal Senin tidak valid. Pilih Senin terdekat.'])->withInput();
            }
        }

        $kodeReg = strtoupper(substr($wbp->no_registrasi, 0, 1));
        $hariKunjungan = $requestDate->dayOfWeek;

        if ($kodeReg === 'A' && !in_array($hariKunjungan, [2, 4])) {
            return back()->with('error', "WBP TAHANAN (Kode A) hanya bisa dikunjungi SELASA dan KAMIS.")->withInput();
        } elseif ($kodeReg === 'B' && !in_array($hariKunjungan, [1, 3])) {
            return back()->with('error', "WBP NARAPIDANA (Kode B) hanya bisa dikunjungi SENIN dan RABU.")->withInput();
        }

        // Lock 1 Minggu
        $startWindow = $requestDate->copy()->subDays(6);
        $recentVisit = Kunjungan::where('wbp_id', $validatedData['wbp_id'])
            ->whereIn('status', [KunjunganStatus::PENDING->value, KunjunganStatus::APPROVED->value])
            ->whereBetween('tanggal_kunjungan', [$startWindow->format('Y-m-d'), $requestDate->format('Y-m-d')])
            ->orderBy('tanggal_kunjungan', 'desc')
            ->first();

        if ($recentVisit) {
            $lastDate = Carbon::parse($recentVisit->tanggal_kunjungan)->translatedFormat('d M Y');
            return back()->with('error', "WBP ini sudah terdaftar kunjungan pada tanggal $lastDate. Sesuai aturan, WBP hanya boleh dikunjungi 1x dalam seminggu.")->withInput();
        }

        // Cek NIK Ganda
        $existingVisitor = Kunjungan::where('nik_ktp', $validatedData['nik_ktp'])
            ->whereDate('tanggal_kunjungan', $requestDate)
            ->whereIn('status', [KunjunganStatus::PENDING->value, KunjunganStatus::APPROVED->value])
            ->first();

        if ($existingVisitor) {
            return back()->with('error', "NIK Anda ({$validatedData['nik_ktp']}) sudah terdaftar untuk kunjungan pada tanggal ini.")->withInput();
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
            $filesPengikut = $request->file('pengikut_foto'); // This will be passed to service

            $kunjungan = $kunjunganService->storeRegistration(
                $validatedData,
                $fileKtp,
                $filesPengikut,
                $nomorAntrian
            );

            // Decrement Quota in Redis
            $quotaService->decrementQuota($tanggal->format('Y-m-d'), $sesi);

            return redirect()->route('kunjungan.create')
                ->with('success', "PENDAFTARAN BERHASIL! Antrian: {$nomorAntrian}.")
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

        $totalQuota = 150;
        if ($tanggal->isMonday()) {
            $totalQuota = ($sesi === 'pagi') ? 120 : 40;
        }

        $query = Kunjungan::where('tanggal_kunjungan', $tanggal->format('Y-m-d'))
            ->whereIn('status', [KunjunganStatus::PENDING, KunjunganStatus::APPROVED]);

        if ($tanggal->isMonday()) {
            $query->where('sesi', $sesi);
        }

        $registeredCount = $query->count();
        $sisaKuota = max(0, $totalQuota - $registeredCount);
        return response()->json(['sisa_kuota' => $sisaKuota]);
    }

    public function printProof(Kunjungan $kunjungan)
    {
        if ($kunjungan->status != KunjunganStatus::APPROVED) {
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
            $message = null;
            if ($kunjungan->status === KunjunganStatus::PENDING) {
                $kunjungan->status = KunjunganStatus::APPROVED;
                $kunjungan->save();
                $message = 'Kunjungan otomatis DISETUJUI saat scan.';

                try {
                    // Kirim notifikasi WA (Approved)
                    $whatsAppService->sendApproved($kunjungan, null);
                    // Kirim notifikasi Email (Approved)
                    Mail::to($kunjungan->email_pengunjung)->send(new KunjunganStatusMail($kunjungan, null));
                } catch (\Exception $e) {
                }
            }

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'kunjungan' => $kunjungan,
                    'message' => $message
                ]);
            }

            if ($message) {
                 // If status changed, maybe redirect to print, but for consistency let's show success page
                 // return redirect()->route('kunjungan.print', $kunjungan->id);
            }

            return view('admin.kunjungan.verifikasi', [
                'status_verifikasi' => 'success',
                'kunjungan' => $kunjungan,
                'approval_message' => $message
            ]);
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
                // Foto tidak dikembalikan di sini karena berat, 
                // tapi jika mau ditampilkan di form bisa ditambahkan:
                // 'foto_ktp' => $profil->foto_ktp 
            ]);
        }

        return response()->json(['message' => 'Profil tidak ditemukan'], 404);
    }
}