<?php 
require_once 'includes/db.php';

$migrationsDir = __DIR__ . '/migrations';
$migrationFiles = array_diff(scandir($migrationsDir), ['.', '..']);

foreach ($migrationFiles as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
        echo "Running: $file\n";
        $migration = require $migrationsDir . '/' . $file;
        $migration($pdo); 
        echo "✅ Completed: $file\n";
    }
}