<?php
require_once '../../includes/db.php';

session_start();

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM menu WHERE menu_id = ?");
    $stmt->execute([$id]);

    $_SESSION['menu_deleted'] = true; 
}
    header('Location: showmenu.php');
    exit;
?>

