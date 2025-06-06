<?php
$serverName = "localhost,1433\\SQLEXPRESS"; // o 127.0.0.1
$connectionOptions = [
    "Database" => "facturae",
    "Uid" => "sa",
    "PWD" => "2413",
    "Encrypt" => false,
    "TrustServerCertificate" => true,
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn) {
    echo "Conexión exitosa";
} else {
    die(print_r(sqlsrv_errors(), true));
}