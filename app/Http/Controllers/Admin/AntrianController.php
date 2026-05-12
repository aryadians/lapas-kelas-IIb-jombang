<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AntrianStatus;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Events\AntrianUpdated;

class AntrianController extends Controller
{
    private function getStatusForSesi($sesi)
    {
        return AntrianStatus::firstOrCreate(
            [
                'tanggal' => Carbon::today(),
                'sesi' => $sesi,
            ],
            ['nomor_terpanggil' => 0]
        );
    }

    public function panggil(Request $request)
    {
        $request->validate(['sesi' => 'required|in:pagi,siang']);
        $sesi = $request->sesi;

        $antrian = $this->getStatusForSesi($sesi);
        $antrian->increment('nomor_terpanggil');

        $payload = [
            'nomor' => $antrian->nomor_terpanggil,
            'loket' => $request->input('loket', null),
            'status' => 'panggil',
            'sesi' => $sesi,
        ];
        AntrianUpdated::dispatch($payload);

        return response()->json([
            'sesi' => $sesi,
            'nomor_terpanggil' => $antrian->nomor_terpanggil,
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate(['sesi' => 'required|in:pagi,siang']);
        $sesi = $request->sesi;

        $antrian = $this->getStatusForSesi($sesi);
        $antrian->update(['nomor_terpanggil' => 0]);

        $payload = [
            'nomor' => 0,
            'loket' => $request->input('loket', null),
            'status' => 'reset',
            'sesi' => $sesi,
        ];
        AntrianUpdated::dispatch($payload);

        return response()->json([
            'sesi' => $sesi,
            'nomor_terpanggil' => 0,
        ]);
    }

    public function panggilManual()
    {
        return view('admin.antrian.panggil_manual');
    }

    public function panggilSpesifik(Request $request)
    {
        $request->validate([
            'nomor' => 'required|integer',
            'prefix' => 'required|string|max:1',
            'loket' => 'nullable|string'
        ]);

        $payload = [
            'nomor' => $request->nomor,
            'prefix' => $request->prefix,
            'loket' => $request->loket,
            'status' => 'panggil',
            'nama' => 'Pengunjung',
            'type' => $request->prefix === 'A' ? 'online' : 'offline',
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
        ];

        // Simpan ke cache agar display bisa mendeteksi lewat polling (fallback jika broadcasting gagal)
        Cache::put('latest_call', $payload, 60);

        // Broadcast event untuk real-time (jika menggunakan Pusher/Reverb)
        AntrianUpdated::dispatch($payload);

        return response()->json(['success' => true, 'payload' => $payload]);
    }

    public function getStatus()
    {
        $statusPagi = $this->getStatusForSesi('pagi');
        $statusSiang = $this->getStatusForSesi('siang');

        return response()->json([
            'pagi' => $statusPagi->nomor_terpanggil,
            'siang' => $statusSiang->nomor_terpanggil,
            'call' => Cache::get('latest_call'), // <--- Auto-announcement trigger
        ]);
    }
}
