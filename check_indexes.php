<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = ['cargos', 'dcargos', 'inventa', 'producto', 'requerimiento_compra'];

foreach ($tables as $table) {
    try {
        echo "Indexes for $table:\n";
        $res = DB::select("SHOW INDEX FROM $table");
        foreach ($res as $index) {
            echo "- " . $index->Key_name . ": " . $index->Column_name . "\n";
        }
        echo "\n";
    } catch (\Exception $e) {
        echo "$table: " . $e->getMessage() . "\n";
    }
}
