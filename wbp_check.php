<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Total: " . \App\Models\Wbp::count() . "\n";
echo "Aktif: " . \App\Models\Wbp::where('status', 'Aktif')->count() . "\n";
echo "Bebas: " . \App\Models\Wbp::where('status', 'Bebas')->count() . "\n";
