<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';
session_start();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: showmenu.php');
    exit;
}

// JOIN orders กับ menu
$stmt = $pdo->prepare("
    SELECT o.*, m.name, m.description, m.image
    FROM orders o
    JOIN menu m ON o.menu_id = m.menu_id
    WHERE o.table_id = ?
");

$stmt->execute([$id]);
$menus = $stmt->fetchAll(PDO::FETCH_ASSOC);

// คำนวณราคารวม
$totalPrice = 0;
foreach ($menus as $m) {
    $totalPrice += $m['total_price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RecMenu</title>
  <link rel="stylesheet" href="../../assets/css/stylemore.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="body">

<nav class="navbar navbar-expand-lg nav-color">
  <div class="container-fluid">
    <div>
      <img src="../../assets/img/152431942_114763933966355_8265361494354481544_n.png" alt="" width="100px" height="100px">
    </div>
    <div class="ms-auto">
      <a href="https://www.youtube.com/@wachirawit007/videos">
        <img src="./assets/img/history.png" alt="" width="60px" style="margin-right: 10px">
      </a>
    </div>
    <div class="table-number">
      Table <?= htmlspecialchars($id) ?>
    </div>
  </div>่
</nav>

<div>
  <a href="./foodrec.php">
    <img src="./assets/img/back-arrow.png" alt="" style="width: 50px; margin: 5px 0 15px 15px;">
  </a>
</div>

<div class="container position-relative">
  <div class="menu-card">
    <?php foreach ($menus as $menu): ?>
      <div class="menu-item">
        <img src="../../backoffice/uploads/imgmenu/<?= htmlspecialchars($menu['image']) ?>" 
             alt="รูปภาพ" 
             onerror="this.onerror=null; this.src='../../assets/img/preview.png';">
        <div class="menu-text">
          <div class="menu-title"><?= htmlspecialchars($menu['name']) ?></div>
          <div class="menu-subtitle"><?= htmlspecialchars($menu['description']) ?></div>
        </div>
        <div class="menu-price"><?= htmlspecialchars($menu['total_price']) ?> ฿</div>
      </div>
    <?php endforeach; ?>

    <div class="total-section">
      Total Price: <span style="margin-left: 5px;"><?= htmlspecialchars($totalPrice) ?></span> ฿
      <button class="ms-auto order-btn" style="background-color: green; padding-bottom: 3px;">รับออร์เดอร์</button>
      <button onclick="confirmDelete('delete.php?table_id=<?= $id ?>')" 
              class="order-btn" 
              style="background-color: red; margin-left: 5px; padding-bottom: 3px;">
        ยกเลิกออร์เดอร์
      </button>
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
    text: "เมนูโต๊ะ <?= $id ?> จะถูกลบทั้งหมด",
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
  });
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
