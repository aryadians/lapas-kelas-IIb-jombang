<?php

namespace App\Exports;

use App\Models\Kunjungan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Chart\Chart;

class KunjunganExport implements
    FromCollection, WithHeadings, WithMapping,
    WithStyles, ShouldAutoSize, WithTitle, WithColumnFormatting, WithEvents
{
    protected $period;
    protected $date;

    // Kolom terakhir (M = 13 kolom)
    const LAST_COL = 'M';
    // Header selesai di baris 10, data mulai baris 11
    const DATA_START_ROW = 11;

    public function __construct(string $period = 'all', ?string $date = null)
    {
        $this->period = $period;
        $this->date   = $date ? Carbon::parse($date) : null;
    }

    public function collection()
    {
        $query = Kunjungan::with(['wbp', 'pengikuts']);
        if ($this->date) {
            match ($this->period) {
                'day'   => $query->whereDate('tanggal_kunjungan', $this->date->format('Y-m-d')),
                'week'  => $query->whereBetween('tanggal_kunjungan', [
                    $this->date->copy()->startOfWeek(Carbon::MONDAY)->format('Y-m-d'),
                    $this->date->copy()->endOfWeek(Carbon::SUNDAY)->format('Y-m-d'),
                ]),
                'month' => $query->whereYear('tanggal_kunjungan', $this->date->year)
                                 ->whereMonth('tanggal_kunjungan', $this->date->month),
                default => null,
            };
        }
        return $query->latest('tanggal_kunjungan')->get();
    }

    public function title(): string
    {
        return 'Laporan Kunjungan';
    }

    public function headings(): array
    {
        $periodeStr = 'SELURUH DATA RIWAYAT';
        if ($this->date) {
            if ($this->period === 'day')   $periodeStr = 'TANGGAL ' . $this->date->translatedFormat('d F Y');
            elseif ($this->period === 'week')  $periodeStr = 'MINGGU KE-' . $this->date->weekOfYear . ' TAHUN ' . $this->date->year;
            elseif ($this->period === 'month') $periodeStr = 'BULAN ' . strtoupper($this->date->translatedFormat('F Y'));
        }

        return [
            // Rows 1-9 → kop surat + judul
            ['KEMENTERIAN IMIGRASI DAN PEMASYARAKATAN REPUBLIK INDONESIA'],
            ['KANTOR WILAYAH DIREKTORAT JENDERAL PEMASYARAKATAN – JAWA TIMUR'],
            ['LEMBAGA PEMASYARAKATAN KELAS IIB JOMBANG'],
            ['Jl. KH. Wahid Hasyim No. 155, Jombang, Jawa Timur 61419  |  Telp. (0321) 861205'],
            [''],
            ['LAPORAN DATA KUNJUNGAN PENGUNJUNG'],
            ['Periode: ' . $periodeStr],
            ['Dicetak oleh: ' . (auth()->user()->name ?? 'Admin') . '   |   Tanggal cetak: ' . now()->translatedFormat('d F Y H:i') . ' WIB'],
            [''], // spacer
            // Row 10 → header kolom
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
                'TGL KUNJUNGAN',
                'SESI',
                'PENGIKUT',
                'BARANG BAWAAN',
            ],
        ];
    }

    public function map($kunjungan): array
    {
        static $no = 1;
        return [
            $no++,
            $kunjungan->kode_kunjungan,
            strtoupper($kunjungan->status->value ?? $kunjungan->status),
            $kunjungan->nomor_antrian_harian
                ? ($kunjungan->registration_type === 'offline' ? 'B-' : 'A-') . str_pad($kunjungan->nomor_antrian_harian, 3, '0', STR_PAD_LEFT)
                : '-',
            strtoupper($kunjungan->nama_pengunjung),
            "'" . $kunjungan->nik_ktp,
            strtoupper($kunjungan->hubungan),
            strtoupper($kunjungan->wbp->nama ?? 'N/A'),
            $kunjungan->wbp->no_registrasi ?? 'N/A',
            $kunjungan->tanggal_kunjungan->format('Y-m-d'),
            strtoupper($kunjungan->sesi),
            $kunjungan->pengikuts->pluck('nama')->implode(', ') ?: '-',
            $kunjungan->barang_bawaan ?: '-',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_TEXT,
            'J' => NumberFormat::FORMAT_DATE_YYYYMMDD,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // ── Row heights ──
                $sheet->getRowDimension(1)->setRowHeight(20);
                $sheet->getRowDimension(2)->setRowHeight(16);
                $sheet->getRowDimension(3)->setRowHeight(22);
                $sheet->getRowDimension(6)->setRowHeight(18);
                $sheet->getRowDimension(10)->setRowHeight(32);

                $lastCol  = self::LAST_COL;
                $lastRow  = $sheet->getHighestRow();
                $dataStart = self::DATA_START_ROW;

                // ── Merge kop baris 1-4 ──
                foreach ([1,2,3,4,6,7,8] as $r) {
                    $sheet->mergeCells("A{$r}:{$lastCol}{$r}");
                }

                // ── Style baris 1-4 (instansi) ──
                $sheet->getStyle("A1:{$lastCol}4")->applyFromArray([
                    'font'      => ['bold' => false, 'size' => 10, 'color' => ['rgb' => '1e3a5f']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                // Baris 1: kementerian (italic, kecil)
                $sheet->getStyle('A1')->getFont()->setItalic(false)->setSize(9)->setBold(false);
                // Baris 3: nama lapas (besar & bold)
                $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(14)->getColor()->setRGB('1e3a5f');
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(10);

                // Separator tipis setelah baris 4
                $sheet->getStyle("A4:{$lastCol}4")->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('94a3b8');

                // ── Row 5 kosong ──
                $sheet->getRowDimension(5)->setRowHeight(6);

                // ── Judul laporan (baris 6) ──
                $sheet->getStyle('A6')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 13, 'color' => ['rgb' => '1e3a5f']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getStyle("A6:{$lastCol}6")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('eff6ff');

                // ── Periode & cetak (baris 7-8) ──
                foreach ([7, 8] as $r) {
                    $sheet->getStyle("A{$r}")->applyFromArray([
                        'font'      => ['size' => 9, 'color' => ['rgb' => '475569']],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                }

                // ── Header tabel (baris 10) ──
                $sheet->getStyle("A10:{$lastCol}10")->applyFromArray([
                    'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 9],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1e3a5f']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                    'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '60a5fa']]],
                ]);

                // ── Data rows ──
                if ($lastRow >= $dataStart) {
                    $sheet->getStyle("A{$dataStart}:{$lastCol}{$lastRow}")->applyFromArray([
                        'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'cbd5e1']]],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                        'font'      => ['size' => 9.5],
                    ]);

                    // Zebra stripe
                    for ($row = $dataStart; $row <= $lastRow; $row++) {
                        if ($row % 2 === 0) {
                            $sheet->getStyle("A{$row}:{$lastCol}{$row}")->getFill()
                                ->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('f8fafc');
                        }
                    }

                    // Center align
                    foreach (['A', 'B', 'C', 'D', 'F', 'G', 'I', 'J', 'K'] as $col) {
                        $sheet->getStyle("{$col}{$dataStart}:{$col}{$lastRow}")
                              ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }

                    // Status conditional formatting
                    $this->applyStatusConditionalFormatting($sheet, $lastRow);
                }

                // ── Freeze header ──
                $sheet->freezePane("A{$dataStart}");
            },
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [];
    }

    protected function applyStatusConditionalFormatting(Worksheet $sheet, $lastRow)
    {
        $range = 'C' . self::DATA_START_ROW . ':C' . $lastRow;
        $statuses = [
            ['APPROVED',  'ecfdf5', '059669'],
            ['PENDING',   'fffbeb', 'd97706'],
            ['REJECTED',  'fef2f2', 'dc2626'],
            ['COMPLETED', 'f1f5f9', '475569'],
            ['ON_QUEUE',  'eff6ff', '2563eb'],
            ['SERVING',   'f0fdf4', '16a34a'],
        ];
        $conditionals = [];
        foreach ($statuses as [$val, $bg, $fg]) {
            $c = new Conditional();
            $c->setConditionType(Conditional::CONDITION_CELLIS)
              ->setOperatorType(Conditional::OPERATOR_EQUAL)
              ->addCondition('"' . $val . '"');
            $c->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($bg);
            $c->getStyle()->getFont()->getColor()->setRGB($fg);
            $c->getStyle()->getFont()->setBold(true);
            $conditionals[] = $c;
        }
        $sheet->getStyle($range)->setConditionalStyles($conditionals);
    }
}
