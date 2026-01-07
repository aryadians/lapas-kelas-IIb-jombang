<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\KunjunganPending;
use App\Mail\KunjunganRejected;
use App\Mail\KunjunganApproved;
use App\Models\Kunjungan;
use App\Models\Wbp;
use App\Models\Pengikut;
use Illuminate\Http\Request;
use App\Mail\KunjunganConfirmationMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator; // <--- POSISI BENAR DI SINI

class KunjunganController extends Controller
{
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
        // ====================================================
        // 0. FIX LOGIC: OTOMATIS ISI SESI (Jika Bukan Senin)
        // ====================================================
        // Kita cek dulu tanggal yang dipilih user
        if ($request->has('tanggal_kunjungan')) {
            try {
                $date = \Carbon\Carbon::parse($request->tanggal_kunjungan);

                // Jika BUKAN hari Senin, sistem otomatis mengisi 'pagi'
                // Agar tidak kena error "The sesi field is required"
                if (!$date->isMonday()) {
                    $request->merge(['sesi' => 'pagi']);
                }
            } catch (\Exception $e) {
                // Abaikan error format tanggal, nanti ditangani validasi di bawah
            }
        }
        // 1. VALIDASI INPUT FORM
        $request->validate([
            'nama_pengunjung'   => 'required|string|max:255',
            'nik_ktp'           => 'required|numeric|digits:16',
            'nomor_hp'          => 'required|string',
            'email_pengunjung'  => 'required|email',
            'alamat_lengkap'    => 'required|string',
            'barang_bawaan'     => 'nullable|string',
            'jenis_kelamin'     => 'required|in:Laki-laki,Perempuan',
            'foto_ktp'          => 'required|image|max:5000',
            'wbp_id'            => 'required',
            'hubungan'          => 'required|string',
            'tanggal_kunjungan' => 'required|date',

            // Validation rule tetap 'required', tapi karena kita sudah merge 'pagi' di atas,
            // maka hari selain Senin akan lolos validasi ini.
            'sesi'              => 'required',
        ]);

        // ====================================================
        // MULAI LOGIKA BISNIS (VALIDASI KHUSUS)
        // ====================================================

        // Setup Variabel Tanggal
        // Kita pakai startOfDay() agar jam tidak berpengaruh, murni cek tanggal
        $requestDate = \Carbon\Carbon::parse($request->tanggal_kunjungan)->startOfDay();
        $today       = \Carbon\Carbon::now()->startOfDay();

        // A. VALIDASI HARI LIBUR
        if ($requestDate->isSunday()) {
            return back()->with('error', 'Maaf, layanan kunjungan TUTUP pada hari Minggu.')->withInput();
        }

        // B. ATURAN PENDAFTARAN (H-1 & SENIN)
        if ($requestDate->isMonday()) {
            // --- ATURAN KHUSUS HARI SENIN ---
            // Syarat: Hari ini harus JUMAT
            if (!$today->isFriday()) {
                return back()->with('error', 'Pendaftaran untuk hari SENIN hanya dibuka pada hari JUMAT sebelumnya.')->withInput();
            }

            // Syarat: Tanggal yang diminta harus Senin terdekat (Selisih 3 hari dari Jumat)
            // Jumat (0) -> Sabtu (1) -> Minggu (2) -> Senin (3)
            if ($today->diffInDays($requestDate) != 3) {
                return back()->with('error', 'Tanggal Senin yang Anda pilih tidak valid. Silakan pilih Senin terdekat.')->withInput();
            }
        } else {
            // --- ATURAN HARI BIASA (SELASA - SABTU) ---
            // Syarat: Pendaftaran wajib H-1
            if ($today->diffInDays($requestDate) != 1) {
                return back()->with('error', 'Pendaftaran kunjungan wajib dilakukan H-1 (Satu hari sebelum jadwal kunjungan).')->withInput();
            }
        }

        // C. SISTEM KUNCI (LOCK) WBP 1 MINGGU
        // Aturan: WBP tidak boleh dikunjungi lagi jika sudah ada kunjungan dalam 6 hari terakhir
        // Hitung mundur 6 hari dari tanggal yang diminta
        $startWindow = $requestDate->copy()->subDays(6);

