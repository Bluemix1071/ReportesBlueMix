<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

try {
    DB::beginTransaction();
    
    // Obtener primero el Nro Bodega
    $maxNro = DB::table('salida_de_bodega')->max('nro');
    $nroBodega = $maxNro ? $maxNro + 1 : 1;

    $id = DB::table('solicitud_guias')->insertGetId([
        'usuario' => 'TEST_SCRIPT',
        'fecha_solicitud' => date('Y-m-d H:i:s'),
        'estado' => 0,
        'nro_bodega' => $nroBodega,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ]);

    // Integración con Bodega System (salida_de_bodega)
    DB::table('salida_de_bodega')->insert([
        'nro' => $nroBodega,
        'fecha' => date('Y-m-d'),
        'hora' => date('H:i'),
        'usuario' => 'TEST_SCRIPT',
        'estado' => 'W', // Pendiente
        'tipo' => 'S' // Sucursal
    ]);

    $prod = ['codigo' => 'TEST1', 'detalle' => 'Item', 'marca' => 'M', 'cantidad' => 1];
    
    DB::table('dsolicitud_guias')->insert([
        'id_solicitud' => $id,
        'articulo' => $prod['codigo'],
        'detalle' => $prod['detalle'],
        'marca' => $prod['marca'] ?? '',
        'cantidad' => $prod['cantidad'],
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ]);

    DB::table('dsalida_bodega')->insert([
        'id' => $nroBodega,
        'articulo' => $prod['codigo'],
        'cantidad' => $prod['cantidad'],
        'destino' => 'SUCURSAL',
        'desde' => '',
        'tipo' => 'S',
        'ubicacion' => ''
    ]);

    DB::rollBack(); // rollback since it's a test
    echo "SUCCESS: Logic works without errors.\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}
