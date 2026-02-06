<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$query = DB::table('bodeprod as bp')
    ->join('producto as p', 'p.ARCODI', '=', 'bp.bpprod')
    ->join('precios as pr', 'pr.PCCODI', '=', DB::raw('LEFT(p.ARCODI, 5)'))
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
    ]);

echo "SQL: " . $query->toSql() . "\n";
$explain = DB::select("EXPLAIN " . $query->toSql(), $query->getBindings());
foreach ($explain as $row) {
    print_r($row);
}
