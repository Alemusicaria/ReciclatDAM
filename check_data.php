<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== PREMIOS ===\n";
$premis = \App\Models\Premi::all();
echo "Total: " . $premis->count() . "\n";
foreach ($premis as $p) {
    echo "  {$p->nom} - Stock: {$p->stock}, Temps: {$p->temps_enviament}\n";
}

echo "\n=== OPINIONS ===\n";
$opinions = \App\Models\Opinions::all();
echo "Total: " . $opinions->count() . "\n";
foreach ($opinions->take(5) as $o) {
    echo "  {$o->autor} - {$o->estrelles}⭐ ({$o->created_at})\n";
}
