<?php

namespace App\Imports;

use App\Models\Wbp;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class WbpImport implements ToCollection, SkipsEmptyRows
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Konversi row ke array index angka agar mudah dicek (0, 1, 2...)
            $data = $row->values()->toArray();

            // Variabel penampung
            $noReg = null;
            $nama = null;
            $blok = '-';

            // LOGIKA PINTAR (SMART DETECTION)
            // Sistem akan mencari mana yang "No Registrasi" dan mana yang "Nama"
            // berdasarkan pola isinya, jadi urutan kolom Excel tidak masalah.

            foreach ($data as $cell) {
                if (empty($cell)) continue;
                $cell = trim($cell);

                // 1. Cek Pola No Registrasi (Biasanya ada 'B.I', 'A.I', '/' atau angka tahun)
                // Contoh: BI.N 303/2025, A. 123/2024
                if (preg_match('/(A\.|B\.|BI\.|AI\.|AII|BII|\/20)/i', $cell) && strlen($cell) < 50) {
                    $noReg = $cell;
                }
                // 2. Jika bukan No Reg dan isinya Huruf, kemungkinan Nama
                // (Mengabaikan header seperti 'NO', 'NAMA')
                else if (strlen($cell) > 3 && !preg_match('/(NO\.?|NOMOR|REG|NAMA|BLOK)/i', $cell)) {
                    // Ambil string terpanjang sebagai Nama (asumsi nama WBP lebih panjang dari Blok)
                    if (strlen($cell) > strlen($nama)) {
                        $nama = strtoupper($cell); // Nama WBP biasanya huruf besar
                    } else {
                        // Sisanya kemungkinan Blok
                        $blok = $cell;
                    }
                }
            }

            // SIMPAN JIKA DATA VALID
            // Minimal No Reg dan Nama ditemukan
            if ($noReg && $nama) {
                // Bersihkan karakter aneh
                $noReg = trim(preg_replace('/[\x00-\x1F\x7F]/u', '', $noReg));

                Wbp::updateOrCreate(
                    ['no_registrasi' => $noReg],
                    [
                        'nama' => $nama,
                        'blok_kamar' => $blok
                    ]
                );
            }
        }
    }
}
