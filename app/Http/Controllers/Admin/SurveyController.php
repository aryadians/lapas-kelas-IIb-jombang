<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        $query = Survey::latest();

        if ($request->filled('search')) {
            $query->where('saran', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        
        $surveys = $query->paginate(10)->withQueryString();

        // Data for Charts
        $stats = DB::table('surveys')
            ->select(
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as sangat_baik'),
                DB::raw('SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as baik'),
                DB::raw('SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as cukup'),
                DB::raw('SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as buruk')
            )
            ->first();

        // Handle case where there are no surveys yet
        if (!$stats->total > 0) {
            $stats = (object)[
                'total' => 0,
                'sangat_baik' => 0,
                'baik' => 0,
                'cukup' => 0,
                'buruk' => 0,
            ];
        }

        $averageRating = DB::table('surveys')->avg('rating');

        return view('admin.surveys.index', [
            'surveys' => $surveys,
            'stats' => $stats,
            'averageRating' => $averageRating,
        ]);
    }

    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('admin.surveys.index')->with('success', 'Data survey berhasil dihapus.');
    }
}
