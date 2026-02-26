<?php

namespace App\Exports;

use App\Models\ProfilPengunjung;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class VisitorExport implements
    FromCollection, WithHeadings, WithMapping,
    WithStyles, ShouldAutoSize, WithTitle, WithEvents, WithDrawings
{
    const LAST_COL    = 'J';
    const DATA_START  = 11;

    public function collection()
    {
        return ProfilPengunjung::withCount('kunjungans')
            ->with(['kunjungans' => fn ($q) => $q->with('wbp')->latest('tanggal_kunjungan')->limit(1)])
            ->get();
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo Kemenimipas');
        $drawing->setDescription('Logo Kemenimipas');
        $drawing->setPath(public_path('img/logo.png'));
        $drawing->setHeight(60);
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(10);
        $drawing->setOffsetY(10);

        return $drawing;
    }

    public function title(): string
    {
        return 'Database Pengunjung';
    }

    public function headings(): array
    {
        return [
            ['KEMENTERIAN IMIGRASI DAN PEMASYARAKATAN REPUBLIK INDONESIA'],
            ['KANTOR WILAYAH DIREKTORAT JENDERAL PEMASYARAKATAN – JAWA TIMUR'],
            ['LEMBAGA PEMASYARAKATAN KELAS IIB JOMBANG'],
            ['Jl. KH. Wahid Hasyim No. 155, Jombang, Jawa Timur 61419  |  Telp. (0321) 861205'],
            [''],
            ['LAPORAN DATABASE PROFIL PENGUNJUNG'],
            ['Data seluruh pengunjung yang terdaftar dalam sistem Lapas Jombang'],
            ['Dicetak oleh: ' . (auth()->user()->name ?? 'Admin') . '   |   Tanggal cetak: ' . now()->translatedFormat('d F Y H:i') . ' WIB'],
            [''],
            [
                'NO',
                'NIK',
                'NAMA LENGKAP',
                'JENIS KELAMIN',
                'NOMOR HP',
                'EMAIL',
                'ALAMAT',
                'WBP YANG DIKUNJUNGI',
                'TOTAL KUNJUNGAN',
                'TGL TERDAFTAR',
            ],
        ];
    }

    public function map($visitor): array
    {
        static $no = 1;
        $latest  = $visitor->kunjungans->first();
        $wbpName = $latest && $latest->wbp ? strtoupper($latest->wbp->nama) : '-';

        return [
            $no++,
            "'" . $visitor->nik,
            strtoupper($visitor->nama),
            $visitor->jenis_kelamin,
            $visitor->nomor_hp ?? '-',
            $visitor->email ?? '-',
            $visitor->alamat,
            $wbpName,
            $visitor->kunjungans_count . ' Kali',
            $visitor->created_at->format('d/m/Y'),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet    = $event->sheet->getDelegate();
                $lastCol  = self::LAST_COL;
                $lastRow  = $sheet->getHighestRow();
                $dataStart = self::DATA_START;

                // Merge kop
                foreach ([1,2,3,4,6,7,8] as $r) {
                    $sheet->mergeCells("A{$r}:{$lastCol}{$r}");
                }

                // Kop rows
                $sheet->getStyle("A1:{$lastCol}4")->applyFromArray([
                    'font'      => ['size' => 9.5, 'color' => ['rgb' => '1e3a5f']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(10);
                $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(14)->getColor()->setRGB('1e3a5f');
                $sheet->getStyle("A4:{$lastCol}4")->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('94a3b8');

                $sheet->getRowDimension(1)->setRowHeight(18);
                $sheet->getRowDimension(3)->setRowHeight(22);
                $sheet->getRowDimension(5)->setRowHeight(6);
                $sheet->getRowDimension(10)->setRowHeight(32);

                // Judul (row 6)
                $sheet->getStyle('A6')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 13, 'color' => ['rgb' => '1e3a5f']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getStyle("A6:{$lastCol}6")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('eff6ff');

                foreach ([7, 8] as $r) {
                    $sheet->getStyle("A{$r}")->applyFromArray([
                        'font'      => ['size' => 9, 'color' => ['rgb' => '475569']],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                }

                // Header kolom (row 10)
                $sheet->getStyle("A10:{$lastCol}10")->applyFromArray([
                    'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 9],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1e3a5f']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                    'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '60a5fa']]],
                ]);

                // Data rows
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

                    // Center columns
                    foreach (['A', 'B', 'D', 'I', 'J'] as $col) {
                        $sheet->getStyle("{$col}{$dataStart}:{$col}{$lastRow}")
                              ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }
                }

                $sheet->freezePane("A{$dataStart}");
            },
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [];
    }
}