        $existingVisit = Kunjungan::where('wbp_id', $request->wbp_id)
            ->where('status', '!=', 'rejected') // Abaikan yang statusnya ditolak
            ->whereBetween('tanggal_kunjungan', [$startWindow->format('Y-m-d'), $requestDate->format('Y-m-d')])
            ->first();

        if ($existingVisit) {
            // Ambil tanggal kapan WBP itu dikunjungi terakhir kali
            $lastVisitDate = Carbon::parse($existingVisit->tanggal_kunjungan);
            // Hitung kapan boleh dikunjungi lagi (Tanggal terakhir + 7 hari)
            $nextAllowedDate = $lastVisitDate->addDays(7)->translatedFormat('l, d F Y');

            return back()->with('error', "WBP ini sudah menerima kunjungan pada tanggal " . $lastVisitDate->translatedFormat('d M Y') . ". Sesuai aturan, WBP baru bisa dikunjungi kembali mulai: " . $nextAllowedDate)->withInput();
        }

        // ====================================================
        // AKHIR LOGIKA BISNIS - LANJUT SIMPAN DATABASE
        // ====================================================

        // MAPPING DATA
        $inputData = [
            'wbp_id'            => $request->wbp_id,
            'nama_pengunjung'   => $request->nama_pengunjung,
            'nik_ktp'           => $request->nik_ktp,
            'no_wa_pengunjung'  => $request->nomor_hp,
            'email_pengunjung'  => $request->email_pengunjung,
            'alamat_pengunjung' => $request->alamat_lengkap,
            'barang_bawaan'     => $request->barang_bawaan,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'hubungan'          => $request->hubungan,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'sesi'              => $request->sesi,
        ];

