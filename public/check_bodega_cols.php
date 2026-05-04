<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
use Illuminate\Support\Facades\DB;

$res1 = DB::select('SELECT * FROM salida_de_bodega ORDER BY id DESC LIMIT 5');
$res2 = DB::select('SELECT * FROM dsalida_bodega ORDER BY id DESC LIMIT 5');
print_r($res1);
print_r($res2);
