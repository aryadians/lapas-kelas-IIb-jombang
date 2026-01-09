<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wbp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

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
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        $handle = fopen($path, "r");
        if (!$handle) {
            return response()->json(['success' => false, 'message' => 'Gagal membuka file yang diupload.']);
        }
        $firstLine = fgets($handle);
        fclose($handle);
        $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';

        $imported = 0;
        $skipped = 0;
        $rowNumber = 0;
        $processedRegistrations = []; // Array to track duplicates within the CSV

        DB::beginTransaction();
        try {
            // Hapus semua data lama sebelum import
            Wbp::query()->delete();

            if (($handle = fopen($path, "r")) !== FALSE) {
                while (($row = fgetcsv($handle, 3000, $delimiter)) !== FALSE) {
                    $rowNumber++;
                    if ($rowNumber == 1 || (isset($row[0]) && stripos($row[0], 'Nama') !== false)) {
                        continue;
                    }

                    $cleanRow = array_map(function ($val) {
                        return trim(preg_replace('/[\x00-\x1F\x7F]/u', '', $val ?? ''));
                    }, $row);

                    $noReg = $cleanRow[1] ?? '';

                    // Validasi: Lewati jika No. Reg kosong ATAU jika sudah diproses (duplikat di CSV)
                    if (empty($noReg) || in_array($noReg, $processedRegistrations)) {
                        $skipped++;
                        continue;
                    }

                    $nama = $cleanRow[0] ?? '';
                    $alias = null;
                    for ($i = 4; $i <= 9; $i++) {
                        if (!empty($cleanRow[$i]) && $cleanRow[$i] != '-') {
                            $alias = strtoupper($cleanRow[$i]);
                            break;
                        }
                    }
                    $blok = !empty($cleanRow[10]) ? strtoupper($cleanRow[10]) : '-';
                    $kamar = !empty($cleanRow[11]) ? strtoupper($cleanRow[11]) : '-';

                    Wbp::create([
                        'no_registrasi'     => $noReg,
                        'nama'              => strtoupper($nama),
                        'nama_panggilan'    => $alias,
                        'tanggal_masuk'     => $this->parseDate($cleanRow[2] ?? null),
                        'tanggal_ekspirasi' => $this->parseDate($cleanRow[3] ?? null),
                        'blok'              => $blok,
                        'kamar'             => $kamar,
                    ]);
                    $processedRegistrations[] = $noReg; // Tandai No. Reg ini sudah diproses
                    $imported++;
                }
                fclose($handle);
            }

            DB::commit();
            Artisan::call('cache:clear');

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($handle) && is_resource($handle)) {
                fclose($handle);
            }
            return response()->json([
                'success' => false, 
                'message' => 'Terjadi error pada baris ' . $rowNumber . ': ' . $e->getMessage()
            ]);
        }

        if ($imported > 0) {
            return response()->json([
                'success' => true,
                'message' => "Basis data telah diganti!",
                'stats'   => [
                    'imported' => $imported,
                    'updated'  => 0, // No longer updating
                    'skipped'  => $skipped,
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'File terbaca, namun tidak ada data valid yang dapat diimpor. Basis data tidak diubah.'
            ]);
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
            'kamar' => 'nullable|string|max:255',
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
            'kamar' => 'nullable|string|max:255',
        ]);

        $wbp->update($request->all());

        return redirect()->route('admin.wbp.index')->with('success', 'WBP updated successfully.');
    }

    public function destroy(Wbp $wbp)
    {
        $wbp->delete();

        return redirect()->route('admin.wbp.index')->with('success', 'WBP deleted successfully.');
    }
}
