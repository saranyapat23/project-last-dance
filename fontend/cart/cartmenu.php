<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';
session_start();

$stmt = $pdo->query("SELECT * FROM cart_item");
$menus = $stmt->fetchALL();

$menu = isset($_GET['menu']) ? (int)$_GET['menu'] : 1;


$totalPrice = 0;
foreach ($menus as $m) {
    $totalPrice += $m['price'];
}

$menu = isset($_GET['menu']) ? (int)$_GET['menu'] : 1;
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RecMenu</title>
  <link rel="stylesheet" href="../../assets/css/stylemore.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body class="body">
  <?php include "../../backoffice/components/navbar.php" ?>

  <div><a href="./foodrec.php"><img src="./assets/img/back-arrow.png" alt="" style="width: 50px; margin-top: 5px; margin-left: 15px; margin-bottom: 15px;"></a></div>
  <div class="container position-relative">

    <div class="menu-card">
        <?php foreach ($menus as $menu): ?>
      <div class="menu-item">
        <img src="../../backoffice/uploads/imgmenu/<?= htmlspecialchars($menu['image']) ?>"  alt="รูปภาพ" onerror="this.onerror=null; this.src='../../assets/img/preview.png';">
        <div class="menu-text">
          <div class="menu-title"><?= htmlspecialchars($menu['name'])?></div>
          <div class="menu-subtitle"><?= htmlspecialchars($menu['description'])?></div>
        </div>
        <div class="menu-price"><?= htmlspecialchars($menu['price'])?> ฿ </div>
        <a class="delete-btn" 
   href="javascript:void(0);" 
   onclick="confirmDelete('delete_cart.php?id=<?= htmlspecialchars($menu['id']) ?>')">
   <img src="../../assets/img/bin.png" alt="delete">
</a>      </div>
      
      <?php endforeach; ?>
      <div class="total-section">
        Total Price: <span style="margin-left: 5px;"><?= htmlspecialchars($totalPrice) ?></span> ฿
        <button class="ms-auto order-btn">ยืนยันคำสั่งซื้อ</button>
        </div>

    </div>
  </div>
<?php if (!empty($_SESSION['menu_deleted'])): ?>
  <p style="color: green;">ลบเมนูเรียบร้อยแล้ว</p>
  <?php unset($_SESSION['menu_deleted']); ?>
<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function confirmDelete(url) {
    Swal.fire({
      title: 'คุณแน่ใจหรือไม่?',
      text: "ลบเมนู <?= htmlspecialchars($menu['name']) ?> หรือไม่",
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
<footer></footer>
</html>