<?php 
require_once '../../includes/db.php';
session_start();

$order_id = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
$new_status = $_POST['new_status'] ?? null;
$isCancel = isset($_POST['cancel']) && $_POST['cancel'] == 1;

if ($order_id <= 0) {
    die('ไม่มีรหัสคำสั่งซื้อ');
}

// กำหนดสถานะที่ถูกต้องในฐานข้อมูล
$valid_status = ['รอรับออร์เดอร์', 'กำลังทำ', 'เสร็จแล้ว', 'ยกเลิก'];

try {
    if ($isCancel) {
        $stmt = $pdo->prepare("UPDATE orders SET status = 'ยกเลิก' WHERE id = ?");
        $stmt->execute([$order_id]);
        $_SESSION['message'] = "คำสั่งซื้อนี้ถูกยกเลิกแล้ว";
    } elseif ($new_status && in_array($new_status, $valid_status)) {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$new_status, $order_id]);
        $_SESSION['message'] = "อัปเดตสถานะเป็น $new_status สำเร็จ";
    } else {
        die('สถานะไม่ถูกต้องหรือไม่มีการกระทำใด ๆ');
    }

    header("Location: order_detail.php?id=$order_id");
    exit;
} catch (Exception $e) {
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}
?>
