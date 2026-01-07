<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wbp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WbpController extends Controller
{
    /**
     * Menampilkan daftar WBP
     */
    public function index(Request $request)
    {
        $query = Wbp::query();

        if ($request->has('search')) {
            $search = trim($request->search); // Bersihkan spasi tidak sengaja
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                    ->orWhere('no_registrasi', 'LIKE', "%{$search}%")
                    ->orWhere('nama_panggilan', 'LIKE', "%{$search}%");
            });
        }

        // Urutkan berdasarkan waktu input terakhir agar data baru terlihat
        $wbps = $query->latest()->paginate(10);

        return view('admin.wbp.index', compact('wbps'));
    }

    /**
     * Proses Import CSV (Fix Logic)
     */
    public function import(Request $request)
    {
        // 1. Validasi File
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        // 2. Deteksi Delimiter (Pemisah ; atau ,) secara otomatis
        $handle = fopen($path, "r");
        $firstLine = fgets($handle);
        fclose($handle);

        // Prioritaskan titik koma (Format Excel Indo), kalau tidak ada baru koma
        $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';

        $imported = 0;
        $rowNumber = 0;

        if (($handle = fopen($path, "r")) !== FALSE) {

            DB::beginTransaction(); // Pakai Transaction agar aman
            try {
                // Baca baris per baris
                while (($row = fgetcsv($handle, 3000, $delimiter)) !== FALSE) {
                    $rowNumber++;

                    // SKIP HEADER: Jika baris pertama ATAU kolom pertama berisi kata "Nama"
                    if ($rowNumber == 1 || (isset($row[0]) && stripos($row[0], 'Nama') !== false)) {
                        continue;
                    }

                    // === BERSIHKAN DATA DARI KARAKTER ANEH ===
                    // Ini penting agar data terbaca oleh database
                    $cleanRow = array_map(function ($val) {
                        // Hapus karakter non-printable (BOM, Null, dll)
                        return trim(preg_replace('/[\x00-\x1F\x7F]/u', '', $val ?? ''));
                    }, $row);

                    // === MAPPING DATA SESUAI STRUKTUR EXCEL ANDA ===
                    // A [0] : Nama Lengkap
                    // B [1] : No Registrasi
                    // C [2] : Tgl Msk UPT
                    // D [3] : Tgl Ekspirasi
                    // E [4] - J [9] : Alias / Nama Kecil
                    // K [10]: Blok
                    // L [11]: Lokasi Sel

                    $nama   = $cleanRow[0] ?? '';
                    $noReg  = $cleanRow[1] ?? '';

                    // Validasi Kunci: Jika No Reg Kosong, lewati baris ini
                    if (empty($noReg)) continue;

                    // Logika Ambil Alias (Cari kolom alias pertama yang terisi)
                    $alias = null;
                    for ($i = 4; $i <= 9; $i++) {
                        if (!empty($cleanRow[$i]) && $cleanRow[$i] != '-') {
                            $alias = strtoupper($cleanRow[$i]);
                            break;
                        }
                    }

                    // Logika Ambil Lokasi
                    $blok = !empty($cleanRow[10]) ? strtoupper($cleanRow[10]) : '-';
                    $kamar = !empty($cleanRow[11]) ? strtoupper($cleanRow[11]) : '-';

                    // SIMPAN KE DATABASE
                    Wbp::updateOrCreate(
                        ['no_registrasi' => $noReg], // Cek berdasarkan No Reg
                        [
                            'nama'              => strtoupper($nama),
                            'nama_panggilan'    => $alias,
                            'tanggal_masuk'     => $this->parseDate($cleanRow[2] ?? null),
                            'tanggal_ekspirasi' => $this->parseDate($cleanRow[3] ?? null),
                            'blok'              => $blok,
                            'kamar'             => $kamar,
                        ]
                    );
                    $imported++;
                }

                DB::commit(); // Simpan perubahan permanen

            } catch (\Exception $e) {
                DB::rollBack(); // Batalkan jika ada error
                fclose($handle);
                return back()->with('error', 'Error pada baris ' . $rowNumber . ': ' . $e->getMessage());
            }
            fclose($handle);
        }

        // Feedback ke User
        if ($imported > 0) {
            return back()->with('success', "BERHASIL! $imported data WBP telah masuk ke database.");
        } else {
            return back()->with('error', 'File terbaca tapi KOSONG atau Format salah. Pastikan Save As CSV (Comma delimited).');
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

    public function history($id)
    {
        $wbp = Wbp::with(['kunjungans' => function ($q) {
            $q->latest();
        }])->findOrFail($id);

        return view('admin.wbp.history', compact('wbp'));
    }
}
