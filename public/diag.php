<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

header('Content-Type: text/plain');

$pdo = DB::connection()->getPdo();
echo "--- DB Connection Stats ---\n";
echo "Server Version: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "\n";
echo "Server Info: " . $pdo->getAttribute(PDO::ATTR_SERVER_INFO) . "\n";
echo "Client Version: " . $pdo->getAttribute(PDO::ATTR_CLIENT_VERSION) . "\n";
echo "Connection Status: " . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

echo "\n--- Database List ---\n";
$dbs = DB::select('SHOW DATABASES');
foreach ($dbs as $db) {
    echo $db->Database . "\n";
}

echo "\n--- Current Database: " . DB::getDatabaseName() . " ---\n";

echo "\n--- Tables in " . DB::getDatabaseName() . " ---\n";
$tables = DB::select('SHOW TABLES');
foreach ($tables as $table) {
    $prop = "Tables_in_" . DB::getDatabaseName();
    echo $table->$prop . "\n";
}

echo "\n--- DESCRIBE solicitud_guias ---\n";
try {
    $res = DB::select("DESCRIBE solicitud_guias");
    foreach ($res as $row) {
        echo "{$row->Field} - {$row->Type}\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
