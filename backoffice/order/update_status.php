<?php 
require_once '../../includes/db.php';
session_start();

$order_id =  $_POST['id'] ?? null;
$new_status = $_POST['new_status'] ?? null;
$isCancel = isset($_POST['cancel']);

if (!$order_id) {
    die('Missing order ID');
}

try {
    if ($isCancel) {
        $stmt = $pdo->prepare("UPDATE orders SET status = 'cancelled' WHERE id = ?");
        $stmt->execute([$order_id]);
        $_SESSION['message'] = "คำสั่งซื้อนี้ถูกยกเลิกแล้ว";
    } elseif ($new_status) {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$new_status, $order_id]);
        $_SESSION['message'] = "อัปเดตสถานะเป็น $new_status สำเร็จ";
    }

    header("Location: order_detail.php?id=$order_id");
    exit;
} catch (Exception $e) {
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}

?>