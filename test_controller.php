<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\Admin\exports\ExportsController;
use Illuminate\Http\Request;

try {
    $controller = new ExportsController();
    $request = new Request();
    $response = $controller->exportExcelStockTiempoReal($request);
    echo "Controller call successful!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " on line " . $e->getLine() . "\n";
} catch (\Throwable $t) {
    echo "Throwable Error: " . $t->getMessage() . "\n";
    echo "File: " . $t->getFile() . " on line " . $t->getLine() . "\n";
}
