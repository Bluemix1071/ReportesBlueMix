<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use Illuminate\Support\Facades\DB;

function showIndexes($table) {
    echo "--- INDEXES FOR $table ---" . PHP_EOL;
    try {
        $indexes = DB::select("SHOW INDEX FROM $table");
        print_r($indexes);
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . PHP_EOL;
    }
}

showIndexes('Stock_critico_2');
showIndexes('producto_clasificar');
showIndexes('vv_tablas22');

echo "--- EXPLAIN QUERY ---" . PHP_EOL;
$sql = 'select sc.Codigo, sc.Detalle, sc.Marca_producto, sc.codigo_familia, sc.fecha, sc.Media_de_ventas, sc.Bodega, fam.taglos as familia_nombre from Stock_critico_2 as sc left join vv_tablas22 as fam on sc.codigo_familia = fam.tarefe left join producto_clasificar as pc on sc.Codigo = pc.Codigo where sc.Media_de_ventas * 1.2 >= sc.Bodega and pc.Codigo is null group by sc.Codigo, sc.Detalle, sc.Marca_producto, sc.codigo_familia, sc.fecha, sc.Media_de_ventas, sc.Bodega, fam.taglos order by sc.Media_de_ventas desc';

try {
    $explain = DB::select("EXPLAIN $sql");
    print_r($explain);
} catch (\Exception $e) {
    echo "Error explaining: " . $e->getMessage() . PHP_EOL;
}
