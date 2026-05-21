<?php
function find_files($dir) {
    $files = [];
    $iterator = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
    $filter = new RecursiveCallbackFilterIterator($iterator, function ($current, $key, $iterator) {
        $filename = $current->getFilename();
        if ($current->isDir()) {
            // Exclude directories
            return !in_array($filename, ['node_modules', 'vendor', '.git', 'c:Tugas', 'storage']);
        }
        // Include files
        return in_array(pathinfo($filename, PATHINFO_EXTENSION), ['xlsx', 'xls', 'csv']);
    });

    foreach (new RecursiveIteratorIterator($filter) as $file) {
        $files[] = $file->getPathname();
    }
    
    // Also specifically look into storage/app
    if (is_dir($dir . '/storage/app')) {
        $storageFiles = new RecursiveIteratorIterator(
            new RecursiveCallbackFilterIterator(
                new RecursiveDirectoryIterator($dir . '/storage/app', RecursiveDirectoryIterator::SKIP_DOTS),
                function ($current, $key, $iterator) {
                    if ($current->isDir()) {
                        return !in_array($current->getFilename(), ['framework', 'logs']);
                    }
                    return in_array(pathinfo($current->getFilename(), PATHINFO_EXTENSION), ['xlsx', 'xls', 'csv']);
                }
            )
        );
        foreach ($storageFiles as $file) {
            $files[] = $file->getPathname();
        }
    }
    
    return array_unique($files);
}

$all_files = find_files(__DIR__);
echo "Found files:\n";
foreach ($all_files as $f) {
    echo "- $f\n";
}
