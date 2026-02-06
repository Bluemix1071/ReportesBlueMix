<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $pdo = DB::connection()->getPdo();
    echo $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
