<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

header('Content-Type: text/plain');

echo "--- Connection Info ---\n";
echo "DB_CONNECTION: " . config('database.default') . "\n";
echo "DB_DATABASE: " . config('database.connections.'.config('database.default').'.database') . "\n";
echo "DB_USERNAME: " . config('database.connections.'.config('database.default').'.username') . "\n";

echo "\n--- solicitud_guias Columns ---\n";
try {
    $columns = DB::getSchemaBuilder()->getColumnListing('solicitud_guias');
    print_r($columns);
    if (in_array('observacion_despacho', $columns)) {
        echo "Column 'observacion_despacho' EXISTS in schema builder.\n";
    } else {
        echo "Column 'observacion_despacho' DOES NOT EXIST in schema builder.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n--- DB::select check ---\n";
try {
    $res = DB::select("DESCRIBE solicitud_guias");
    foreach ($res as $row) {
        echo "{$row->Field} - {$row->Type}\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
