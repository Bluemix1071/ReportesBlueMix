<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $sql = "select count(*) as aggregate from `bodeprod` as `bp` inner join `producto` as `p` on `p`.`ARCODI` = `bp`.`bpprod` inner join `precios` as `pr` on `pr`.`PCCODI` = `p`.`ARCODI_PREFIX` left join `suma_bodega` as `sb` on `sb`.`inarti` = `bp`.`bpprod`";
    echo "Running query: $sql\n";
    $result = DB::select($sql);
    print_r($result);
    echo "Query successful!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
