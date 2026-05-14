<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wbp;
use App\Models\WbpRestriction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class WbpController extends Controller
{
    /**
     * Menampilkan daftar WBP
     */
    public function index(Request $request)
    {
        // Otomatis update status WBP yang sudah ekspirasi (lewat hari ini) menjadi 'Bebas'
        Wbp::where('status', 'Aktif')
            ->whereNotNull('tanggal_ekspirasi')
            ->where('tanggal_ekspirasi', '<', now()->toDateString())
            ->update(['status' => 'Bebas']);

        $query = Wbp::query()->with('latestRestriction');

        // Filter Status (Default: Aktif)
        $status = $request->get('status', 'Aktif');
        $restrictionTypes = ['Mapenaling', 'Strap Cell', 'Sidang TPP'];

        if (in_array($status, $restrictionTypes)) {
            $query->whereHas('latestRestriction', function ($q) use ($status) {
                $q->where('type', $status);
            });
        } elseif ($status !== 'Semua') {
            $query->where('status', $status);
            // Sembunyikan WBP yang sedang dibatasi dari tab Aktif agar rapi
            if ($status === 'Aktif') {
                $query->whereDoesntHave('latestRestriction');
            }
        }

        if ($request->has('search')) {
            $search = trim($request->search); // Bersihkan spasi tidak sengaja
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                    ->orWhere('no_registrasi', 'LIKE', "%{$search}%")
                    ->orWhere('nama_panggilan', 'LIKE', "%{$search}%");
            });
        }

        // Filter Pengurutan
        $sort = $request->get('sort', 'terbaru');
        if ($sort === 'abjad_asc') {
            $query->orderBy('nama', 'asc');
        } elseif ($sort === 'abjad_desc') {
            $query->orderBy('nama', 'desc');
        } else {
            $query->latest();
        }

        $wbps = $query->paginate(15)->withQueryString();

        return view('admin.wbp.index', compact('wbps', 'status', 'sort'));
    }

    /**
     * Proses Import Excel/CSV menggunakan Maatwebsite Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,txt'
        ]);

        try {
            DB::beginTransaction();
            
            $import = new \App\Imports\WbpImport;
            \Maatwebsite\Excel\Facades\Excel::import($import, $request->file('file'));

            // SINKRONISASI STATUS BEBAS:
            // WBP yang tidak ada dalam file import baru akan diubah statusnya menjadi 'Bebas'
            if (!empty($import->importedNoRegs)) {
                Wbp::whereNotIn('no_registrasi', $import->importedNoRegs)
                   ->update(['status' => 'Bebas']);
            }

            DB::commit();
            Artisan::call('cache:clear');

            return response()->json([
                'success' => true,
                'message' => "Database WBP telah berhasil diperbarui!"
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('WBP Import Error: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper Parsing Tanggal Kuat (Handle format Indonesia & Excel)
     */
    private function parseDate($date)
    {
        if (!$date || trim($date) == '-' || trim($date) == '') return null;
        try {
            // Coba format d/m/Y atau d-m-Y (Format Indo: 25/02/2025)
            $date = str_replace('/', '-', $date);
            return Carbon::createFromFormat('d-m-Y', trim($date))->format('Y-m-d');
        } catch (\Exception $e) {
            try {
                // Coba format Y-m-d (Format Database/Excel standar)
                return Carbon::parse($date)->format('Y-m-d');
            } catch (\Exception $x) {
                return null; // Jika gagal semua, set null
            }
        }
    }

    public function history(Wbp $wbp)
    {
        $wbp->load(['kunjungans' => function ($q) {
            $q->latest();
        }]);

        return view('admin.wbp.history', compact('wbp'));
    }

    public function create()
    {
        return view('admin.wbp.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_registrasi' => 'required|string|max:255|unique:wbps,no_registrasi',
            'nama_panggilan' => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_ekspirasi' => 'nullable|date',
            'blok' => 'nullable|string|max:255',
            'lokasi_sel' => 'nullable|string|max:255',
            'kode_tahanan' => 'nullable|string|max:255',
        ]);

        Wbp::create($request->all());

        return redirect()->route('admin.wbp.index')->with('success', 'WBP created successfully.');
    }

    public function show(Wbp $wbp)
    {
        return view('admin.wbp.show', compact('wbp'));
    }

    public function edit(Wbp $wbp)
    {
        return view('admin.wbp.edit', compact('wbp'));
    }

    public function update(Request $request, Wbp $wbp)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_registrasi' => 'required|string|max:255|unique:wbps,no_registrasi,' . $wbp->id,
            'nama_panggilan' => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'tanggal_ekspirasi' => 'nullable|date',
            'blok' => 'nullable|string|max:255',
            'lokasi_sel' => 'nullable|string|max:255',
            'kode_tahanan' => 'nullable|string|max:255',
        ]);

        $wbp->update($request->all());

        return redirect()->route('admin.wbp.index')->with('success', 'WBP updated successfully.');
    }

    /**
     * Update status multiple WBP secara massal
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:wbps,id',
            'status' => 'required|string|in:Aktif,Bebas'
        ]);

        try {
            Wbp::whereIn('id', $request->ids)->update(['status' => $request->status]);
            
            // Clear cache after update if needed
            Artisan::call('cache:clear');

            return response()->json([
                'success' => true,
                'message' => count($request->ids) . ' data WBP berhasil diubah statusnya menjadi ' . $request->status
            ]);
        } catch (\Exception $e) {
            Log::error('WBP Bulk Update Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Set pembatasan kunjungan (Mapenaling, dll) secara massal
     */
    public function setRestriction(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:wbps,id',
            'type' => 'required|string|in:Mapenaling,Strap Cell,Sidang TPP,Lainnya',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Hapus pembatasan aktif sebelumnya (jika ada overlap)
            WbpRestriction::whereIn('wbp_id', $request->ids)
                ->where('end_date', '>=', now()->toDateString())
                ->delete();

            // Insert pembatasan baru
            $data = [];
            $now = now();
            foreach ($request->ids as $wbpId) {
                $data[] = [
                    'wbp_id' => $wbpId,
                    'type' => $request->type,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'reason' => $request->reason,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            WbpRestriction::insert($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => count($request->ids) . ' data WBP berhasil dimasukkan ke tab ' . $request->type
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('WBP Set Restriction Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengatur pembatasan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cabut pembatasan kunjungan massal
     */
    public function removeRestriction(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:wbps,id',
        ]);

        try {
            // Kita percepat tanggal kadaluarsanya menjadi hari kemarin agar riwayat tetap ada tapi tidak aktif
            WbpRestriction::whereIn('wbp_id', $request->ids)
                ->where('end_date', '>=', now()->toDateString())
                ->update(['end_date' => now()->subDay()->toDateString()]);

            return response()->json([
                'success' => true,
                'message' => 'Pembatasan kunjungan berhasil dicabut untuk ' . count($request->ids) . ' WBP.'
            ]);
        } catch (\Exception $e) {
            Log::error('WBP Remove Restriction Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mencabut pembatasan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Broadcast pembatalan kunjungan untuk WBP yang dibatasi
     */
    public function broadcastRestriction(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:wbps,id',
        ]);

        try {
            $countKunjungan = 0;

            foreach ($request->ids as $wbpId) {
                $wbp = Wbp::with('activeRestriction')->find($wbpId);
                if ($wbp && $wbp->activeRestriction) {
                    $restriction = $wbp->activeRestriction;
                    
                    // Cari kunjungan yang overlapping dengan masa pembatasan
                    $kunjungans = \App\Models\Kunjungan::where('wbp_id', $wbpId)
                        ->whereIn('status', ['PENDING', 'APPROVED'])
                        ->whereDate('tanggal_kunjungan', '>=', $restriction->start_date)
                        ->whereDate('tanggal_kunjungan', '<=', $restriction->end_date)
                        ->get();

                    foreach ($kunjungans as $kunjungan) {
                        // Batalkan kunjungan tanpa memicu observer (menghindari double notifikasi)
                        $kunjungan->updateQuietly(['status' => 'REJECTED']);
                        
                        // Dispatch job broadcast khusus pembatasan
                        \App\Jobs\SendRestrictionNotificationJob::dispatch($kunjungan->id, $wbpId, $restriction->id);
                        $countKunjungan++;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Berhasil membatalkan $countKunjungan kunjungan terdampak dan menaruh notifikasi ke dalam antrean (Queue)."
            ]);
        } catch (\Exception $e) {
            Log::error('WBP Broadcast Restriction Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat broadcast: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Wbp $wbp)
    {
        $wbp->delete();

        return redirect()->route('admin.wbp.index')->with('success', 'WBP deleted successfully.');
    }
}
