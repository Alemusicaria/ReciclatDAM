<?php
foreach (['ca','en','es'] as $loc) {
    $p = "resources/lang/$loc.json";
    $c = file_get_contents($p);
    json_decode($c, true);
    echo $loc . ': ' . (json_last_error() === JSON_ERROR_NONE ? 'OK' : 'ERR ' . json_last_error_msg()) . PHP_EOL;
}
