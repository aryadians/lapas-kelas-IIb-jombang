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
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;

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

    public function store(Request $request)
    {
        // 0. PRE-PROCESSING
        if ($request->has('tanggal_kunjungan')) {
            try {
                $date = Carbon::parse($request->tanggal_kunjungan);
                if (!$date->isMonday()) {
                    $request->merge(['sesi' => 'pagi']);
                }
            } catch (\Exception $e) {
            }
        }

        // 1. VALIDASI
        $rules = [
            'nama_pengunjung'               => 'required|string|max:255',
            'nik_ktp'                       => 'required|numeric|digits:16',
            'nomor_hp'                      => 'required|string',
            'email_pengunjung'              => 'required|email',
            'alamat_lengkap'                => 'required|string',
            'barang_bawaan'                 => 'nullable|string',
            'jenis_kelamin'                 => 'required|in:Laki-laki,Perempuan',
            'foto_ktp'                      => 'required|image|max:5000',
            'wbp_id'                        => 'required|exists:wbps,id',
            'hubungan'                      => 'required|string',
            'tanggal_kunjungan'             => 'required|date',
            'preferred_notification_channel' => 'required|in:email,whatsapp',
            'sesi'                          => 'required',
            'pengikut_nama'                 => 'nullable|array|max:4',
            'pengikut_nik'                  => 'nullable|array|max:4',
            'pengikut_hubungan'             => 'nullable|array|max:4',
            'pengikut_foto'                 => 'nullable|array|max:4',
            'pengikut_foto.*'               => 'nullable|image|max:5000',
        ];

        $messages = ['pengikut_nama.max' => 'Jumlah pengikut tidak boleh lebih dari 4 orang.'];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $validatedData = $validator->validated();

        // 2. LOGIKA BISNIS
        $requestDate = Carbon::parse($validatedData['tanggal_kunjungan'])->startOfDay();
        $today = Carbon::now()->startOfDay();
        $wbp = Wbp::find($validatedData['wbp_id']);

        // Cek Hari Libur
        if ($requestDate->isFriday() || $requestDate->isSaturday() || $requestDate->isSunday()) {
            return back()->with('error', 'Layanan kunjungan TUTUP pada hari Jumat-Minggu.')->withInput();
        }

        // Cek Aturan H-1 & Senin
        if ($requestDate->isMonday()) {
            if (!($today->isFriday() || $today->isSaturday() || $today->isSunday())) {
                return back()->with('error', 'Pendaftaran untuk hari Senin hanya dibuka pada hari Jumat-Minggu sebelumnya.')->withInput();
            }
            if ($today->diffInDays($requestDate, false) < 1 || $today->diffInDays($requestDate, false) > 3) {
                return back()->with('error', 'Tanggal Senin tidak valid. Pilih Senin terdekat.')->withInput();
            }
        } else {
            if ($requestDate->toDateString() !== $today->copy()->addDay()->toDateString()) {
                return back()->with('error', 'Pendaftaran kunjungan wajib dilakukan H-1 (satu hari sebelum jadwal kunjungan).')->withInput();
            }
        }

        // Cek Tipe WBP
        $kodeReg = strtoupper(substr($wbp->no_registrasi, 0, 1));
        $hariKunjungan = $requestDate->dayOfWeek;

        if ($kodeReg === 'A' && !in_array($hariKunjungan, [2, 4])) {
            return back()->with('error', "WBP TAHANAN (Kode A) hanya bisa dikunjungi SELASA dan KAMIS.")->withInput();
        } elseif ($kodeReg === 'B' && !in_array($hariKunjungan, [1, 3])) {
            return back()->with('error', "WBP NARAPIDANA (Kode B) hanya bisa dikunjungi SENIN dan RABU.")->withInput();
        }

        // Cek Lock WBP 1 Minggu
        $startWindow = $requestDate->copy()->subDays(6);
        $recentVisit = Kunjungan::where('wbp_id', $validatedData['wbp_id'])
            ->whereIn('status', [KunjunganStatus::PENDING, KunjunganStatus::APPROVED])
            ->whereBetween('tanggal_kunjungan', [$startWindow->format('Y-m-d'), $requestDate->format('Y-m-d')])
            ->orderBy('tanggal_kunjungan', 'desc')
            ->first();

        if ($recentVisit) {
            $lastDate = Carbon::parse($recentVisit->tanggal_kunjungan)->translatedFormat('d M Y');
            return back()->with('error', "WBP ini sudah terdaftar kunjungan pada tanggal $lastDate. Sesuai aturan, WBP hanya boleh dikunjungi 1x dalam seminggu.")->withInput();
        }

        // Cek NIK Ganda (Per Hari)
        $existingVisitor = Kunjungan::where('nik_ktp', $validatedData['nik_ktp'])
            ->whereDate('tanggal_kunjungan', $requestDate)
            ->whereIn('status', [KunjunganStatus::PENDING, KunjunganStatus::APPROVED])
            ->first();

        if ($existingVisitor) {
            return back()->with('error', "NIK Anda ({$validatedData['nik_ktp']}) sudah terdaftar untuk kunjungan pada tanggal ini.")->withInput();
        }

        // 3. SIMPAN DATA
        try {
            DB::beginTransaction();

            $pathFotoUtama = $request->file('foto_ktp')->store('uploads/ktp', 'public');

            // Antrian (Reset per Sesi)
            $lastQueue = Kunjungan::where('tanggal_kunjungan', $validatedData['tanggal_kunjungan'])
                ->where('sesi', $validatedData['sesi'])
                ->lockForUpdate()
                ->orderBy('nomor_antrian_harian', 'desc')
                ->first();

            $nomorAntrian = $lastQueue ? $lastQueue->nomor_antrian_harian + 1 : 1;

            $fullData = array_merge($validatedData, [
                'no_wa_pengunjung'  => $request->nomor_hp,
                'alamat_pengunjung' => $request->alamat_lengkap,
            ]);

            $kunjungan = Kunjungan::create(array_merge($fullData, [
                'kode_kunjungan'       => 'VIS-' . strtoupper(Str::random(6)),
                'nomor_antrian_harian' => $nomorAntrian,
                'status'               => KunjunganStatus::PENDING,
                'qr_token'             => Str::uuid(),
                'foto_ktp'             => $pathFotoUtama,
            ]));

            if ($request->has('pengikut_nama')) {
                foreach ($request->pengikut_nama as $index => $nama) {
                    if (!empty($nama)) {
                        $pathFotoPengikut = null;
                        if ($request->hasFile("pengikut_foto.$index")) {
                            $pathFotoPengikut = $request->file("pengikut_foto")[$index]->store('uploads/pengikut', 'public');
                        }
                        Pengikut::create([
                            'kunjungan_id' => $kunjungan->id,
                            'nama' => $nama,
                            'nik' => $request->pengikut_nik[$index] ?? null,
                            'hubungan' => $request->pengikut_hubungan[$index] ?? null,
                            'barang_bawaan' => $request->pengikut_barang[$index] ?? null,
                            'foto_ktp' => $pathFotoPengikut
                        ]);
                    }
                }
            }

            // --- GENERATE QR CODE (FALLBACK MECHANISM) ---
            $path = storage_path('app/public/qrcodes');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            $qrCodePath = null;

            try {
                // COBA 1: PNG (Best for Email)
                $qrContent = QrCode::format('png')
                    ->size(400)
                    ->margin(2)
                    ->color(0, 0, 0)
                    ->backgroundColor(255, 255, 255)
                    ->generate($kunjungan->qr_token);

                $qrCodePath = 'qrcodes/' . $kunjungan->id . '.png';
                Storage::disk('public')->put($qrCodePath, $qrContent);
            } catch (\Exception $e) {
                // FALLBACK: SVG (Anti-Error)
                $qrContent = QrCode::format('svg')
                    ->size(400)
                    ->margin(2)
                    ->generate($kunjungan->qr_token);

                $qrCodePath = 'qrcodes/' . $kunjungan->id . '.svg';
                Storage::disk('public')->put($qrCodePath, $qrContent);

                Log::warning('QR Code PNG failed, fallback to SVG: ' . $e->getMessage());
            }

            DB::commit();

            // KIRIM NOTIFIKASI
            try {
                if ($kunjungan->preferred_notification_channel === 'whatsapp') {
                    (new WhatsAppService())->sendPending($kunjungan, Storage::disk('public')->url($qrCodePath));
                } else {
                    $fullQrPath = Storage::disk('public')->path($qrCodePath);
                    Mail::to($kunjungan->email_pengunjung)->send(new KunjunganStatusMail($kunjungan, $fullQrPath));
                }
            } catch (\Exception $e) {
                Log::error('Gagal kirim notifikasi awal: ' . $e->getMessage());
            }

            return redirect()->route('kunjungan.status', $kunjungan->id)
                ->with('success', "PENDAFTARAN BERHASIL! Antrian: {$nomorAntrian} (Sesi " . ucfirst($validatedData['sesi']) . ").");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing visit: ' . $e->getMessage());

            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                return back()->with('error', 'Terjadi kepadatan antrian. Mohon klik tombol kirim sekali lagi.')->withInput();
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
            // Cek Path QR (Prioritas PNG)
            $qrCodePath = 'qrcodes/' . $kunjungan->id . '.png';
            if (!Storage::disk('public')->exists($qrCodePath)) {
                // Cek SVG jika PNG tak ada
                $pathSvg = 'qrcodes/' . $kunjungan->id . '.svg';
                if (Storage::disk('public')->exists($pathSvg)) {
                    $qrCodePath = $pathSvg;
                }
            }

            // Jika Approved & File tidak ada -> Generate Ulang (Fallback)
            if ($newStatus == KunjunganStatus::APPROVED->value) {
                $fullQrPath = Storage::disk('public')->path($qrCodePath);

                // Jika file fisik benar-benar tidak ada, buat baru
                if (!file_exists($fullQrPath)) {
                    try {
                        // Coba PNG
                        $qrContent = QrCode::format('png')->size(400)->margin(2)->generate($kunjungan->qr_token);
                        $qrCodePath = 'qrcodes/' . $kunjungan->id . '.png';
                    } catch (\Exception $e) {
                        // Fallback SVG
                        $qrContent = QrCode::format('svg')->size(400)->margin(2)->generate($kunjungan->qr_token);
                        $qrCodePath = 'qrcodes/' . $kunjungan->id . '.svg';
                    }
                    Storage::disk('public')->put($qrCodePath, $qrContent);
                    $fullQrPath = Storage::disk('public')->path($qrCodePath); // Update path fisik
                }
            }

            // Kirim Notifikasi
            if ($kunjungan->preferred_notification_channel === 'whatsapp') {
                if ($newStatus == KunjunganStatus::APPROVED->value) {
                    $whatsAppService->sendApproved($kunjungan, Storage::disk('public')->url($qrCodePath));
                } elseif ($newStatus == KunjunganStatus::REJECTED->value) {
                    $whatsAppService->sendRejected($kunjungan);
                }
            } else {
                // Email Notification
                if ($newStatus == KunjunganStatus::APPROVED->value) {
                    // Pastikan path fisik digunakan
                    $fullQrPath = Storage::disk('public')->path($qrCodePath);
                    Mail::to($kunjungan->email_pengunjung)->send(new KunjunganStatusMail($kunjungan, $fullQrPath));
                } elseif ($newStatus == KunjunganStatus::REJECTED->value) {
                    Mail::to($kunjungan->email_pengunjung)->send(new KunjunganStatusMail($kunjungan, null));
                }
            }
        } catch (\Exception $e) {
            Log::error('Gagal kirim notifikasi update: ' . $e->getMessage());
        }

        return back()->with('success', 'Status diperbarui & notifikasi dikirim.');
    }

    // Method pendukung lainnya (Sama)
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
        $token = $request->qr_token;
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
                    if ($kunjungan->preferred_notification_channel === 'whatsapp') {
                        $whatsAppService->sendApproved($kunjungan, null);
                    } else {
                        Mail::to($kunjungan->email_pengunjung)->send(new KunjunganStatusMail($kunjungan, null));
                    }
                } catch (\Exception $e) {
                }
            }

            return view('admin.kunjungan.verifikasi', [
                'status_verifikasi' => 'success',
                'kunjungan' => $kunjungan,
                'approval_message' => $message
            ]);
        } else {
            return view('admin.kunjungan.verifikasi', [
                'status_verifikasi' => 'failed',
                'qr_token' => $token
            ]);
        }
    }
}
