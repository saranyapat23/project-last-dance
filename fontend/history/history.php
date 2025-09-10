<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';
session_start();

// ตรวจสอบว่ามี table_id ใน session
if (!isset($_SESSION['table_id'])) {
    die("ไม่พบ table_id กรุณา Scan QR Code ก่อน");
}

$table_id = $_SESSION['table_id'];

// ดึงสถานะโต๊ะ + order ปัจจุบัน (ถ้ามี)
$stmt = $pdo->prepare("
    SELECT t.status AS table_status, t.current_order_id, 
           o.id AS order_id, o.status AS order_status, o.total_price, o.order_at
    FROM tables t
    LEFT JOIN orders o ON t.current_order_id = o.id
    WHERE t.table_id = ?
");
$stmt->execute([$table_id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

// เตรียม array สำหรับ loop
if ($data['table_status'] === 'OPEN' && $data['current_order_id']) {
    $orders = [$data]; // order ปัจจุบัน
} else {
    $orders = []; // โต๊ะปิด → ไม่มี order แสดง
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hobby Board Game Cafe</title>
    <link rel="stylesheet" href="../../assets/css/stylemore.css">
    <link rel="icon" type="image/x-icon" href="../../assets/img/casino.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="body"> 
<nav class="navbar navbar-expand-lg nav-color">
    <div class="container-fluid">
        <div>
            <img src="../../assets/img/152431942_114763933966355_8265361494354481544_n.png" alt="" width="100px" height="100px">
        </div>
        <div class="ms-auto adminnav">
            <a href="../../fontend/main/menu.php"><img src="../../assets/img/menu.png" alt="" style="width: 55px; margin-left: 7px; margin-top: 2px;"></a>
        </div>
        <div class="table-number">
            Table <?= htmlspecialchars($table_id) ?>
        </div>
    </div>
</nav>

<div>
    <a href="./index.php">
        <img src="./assets/img/back-arrow.png" alt="" style="width: 50px; margin-top: 5px; margin-left: 15px; margin-bottom: 15px;">
    </a>
</div>

<div class="container-history">
    <div class="card-history">
        <p class="order-history-text">Order History</p>
        <div class="order-list">
            <?php if (!empty($orders)): ?>
                <?php 
                $statusColors = [
                    'pending'   => 'pastel-yellow',
                    'preparing' => 'pastel-blue',
                    'completed' => 'pastel-green'
                ];
                $statusText = [
                    'pending'   => 'รอรับออเดอร์',
                    'preparing' => 'กำลังจัดเตรียม',
                    'completed' => 'เสร็จเรียบร้อย'
                ];
                ?>
                <?php foreach ($orders as $od): ?>
                    <?php
                        $status = $od['order_status'] ?? ''; // ป้องกันค่า NULL หรือว่าง
                        $badgeClass = $statusColors[$status] ?? 'secondary';
                        $displayStatus = $statusText[$status] ?? 'ไม่ระบุสถานะ';
                    ?>
                    <?= htmlspecialchars($od['order_id']) ?>
                    <div class="order-item">
                        <div class="order-time fw-bold"><?= date('H:i A', strtotime($od['order_at'])) ?></div>
                        <span style="font-size: 20px" class="badge rounded-pill <?= $badgeClass ?>">
                            สถานะ: <?= $displayStatus ?>
                        </span>
                        <a class="check-btn" href="detail.php?id=<?= htmlspecialchars($od['order_id']) ?>">ตรวจสอบรายการ</a>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
                <p style="padding: 20px; text-align:center; color:#555;">ยังไม่มีออเดอร์</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
