<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wbp;
use App\Models\WbpRestriction;
use App\Models\BroadcastRestrictionLog;
use App\Models\BroadcastRestrictionLogDetail;
use App\Enums\KunjunganStatus;
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
        $query = Wbp::query();

        // Filter Status (Default: Aktif)
        $status = $request->get('status', 'Aktif');
        $restrictionTypes = ['Mapenaling', 'Strap Cell', 'Sidang'];

        if (in_array($status, $restrictionTypes)) {
            // Khusus untuk tab pembatasan, tampilkan hanya yang terkait
            $query->whereHas('latestRestriction', function ($q) use ($status) {
                $q->where('type', $status);
            });
        } elseif ($status === 'Aktif') {
            // Tab Aktif: Sembunyikan WBP yang sedang dibatasi
            $query->where('status', 'Aktif')->whereDoesntHave('latestRestriction');
        } elseif ($status !== 'Semua') {
            // Tab lain
            $query->where('status', $status);
        }

        if ($request->has('search')) {
            $search = trim($request->search);
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

        // Load relasi setelah filter & sort
        $query->with('latestRestriction');

        $limit = $request->get('limit', 15);
        if ($limit === 'all') {
            $wbps = $query->paginate(999999)->withQueryString();
        } else {
            $wbps = $query->paginate((int)$limit)->withQueryString();
        }

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



            DB::commit();
            Artisan::call('cache:clear');

            $totalImported = count($import->importedNoRegs);
            return response()->json([
                'success' => true,
                'message' => "Database WBP telah berhasil diperbarui! Total {$totalImported} WBP diproses."
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
            'type' => 'required|string|in:Mapenaling,Strap Cell,Sidang,Lainnya',
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
     * Broadcast manual pembatalan kunjungan untuk WBP yang dibatasi.
     * Setiap eksekusi disimpan ke broadcast_restriction_logs untuk audit trail.
     */
    public function broadcastRestriction(Request $request)
    {
        $request->validate([
            'ids'   => 'nullable|array',
            'ids.*' => 'exists:wbps,id',
        ]);

        $startTime               = now();
        $totalWbpProcessed       = 0;
        $totalWbpNoRestriction   = 0;
        $totalKunjunganCancelled = 0;
        $totalNotifQueued        = 0;
        $hasError                = false;
        $logDetails              = [];

        $targetIds = $request->get('ids');
        if (empty($targetIds)) {
            $targetIds = Wbp::whereHas('latestRestriction')->pluck('id')->toArray();
        }

        try {
            foreach ($targetIds as $wbpId) {
                $wbp = Wbp::with(['latestRestriction'])->find($wbpId);
                $totalWbpProcessed++;

                if (!$wbp || !$wbp->latestRestriction) {
                    $totalWbpNoRestriction++;
                    Log::warning("Broadcast restriction: WBP {$wbpId} tidak memiliki restriction aktif/mendatang.");
                    $logDetails[] = [
                        'wbp_id'            => $wbpId,
                        'wbp_nama'          => $wbp?->nama ?? "WBP #{$wbpId}",
                        'restriction_type'  => null,
                        'restriction_start' => null,
                        'restriction_end'   => null,
                        'kunjungan_id'      => null,
                        'kode_booking'      => null,
                        'tanggal_kunjungan' => null,
                        'pengunjung_nama'   => null,
                        'pengunjung_wa'     => null,
                        'pengunjung_email'  => null,
                        'wa_queued'         => false,
                        'email_queued'      => false,
                        'action'            => 'no_restriction',
                        'error_message'     => null,
                    ];
                    continue;
                }

                $restriction = $wbp->latestRestriction;

                $kunjungans = \App\Models\Kunjungan::with('profilPengunjung')
                    ->where('wbp_id', $wbpId)
                    ->whereIn('status', [
                        KunjunganStatus::PENDING->value,
                        KunjunganStatus::APPROVED->value,
                    ])
                    ->whereDate('tanggal_kunjungan', '>=', $restriction->start_date)
                    ->whereDate('tanggal_kunjungan', '<=', $restriction->end_date)
                    ->get();

                Log::info("[ManualBroadcast] WBP {$wbp->nama} (id:{$wbpId}) | {$restriction->start_date} s.d. {$restriction->end_date} | Terdampak: {$kunjungans->count()}");

                if ($kunjungans->isEmpty()) {
                    $logDetails[] = [
                        'wbp_id'            => $wbp->id,
                        'wbp_nama'          => $wbp->nama,
                        'restriction_type'  => $restriction->type,
                        'restriction_start' => $restriction->start_date,
                        'restriction_end'   => $restriction->end_date,
                        'kunjungan_id'      => null,
                        'kode_booking'      => null,
                        'tanggal_kunjungan' => null,
                        'pengunjung_nama'   => null,
                        'pengunjung_wa'     => null,
                        'pengunjung_email'  => null,
                        'wa_queued'         => false,
                        'email_queued'      => false,
                        'action'            => 'no_kunjungan',
                        'error_message'     => null,
                    ];
                    continue;
                }

                foreach ($kunjungans as $kunjungan) {
                    try {
                        $kunjungan->updateQuietly(['status' => KunjunganStatus::REJECTED]);
                        \App\Jobs\SendRestrictionNotificationJob::dispatch($kunjungan->id, $wbpId, $restriction->id);

                        $profil = $kunjungan->profilPengunjung;
                        $logDetails[] = [
                            'wbp_id'            => $wbp->id,
                            'wbp_nama'          => $wbp->nama,
                            'restriction_type'  => $restriction->type,
                            'restriction_start' => $restriction->start_date,
                            'restriction_end'   => $restriction->end_date,
                            'kunjungan_id'      => $kunjungan->id,
                            'kode_booking'      => $kunjungan->kode_booking,
                            'tanggal_kunjungan' => $kunjungan->tanggal_kunjungan,
                            'pengunjung_nama'   => $profil?->nama ?? $kunjungan->nama_pengunjung ?? '-',
                            'pengunjung_wa'     => $profil?->nomor_hp ?? $kunjungan->no_wa_pengunjung ?? '-',
                            'pengunjung_email'  => $profil?->email ?? $kunjungan->email_pengunjung ?? '-',
                            'wa_queued'         => true,
                            'email_queued'      => false,
                            'action'            => 'cancelled',
                            'error_message'     => null,
                        ];
                        $totalKunjunganCancelled++;
                        $totalNotifQueued++;
                    } catch (\Exception $e) {
                        $hasError = true;
                        Log::error("[ManualBroadcast] Error kunjungan #{$kunjungan->id}: " . $e->getMessage());
                        $logDetails[] = [
                            'wbp_id'            => $wbp->id,
                            'wbp_nama'          => $wbp->nama,
                            'restriction_type'  => $restriction->type,
                            'restriction_start' => $restriction->start_date,
                            'restriction_end'   => $restriction->end_date,
                            'kunjungan_id'      => $kunjungan->id,
                            'kode_booking'      => $kunjungan->kode_booking,
                            'tanggal_kunjungan' => $kunjungan->tanggal_kunjungan,
                            'pengunjung_nama'   => null,
                            'pengunjung_wa'     => null,
                            'pengunjung_email'  => null,
                            'wa_queued'         => false,
                            'email_queued'      => false,
                            'action'            => 'error',
                            'error_message'     => $e->getMessage(),
                        ];
                    }
                }
            }

            // Tentukan status akhir
            $status = 'success';
            if ($totalKunjunganCancelled === 0 && !$hasError) {
                $status = 'no_impact';
            } elseif ($hasError && $totalKunjunganCancelled > 0) {
                $status = 'partial_error';
            } elseif ($hasError) {
                $status = 'failed';
            }

            $notes = "Manual broadcast oleh admin. WBP dipilih: {$totalWbpProcessed}. "
                   . "Tanpa restriction: {$totalWbpNoRestriction}. "
                   . "Kunjungan dibatalkan: {$totalKunjunganCancelled}. "
                   . "Durasi: " . now()->diffInSeconds($startTime) . " detik.";

            // Simpan log utama
            $log = BroadcastRestrictionLog::create([
                'triggered_by'               => 'manual',
                'triggered_by_user_id'       => auth()->id(),
                'total_wbp_processed'        => $totalWbpProcessed,
                'total_wbp_no_restriction'   => $totalWbpNoRestriction,
                'total_kunjungan_cancelled'  => $totalKunjunganCancelled,
                'total_notifications_queued' => $totalNotifQueued,
                'status'                     => $status,
                'notes'                      => $notes,
            ]);

            // Simpan detail per kunjungan
            foreach ($logDetails as $detail) {
                $detail['broadcast_restriction_log_id'] = $log->id;
                BroadcastRestrictionLogDetail::create($detail);
            }

            Log::info("[ManualBroadcast] DONE | log_id: {$log->id} | status: {$status}");

            if ($totalKunjunganCancelled === 0) {
                $extra = $totalWbpNoRestriction > 0
                    ? " ({$totalWbpNoRestriction} WBP tanpa data pembatasan aktif.)"
                    : '';
                return response()->json([
                    'success'  => true,
                    'message'  => "Broadcast selesai. Tidak ada kunjungan (Pending/Disetujui) yang perlu dibatalkan selama masa pembatasan ini. Kemungkinan belum ada pengunjung yang mendaftar untuk WBP tersebut.{$extra}",
                    'log_id'   => $log->id,
                ]);
            }

            return response()->json([
                'success'  => true,
                'message'  => "Berhasil membatalkan {$totalKunjunganCancelled} kunjungan terdampak dan menaruh notifikasi ke dalam antrean (Queue).",
                'log_id'   => $log->id,
            ]);

        } catch (\Exception $e) {
            Log::error('[ManualBroadcast] Fatal Error: ' . $e->getMessage());

            // Simpan log error
            BroadcastRestrictionLog::create([
                'triggered_by'               => 'manual',
                'triggered_by_user_id'       => auth()->id(),
                'total_wbp_processed'        => $totalWbpProcessed,
                'total_wbp_no_restriction'   => $totalWbpNoRestriction,
                'total_kunjungan_cancelled'  => $totalKunjunganCancelled,
                'total_notifications_queued' => $totalNotifQueued,
                'status'                     => 'failed',
                'notes'                      => 'FATAL ERROR: ' . $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat broadcast: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Wbp $wbp)
    {
        $wbp->delete();

        return redirect()->route('admin.wbp.index')->with('success', 'WBP deleted successfully.');
    }
}
