<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WbpImport;

// Create a mock Excel file with 150 rows
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Headers
$headers = ["Nama Lengkap", "No. Registrasi", "Tgl Msk UPT", "Tgl Ekspirasi", "Nm Alias 1", "Nm Alias 2", "Nm Alias 3", "Nm Kecil 1", "Nm Kecil 2", "Nm Kecil 3", "Blok", "Lokasi Sel"];
foreach ($headers as $colIndex => $header) {
    $sheet->setCellValueByColumnAndRow($colIndex + 1, 1, $header);
}

// 150 mock rows
for ($i = 1; $i <= 150; $i++) {
    $row = [
        "MOCK NAME $i",
        "REG-$i",
        45713,
        46195,
        "ALIAS-$i",
        "", "", "", "", "",
        "A",
        "A1"
    ];
    foreach ($row as $colIndex => $val) {
        $sheet->setCellValueByColumnAndRow($colIndex + 1, $i + 1, $val);
    }
}

$writer = new Xlsx($spreadsheet);
$tempFile = tempnam(sys_get_temp_dir(), 'mock_wbp') . '.xlsx';
$writer->save($tempFile);

echo "Created mock excel with 150 data rows at: $tempFile\n";

// Run import inside database transaction to not affect real db
DB::beginTransaction();
try {
    $import = new WbpImport();
    Excel::import($import, $tempFile);
    
    echo "Total elements in importedNoRegs: " . count($import->importedNoRegs) . "\n";
    echo "First 5: " . implode(', ', array_slice($import->importedNoRegs, 0, 5)) . "\n";
    echo "Last 5: " . implode(', ', array_slice($import->importedNoRegs, -5)) . "\n";
} finally {
    DB::rollBack();
    if (file_exists($tempFile)) {
        unlink($tempFile);
    }
}
