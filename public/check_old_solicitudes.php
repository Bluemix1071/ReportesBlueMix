<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
use Illuminate\Support\Facades\DB;

$pendientes = DB::table('solicitud_guias')
    ->where('estado', 0)
    ->whereNull('nro_bodega')
    ->get();

echo "Hay " . count($pendientes) . " solicitudes antiguas pendientes sin nro_bodega.\n";