        try {
            DB::beginTransaction();

            // A. Upload Foto
            $pathFotoUtama = $request->file('foto_ktp')->store('uploads/ktp', 'public');

            // B. Simpan Kunjungan
            $nomorAntrian = Kunjungan::where('tanggal_kunjungan', $request->tanggal_kunjungan)->count() + 1;

            $kunjungan = Kunjungan::create(array_merge($inputData, [
                'kode_kunjungan'       => 'VIS-' . strtoupper(Str::random(6)),
                'nomor_antrian_harian' => $nomorAntrian,
                'status'               => 'pending',
                'qr_token'             => Str::uuid(),
                'foto_ktp'             => $pathFotoUtama,
                'pengikut_laki'        => 0,
                'pengikut_perempuan'   => 0,
                'pengikut_anak'        => 0
            ]));

            // C. Simpan Detail Pengikut
            if ($request->has('pengikut_nama')) {
                foreach ($request->pengikut_nama as $index => $nama) {
                    if (!empty($nama)) {
                        $pathFotoPengikut = null;
                        if ($request->hasFile("pengikut_foto.$index")) {
                            $pathFotoPengikut = $request->file("pengikut_foto")[$index]->store('uploads/pengikut', 'public');
                        }

                        Pengikut::create([
                            'kunjungan_id'  => $kunjungan->id,
                            'nama'          => $nama,
                            'nik'           => $request->pengikut_nik[$index] ?? null,
                            'hubungan'      => $request->pengikut_hubungan[$index] ?? null,
                            'barang_bawaan' => $request->pengikut_barang[$index] ?? null,
                            'foto_ktp'      => $pathFotoPengikut
                        ]);
                    }
                }
            }

            DB::commit();

            // KIRIM EMAIL PENDING (Jika konfigurasi env sudah benar)
            try {
                if ($request->email_pengunjung) {
                    Mail::to($request->email_pengunjung)->send(new KunjunganPending($kunjungan));
                }
            } catch (\Exception $e) {
            }

            return redirect()->route('kunjungan.status', $kunjungan->id)
                ->with('success', "PENDAFTARAN BERHASIL! Nomor Antrian: {$nomorAntrian}");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi Kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function status(Kunjungan $kunjungan)
    {
        return view('guest.kunjungan.status', compact('kunjungan'));
    }

    public function getQuotaStatus(Request $request)
    {
        // (Isi API Quota - biarkan seperti kode sebelumnya)
        return response()->json(['sisa_kuota' => 100]);
    }
    /**
     * Menampilkan Halaman Cetak Tiket
     */
    public function printProof(Kunjungan $kunjungan)
    {
        // Pastikan hanya yang status approved yang bisa cetak (opsional)
        if ($kunjungan->status != 'approved') {
            return redirect()->route('kunjungan.status', $kunjungan->id)
                ->with('error', 'Tiket belum tersedia. Menunggu persetujuan admin.');
        }

        return view('guest.kunjungan.print', compact('kunjungan'));
    }
    public function updateStatus(Request $request, Kunjungan $kunjungan)
    {
        $statusBaru = $request->status; // 'approved' atau 'rejected'

        $kunjungan->update(['status' => $statusBaru]);

        // --- LOGIKA KIRIM EMAIL OTOMATIS ---
        try {
            if ($statusBaru == 'approved') {
                // Kirim Email Tiket
                // Mail::to($kunjungan->email_pengunjung)->send(new \App\Mail\KunjunganApproved($kunjungan));
            } elseif ($statusBaru == 'rejected') {
                // Kirim Email Penolakan
                // Mail::to($kunjungan->email_pengunjung)->send(new \App\Mail\KunjunganRejected($kunjungan));
            }
        } catch (\Exception $e) {
            // Log error email tapi biarkan status berubah
        }

        return back()->with('success', 'Status berhasil diperbarui!');
    }
    public function update(Request $request, $id)
    {
        $kunjungan = Kunjungan::findOrFail($id);
        $oldStatus = $kunjungan->status;

        // Update Status
        $kunjungan->status = $request->status;
        $kunjungan->save();

        // --- [BARU] LOGIKA KIRIM EMAIL OTOMATIS ---
        try {
            if ($kunjungan->email_pengunjung) {
                // 1. Jika berubah jadi APPROVED
                if ($request->status == 'approved' && $oldStatus != 'approved') {
                    Mail::to($kunjungan->email_pengunjung)->send(new KunjunganApproved($kunjungan));
                }
                // 2. Jika berubah jadi REJECTED
                elseif ($request->status == 'rejected' && $oldStatus != 'rejected') {
                    Mail::to($kunjungan->email_pengunjung)->send(new KunjunganRejected($kunjungan));
                }
            }
        } catch (\Exception $e) {
            // Abaikan error email agar admin tidak terganggu
        }
        // -------------------------------------------

        return back()->with('success', 'Status diperbarui & Notifikasi email dikirim.');
    }
    // 1. Menampilkan Halaman Awal (Scan/Input)
    public function verifikasiPage()
    {
        return view('admin.kunjungan.verifikasi');
    }

    // 2. Memproses Data Saat Tombol Ditekan
    public function verifikasiSubmit(Request $request)
    {
        // Ambil token dari input form
        $token = $request->qr_token;

        // Cari data berdasarkan qr_token (atau kode_kunjungan)
        $kunjungan = Kunjungan::with(['wbp', 'pengikuts']) // Load relasi biar lengkap
            ->where('qr_token', $token)
            ->orWhere('kode_kunjungan', $token) // Biar bisa cari pakai kode manual juga
            ->first();

        if ($kunjungan) {
            // JIKA KETEMU:
            // Kembalikan ke view yang sama, tapi bawa data 'status_verifikasi' = 'success'
            // dan bawa data '$kunjungan' nya.
            return view('admin.kunjungan.verifikasi', [
                'status_verifikasi' => 'success',
                'kunjungan' => $kunjungan
            ]);
        } else {
            // JIKA TIDAK KETEMU:
            // Kembalikan ke view yang sama, status 'failed'
            return view('admin.kunjungan.verifikasi', [
                'status_verifikasi' => 'failed',
                'qr_token' => $token
            ]);
        }
    }
}
