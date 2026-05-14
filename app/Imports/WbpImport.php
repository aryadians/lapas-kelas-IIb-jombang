<?php

namespace App\Imports;

use App\Models\Wbp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class WbpImport implements ToModel, WithChunkReading, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Wbp|null
     */
    public function model(array $row)
    {
        // Debug: Log data baris yang masuk
        // Log::info("Row processing: " . json_encode($row));

        $nama  = trim((string)($row['nama_lengkap'] ?? $row['nama'] ?? ''));
        $noReg = trim((string)($row['no_registrasi'] ?? $row['no_registrasi'] ?? ''));

        if (empty($nama) || empty($noReg)) {
            return null;
        }

        $tglMasuk     = $this->transformDate($row['tgl_msk_upt'] ?? null);
        $tglEkspirasi = $this->transformDate($row['tgl_ekspirasi'] ?? null);
        
        $blok = !empty($row['blok']) ? trim((string)$row['blok']) : '-';
        $lokasiSel = !empty($row['lokasi_sel']) ? trim((string)$row['lokasi_sel']) : '-';

        $inferredKode = in_array(strtoupper(substr($noReg, 0, 1)), ['A', 'B']) ? strtoupper(substr($noReg, 0, 1)) : null;

        $wbp = Wbp::where('no_registrasi', $noReg)->first();

        if ($wbp) {
            $wbp->update([
                'nama'              => strtoupper($nama),
                'kode_tahanan'      => $inferredKode,
                'tanggal_masuk'     => $tglMasuk,
                'tanggal_ekspirasi' => $tglEkspirasi,
                'blok'              => $blok,
                'lokasi_sel'        => $lokasiSel,
            ]);
            return null;
        }

        return new Wbp([
            'no_registrasi'     => $noReg,
            'nama'              => strtoupper($nama),
            'kode_tahanan'      => $inferredKode,
            'tanggal_masuk'     => $tglMasuk,
            'tanggal_ekspirasi' => $tglEkspirasi,
            'blok'              => $blok,
            'lokasi_sel'        => $lokasiSel,
            'status'            => 'Aktif',
        ]);
    }

    public function chunkSize(): int 
    { 
        return 100; 
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
