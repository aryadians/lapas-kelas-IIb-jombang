<?php

namespace App\Exports;

use App\Models\ProfilPengunjung;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class VisitorExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ProfilPengunjung::withCount('kunjungans')->get();
    }

    public function title(): string
    {
        return 'Database Pengunjung';
    }

    public function headings(): array
    {
        return [
            ['LAPAS KELAS IIB JOMBANG'],
            ['LAPORAN DATABASE PENGUNJUNG'],
            ['Dicetak pada: ' . date('d/m/Y H:i')],
            [''],
            [
                'NO',
                'NIK',
                'NAMA LENGKAP',
                'JENIS KELAMIN',
                'NOMOR HP',
                'EMAIL',
                'ALAMAT',
                'TOTAL KUNJUNGAN',
                'TANGGAL DAFTAR'
            ]
        ];
    }

    public function map($visitor): array
    {
        static $no = 1;
        return [
            $no++,
            "'" . $visitor->nik, // Prefix with ' to prevent scientific notation in Excel
            strtoupper($visitor->nama),
            $visitor->jenis_kelamin,
            $visitor->nomor_hp ?? '-',
            $visitor->email ?? '-',
            $visitor->alamat,
            $visitor->kunjungans_count . ' Kali',
            $visitor->created_at->format('d/m/Y')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Merge cells for header
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A3:I3');

        $styleArray = [
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $sheet->getStyle('A1:A2')->applyFromArray($styleArray);
        $sheet->getStyle('A1')->getFont()->setSize(14);
        
        // Table Header Style (Row 5)
        $sheet->getStyle('A5:I5')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4'],
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
        $sheet->getStyle('A6:I' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Center align NO, NIK, JK, TOTAL, TANGGAL columns
        $sheet->getStyle('A6:B' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D6:D' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H6:I' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }
}
