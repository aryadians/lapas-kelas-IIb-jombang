<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$results = DB::table('wbps')
    ->select('status', 'updated_at', DB::raw('count(*) as count'))
    ->groupBy('status', 'updated_at')
    ->orderBy('updated_at', 'desc')
    ->limit(50)
    ->get();

echo "WBP Status & Updated At Counts:\n";
foreach ($results as $row) {
    echo "- Status: {$row->status}, Updated At: {$row->updated_at}, Count: {$row->count}\n";
}
