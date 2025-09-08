<?php
require_once '../../includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table_id = $_POST['table_id'] ?? null;
    $status   = $_POST['status'] ?? null;
    $time     = date('Y-m-d H:i:s'); // หรือจะรับจาก $_POST['update_at'] ก็ได้

    if ($table_id && in_array($status, ['OPEN', 'CLOSED'])) {
        $stmt = $pdo->prepare("UPDATE tables SET status = ?, update_at = ? WHERE table_id = ?");
        $stmt->execute([$status, $time, $table_id]);
        echo "success";
    } else {
        echo "invalid";
    }
}
