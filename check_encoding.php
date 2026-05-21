<?php
$content = file_get_contents('storage/logs/laravel.log');
$len = strlen($content);
echo "Length in bytes: $len\n";
echo "First 100 bytes (hex):\n";
for ($i = 0; $i < min($len, 100); $i++) {
    printf("%02X ", ord($content[$i]));
}
echo "\n";
// Let's print the first 100 characters in different encodings
echo "First 100 bytes as UTF-8: " . substr($content, 0, 100) . "\n";
echo "First 100 bytes as UTF-16LE: " . mb_convert_encoding(substr($content, 0, 100), 'UTF-8', 'UTF-16LE') . "\n";
echo "First 100 bytes as UTF-16BE: " . mb_convert_encoding(substr($content, 0, 100), 'UTF-8', 'UTF-16BE') . "\n";
