<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialReport;
use App\Models\ReportCategory;
use Illuminate\Http\Request;

class ReportCategoryController extends Controller
{
    /**
     * Simpan kategori baru (dari form create laporan).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100|unique:report_categories,name',
            'icon'  => 'nullable|string|max:50',
            'emoji' => 'nullable|string|max:10',
        ]);

        ReportCategory::create([
            'name'       => trim($request->name),
            'icon'       => $request->icon  ?: 'fa-file-alt',
            'emoji'      => $request->emoji ?: null,
            'sort_order' => ReportCategory::max('sort_order') + 1,
        ]);

        return response()->json([
            'success'  => true,
            'message'  => "Kategori \"{$request->name}\" berhasil ditambahkan.",
            'category' => ['name' => trim($request->name), 'icon' => $request->icon ?: 'fa-file-alt', 'emoji' => $request->emoji],
        ]);
    }

    /**
     * Hapus kategori.
     */
    public function destroy(ReportCategory $reportCategory)
    {
        $inUse = FinancialReport::where('category', $reportCategory->name)->count();

        if ($inUse > 0) {
            return response()->json([
                'success' => false,
                'message' => "Tidak bisa dihapus. Kategori \"{$reportCategory->name}\" masih digunakan oleh {$inUse} laporan.",
            ], 422);
        }

        $reportCategory->delete();

        return response()->json([
            'success' => true,
            'message' => "Kategori \"{$reportCategory->name}\" berhasil dihapus.",
        ]);
    }

    /**
     * API: list kategori untuk picker (JSON).
     */
    public function index()
    {
        $categories = ReportCategory::ordered()->get(['id', 'name', 'icon', 'emoji']);
        return response()->json($categories);
    }
}
