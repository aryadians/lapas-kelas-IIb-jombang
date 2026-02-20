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
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class KunjunganExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle, WithColumnFormatting, WithDrawings
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
                        $this->date->copy()->startOfWeek(Carbon::MONDAY)->format('Y-m-d'),
                        $this->date->copy()->endOfWeek(Carbon::SUNDAY)->format('Y-m-d')
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

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo Lapas');
        $drawing->setDescription('Logo Lapas Kelas IIB Jombang');
        $drawing->setPath(public_path('img/logo.png'));
        $drawing->setHeight(80);
        $drawing->setCoordinates('B1');
        $drawing->setOffsetX(20);
        $drawing->setOffsetY(5);

        return $drawing;
    }

    public function title(): string
    {
        return 'Laporan Kunjungan';
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $periodeStr = 'SELURUH DATA RIWAYAT';
        if ($this->date) {
            if ($this->period == 'day') $periodeStr = 'TANGGAL ' . $this->date->format('d/m/Y');
            elseif ($this->period == 'week') $periodeStr = 'MINGGU KE-' . $this->date->weekOfYear . ' TAHUN ' . $this->date->year;
            elseif ($this->period == 'month') $periodeStr = 'BULAN ' . $this->date->translatedFormat('F Y');
        }

        return [
            [''], // Row 1 (Reserved for logo height)
            ['', 'KEMENTERIAN IMIGRASI DAN PEMASYARAKATAN REPUBLIK INDONESIA'],
            ['', 'KANTOR WILAYAH JAWA TIMUR'],
            ['', 'LEMBAGA PEMASYARAKATAN KELAS IIB JOMBANG'],
            ['', 'LAPORAN DATA KUNJUNGAN PENGUNJUNG'],
            ['', 'Periode Laporan: ' . $periodeStr],
            ['', 'Dicetak pada: ' . date('d/m/Y H:i')],
            [''],
            [
                'NO',
                'KODE BOOKING',
                'STATUS',
                'NO. ANTRIAN',
                'NAMA PENGUNJUNG',
                'NIK KTP',
                'HUBUNGAN',
                'NAMA WBP',
                'NO REG WBP',
                'TANGGAL KUNJUNGAN',
                'SESI',
                'PENGIKUT TAMBAHAN',
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
            $kunjungan->nomor_antrian_harian ? ($kunjungan->registration_type === 'offline' ? 'B-' : 'A-') . str_pad($kunjungan->nomor_antrian_harian, 3, '0', STR_PAD_LEFT) : '-',
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
        // Header Styling (Rows 2-7)
        $sheet->mergeCells('B2:M2');
        $sheet->mergeCells('B3:M3');
        $sheet->mergeCells('B4:M4');
        $sheet->mergeCells('B5:M5');
        $sheet->mergeCells('B6:M6');
        $sheet->mergeCells('B7:M7');

        $styleHeaderBase = [
            'font' => ['bold' => true, 'size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];

        $sheet->getStyle('B2:B7')->applyFromArray($styleHeaderBase);
        $sheet->getStyle('B4')->getFont()->setSize(14);
        $sheet->getStyle('B5')->getFont()->setSize(12);
        
        // Table Header Style (Row 9)
        $sheet->getStyle('A9:M9')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 10
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1e293b'], // Slate 900
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
            ],
        ]);

        $sheet->getRowDimension(9)->setRowHeight(30);

        // Content Styling
        $lastRow = $sheet->getHighestRow();
        if ($lastRow >= 10) {
            $sheet->getStyle('A10:M' . $lastRow)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'cbd5e1'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Alternate row coloring for better readability
            for ($i = 10; $i <= $lastRow; $i++) {
                if ($i % 2 == 0) {
                    $sheet->getStyle('A' . $i . ':M' . $i)->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('f8fafc');
                }
            }

            // Center align specific columns
            $centerColumns = ['A', 'B', 'C', 'D', 'F', 'G', 'I', 'J', 'K'];
            foreach ($centerColumns as $col) {
                $sheet->getStyle($col . '10:' . $col . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }

        return [];
    }
}
