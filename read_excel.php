<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$file = 'public/storage/export_test_all_20260220232428.xlsx';

if (!file_exists($file)) {
    die("File not found: $file\n");
}

$spreadsheet = IOFactory::load($file);
$sheet = $spreadsheet->getActiveSheet();
$rows = $sheet->toArray();

echo "Total Rows in Excel (including header): " . count($rows) . "\n";
if (count($rows) > 0) {
    echo "Headers:\n";
    print_r($rows[0]);
    echo "First 5 data rows:\n";
    for ($i = 1; $i <= min(5, count($rows) - 1); $i++) {
        print_r($rows[$i]);
    }
}
