<?php
$dir = __DIR__;
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
foreach ($iterator as $file) {
    if ($file->isDir()) continue;
    $ext = $file->getExtension();
    if (!in_array($ext, ['php', 'md', 'json', 'xml'])) continue;
    if ($file->getFilename() === 'rename_script.php') continue;
    // Skip vendor directory completely
    if (strpos($file->getPathname(), DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR) !== false) continue;

    $content = file_get_contents($file->getPathname());
    
    // Replacements
    $content = str_replace('AskMe', 'ArtifyForm', $content);
    $content = str_replace('askme', 'artifyform', $content);
    $content = str_replace('AskForm', 'ArtifyForm', $content);
    
    file_put_contents($file->getPathname(), $content);
}

// Rename files if they exist
$renames = [
    '/src/AskForm.php' => '/src/ArtifyForm.php',
    '/src/Integration/WordPress/AskMeWP.php' => '/src/Integration/WordPress/ArtifyFormWP.php',
    '/src/Integration/Laravel/AskMeServiceProvider.php' => '/src/Integration/Laravel/ArtifyFormServiceProvider.php',
    '/tests/AskFormTest.php' => '/tests/ArtifyFormTest.php'
];

foreach ($renames as $old => $new) {
    if (file_exists($dir . $old)) {
        rename($dir . $old, $dir . $new);
    }
}

echo "Rename complete.";
