<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "Adding virtual column ARCODI_PREFIX...\n";
    DB::statement("ALTER TABLE producto ADD COLUMN ARCODI_PREFIX VARCHAR(5) AS (LEFT(ARCODI, 5)) VIRTUAL");
    echo "Adding index idx_arcodi_prefix...\n";
    DB::statement("ALTER TABLE producto ADD INDEX idx_arcodi_prefix (ARCODI_PREFIX)");
    echo "Optimization applied successfully!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
