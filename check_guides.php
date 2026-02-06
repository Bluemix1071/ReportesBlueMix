<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->handle(new Symfony\Component\Console\Input\ArgvInput(['artisan']));

use Illuminate\Support\Facades\DB;

echo "\n--- SEARCHING FOR DETAILS IN dcargos ---\n";
try {
    $details = DB::select("SELECT * FROM dcargos WHERE DENMRO IN (3727, 3728)");
    print_r($details);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
