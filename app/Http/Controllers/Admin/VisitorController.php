<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $query = Kunjungan::select(
                'nama_pengunjung',
                'nik_ktp',
                'no_wa_pengunjung',
                'email_pengunjung',
                DB::raw('COUNT(id) as total_kunjungan'),
                DB::raw('MAX(tanggal_kunjungan) as terakhir_berkunjung')
            )
            ->groupBy('nama_pengunjung', 'nik_ktp', 'no_wa_pengunjung', 'email_pengunjung')
            ->orderBy('terakhir_berkunjung', 'desc');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pengunjung', 'LIKE', "%{$search}%")
                  ->orWhere('nik_ktp', 'LIKE', "%{$search}%");
            });
        }

        $visitors = $query->paginate(12);

        return view('admin.visitors.index', compact('visitors'));
    }
}
