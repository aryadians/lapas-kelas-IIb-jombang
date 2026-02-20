<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Exports\FinancialReportExport;
use Maatwebsite\Excel\Facades\Excel;

class FinancialReportController extends Controller
{
    public function index(Request $request)
    {
        $query = FinancialReport::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        $reports = $query->latest()->paginate(10);
        return view('admin.financial_reports.index', compact('reports'));
    }

    public function create()
    {
        return view('admin.financial_reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'description' => 'nullable|string',
        ]);

        $filePath = $request->file('file')->store('public/reports');

        FinancialReport::create([
            'title' => $request->title,
            'category' => $request->category,
            'year' => $request->year,
            'description' => $request->description,
            'file_path' => $filePath,
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('admin.financial-reports.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function edit(FinancialReport $financialReport)
    {
        return view('admin.financial_reports.edit', compact('financialReport'));
    }

    public function update(Request $request, FinancialReport $financialReport)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'year' => 'required|integer',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        $data = [
            'title' => $request->title,
            'category' => $request->category,
            'year' => $request->year,
            'description' => $request->description,
            'is_published' => $request->has('is_published'),
        ];

        if ($request->hasFile('file')) {
            Storage::delete($financialReport->file_path);
            $data['file_path'] = $request->file('file')->store('public/reports');
        }

        $financialReport->update($data);

        return redirect()->route('admin.financial-reports.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(FinancialReport $financialReport)
    {
        Storage::delete($financialReport->file_path);
        $financialReport->delete();

        return redirect()->route('admin.financial-reports.index')->with('success', 'Laporan berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return back()->with('error', 'Pilih data yang ingin dihapus.');
        }

        $reports = FinancialReport::whereIn('id', $ids)->get();
        foreach ($reports as $report) {
            Storage::delete($report->file_path);
            $report->delete();
        }

        return back()->with('success', count($ids) . ' laporan berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new FinancialReportExport, 'Laporan_Publik_Lapas_Jombang_' . date('Ymd') . '.xlsx');
    }

    public function exportPdf()
    {
        $reports = FinancialReport::all();
        return view('admin.financial_reports.export_pdf', compact('reports'));
    }
}
