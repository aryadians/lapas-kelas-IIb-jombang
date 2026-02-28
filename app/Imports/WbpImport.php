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
        $blokIdx = -1;
        $kamarIdx = -1;

        foreach ($rows as $index => $row) {
            // Lewati header jika baris pertama mengandung kata kunci tertentu
            if ($this->isHeader($row)) {
                // Dinamis mencari indeks kolom Blok dan Kamar jika ada
                foreach ($row->values()->toArray() as $colIdx => $colName) {
                    $cn = strtolower(trim((string)$colName));
                    if (str_contains($cn, 'blok')) $blokIdx = $colIdx;
                    if (str_contains($cn, 'kamar') || str_contains($cn, 'sel')) $kamarIdx = $colIdx;
                }
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

            // Ambil dari deteksi indeks header dinamis (jika ada)
            if ($blokIdx !== -1 && isset($data[$blokIdx]) && trim((string)$data[$blokIdx]) !== '') {
                $blok = trim((string)$data[$blokIdx]);
            }
            if ($kamarIdx !== -1 && isset($data[$kamarIdx]) && trim((string)$data[$kamarIdx]) !== '') {
                $kamar = trim((string)$data[$kamarIdx]);
            }

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
                
                // Jika posisi kolom fix (format khusus file Excel SDP Lapas standar)
                // Fallback jika tidak ditemukan nama header 'blok' / 'kamar'
                if ($blok === '-' && isset($data[10]) && trim((string)$data[10]) !== '') {
                     $blok = trim((string)$data[10]);
                }
                if ($kamar === '-' && isset($data[11]) && trim((string)$data[11]) !== '') {
                     $kamar = trim((string)$data[11]);
                }
                
                // Fallback format CSV Ringkas (misal Kolom 4 & 5)
                if ($blok === '-' && isset($data[4]) && !preg_match('/^\d{1,2}[\/\-]\d{1,2}/', (string)$data[4]) && strlen(trim((string)$data[4])) <= 10) {
                     $blok = trim((string)$data[4]);
                }
                if ($kamar === '-' && isset($data[5]) && !preg_match('/^\d{1,2}[\/\-]\d{1,2}/', (string)$data[5]) && strlen(trim((string)$data[5])) <= 10) {
                     $kamar = trim((string)$data[5]);
                }

                $inferredKode = null;
                if (!empty($noReg)) {
                    $firstChar = strtoupper(substr(trim($noReg), 0, 1));
                    if (in_array($firstChar, ['A', 'B'])) {
                        $inferredKode = $firstChar;
                    }
                }

                Wbp::create([
                    'no_registrasi'     => $noReg,
                    'kode_tahanan'      => $inferredKode,
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
