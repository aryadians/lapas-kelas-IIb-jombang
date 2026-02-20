<?php

namespace App\Exports;

use App\Models\FinancialReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class FinancialReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return FinancialReport::all();
    }

    public function headings(): array
    {
        return [
            ['LAPAS KELAS IIB JOMBANG'],
            ['REKAPITULASI LAPORAN INFORMASI PUBLIK'],
            ['Dicetak pada: ' . date('d/m/Y H:i')],
            [''],
            ['NO', 'JUDUL LAPORAN', 'KATEGORI', 'TAHUN', 'KETERANGAN', 'STATUS', 'TANGGAL UNGGAH']
        ];
    }

    public function map($report): array
    {
        static $no = 1;
        return [
            $no++,
            strtoupper($report->title),
            $report->category,
            $report->year,
            $report->description ?? '-',
            $report->is_published ? 'PUBLIK' : 'DRAFT',
            $report->created_at->format('d/m/Y')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');
        $sheet->mergeCells('A3:G3');

        $styleHeader = [
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];

        $sheet->getStyle('A1:A2')->applyFromArray($styleHeader);
        
        // Table Head Style
        $sheet->getStyle('A5:G5')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E293B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A6:G' . $lastRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER]
        ]);

        return [];
    }
}
