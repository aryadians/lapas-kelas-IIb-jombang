<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialReport;
use App\Models\ReportCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportCategoryController extends Controller
{
    /**
     * Tampilkan halaman manajemen kategori.
     */
    public function index()
    {
        $categories = ReportCategory::ordered()->get();
        
        if (request()->wantsJson()) {
            return response()->json($categories);
        }

        return view('admin.report_categories.index', compact('categories'));
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100|unique:report_categories,name',
            'icon'  => 'nullable|string|max:50',
            'emoji' => 'nullable|string|max:10',
        ]);

        $category = ReportCategory::create([
            'name'       => trim($request->name),
            'icon'       => $request->icon  ?: 'fa-file-alt',
            'emoji'      => $request->emoji ?: null,
            'sort_order' => ReportCategory::max('sort_order') + 1,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'  => true,
                'message'  => "Kategori \"{$request->name}\" berhasil ditambahkan.",
                'category' => $category,
            ]);
        }

        return redirect()->route('admin.report-categories.index')->with('success', "Kategori \"{$request->name}\" berhasil ditambahkan.");
    }

    /**
     * Update kategori.
     */
    public function update(Request $request, ReportCategory $reportCategory)
    {
        $request->validate([
            'name'  => 'required|string|max:100|unique:report_categories,name,' . $reportCategory->id,
            'icon'  => 'nullable|string|max:50',
            'emoji' => 'nullable|string|max:10',
            'sort_order' => 'nullable|integer',
        ]);

        $oldName = $reportCategory->name;
        $newName = trim($request->name);

        DB::transaction(function () use ($reportCategory, $oldName, $newName, $request) {
            $reportCategory->update([
                'name'       => $newName,
                'icon'       => $request->icon  ?: 'fa-file-alt',
                'emoji'      => $request->emoji ?: null,
                'sort_order' => $request->sort_order ?? $reportCategory->sort_order,
            ]);

            // Jika nama berubah, update semua laporan yang menggunakan kategori ini
            if ($oldName !== $newName) {
                FinancialReport::where('category', $oldName)->update(['category' => $newName]);
            }
        });

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Kategori \"{$newName}\" berhasil diperbarui.",
                'category' => $reportCategory,
            ]);
        }

        return redirect()->route('admin.report-categories.index')->with('success', "Kategori \"{$newName}\" berhasil diperbarui.");
    }

    /**
     * Hapus kategori.
     */
    public function destroy(ReportCategory $reportCategory)
    {
        $inUse = FinancialReport::where('category', $reportCategory->name)->count();

        if ($inUse > 0) {
            $msg = "Tidak bisa dihapus. Kategori \"{$reportCategory->name}\" masih digunakan oleh {$inUse} laporan.";
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }

        $reportCategory->delete();

        $msg = "Kategori \"{$reportCategory->name}\" berhasil dihapus.";
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => $msg]);
        }
        return redirect()->route('admin.report-categories.index')->with('success', $msg);
    }
}
