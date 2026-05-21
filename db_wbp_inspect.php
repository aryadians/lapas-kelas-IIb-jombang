<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Wbp;

echo "Total WBP: " . Wbp::count() . "\n";
echo "Active: " . Wbp::where('status', 'Aktif')->count() . "\n";
echo "Bebas: " . Wbp::where('status', 'Bebas')->count() . "\n";

echo "\nLatest 20 WBP created:\n";
$latestCreated = Wbp::latest()->limit(20)->get();
foreach ($latestCreated as $wbp) {
    echo "- ID: {$wbp->id}, Nama: {$wbp->nama}, Reg: {$wbp->no_registrasi}, Status: {$wbp->status}, Created: {$wbp->created_at}\n";
}

echo "\nLatest 20 WBP updated:\n";
$latestUpdated = Wbp::orderBy('updated_at', 'desc')->limit(20)->get();
foreach ($latestUpdated as $wbp) {
    echo "- ID: {$wbp->id}, Nama: {$wbp->nama}, Reg: {$wbp->no_registrasi}, Status: {$wbp->status}, Updated: {$wbp->updated_at}\n";
}

echo "\nChecking if there are any records created recently:\n";
$recentCount = Wbp::where('created_at', '>=', '2026-05-01')->count();
echo "Count of WBP created since 2026-05-01: $recentCount\n";
