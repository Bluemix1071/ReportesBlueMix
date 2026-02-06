<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $view = DB::select("SHOW CREATE VIEW suma_bodega");
    print_r($view);
} catch (\Exception $e) {
    echo "Not a view or error: " . $e->getMessage() . "\n";
    
    try {
        $tableInfo = DB::select("SHOW CREATE TABLE suma_bodega");
        print_r($tableInfo);
    } catch (\Exception $e2) {
        echo "Error showing table: " . $e2->getMessage() . "\n";
    }
}
