<?php

/**
 * LARAVEL DEPLOYMENT HELPER FOR SHARED HOSTING
 * -------------------------------------------
 * Cara Pakai:
 * 1. Upload semua file project ke hosting.
 * 2. Akses: namadomain.com/deploy-helper.php?token=lapasjombang2026
 */

$token = "lapasjombang2026"; // Ganti ini dengan kata rahasia Anda

if (!isset($_GET['token']) || $_GET['token'] !== $token) {
    die("Akses ditolak. Token tidak valid.");
}

function runArtisan($command) {
    echo "<h3>Menjalankan: php artisan $command</h3>";
    try {
        $artisan = __DIR__ . '/../artisan';
        $output = shell_exec("php $artisan $command 2>&1");
        echo "<pre>$output</pre>";
        echo "<p style='color:green'>✅ Selesai</p><hr>";
    } catch (Exception $e) {
        echo "<p style='color:red'>❌ Error: " . $e->getMessage() . "</p><hr>";
    }
}

echo "<h1>Laravel Deployment Assistant</h1>";

// 1. Jalankan Migrasi
runArtisan("migrate --force");

// 2. Buat Symlink Storage
runArtisan("storage:link");

// 3. Clear Cache
runArtisan("optimize:clear");
runArtisan("config:cache");
runArtisan("view:cache");

echo "<h2>🎉 Semua proses berhasil dijalankan.</h2>";
echo "<p style='color:orange'><strong>PENTING:</strong> Segera hapus file ini dari server demi keamanan!</p>";
