<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "--- TABLES ---\n";
$tables = DB::select('SHOW TABLES');
foreach ($tables as $table) {
    print_r($table);
}

echo "\n--- DESCRIBE solicitud_guias ---\n";
try {
    $res = DB::select("DESCRIBE solicitud_guias");
    foreach ($res as $row) {
        echo "{$row->Field} - {$row->Type}\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
