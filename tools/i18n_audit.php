<?php

$base = __DIR__ . '/../resources/lang';
$locales = ['ca', 'en', 'es'];
$files = ['messages.php', 'auth.php', 'validation.php', 'actions.php', 'passwords.php', 'pagination.php', 'http-statuses.php'];

$flatten = function (array $arr, string $prefix = '') use (&$flatten): array {
    $out = [];
    foreach ($arr as $k => $v) {
        $key = $prefix === '' ? (string) $k : $prefix . '.' . $k;
        if (is_array($v)) {
            $out = array_merge($out, $flatten($v, $key));
            continue;
        }
        $out[$key] = 1;
    }
    return $out;
};

$hasMissing = false;
foreach ($files as $file) {
    $all = [];
    foreach ($locales as $loc) {
        $path = "$base/$loc/$file";
        if (!file_exists($path)) {
            $hasMissing = true;
            echo "MISSING file: $path" . PHP_EOL;
            continue;
        }
        $data = include $path;
        $all[$loc] = $flatten($data);
    }

    $union = [];
    foreach ($all as $set) {
        $union = array_replace($union, $set);
    }

    foreach ($locales as $loc) {
        if (!isset($all[$loc])) {
            continue;
        }
        $missing = array_diff_key($union, $all[$loc]);
        if (count($missing) > 0) {
            $hasMissing = true;
            echo "MISSING in $loc for $file: " . count($missing) . PHP_EOL;
        }
    }
}

if (!$hasMissing) {
    echo 'PHP locale files: OK' . PHP_EOL;
}

$views = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/../resources/views'));
$strings = [];
foreach ($views as $file) {
    if ($file->isDir()) {
        continue;
    }
    if (!str_ends_with($file->getFilename(), '.blade.php')) {
        continue;
    }
    $content = file_get_contents($file->getPathname());
    if (preg_match_all('/__\(\s*[\"\']([^\"\']+)[\"\']\s*\)/', $content, $m)) {
        foreach ($m[1] as $key) {
            if (
                !str_starts_with($key, 'messages.')
                && !str_starts_with($key, 'passwords.')
                && !str_starts_with($key, 'validation.')
                && !str_starts_with($key, 'auth.')
            ) {
                $strings[$key] = true;
            }
        }
    }
}

ksort($strings);
$keys = array_keys($strings);
$data = [];
foreach ($locales as $loc) {
    $decoded = json_decode(file_get_contents("$base/$loc.json"), true);
    $data[$loc] = is_array($decoded) ? $decoded : [];
}

$jsonMissing = false;
foreach ($keys as $k) {
    foreach ($locales as $loc) {
        if (!array_key_exists($k, $data[$loc])) {
            $jsonMissing = true;
            echo "JSON missing in $loc: $k" . PHP_EOL;
        }
    }
}

if (!$jsonMissing) {
    echo 'JSON literal keys: OK' . PHP_EOL;
}

exit(($hasMissing || $jsonMissing) ? 1 : 0);
