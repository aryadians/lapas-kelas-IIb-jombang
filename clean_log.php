<?php
$content = file_get_contents('storage/logs/laravel.log');
// Remove null bytes
$content = str_replace("\x00", "", $content);
// Strip UTF-16 BOM if it exists at the start
if (substr($content, 0, 3) === "\xEF\xBB\xBF") {
    $content = substr($content, 3);
} elseif (substr($content, 0, 2) === "\xFF\xFE") {
    $content = substr($content, 2);
} elseif (substr($content, 0, 2) === "\xFE\xFF") {
    $content = substr($content, 2);
}

file_put_contents('storage/logs/laravel_clean.log', trim($content));
echo "Cleaned log saved to storage/logs/laravel_clean.log\n";
