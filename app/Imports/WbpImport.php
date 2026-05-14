<?php

namespace App\Imports;

use App\Models\Wbp;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class WbpImport implements ToCollection, SkipsEmptyRows, WithChunkReading
{
    public $importedNoRegs = [];

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        // Tingkatkan batas waktu eksekusi untuk file besar
        set_time_limit(300); 

        foreach ($rows as $index => $row) {
            // Lewati header
            if ($this->isHeader($row)) {
                continue;
            }

            $data = $row->values()->toArray();
            
            // Ambil data berdasarkan urutan kolom yang diberikan user
            $nama = isset($data[0]) ? trim((string)$data[0]) : null;
            $noReg = isset($data[1]) ? trim((string)$data[1]) : null;
            
            // Jika baris benar-benar kosong atau No Reg tidak valid, lewati
            if (empty($nama) || empty($noReg) || strlen($noReg) < 5) {
                continue;
            }

            // Gabungkan Alias & Nama Kecil (Kolom 4 sampai 9)
            $aliasParts = [];
            for ($i = 4; $i <= 9; $i++) {
                if (isset($data[$i]) && trim((string)$data[$i]) !== '' && trim((string)$data[$i]) !== '-') {
                    $aliasParts[] = trim((string)$data[$i]);
                }
            }
            $namaPanggilan = !empty($aliasParts) ? implode(', ', array_unique($aliasParts)) : '-';

            $tglMasuk = isset($data[2]) ? $this->transformDate($data[2]) : null;
            $tglEkspirasi = isset($data[3]) ? $this->transformDate($data[3]) : null;
            
            $blok = (isset($data[10]) && trim((string)$data[10]) !== '') ? trim((string)$data[10]) : '-';
            $lokasiSel = (isset($data[11]) && trim((string)$data[11]) !== '') ? trim((string)$data[11]) : '-';

            // Tentukan Kode Tahanan (A/B)
            $inferredKode = null;
            $firstChar = strtoupper(substr(trim($noReg), 0, 1));
            if (in_array($firstChar, ['A', 'B'])) {
                $inferredKode = $firstChar;
            }

            // Update atau Buat Baru
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

            // Simpan daftar no reg yang ada di file
            $this->importedNoRegs[] = $noReg;
        }
    }

    private function isHeader($row)
    {
        $firstCell = trim(strtolower((string)$row->first()));
        $headerKeywords = ['nama lengkap', 'no. registrasi', 'no registrasi'];
        
        foreach ($headerKeywords as $keyword) {
            if ($firstCell === $keyword) return true;
        }

        return false;
    }

    public function chunkSize(): int
    {
        return 100; // Memproses per 100 baris untuk efisiensi memori
    }

    private function transformDate($value)
    {
        if (empty($value) || $value === '-' || $value === '00/00/0000') return null;

        try {
            if (is_numeric($value)) {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
            }
            $cleanDate = str_replace('/', '-', $value);
            return Carbon::parse($cleanDate)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
