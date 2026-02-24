<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\AntrianStatus;
use App\Events\AntrianUpdated;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Enums\KunjunganStatus;

class QueueController extends Controller
{
    /**
     * Display the queue control room.
     */
    public function index()
    {
        return view('admin.antrian.kontrol');
    }

    /**
     * Get the current state of the queue for today.
     */
    public function getState()
    {
        $today = Carbon::today();

        $kunjungans = Kunjungan::with(['wbp', 'profilPengunjung'])
            ->whereDate('tanggal_kunjungan', $today)
            ->whereIn('status', [KunjunganStatus::APPROVED, KunjunganStatus::IN_PROGRESS, KunjunganStatus::COMPLETED])
            ->orderBy('nomor_antrian_harian', 'asc')
            ->get();
        
        $waiting = $kunjungans->where('status', KunjunganStatus::APPROVED)->values();
        $in_progress = $kunjungans->where('status', KunjunganStatus::IN_PROGRESS)->values();
        // Get last 5 completed visits, sorted by when they ended
        $completed = $kunjungans->where('status', KunjunganStatus::COMPLETED)->sortByDesc('visit_ended_at')->take(5)->values();

        return response()->json([
            'waiting' => $waiting,
            'in_progress' => $in_progress,
            'completed' => $completed,
        ]);
    }

    /**
     * Start the 15-minute visit timer.
     */
    public function start(Kunjungan $kunjungan)
    {
        if ($kunjungan->status !== KunjunganStatus::APPROVED || !$kunjungan->tanggal_kunjungan->isToday()) {
             return response()->json(['error' => 'Kunjungan ini tidak bisa dimulai. Status saat ini: ' . $kunjungan->status->value], 422);
        }

        $kunjungan->status = KunjunganStatus::IN_PROGRESS;
        $kunjungan->visit_started_at = now();
        $kunjungan->save();

        // Update AntrianStatus
        if ($kunjungan->sesi) {
            $antrian = AntrianStatus::firstOrCreate(
                [
                    'tanggal' => Carbon::today(),
                    'sesi' => $kunjungan->sesi,
                ]
            );
            $antrian->nomor_terpanggil = $kunjungan->nomor_antrian_harian;
            $antrian->save();

            // Broadcast the event
            $payload = [
                'nomor' => $antrian->nomor_terpanggil,
                'loket' => null,
                'status' => 'start',
                'sesi' => $kunjungan->sesi,
            ];
            AntrianUpdated::dispatch($payload);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kunjungan untuk ' . $kunjungan->nama_pengunjung . ' telah dimulai.',
            'kunjungan' => $kunjungan->fresh('wbp'),
        ]);
    }

    /**
     * Mark a visit as 'completed'.
     */
    public function finish(Kunjungan $kunjungan)
    {
         if ($kunjungan->status !== KunjunganStatus::IN_PROGRESS) {
             return response()->json(['error' => 'Kunjungan tidak sedang berlangsung.'], 422);
        }
        
        $kunjungan->status = KunjunganStatus::COMPLETED;
        $kunjungan->visit_ended_at = now();
        $kunjungan->save();

        return response()->json([
            'success' => true,
            'message' => 'Kunjungan untuk ' . $kunjungan->nama_pengunjung . ' telah selesai.',
            'kunjungan' => $kunjungan->fresh('wbp'),
        ]);
    }

    /**
     * Trigger a voice call for the visitor.
     */
    public function call(Kunjungan $kunjungan)
    {
        $type = $kunjungan->registration_type === 'offline' ? 'offline' : 'online';
        $formattedNomor = $kunjungan->nomor_antrian_harian . ' ' . $type;

        // Cache the call signal for 20 seconds
        // "latest_call" will be polled by the display page
        \Illuminate\Support\Facades\Cache::put('latest_call', [
            'type' => 'visitor',
            'nomor' => $formattedNomor,
            'nama' => $kunjungan->nama_pengunjung,
            'loket' => 'Pintu Utama', // Or dynamic based on context
            'uuid' => \Illuminate\Support\Str::uuid()->toString(),
            'timestamp' => now()->timestamp
        ], 20);

        return response()->json([
            'success' => true,
            'message' => 'Panggilan suara dikirim ke Display.',
        ]);
    }
}
