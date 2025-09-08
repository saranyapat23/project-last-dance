<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';
session_start();

// ตอนเริ่มหน้า cart.php
if (!isset($_SESSION['cart_id'])) {
    if (!isset($_SESSION['table_id'])) {
        die("ไม่พบ table_id กรุณา scan QR code ใหม่");
    }

    $table_id = $_SESSION['table_id'];

    $stmt = $pdo->prepare("INSERT INTO cart (table_id) VALUES (?)");
    $stmt->execute([$table_id]);

    $_SESSION['cart_id'] = $pdo->lastInsertId();
}

$cart_id = $_SESSION['cart_id'];


// ดึงรายการใน cart_items พร้อมข้อมูลจาก menu
$stmt = $pdo->prepare("
    SELECT ci.id AS cart_item_id, ci.cart_id, ci.menu_id, ci.quantity, ci.note,
           m.name, m.image, m.price
    FROM cart_items ci
    JOIN menu m ON ci.menu_id = m.menu_id
    WHERE ci.cart_id = ?
"); 
$stmt->execute([$cart_id]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);


// คำนวณ total price
$totalPrice = 0;
foreach ($cartItems as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])) {
    // 1. คำนวณ total price
    $totalPrice = 0;
    foreach ($cartItems as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }

    $stmtTable = $pdo->prepare("SELECT table_id FROM cart WHERE id = ?");
    $stmtTable->execute([$cart_id]);
    $table_id = $stmtTable->fetchColumn();

    // 2. สร้าง order ใหม่
    $stmt = $pdo->prepare("INSERT INTO orders (table_id, total_price, status) VALUES (?, ?, ?)");
    $stmt->execute([$table_id, $totalPrice, 'pending']);
    $order_id = $pdo->lastInsertId();

    // 3. ย้าย cart_items → order_details
    $stmt = $pdo->prepare("INSERT INTO order_details (order_id, menu_id, quantity, price, note) VALUES (?, ?, ?, ?, ?)");
    foreach ($cartItems as $item) {
        $stmt->execute([
            $order_id,
            $item['menu_id'],
            $item['quantity'],
            $item['price'],
            $item['note'] ?? null
        ]);
    }

    // 4. ลบ cart_items ของ cart นี้
    $stmt = $pdo->prepare("DELETE FROM cart_items WHERE cart_id = ?");
    $stmt->execute([$cart_id]);

    // 5. ลบ cart_id ใน session
    unset($_SESSION['cart_id']);

    // 6. รีไดเรกต์ไปหน้า thank you / order list
    header('Location: ../../fontend/main/menu.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../../assets/img/casino.png">
  <title>Hobby Board Game Cafe</title>
  <link rel="stylesheet" href="../../assets/css/stylemore.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="body background-customer">
  <?php include "../../backoffice/components/navbar.php" ?>

  <div class="container position-relative">
    <div class="menu-card">
      <?php if (!empty($cartItems)): ?>
        <?php foreach ($cartItems as $item): ?>
        <div class="menu-item">
           <img src="../../backoffice/uploads/imgmenu/<?= htmlspecialchars($item['image']) ?>" alt="">
    <div class="menu-text">
        <div class="menu-title"><?= htmlspecialchars($item['name']) ?></div>
        <div class="menu-subtitle">
    <?= htmlspecialchars($_SESSION['cart_optional'][$item['cart_item_id']] ?? '(ไม่ได้เพิ่มรายละเอียด)') ?>
</div>
    </div>
    <div class="menu-price"><?= htmlspecialchars($item['price']) ?> ฿</div>

         <a class="delete-btn"  href="javascript:void(0);" onclick="confirmDelete('delete_cart.php?id=<?= $item['cart_item_id'] ?>', '<?= htmlspecialchars($item['name']) ?>')">
   <img src="../../assets/img/bin.png" alt="delete"> </a>

        </div>
        <?php endforeach; ?>
        <form method="POST">
        <div class="total-section"> Total Price: <span style="margin-left: 5px;"><?= htmlspecialchars($totalPrice) ?></span> ฿ 
        
        <button name="confirm_order" class="ms-auto order-btn" style="padding-top: 20px;">ยืนยันคำสั่งซื้อ</button> </div>
        </form>

      <?php else: ?>
        <div class="text-center" style="padding: 30px;">
          <img src="../../assets/img/panda.png" alt="ไม่มีออเดอร์" style="width:120px; opacity:0.7;">
          <p style="margin-top: 15px; font-size: 18px; color: #777;">ยังไม่มีออเดอร์ในตะกร้า</p>
        </div>
      <?php endif; ?>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(url, name) {
  Swal.fire({
    title: 'คุณแน่ใจหรือไม่?',
    text: `เมนู ${name} จะถูกลบถาวร`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#e74c3c',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'ใช่, ลบเลย!',
    cancelButtonText: 'ยกเลิก'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  })
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
