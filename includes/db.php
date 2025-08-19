<?php

$env = parse_ini_file(__DIR__ . '/../.env');

$host = $env['DB_HOST'] ?? 'localhost';
$db   = $env['DB_NAME'] ?? 'projecthobby';
$user = $env['DB_USER'] ?? 'root';
$pass = $env['DB_PASS'] ?? '';
$charset = 'ulf8mb4';

$dsn = "mysql:host=$host;dbname=$db;chraset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,

];

try{
    $pdo = new PDO($dsn ,$user ,$pass ,$options);
} catch (\PDOException $e){
    echo "❌ Database Connection failed" . $e->getMessage();
    exit;
}