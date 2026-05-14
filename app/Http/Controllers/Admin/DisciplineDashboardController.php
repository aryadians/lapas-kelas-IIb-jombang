<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wbp;
use App\Models\WbpRestriction;
use Illuminate\Support\Facades\DB;

class DisciplineDashboardController extends Controller
{
    public function index()
    {
        // Stats: Count by Type
        $statsByType = WbpRestriction::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type');

        // Top Violators (Most frequent restrictions)
        $topViolators = WbpRestriction::select('wbp_id', DB::raw('count(*) as total_restrictions'))
            ->groupBy('wbp_id')
            ->orderBy('total_restrictions', 'desc')
            ->with('wbp')
            ->limit(10)
            ->get();

        // Restrictions by month
        $monthlyData = WbpRestriction::select(
                DB::raw('MONTH(start_date) as month'),
                DB::raw('count(*) as total')
            )
            ->whereYear('start_date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        return view('admin.discipline.index', compact('statsByType', 'topViolators', 'monthlyData'));
    }
}
