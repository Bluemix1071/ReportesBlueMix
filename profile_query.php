<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$start = microtime(true);
$query = DB::table('bodeprod as bp')
    ->join('producto as p', 'p.ARCODI', '=', 'bp.bpprod')
    ->join('precios as pr', 'pr.PCCODI', '=', 'p.ARCODI_PREFIX')
    ->leftJoin('suma_bodega as sb', 'sb.inarti', '=', 'bp.bpprod')
    ->select([
        'bp.bpprod as codigo',
        'p.ARDESC as descripcion',
        'p.ARMARCA as marca',
        'bp.bpsrea as stock_sala',
        DB::raw('IFNULL(sb.cantidad, 0) as stock_bodega'),
        'pr.PCPVDET as precio_detalle',
        'pr.PCPVMAY as precio_mayor',
        DB::raw('ROUND(pr.PCCOSTOREA / 1.19, 1) as neto'),
        'pr.FechaCambioPrecio'
    ])
    ->limit(100)
    ->get();
$end = microtime(true);

echo 'Time for 100 rows: ' . ($end - $start) . "s\n";

$startTotal = microtime(true);
$total = DB::table('bodeprod as bp')
    ->join('producto as p', 'p.ARCODI', '=', 'bp.bpprod')
    ->join('precios as pr', 'pr.PCCODI', '=', 'p.ARCODI_PREFIX')
    ->leftJoin('suma_bodega as sb', 'sb.inarti', '=', 'bp.bpprod')
    ->count();
$endTotal = microtime(true);

$startAll = microtime(true);
$all = DB::table('bodeprod as bp')
    ->join('producto as p', 'p.ARCODI', '=', 'bp.bpprod')
    ->join('precios as pr', 'pr.PCCODI', '=', 'p.ARCODI_PREFIX')
    ->leftJoin('suma_bodega as sb', 'sb.inarti', '=', 'bp.bpprod')
    ->select([
        'bp.bpprod as codigo',
        'p.ARDESC as descripcion',
        'p.ARMARCA as marca',
        'bp.bpsrea as stock_sala',
        DB::raw('IFNULL(sb.cantidad, 0) as stock_bodega'),
        'pr.PCPVDET as precio_detalle',
        'pr.PCPVMAY as precio_mayor',
        DB::raw('ROUND(pr.PCCOSTOREA / 1.19, 1) as neto'),
        'pr.FechaCambioPrecio'
    ])
    ->get();
$endAll = microtime(true);

$startSearch = microtime(true);
$search = DB::table('bodeprod as bp')
    ->join('producto as p', 'p.ARCODI', '=', 'bp.bpprod')
    ->join('precios as pr', 'pr.PCCODI', '=', DB::raw('LEFT(p.ARCODI, 5)'))
    ->leftJoin('suma_bodega as sb', 'sb.inarti', '=', 'bp.bpprod')
    ->where('p.ARDESC', 'like', '%LAPICERA%')
    ->select([
        'bp.bpprod as codigo',
        'p.ARDESC as descripcion',
        'p.ARMARCA as marca',
        'bp.bpsrea as stock_sala',
        DB::raw('IFNULL(sb.cantidad, 0) as stock_bodega'),
        'pr.PCPVDET as precio_detalle',
        'pr.PCPVMAY as precio_mayor',
        DB::raw('ROUND(pr.PCCOSTOREA / 1.19, 1) as neto'),
        'pr.FechaCambioPrecio'
    ])
    ->limit(10)
    ->get();
$endSearch = microtime(true);

echo 'Time for search: ' . ($endSearch - $startSearch) . "s\n";
echo 'Search result count: ' . count($search) . "\n";
