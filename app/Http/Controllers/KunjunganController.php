<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Wbp; // Import Model WBP
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\KunjunganConfirmationMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KunjunganController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $datesByDay = [
            'Senin' => [],
            'Selasa' => [],
            'Rabu' => [],
            'Kamis' => [],
        ];

        $date = Carbon::today();
        $dayMapping = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
        ];

        for ($i = 0; $i < 60; $i++) { // Search up to 60 days in the future
            $currentDate = $date->copy()->addDays($i);
            $dayOfWeek = $currentDate->dayOfWeek;

            if (array_key_exists($dayOfWeek, $dayMapping)) {
                $dayName = $dayMapping[$dayOfWeek];
                // Add up to 3 upcoming dates for each valid day
                if (count($datesByDay[$dayName]) < 3) {
                    $datesByDay[$dayName][] = [
                        'value' => $currentDate->format('Y-m-d'),
                        'label' => $currentDate->translatedFormat('d F Y'),
                    ];
                }
            }
        }

        return view('guest.kunjungan.create', ['datesByDay' => $datesByDay]);
    }

    /**
     * API untuk Pencarian WBP (Autocomplete)
     */
    public function searchWbp(Request $request)
    {
        $query = $request->get('q');
        $wbps = Wbp::where('nama', 'LIKE', "%{$query}%")
            ->orWhere('no_registrasi', 'LIKE', "%{$query}%")
            ->limit(10)->get();
        return response()->json($wbps);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Dasar & Baru
        $validated = $request->validate([
            'nama_pengunjung'    => 'required|string|max:255',
            'nik_pengunjung'     => 'required|string|size:16',
            'no_wa_pengunjung'   => 'required|string|max:15',
            'email_pengunjung'   => 'required|email|max:255',
            'alamat_pengunjung'  => 'required|string',

            // Validasi WBP & Hubungan
            'wbp_id'             => 'required|exists:wbps,id', // Wajib ID dari database WBP
            'nama_wbp'           => 'required|string', // Fallback name
            'hubungan'           => 'required|string|max:100',

            'tanggal_kunjungan'  => 'required|date|after_or_equal:today',
            'sesi'               => 'nullable|string|in:pagi,siang',

            // Validasi Pengikut
            'total_pengikut'     => 'required|integer|min:0|max:4',
            'pengikut_nama.*'    => 'nullable|string',
            'pengikut_barang.*'  => 'nullable|string',
            
        ]);

        $tanggalKunjungan = Carbon::parse($validated['tanggal_kunjungan']);
        $sesi = $request->input('sesi');
        $today = Carbon::now();

        // 2. LOGIKA VALIDASI HARI (H-1 & SENIN)
        if ($tanggalKunjungan->isMonday()) {
            // Jika kunjungan Senin, wajib daftar hari Jumat sebelumnya
            // (Asumsi: Hari ini harus Jumat)
            if (!$today->isFriday()) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'tanggal_kunjungan' => 'Khusus kunjungan hari Senin, pendaftaran hanya dibuka pada hari Jumat sebelumnya.',
                ]);
            }
            // Sesi wajib untuk Senin
            if (!$sesi) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'sesi' => 'Untuk hari Senin, Anda wajib memilih sesi kunjungan.',
                ]);
            }
        } else {
            // Hari Biasa (Selasa-Kamis): Wajib H-1
            // Cek selisih hari (harus 1 hari)
            if ($today->diffInDays($tanggalKunjungan, false) != 1) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'tanggal_kunjungan' => 'Pendaftaran wajib dilakukan H-1 (Satu hari sebelum jadwal kunjungan).',
                ]);
            }
        }

        // Cek jika hari libur sistem (Jumat/Sabtu/Minggu tidak terima kunjungan)
        if ($tanggalKunjungan->isFriday() || $tanggalKunjungan->isSaturday() || $tanggalKunjungan->isSunday()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'tanggal_kunjungan' => 'Layanan kunjungan tutup pada hari Jumat, Sabtu, dan Minggu.',
            ]);
        }

        // 3. LOGIKA SISTEM KUNCI (LOCK) 1 MINGGU
        // Cek apakah WBP ini sudah dikunjungi dalam 7 hari terakhir?
        $lockDateStart = $tanggalKunjungan->copy()->subDays(6);

        $sudahDikunjungi = Kunjungan::where('wbp_id', $request->wbp_id)
            ->where('status', '!=', 'rejected') // Hitung status pending & approved
            ->whereBetween('tanggal_kunjungan', [$lockDateStart->format('Y-m-d'), $tanggalKunjungan->format('Y-m-d')])
            ->exists();

        if ($sudahDikunjungi) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'nama_wbp' => 'Warga Binaan ini sudah menerima kunjungan dalam 1 minggu terakhir. Kuota terkunci.',
            ]);
        }

        // 4. Validasi Kuota Harian/Sesi
        $query = Kunjungan::where('tanggal_kunjungan', $tanggalKunjungan->format('Y-m-d'));

        if ($tanggalKunjungan->isMonday()) {
            $kuota = ($sesi == 'pagi') ? config('kunjungan.quota_senin_pagi') : config('kunjungan.quota_senin_siang');
            $jumlahPendaftar = (clone $query)->where('sesi', $sesi)->where('status', 'approved')->count();

            if ($jumlahPendaftar >= $kuota) {
                $namaSesi = ($sesi == 'pagi') ? 'Pagi' : 'Siang';
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'sesi' => "Maaf, kuota untuk Sesi {$namaSesi} pada tanggal tersebut sudah penuh.",
                ]);
            }
        } else {
            $kuota = config('kunjungan.quota_hari_biasa');
            $jumlahPendaftar = (clone $query)->where('status', 'approved')->count();

            if ($jumlahPendaftar >= $kuota) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'tanggal_kunjungan' => 'Maaf, kuota untuk tanggal tersebut sudah penuh.',
                ]);
            }
        }

        // 5. Proses Data Pengikut (Array ke JSON)
        $dataPengikut = [];
        if ($request->total_pengikut > 0 && $request->has('pengikut_nama')) {
            foreach ($request->pengikut_nama as $index => $nama) {
                if (!empty($nama)) {
                    $dataPengikut[] = [
                        'nama' => $nama,
                        'barang' => $request->pengikut_barang[$index] ?? '-'
                    ];
                }
            }
        }

        // 6. Simpan ke Database
        $kunjunganBaru = null;
        DB::transaction(function () use ($validated, $tanggalKunjungan, $sesi, $dataPengikut, &$kunjunganBaru) {
            $nomorAntrian = Kunjungan::where('tanggal_kunjungan', $tanggalKunjungan->format('Y-m-d'))->count() + 1;

            // Setup data insert
            $validated['nomor_antrian_harian'] = $nomorAntrian;
            $validated['status'] = 'pending';
            $validated['qr_token'] = Str::uuid();
            $validated['data_pengikut'] = $dataPengikut; // Simpan JSON

            if ($sesi) {
                $validated['sesi'] = $sesi;
            }

            $kunjunganBaru = Kunjungan::create($validated);
        });

        // Send confirmation email
        Mail::to($kunjunganBaru->email_pengunjung)->queue(new KunjunganConfirmationMail($kunjunganBaru));

        // 7. Redirect dengan pesan sukses
        $pesanSukses = "Pendaftaran berhasil! Nomor antrian Anda: {$kunjunganBaru->nomor_antrian_harian}.";
        if ($kunjunganBaru->sesi) {
            $pesanSukses .= " Anda terdaftar untuk Sesi " . ucfirst($kunjunganBaru->sesi) . ".";
        }
        $pesanSukses .= " Mohon tunggu konfirmasi dari petugas.";

        return redirect()->route('kunjungan.status', $kunjunganBaru)->with('success', $pesanSukses);
    }

    /**
     * Display the specified resource.
     */
    public function status(Kunjungan $kunjungan)
    {
        return view('guest.kunjungan.status', compact('kunjungan'));
    }

    /**
     * Display a verification page for the specified resource.
     */
    public function verify(Kunjungan $kunjungan)
    {
        return view('guest.kunjungan.verify', compact('kunjungan'));
    }

    /**
     * Get the status of a Kunjungan for API calls.
     */
    public function getStatusApi(Kunjungan $kunjungan)
    {
        return response()->json(['status' => $kunjungan->status]);
    }

    /**
     * Get quota status for a given date and session for API calls.
     */
    public function getQuotaStatus(Request $request)
    {
        $validated = $request->validate([
            'tanggal_kunjungan' => 'required|date_format:Y-m-d',
            'sesi'              => 'nullable|string|in:pagi,siang',
        ]);

        $tanggalKunjungan = Carbon::parse($validated['tanggal_kunjungan']);
        $sesi = $validated['sesi'] ?? null;

        if ($tanggalKunjungan->isFriday() || $tanggalKunjungan->isSaturday() || $tanggalKunjungan->isSunday()) {
            return response()->json(['error' => 'Kunjungan tidak tersedia pada hari Jumat, Sabtu, atau Minggu.'], 422);
        }

        $query = Kunjungan::where('tanggal_kunjungan', $tanggalKunjungan->format('Y-m-d'));
        $jumlahPendaftar = 0;
        $totalKuota = 0;

        if ($tanggalKunjungan->isMonday()) {
            if (!$sesi) {
                return response()->json(['error' => 'Sesi harus dipilih untuk hari Senin.'], 422);
            }
            $totalKuota = ($sesi == 'pagi') ? config('kunjungan.quota_senin_pagi') : config('kunjungan.quota_senin_siang');
            $jumlahPendaftar = (clone $query)->where('sesi', $sesi)->where('status', 'approved')->count();
        } else {
            $totalKuota = config('kunjungan.quota_hari_biasa');
            $jumlahPendaftar = (clone $query)->where('status', 'approved')->count();
        }

        $sisaKuota = $totalKuota - $jumlahPendaftar;

        return response()->json([
            'total_kuota' => $totalKuota,
            'jumlah_pendaftar' => $jumlahPendaftar,
            'sisa_kuota' => $sisaKuota,
        ]);
    }

    /**
     * Display a printable version of the registration proof.
     */
    public function printProof(Kunjungan $kunjungan)
    {
        return view('guest.kunjungan.print', compact('kunjungan'));
    }
}
