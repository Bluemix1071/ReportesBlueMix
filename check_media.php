<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = ['media_productos'];

foreach ($tables as $table) {
    try {
        $res = DB::select("SHOW CREATE TABLE $table");
        if (isset($res[0]->{'Create View'})) {
            echo "$table is a VIEW\n";
            echo $res[0]->{'Create View'} . "\n\n";
        } else {
            echo "$table is a TABLE\n";
        }
    } catch (\Exception $e) {
        echo "$table: " . $e->getMessage() . "\n";
    }
}
