<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AntrianStatus;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

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

        return response()->json([
            'sesi' => $sesi,
            'nomor_terpanggil' => 0,
        ]);
    }

    public function getStatus()
    {
        $statusPagi = $this->getStatusForSesi('pagi');
        $statusSiang = $this->getStatusForSesi('siang');

        return response()->json([
            'pagi' => $statusPagi->nomor_terpanggil,
            'siang' => $statusSiang->nomor_terpanggil,
        ]);
    }
}
