<?php
require_once '../../includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table_id = $_POST['table_id'] ?? null;
    $status   = $_POST['status'] ?? null;

    if ($table_id && in_array($status, ['OPEN', 'CLOSED'])) {
        $stmt = $pdo->prepare("UPDATE tables SET status = ? WHERE table_id = ?");
        $stmt->execute([$status, $table_id]);
        echo "success";
    } else {
        echo "invalid";
    }
}
?>