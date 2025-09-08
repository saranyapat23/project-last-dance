<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';
session_start();

if (isset($_GET['id'])) {
    $menu_id = (int)$_GET['id'];

    // ดึงค่าปัจจุบัน
    $stmt = $pdo->prepare("SELECT is_hot FROM menu WHERE menu_id = ?");
    $stmt->execute([$menu_id]);
    $current = $stmt->fetchColumn();

    // toggle ค่าระหว่าง 0/1
    $newValue = $current == 1 ? 0 : 1;

    $update = $pdo->prepare("UPDATE menu SET is_hot = ? WHERE menu_id = ?");
    $update->execute([$newValue, $menu_id]);

    $_SESSION['menu_hot'] = $newValue ? "ตั้งเป็น Hot Menu แล้ว" : "ยกเลิก Hot Menu แล้ว";
}

header("Location: showmenu.php?menu=1"); // กลับไปหน้า Recommend
exit;
