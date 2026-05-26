<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BroadcastRestrictionLog;
use App\Models\BroadcastRestrictionLogDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BroadcastRestrictionLogController extends Controller
{
    /**
     * Halaman daftar log broadcast pembatasan WBP
     */
    public function index(Request $request)
    {
        $query = BroadcastRestrictionLog::with('triggeredByUser')
            ->withCount('details');

        // Filter by date
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by triggered_by
        if ($request->filled('triggered_by')) {
            $query->where('triggered_by', $request->triggered_by);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        // Stats overview
        $stats = [
            'total'      => BroadcastRestrictionLog::count(),
            'success'    => BroadcastRestrictionLog::where('status', 'success')->count(),
            'no_impact'  => BroadcastRestrictionLog::where('status', 'no_impact')->count(),
            'failed'     => BroadcastRestrictionLog::whereIn('status', ['failed', 'partial_error'])->count(),
            'total_cancelled' => BroadcastRestrictionLog::sum('total_kunjungan_cancelled'),
        ];

        // Group by date untuk kalender mini
        $logsByDate = BroadcastRestrictionLog::selectRaw('DATE(created_at) as date, COUNT(*) as total, SUM(total_kunjungan_cancelled) as cancelled')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get()
            ->keyBy('date');

        return view('admin.restriction_logs.index', compact('logs', 'stats', 'logsByDate'));
    }

    /**
     * Detail satu sesi broadcast
     */
    public function show(BroadcastRestrictionLog $log)
    {
        $log->load(['triggeredByUser', 'details']);
        
        // Group details by WBP
        $detailsByWbp = $log->details->groupBy('wbp_nama');

        return view('admin.restriction_logs.show', compact('log', 'detailsByWbp'));
    }

    /**
     * Bulk delete log terpilih
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:broadcast_restriction_logs,id',
        ]);

        $count = BroadcastRestrictionLog::whereIn('id', $request->ids)->count();
        
        // Detail akan terhapus otomatis via CASCADE
        BroadcastRestrictionLog::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => "{$count} log broadcast berhasil dihapus.",
        ]);
    }
}
