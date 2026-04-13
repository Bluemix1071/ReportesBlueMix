<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

header('Content-Type: text/plain');
echo "APP_ENV: " . env('APP_ENV') . "\n";
echo "DB_CONNECTION: " . env('DB_CONNECTION') . "\n";
echo "DB_DATABASE: " . env('DB_DATABASE') . "\n";
echo "DB_HOST: " . env('DB_HOST') . "\n";
echo "DB_USERNAME: " . env('DB_USERNAME') . "\n";

// Check if file .env exists and is readable
echo ".env exists: " . (file_exists(__DIR__.'/../.env') ? 'YES' : 'NO') . "\n";
echo ".env readable: " . (is_readable(__DIR__.'/../.env') ? 'YES' : 'NO') . "\n";
