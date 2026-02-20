<?php

namespace App\Imports;

use App\Models\Wbp;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class WbpImport implements ToCollection, SkipsEmptyRows
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        $processedRegistrations = [];

        foreach ($rows as $index => $row) {
            // Lewati header jika baris pertama mengandung kata kunci tertentu
            if ($index === 0 && $this->isHeader($row)) {
                continue;
            }

            $data = $row->values()->toArray();
            
            $nama = null;
            $noReg = null;
            $alias = null;
            $tglMasuk = null;
            $tglEkspirasi = null;
            $blok = '-';
            $kamar = '-';

            // LOGIKA DETEKSI KOLOM (FLEXIBLE)
            foreach ($data as $cellIndex => $cell) {
                if (is_null($cell) || $cell === '') continue;
                $cell = trim((string)$cell);

                // 1. Deteksi No Registrasi (Pola khas: Huruf + Angka + Garis Miring)
                if (!$noReg && preg_match('/^[AB]\.?\s?[I|V]?/i', $cell) && str_contains($cell, '/')) {
                    $noReg = strtoupper($cell);
                    continue;
                }

                // 2. Deteksi Nama (String panjang, tanpa angka, bukan No Reg)
                if (!$nama && strlen($cell) > 3 && !preg_match('/[0-9]/', $cell) && !str_contains($cell, '/')) {
                    $nama = strtoupper($cell);
                    continue;
                }

                // 3. Deteksi Tanggal (Jika cell formatnya date atau string tanggal)
                if (preg_match('/^\d{1,2}[\/\-]\d{1,2}[\/\-]\d{2,4}$/', $cell) || is_numeric($cell) && $cell > 30000) {
                    if (!$tglMasuk) {
                        $tglMasuk = $this->transformDate($cell);
                    } else if (!$tglEkspirasi) {
                        $tglEkspirasi = $this->transformDate($cell);
                    }
                }
            }

            // Fallback: Jika logic deteksi pintar gagal, gunakan posisi kolom (Asumsi format Lapas standar)
            if (!$noReg && isset($data[1])) $noReg = trim($data[1]);
            if (!$nama && isset($data[0])) $nama = trim($data[0]);

            // Simpan jika minimal ada Nama dan No Reg
            if ($nama && $noReg && !in_array($noReg, $processedRegistrations)) {
                
                // Jika posisi kolom fix (format khusus file Excel yang Anda berikan):
                // 0: Nama, 1: No Reg, 2: Tgl Masuk, 3: Tgl Ekspirasi, 10: Blok, 11: Kamar
                if ($this->isNumeric($data[10] ?? null)) {
                     // Jika kolom 10 angka, berarti logic geser
                }

                Wbp::create([
                    'no_registrasi'     => $noReg,
                    'nama'              => strtoupper($nama),
                    'nama_panggilan'    => $alias,
                    'tanggal_masuk'     => $tglMasuk,
                    'tanggal_ekspirasi' => $tglEkspirasi,
                    'blok'              => $blok,
                    'kamar'             => $kamar,
                ]);

                $processedRegistrations[] = $noReg;
            }
        }
    }

    private function isHeader($row)
    {
        $firstCell = strtolower((string)$row->first());
        return str_contains($firstCell, 'nama') || str_contains($firstCell, 'no') || str_contains($firstCell, 'registrasi');
    }

    private function transformDate($value)
    {
        if (empty($value) || $value === '-') return null;

        try {
            // Jika format angka Excel (Serial Date)
            if (is_numeric($value)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
            }

            // Jika format string Indonesia (d/m/Y)
            $cleanDate = str_replace('/', '-', $value);
            return Carbon::parse($cleanDate)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    private function isNumeric($val) {
        return is_numeric($val);
    }
}
