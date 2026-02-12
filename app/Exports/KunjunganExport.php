<?php

namespace App\Exports;

use App\Models\Kunjungan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class KunjunganExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle, WithColumnFormatting
{
    protected $period;
    protected $date;

    public function __construct(string $period = 'all', ?string $date = null)
    {
        $this->period = $period;
        $this->date = $date ? Carbon::parse($date) : null;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Kunjungan::with(['wbp', 'pengikuts']);

        if ($this->date) {
            switch ($this->period) {
                case 'day':
                    $query->whereDate('tanggal_kunjungan', $this->date->format('Y-m-d'));
                    break;
                case 'week':
                    $query->whereBetween('tanggal_kunjungan', [
                        $this->date->startOfWeek(Carbon::MONDAY)->format('Y-m-d'),
                        $this->date->endOfWeek(Carbon::SUNDAY)->format('Y-m-d')
                    ]);
                    break;
                case 'month':
                    $query->whereYear('tanggal_kunjungan', $this->date->year)
                        ->whereMonth('tanggal_kunjungan', $this->date->month);
                    break;
            }
        }

        return $query->latest('tanggal_kunjungan')->get();
    }

    public function title(): string
    {
        return 'Data Kunjungan';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $periodeStr = 'SEMUA PERIODE';
        if ($this->date) {
            if ($this->period == 'day') $periodeStr = 'TANGGAL ' . $this->date->format('d/m/Y');
            elseif ($this->period == 'week') $periodeStr = 'MINGGU KE-' . $this->date->weekOfYear . ' TAHUN ' . $this->date->year;
            elseif ($this->period == 'month') $periodeStr = 'BULAN ' . $this->date->translatedFormat('F Y');
        }

        return [
            ['LAPAS KELAS IIB JOMBANG'],
            ['LAPORAN DATA KUNJUNGAN PENGUNJUNG'],
            ['Periode: ' . $periodeStr],
            ['Dicetak pada: ' . date('d/m/Y H:i')],
            [''],
            [
                'NO',
                'KODE',
                'STATUS',
                'ANTRIAN',
                'NAMA PENGUNJUNG',
                'NIK KTP',
                'HUBUNGAN',
                'NAMA WBP',
                'NO REG WBP',
                'TANGGAL',
                'SESI',
                'PENGIKUT',
                'BARANG BAWAAN'
            ]
        ];
    }

    /**
     * @param mixed $kunjungan
     * @return array
     */
    public function map($kunjungan): array
    {
        static $no = 1;
        $pengikutNames = $kunjungan->pengikuts->pluck('nama')->implode(', ');

        return [
            $no++,
            $kunjungan->kode_kunjungan,
            strtoupper($kunjungan->status->value ?? $kunjungan->status),
            $kunjungan->nomor_antrian_harian ? '#' . $kunjungan->nomor_antrian_harian : '-',
            strtoupper($kunjungan->nama_pengunjung),
            "'" . $kunjungan->nik_ktp,
            strtoupper($kunjungan->hubungan),
            strtoupper($kunjungan->wbp->nama ?? 'N/A'),
            $kunjungan->wbp->no_registrasi ?? 'N/A',
            $kunjungan->tanggal_kunjungan->format('d/m/Y'),
            strtoupper($kunjungan->sesi),
            $pengikutNames ?: '-',
            $kunjungan->barang_bawaan ?: '-'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Merge cells for header
        $sheet->mergeCells('A1:M1');
        $sheet->mergeCells('A2:M2');
        $sheet->mergeCells('A3:M3');
        $sheet->mergeCells('A4:M4');

        $styleHeader = [
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $sheet->getStyle('A1:A4')->applyFromArray($styleHeader);
        $sheet->getStyle('A1')->getFont()->setSize(14);
        
        // Table Header Style (Row 6)
        $sheet->getStyle('A6:M6')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '10b981'], // Green emerald to match visit list theme
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Content Styling
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A7:M' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Center align specific columns
        $centerColumns = ['A', 'B', 'C', 'D', 'F', 'G', 'I', 'J', 'K'];
        foreach ($centerColumns as $col) {
            $sheet->getStyle($col . '7:' . $col . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        return [];
    }
}
