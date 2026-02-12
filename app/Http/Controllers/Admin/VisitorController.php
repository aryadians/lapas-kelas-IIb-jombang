<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilPengunjung;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

use App\Exports\VisitorExport;
use Maatwebsite\Excel\Facades\Excel;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $query = ProfilPengunjung::query()
            ->withCount('kunjungans')
            ->with(['kunjungans' => function($q) {
                $q->latest('tanggal_kunjungan')->limit(1);
            }]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('nik', 'LIKE', "%{$search}%");
            });
        }

        $visitors = $query->latest()->paginate(10);
        $visitors->appends($request->all());

        // Transform collection to set foto_ktp from latest visit
        $visitors->getCollection()->transform(function ($visitor) {
            $latestKunjungan = $visitor->kunjungans->first();
            $visitor->foto_ktp = $latestKunjungan ? $latestKunjungan->foto_ktp : null;
            $visitor->total_kunjungan = $visitor->kunjungans_count;
            $visitor->last_visit = $latestKunjungan ? $latestKunjungan->tanggal_kunjungan : null;
            return $visitor;
        });

        return view('admin.visitors.index', compact('visitors'));
    }

    public function destroy(ProfilPengunjung $visitor)
    {
        $visitor->delete();
        return back()->with('success', 'Data pengunjung berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return back()->with('error', 'Pilih data yang ingin dihapus terlebih dahulu.');
        }

        ProfilPengunjung::whereIn('id', $ids)->delete();
        return back()->with('success', count($ids) . ' data pengunjung berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new VisitorExport, 'database_pengunjung_' . date('Ymd_His') . '.xlsx');
    }

    public function getHistory($id)
    {
        $visitor = ProfilPengunjung::findOrFail($id);
        $history = Kunjungan::where('nik_ktp', $visitor->nik)
            ->with('wbp')
            ->latest('tanggal_kunjungan')
            ->get();

        return response()->json([
            'visitor' => $visitor,
            'history' => $history
        ]);
    }

    public function exportCsv()
    {
        $filename = "database_pengunjung_" . date('Ymd_His') . ".csv";
        
        $response = new StreamedResponse(function() {
            $handle = fopen('php://output', 'w');
            
            // Add BOM for Excel compatibility with UTF-8
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header
            fputcsv($handle, ['ID', 'NIK', 'Nama', 'Jenis Kelamin', 'Nomor HP', 'Email', 'Alamat', 'Dibuat Pada']);

            // Data
            ProfilPengunjung::chunk(200, function($visitors) use ($handle) {
                foreach ($visitors as $visitor) {
                    fputcsv($handle, [
                        $visitor->id,
                        $visitor->nik,
                        $visitor->nama,
                        $visitor->jenis_kelamin,
                        $visitor->nomor_hp,
                        $visitor->email,
                        $visitor->alamat,
                        $visitor->created_at
                    ]);
                }
            });

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
