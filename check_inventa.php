<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "Columns of inventa:\n";
    $columns = DB::select("SHOW COLUMNS FROM inventa");
    print_r($columns);
    echo "\nIndexes of inventa:\n";
    $indexes = DB::select("SHOW INDEX FROM inventa");
    print_r($indexes);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
