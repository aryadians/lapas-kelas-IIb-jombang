<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilPengunjung;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

use App\Exports\VisitorExport;
use App\Exports\FollowerExport;
use App\Models\Pengikut;
use Maatwebsite\Excel\Facades\Excel;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $query = ProfilPengunjung::query()
            ->withCount('kunjungans')
            ->with(['kunjungans' => function($q) {
                $q->with('wbp')->latest('tanggal_kunjungan')->limit(1);
            }]);

        // 1. Filter Pencarian Nama/NIK
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('nik', 'LIKE', "%{$search}%");
            });
        }

        // 2. Filter Wilayah (Alamat)
        if ($request->filled('wilayah')) {
            $query->where('alamat', 'LIKE', '%' . $request->wilayah . '%');
        }

        // 3. Filter Foto KTP
        if ($request->filled('has_foto')) {
            if ($request->has_foto === 'yes') {
                $query->whereHas('kunjungans', function($q) {
                    $q->whereNotNull('foto_ktp');
                });
            } else {
                $query->whereDoesntHave('kunjungans', function($q) {
                    $q->whereNotNull('foto_ktp');
                });
            }
        }

        // 4. Pengurutan
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'latest_visit':
                $query->leftJoin('kunjungans', function($join) {
                    $join->on('profil_pengunjungs.nik', '=', 'kunjungans.nik_ktp')
                        ->whereRaw('kunjungans.id IN (select MAX(id) from kunjungans group by nik_ktp)');
                })
                ->select('profil_pengunjungs.*')
                ->orderBy('kunjungans.tanggal_kunjungan', 'desc');
                break;
            case 'most_visited':
                $query->orderBy('kunjungans_count', 'desc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $limit = $request->get('limit', 10);
        if ($limit === 'all') {
            $visitors = $query->paginate(999999);
        } else {
            $visitors = $query->paginate((int)$limit);
        }
        $visitors->appends($request->all());

        $visitors->getCollection()->transform(function ($visitor) {
            $latestKunjungan = $visitor->kunjungans->first();
            $visitor->foto_ktp = $visitor->image ?: ($latestKunjungan ? $latestKunjungan->foto_ktp : null);
            $visitor->total_kunjungan = $visitor->kunjungans_count;
            $visitor->last_visit = $latestKunjungan ? $latestKunjungan->tanggal_kunjungan : null;
            $visitor->last_wbp = $latestKunjungan && $latestKunjungan->wbp ? $latestKunjungan->wbp->nama : '-';
            return $visitor;
        });

        return view('admin.visitors.index', compact('visitors'));
    }

    public function followers(Request $request)
    {
        // Mendapatkan pengikut unik (berdasarkan NIK atau Nama) dengan data kunjungan terbaru
        $allFollowers = Pengikut::with(['kunjungan.profilPengunjung', 'kunjungan.wbp'])
            ->whereIn('id', function($q) {
                $q->select(DB::raw('MAX(id)'))
                    ->from('pengikuts')
                    ->groupBy(DB::raw('COALESCE(nik, nama)'));
            })
            ->when($request->search, function($q) use ($request) {
                $search = $request->search;
                $q->where(function($sq) use ($search) {
                    $sq->where('nama', 'LIKE', "%{$search}%")
                      ->orWhere('nik', 'LIKE', "%{$search}%");
                });
            })
            ->get();

        $limit = $request->get('limit', 15);
        $perPage = ($limit === 'all') ? 999999 : (int)$limit;
        $page = $request->get('page', 1);
        $followers = new \Illuminate\Pagination\LengthAwarePaginator(
            $allFollowers->forPage($page, $perPage),
            $allFollowers->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.visitors.followers', compact('followers'));
    }

    public function exportFollowersExcel()
    {
        return Excel::download(new FollowerExport, 'database_pengikut_' . date('Ymd_His') . '.xlsx');
    }

    public function exportFollowersPdf()
    {
        // Mendapatkan pengikut unik dengan kunjungan terbaru (sama seperti di view)
        $followers = Pengikut::with(['kunjungan.profilPengunjung', 'kunjungan.wbp'])
            ->whereIn('id', function($q) {
                $q->select(DB::raw('MAX(id)'))
                    ->from('pengikuts')
                    ->groupBy(DB::raw('COALESCE(nik, nama)'));
            })
            ->orderBy('nama')
            ->get();

        return view('admin.visitors.followers-pdf', compact('followers'));
    }

    public function destroy(ProfilPengunjung $visitor)
    {
        DB::transaction(function() use ($visitor) {
            // Hapus kunjungan & pengikut terkait (berdasarkan NIK karena relasi string)
            $kunjunganIds = Kunjungan::where('nik_ktp', $visitor->nik)->pluck('id');
            Pengikut::whereIn('kunjungan_id', $kunjunganIds)->delete();
            Kunjungan::whereIn('id', $kunjunganIds)->delete();
            
            $visitor->delete();
        });

        return back()->with('success', 'Data pengunjung dan riwayat terkait berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return back()->with('error', 'Pilih data yang ingin dihapus terlebih dahulu.');
        }

        DB::transaction(function() use ($ids) {
            $niks = ProfilPengunjung::whereIn('id', $ids)->pluck('nik');
            $kunjunganIds = Kunjungan::whereIn('nik_ktp', $niks)->pluck('id');
            
            Pengikut::whereIn('kunjungan_id', $kunjunganIds)->delete();
            Kunjungan::whereIn('id', $kunjunganIds)->delete();
            ProfilPengunjung::whereIn('id', $ids)->delete();
        });

        return back()->with('success', count($ids) . ' data pengunjung dan riwayat terkait berhasil dihapus.');
    }

    public function deleteAll()
    {
        DB::transaction(function() {
            Pengikut::query()->delete();
            Kunjungan::query()->delete();
            ProfilPengunjung::query()->delete();
        });

        return back()->with('success', 'Seluruh data pengunjung dan riwayat telah berhasil dikosongkan.');
    }

    public function bulkDestroyFollowers(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return back()->with('error', 'Pilih data yang ingin dihapus terlebih dahulu.');
        }

        // Karena satu orang pengikut bisa punya banyak record di tabel pengikuts (tiap kunjungan),
        // kita hapus berdasarkan Nama/NIK yang dipilih.
        $followersToDelete = Pengikut::whereIn('id', $ids)->get();
        
        DB::transaction(function() use ($followersToDelete) {
            foreach ($followersToDelete as $f) {
                if ($f->nik) {
                    Pengikut::where('nik', $f->nik)->delete();
                } else {
                    Pengikut::where('nama', $f->nama)->delete();
                }
            }
        });

        return back()->with('success', 'Data pengikut terpilih berhasil dihapus dari database.');
    }

    public function deleteAllFollowers()
    {
        Pengikut::query()->delete();
        return back()->with('success', 'Seluruh data pengikut telah berhasil dikosongkan.');
    }

    public function exportPdf()
    {
        $visitors = ProfilPengunjung::with('kunjungans.wbp')->get();
        return view('admin.visitors.pdf', compact('visitors'));
    }

    public function exportExcel()
    {
        return Excel::download(new VisitorExport, 'database_pengunjung_' . date('Ymd_His') . '.xlsx');
    }

    public function deleteOldVisitors()
    {
        $count = ProfilPengunjung::where('created_at', '<', now()->subMonth())->delete();
        Log::info("Auto-cleanup: Deleted $count visitor profiles older than 1 month.");
        return $count;
    }

    public function getHistory($id)
    {
        try {
            Log::info("Fetching history for visitor ID: $id");
            $visitor = ProfilPengunjung::findOrFail($id);
            
            $history = Kunjungan::where('nik_ktp', $visitor->nik)
                ->with(['wbp:id,nama,no_registrasi', 'pengikuts'])
                ->latest('tanggal_kunjungan')
                ->get();

            return response()->json([
                'success' => true,
                'visitor' => $visitor,
                'history' => $history
            ]);
        } catch (\Exception $e) {
            Log::error("History Error for ID $id: " . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Gagal sinkronisasi data riwayat: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportCsv()
    {
        $filename = "database_pengunjung_" . date('Ymd_His') . ".csv";
        
        $response = new StreamedResponse(function() {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($handle, ['ID', 'NIK', 'Nama', 'Jenis Kelamin', 'Nomor HP', 'Email', 'Alamat', 'Dibuat Pada']);

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
