<?php

namespace App\Imports;

use App\Models\Wbp;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class WbpImport implements ToCollection
{
    /**
     * Array untuk menyimpan nomor registrasi yang berhasil diimport
     */
    public $importedNoRegs = [];

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        $headerRowIndex = null;
        $mappings = [];

        // 1. Detect header row
        foreach ($rows as $index => $row) {
            $rowArray = is_array($row) ? $row : $row->toArray();
            
            $hasNama = false;
            $hasReg = false;

            foreach ($rowArray as $cell) {
                $cellStr = trim((string)$cell);
                if (empty($cellStr)) {
                    continue;
                }

                // Check for Nama / Nama Lengkap
                if (preg_match('/nama/i', $cellStr)) {
                    $hasNama = true;
                }
                // Check for No. Registrasi / No Registrasi / Reg
                if (preg_match('/reg/i', $cellStr)) {
                    $hasReg = true;
                }
            }

            if ($hasNama && $hasReg) {
                $headerRowIndex = $index;
                // Build mappings
                foreach ($rowArray as $colIndex => $cell) {
                    $cellStr = trim((string)$cell);
                    $cellLower = strtolower($cellStr);

                    if (preg_match('/nama/i', $cellLower) && !isset($mappings['nama'])) {
                        $mappings['nama'] = $colIndex;
                    } elseif (preg_match('/reg/i', $cellLower) && !isset($mappings['no_registrasi'])) {
                        $mappings['no_registrasi'] = $colIndex;
                    } elseif (preg_match('/tgl.*msk|masuk/i', $cellLower) && !isset($mappings['tanggal_masuk'])) {
                        $mappings['tanggal_masuk'] = $colIndex;
                    } elseif (preg_match('/ekspirasi/i', $cellLower) && !isset($mappings['tanggal_ekspirasi'])) {
                        $mappings['tanggal_ekspirasi'] = $colIndex;
                    } elseif (preg_match('/alias.*1/i', $cellLower)) {
                        $mappings['nm_alias_1'] = $colIndex;
                    } elseif (preg_match('/alias.*2/i', $cellLower)) {
                        $mappings['nm_alias_2'] = $colIndex;
                    } elseif (preg_match('/alias.*3/i', $cellLower)) {
                        $mappings['nm_alias_3'] = $colIndex;
                    } elseif (preg_match('/kecil.*1/i', $cellLower)) {
                        $mappings['nm_kecil_1'] = $colIndex;
                    } elseif (preg_match('/kecil.*2/i', $cellLower)) {
                        $mappings['nm_kecil_2'] = $colIndex;
                    } elseif (preg_match('/kecil.*3/i', $cellLower)) {
                        $mappings['nm_kecil_3'] = $colIndex;
                    } elseif (preg_match('/blok/i', $cellLower) && !isset($mappings['blok'])) {
                        $mappings['blok'] = $colIndex;
                    } elseif (preg_match('/sel|kamar/i', $cellLower) && !isset($mappings['lokasi_sel'])) {
                        $mappings['lokasi_sel'] = $colIndex;
                    }
                }
                break;
            }
        }

        // If no header row is found, use default templates (0-indexed columns)
        if ($headerRowIndex === null) {
            $mappings = [
                'nama'              => 0,
                'no_registrasi'     => 1,
                'tanggal_masuk'     => 2,
                'tanggal_ekspirasi' => 3,
                'nm_alias_1'        => 4,
                'nm_alias_2'        => 5,
                'nm_alias_3'        => 6,
                'nm_kecil_1'        => 7,
                'nm_kecil_2'        => 8,
                'nm_kecil_3'        => 9,
                'blok'              => 10,
                'lokasi_sel'        => 11,
            ];
            $startRowIndex = 0;
        } else {
            $startRowIndex = $headerRowIndex + 1;
        }

        // We must have at least 'nama' and 'no_registrasi' mapped
        if (!isset($mappings['nama']) || !isset($mappings['no_registrasi'])) {
            $mappings['nama'] = $mappings['nama'] ?? 0;
            $mappings['no_registrasi'] = $mappings['no_registrasi'] ?? 1;
        }

        // Process data rows
        $processedNoRegs = [];

        foreach ($rows as $index => $row) {
            if ($index < $startRowIndex) {
                continue;
            }

            $rowArray = is_array($row) ? $row : $row->toArray();

            $nama = isset($mappings['nama']) && isset($rowArray[$mappings['nama']]) ? trim((string)$rowArray[$mappings['nama']]) : '';
            $noReg = isset($mappings['no_registrasi']) && isset($rowArray[$mappings['no_registrasi']]) ? trim((string)$rowArray[$mappings['no_registrasi']]) : '';

            // Clean up name and noReg
            if (empty($nama) || empty($noReg) || $nama === '-' || $noReg === '-') {
                continue;
            }

            // Handle duplicate no_registrasi within the import file by appending a suffix
            $originalNoReg = $noReg;
            $resolvedNoReg = $noReg;
            $suffix = 1;
            while (in_array($resolvedNoReg, $processedNoRegs)) {
                $suffix++;
                $resolvedNoReg = $originalNoReg . '-' . $suffix;
            }
            $noReg = $resolvedNoReg;
            $processedNoRegs[] = $noReg;
            $this->importedNoRegs[] = $noReg;

            // Fetch dates
            $tglMasukRaw = isset($mappings['tanggal_masuk']) && isset($rowArray[$mappings['tanggal_masuk']]) ? $rowArray[$mappings['tanggal_masuk']] : null;
            $tglMasuk = $this->transformDate($tglMasukRaw);

            $tglEkspirasiRaw = isset($mappings['tanggal_ekspirasi']) && isset($rowArray[$mappings['tanggal_ekspirasi']]) ? $rowArray[$mappings['tanggal_ekspirasi']] : null;
            $tglEkspirasi = $this->transformDate($tglEkspirasiRaw);

            // Fetch block and cell
            $blokRaw = isset($mappings['blok']) && isset($rowArray[$mappings['blok']]) ? trim((string)$rowArray[$mappings['blok']]) : '';
            $blok = !empty($blokRaw) ? $blokRaw : '-';

            $lokasiSelRaw = isset($mappings['lokasi_sel']) && isset($rowArray[$mappings['lokasi_sel']]) ? trim((string)$rowArray[$mappings['lokasi_sel']]) : '';
            $lokasiSel = !empty($lokasiSelRaw) ? $lokasiSelRaw : '-';

            // Alias fields
            $aliasParts = [];
            $aliasKeys = ['nm_alias_1', 'nm_alias_2', 'nm_alias_3', 'nm_kecil_1', 'nm_kecil_2', 'nm_kecil_3'];
            foreach ($aliasKeys as $key) {
                if (isset($mappings[$key]) && isset($rowArray[$mappings[$key]])) {
                    $val = trim((string)$rowArray[$mappings[$key]]);
                    if (!empty($val) && $val !== '-') {
                        $aliasParts[] = $val;
                    }
                }
            }
            $namaPanggilan = !empty($aliasParts) ? implode(', ', array_unique($aliasParts)) : '-';

            // Infer kode_tahanan from registration number
            $inferredKode = in_array(strtoupper(substr($noReg, 0, 1)), ['A', 'B']) ? strtoupper(substr($noReg, 0, 1)) : null;

            // Update or Create
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
                    'status'            => 'Aktif', // Explicitly reset status to Aktif if it was Bebas
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
        }
    }

    private function transformDate($value)
    {
        if (empty($value) || $value === '-' || $value === '00/00/0000') return null;
        try {
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            }
            return Carbon::parse(str_replace('/', '-', $value))->format('Y-m-d');
        } catch (\Exception $e) { 
            return null; 
        }
    }
}
