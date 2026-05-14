<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wbp;
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

        $query = Wbp::query();

        // Filter Status (Default: Aktif)
        $status = $request->get('status', 'Aktif');
        if ($status !== 'Semua') {
            $query->where('status', $status);
        }

        if ($request->has('search')) {
            $search = trim($request->search); // Bersihkan spasi tidak sengaja
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                    ->orWhere('no_registrasi', 'LIKE', "%{$search}%")
                    ->orWhere('nama_panggilan', 'LIKE', "%{$search}%");
            });
        }

        // Urutkan berdasarkan waktu input terakhir agar data baru terlihat
        $wbps = $query->latest()->paginate(15)->withQueryString();

        return view('admin.wbp.index', compact('wbps', 'status'));
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

    public function destroy(Wbp $wbp)
    {
        $wbp->delete();

        return redirect()->route('admin.wbp.index')->with('success', 'WBP deleted successfully.');
    }
}
