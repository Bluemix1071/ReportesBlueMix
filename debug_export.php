<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Exports\StockTiempoRealExport;

try {
    $export = new StockTiempoRealExport();
    $view = $export->view();
    echo "View generated successfully!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " on line " . $e->getLine() . "\n";
} catch (\Throwable $t) {
    echo "Throwable Error: " . $t->getMessage() . "\n";
    echo "File: " . $t->getFile() . " on line " . $t->getLine() . "\n";
}
