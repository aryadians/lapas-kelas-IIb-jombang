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
        // 1. QUERY UTAMA
        // Menggunakan Group By NIK untuk mendapatkan list pengunjung unik.
        // Menggunakan fungsi MAX() untuk mengambil data detail (alamat, foto, dll) yang paling relevan.
        $query = Kunjungan::select(
            'nik_ktp',
            DB::raw('MAX(nama_pengunjung) as nama_pengunjung'),
            DB::raw('MAX(jenis_kelamin) as jenis_kelamin'),
            DB::raw('MAX(no_wa_pengunjung) as no_wa_pengunjung'),
            DB::raw('MAX(email_pengunjung) as email_pengunjung'),
            DB::raw('MAX(alamat_pengunjung) as alamat_pengunjung'), // <-- Ambil Alamat
            DB::raw('MAX(foto_ktp) as foto_ktp'),                   // <-- Ambil Foto KTP
            DB::raw('COUNT(*) as total_kunjungan'),                  // <-- Hitung Total Kedatangan
            DB::raw('MAX(created_at) as last_visit')                 // <-- Ambil Tanggal Terakhir
        )
            ->groupBy('nik_ktp');

        // 2. FILTER PENCARIAN
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            // Gunakan HAVING karena kita memfilter hasil Agregasi (Group By)
            $query->having('nama_pengunjung', 'LIKE', "%{$search}%")
                ->orHaving('nik_ktp', 'LIKE', "%{$search}%");
        }

        // 3. URUTKAN & PAGINATION
        // Urutkan berdasarkan yang paling baru berkunjung
        $visitors = $query->orderBy('last_visit', 'desc')->paginate(10);

        // FIX PENTING: Tambahkan parameter pencarian ke link pagination
        // Agar saat pindah ke page 2, filter pencarian tidak hilang
        $visitors->appends($request->all());

        return view('admin.visitors.index', compact('visitors'));
    }
}
