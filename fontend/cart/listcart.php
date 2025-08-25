<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';
session_start();

$stmt = $pdo->query("SELECT * FROM cart_item");
$cart_item  = $stmt->fetchALL();

// คำนวณราคารวม
    foreach ($cart_item as $item) {
        $total += $item['price'] * $item['quantity'];
    }


// ดึงข้อมูลตาม type_id

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Cart</title>
  <link rel="stylesheet" href="../../assets/css/stylemore.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #fff9e6; }
    .cart-card { background: #fff; border-radius: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 20px; }
    .cart-title { font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 20px; }
    .cart-item { border-bottom: 1px solid #eee; padding: 10px 0; }
    .cart-item:last-child { border-bottom: none; }
    .item-name { font-size: 18px; font-weight: 500; }
    .item-price { color: #444; }
    .remove-btn { background: #ff6961; color: #fff; border: none; border-radius: 12px; padding: 5px 12px; cursor: pointer; text-decoration: none; }
    .checkout-btn { background: #ff914d; border: none; border-radius: 20px; padding: 12px 24px; color: #fff; font-size: 18px; font-weight: bold; float: right; }
  </style>
</head>
<body>
<?php include "../../backoffice/components/navbar.php"?>

<div class="container mt-4">
  <div class="cart-card">
    <div class="cart-title">🛒 My Cart</div>

    <?php if (empty($cart_item)): ?>
      <p class="text-center">ตะกร้าของคุณยังว่างเปล่า</p>
    <?php else: ?>
      <?php foreach ($cart_item as $item): ?>
        <div class="cart-item row align-items-center">
          <div class="col-md-2">
            <img src="../../backoffice/uploads/imgmenu<?= htmlspecialchars($item['image']) ?>" class="img-fluid rounded" alt="">
          </div>
          <div class="col-md-6">
            <p class="item-name mb-1"><?= htmlspecialchars($item['name']) ?></p>
            <p class="item-price mb-0"><?= $item['price'] ?> B x <?= $item['quantity'] ?></p>
          </div>
          <div class="col-md-4 text-end">
            <a href="cart.php?remove=<?= $item['id'] ?>" class="remove-btn">ลบ</a>
          </div>
        </div>
      <?php endforeach; ?>

      <div class="mt-3 text-end">
        <h5>รวมทั้งหมด: <?= $total ?> B</h5>
        <form action="checkout.php" method="post">
            <button type="submit" class="checkout-btn">Checkout</button>
        </form>
      </div>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
