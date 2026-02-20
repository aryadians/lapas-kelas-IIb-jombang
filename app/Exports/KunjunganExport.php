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
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Conditional;

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
            if ($this->period == 'day') $periodeStr = 'TANGGAL ' . $this->date->format('Y-m-d');
            elseif ($this->period == 'week') $periodeStr = 'MINGGU KE-' . $this->date->weekOfYear . ' TAHUN ' . $this->date->year;
            elseif ($this->period == 'month') $periodeStr = 'BULAN ' . $this->date->translatedFormat('F Y');
        }

        return [
            ['KEMENTERIAN IMIGRASI DAN PEMASYARAKATAN REPUBLIK INDONESIA'],
            ['KANTOR WILAYAH JAWA TIMUR'],
            ['LEMBAGA PEMASYARAKATAN KELAS IIB JOMBANG'],
            ['LAPORAN DATA KUNJUNGAN PENGUNJUNG'],
            ['Periode Laporan: ' . $periodeStr],
            ['Dicetak pada: ' . date('Y-m-d H:i')],
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
            $kunjungan->tanggal_kunjungan->format('Y-m-d'),
            strtoupper($kunjungan->sesi),
            $pengikutNames ?: '-',
            $kunjungan->barang_bawaan ?: '-'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_TEXT,
            'J' => NumberFormat::FORMAT_DATE_YYYYMMDD,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header Styling (Rows 1-6)
        $sheet->mergeCells('A1:M1');
        $sheet->mergeCells('A2:M2');
        $sheet->mergeCells('A3:M3');
        $sheet->mergeCells('A4:M4');
        $sheet->mergeCells('A5:M5');
        $sheet->mergeCells('A6:M6');

        $styleHeaderBase = [
            'font' => ['bold' => true, 'size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];

        $sheet->getStyle('A1:A6')->applyFromArray($styleHeaderBase);
        $sheet->getStyle('A3')->getFont()->setSize(14);
        $sheet->getStyle('A4')->getFont()->setSize(12);
        
        // Table Header Style (Row 8)
        $sheet->getStyle('A8:M8')->applyFromArray([
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

        $sheet->getRowDimension(8)->setRowHeight(30);

        // Content Styling
        $lastRow = $sheet->getHighestRow();
        if ($lastRow >= 9) {
            $sheet->getStyle('A9:M' . $lastRow)->applyFromArray([
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

            // Center align specific columns
            $centerColumns = ['A', 'B', 'C', 'D', 'F', 'G', 'I', 'J', 'K'];
            foreach ($centerColumns as $col) {
                $sheet->getStyle($col . '9:' . $col . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }

            // Conditional Formatting for Status (Column C)
            $this->applyStatusConditionalFormatting($sheet, $lastRow);
        }

        return [];
    }

    protected function applyStatusConditionalFormatting(Worksheet $sheet, $lastRow)
    {
        $statusCellRange = 'C9:C' . $lastRow;

        // Disetujui (APPROVED) -> Emerald/Green
        $conditional1 = new Conditional();
        $conditional1->setConditionType(Conditional::CONDITION_EXPRESSION)
            ->setOperatorType(Conditional::OPERATOR_EQUAL)
            ->addCondition('C9="APPROVED"')
            ->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('ecfdf5');
        $conditional1->getStyle()->getFont()->getColor()->setRGB('059669');
        $conditional1->getStyle()->getFont()->setBold(true);

        // Menunggu (PENDING) -> Amber/Yellow
        $conditional2 = new Conditional();
        $conditional2->setConditionType(Conditional::CONDITION_EXPRESSION)
            ->setOperatorType(Conditional::OPERATOR_EQUAL)
            ->addCondition('C9="PENDING"')
            ->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('fffbeb');
        $conditional2->getStyle()->getFont()->getColor()->setRGB('d97706');
        $conditional2->getStyle()->getFont()->setBold(true);

        // Ditolak (REJECTED) -> Red
        $conditional3 = new Conditional();
        $conditional3->setConditionType(Conditional::CONDITION_EXPRESSION)
            ->setOperatorType(Conditional::OPERATOR_EQUAL)
            ->addCondition('C9="REJECTED"')
            ->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('fef2f2');
        $conditional3->getStyle()->getFont()->getColor()->setRGB('dc2626');
        $conditional3->getStyle()->getFont()->setBold(true);

        // Selesai (COMPLETED) -> Slate/Gray
        $conditional4 = new Conditional();
        $conditional4->setConditionType(Conditional::CONDITION_EXPRESSION)
            ->setOperatorType(Conditional::OPERATOR_EQUAL)
            ->addCondition('C9="COMPLETED"')
            ->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('f8fafc');
        $conditional4->getStyle()->getFont()->getColor()->setRGB('475569');
        $conditional4->getStyle()->getFont()->setBold(true);

        $sheet->getStyle($statusCellRange)->setConditionalStyles([$conditional1, $conditional2, $conditional3, $conditional4]);
    }
}
