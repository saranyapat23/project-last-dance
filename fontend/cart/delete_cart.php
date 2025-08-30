<?php
require_once '../../includes/db.php';

session_start();

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM cart_items WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['menu_deleted'] = true; 
}
    header('Location: cartmenu.php');
    exit;
?>

