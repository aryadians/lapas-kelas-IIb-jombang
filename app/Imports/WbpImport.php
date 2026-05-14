<?php

namespace App\Imports;

use App\Models\Wbp;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class WbpImport implements ToCollection, SkipsEmptyRows, WithChunkReading
{
    public $importedNoRegs = [];

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        // Tingkatkan limit waktu eksekusi untuk file besar
        set_time_limit(300);

        foreach ($rows as $index => $row) {
            $data = $row->values()->toArray();

            // Log untuk debug setiap baris
            Log::info("Processing WBP Index $index: " . json_encode($data));

            // 1. Deteksi Header
            if ($this->isHeader($row)) {
                Log::info("Row $index skipped as header");
                continue;
            }

            // 2. Validasi Struktur Minimal
            if (count($data) < 2) {
                Log::info("Row $index skipped: count < 2");
                continue;
            }

            $nama  = isset($data[0]) ? trim((string)$data[0]) : null;
            $noReg = isset($data[1]) ? trim((string)$data[1]) : null;

            // 3. Validasi Data Inti
            if (empty($nama) || empty($noReg) || strtoupper($nama) === 'NAMA LENGKAP') {
                Log::info("Row $index skipped: Invalid data - Nama: '$nama', NoReg: '$noReg'");
                continue;
            }

            // 4. Pengolahan Alias / Nama Panggilan (Kolom 4 - 9)
            $aliasParts = [];
            for ($i = 4; $i <= 9; $i++) {
                $val = isset($data[$i]) ? trim((string)$data[$i]) : '';
                if ($val !== '' && $val !== '-') {
                    $aliasParts[] = $val;
                }
            }
            $namaPanggilan = !empty($aliasParts) ? implode(', ', array_unique($aliasParts)) : '-';

            // 5. Transformasi Data Tambahan
            $tglMasuk     = isset($data[2]) ? $this->transformDate($data[2]) : null;
            $tglEkspirasi = isset($data[3]) ? $this->transformDate($data[3]) : null;
            $blok         = (!empty($data[10]) && trim((string)$data[10]) !== '-') ? trim((string)$data[10]) : '-';
            $lokasiSel    = (!empty($data[11]) && trim((string)$data[11]) !== '-') ? trim((string)$data[11]) : '-';

            // 6. Inferred Kode Tahanan (A/B)
            $inferredKode = null;
            $firstChar    = strtoupper(substr(trim($noReg), 0, 1));
            if (in_array($firstChar, ['A', 'B'])) {
                $inferredKode = $firstChar;
            }

            // 7. Eksekusi Database
            try {
                $wbp = Wbp::where('no_registrasi', $noReg)->first();

                if ($wbp) {
                    $wbp->update([
                        'nama'              => strtoupper($nama),
                        'kode_tahanan'      => $inferredKode,
                        'nama_panggilan'    => strtoupper($namaPanggilan),
                        'tanggal_masuk'     => $tglMasuk,
                        'tanggal_ekspirasi' => $tglEkspirasi,
                        'blok'              => $blok,
                        'lokasi_sel'        => $lokasiSel,
                    ]);
                } else {
                    Wbp::create([
                        'no_registrasi'     => $noReg,
                        'nama'              => strtoupper($nama),
                        'kode_tahanan'      => $inferredKode,
                        'nama_panggilan'    => strtoupper($namaPanggilan),
                        'tanggal_masuk'     => $tglMasuk,
                        'tanggal_ekspirasi' => $tglEkspirasi,
                        'blok'              => $blok,
                        'lokasi_sel'        => $lokasiSel,
                        'status'            => 'Aktif',
                    ]);
                }
            } catch (Exception $e) {
                Log::error("Gagal memproses baris ke-" . ($index + 1) . ": " . $e->getMessage());
            }
        }
    }

    /**
     * Logika pendeteksi header.
     */
    private function isHeader($row)
    {
        $firstCell = trim(strtolower((string)$row->first()));
        return str_contains($firstCell, 'nama') || 
               str_contains($firstCell, 'no. registrasi') || 
               $firstCell === '';
    }

    /**
     * Konfigurasi Chunk Size.
     */
    public function chunkSize(): int
    {
        return 10; 
    }

    /**
     * Helper untuk konversi tanggal Excel/String ke format Y-m-d.
     */
    private function transformDate($value)
    {
        if (empty($value) || $value === '-' || $value === '00/00/0000') {
            return null;
        }

        try {
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            }
            
            $cleanDate = str_replace('/', '-', $value);
            return Carbon::parse($cleanDate)->format('Y-m-d');
        } catch (Exception $e) {
            Log::warning("Format tanggal tidak valid: " . $value);
            return null;
        }
    }
}
