<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = ['bodeprod', 'producto', 'precios', 'suma_bodega'];

foreach ($tables as $table) {
    echo "\nTable: $table\n";
    try {
        echo "Columns:\n";
        $columns = DB::select("SHOW COLUMNS FROM $table");
        foreach ($columns as $col) {
            echo " - {$col->Field} ({$col->Type}) Key: {$col->Key}\n";
        }
        echo "Indexes:\n";
        $indexes = DB::select("SHOW INDEX FROM $table");
        foreach ($indexes as $idx) {
            echo " - {$idx->Key_name}: {$idx->Column_name}\n";
        }
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
