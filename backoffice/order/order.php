<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';
session_start();

$stmt = $pdo->query("SELECT * FROM orders");
$menus = $stmt->fetchALL();

$statusMap = [
    1 => 'pending',  // PLACE ORDER
    2 => 'preparing',     // PROGRESS
    3 => 'completed'     // COMPLETED
];

$menu = isset($_GET['menu']) ? (int)$_GET['menu'] : 1;
$status = $statusMap[$menu] ?? 'place_order';

// ดึงออร์เดอร์ตาม status
$stmt = $pdo->prepare("SELECT * FROM orders WHERE status = ?");
$stmt->execute([$status]);
$menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
 
    
<form id="menuForm" method="get">
  <div class="menu-options-customer">
    <input type="radio" id="menu1" name="menu" value="1" <?= $menu === 1 ? 'checked' : '' ?>>
    <label for="menu1">PLACE ORDER</label>

    <input type="radio" id="menu2" name="menu" value="2" <?= $menu === 2 ? 'checked' : '' ?>>
    <label for="menu2">PROGRESS</label>

    <input type="radio" id="menu3" name="menu" value="3" <?= $menu === 3 ? 'checked' : '' ?>>
    <label for="menu3">COMPLETED</label>
  </div>
</form>
    
 <div class="container position-relative">
    
   <div class="menu-card">
    <?php if (empty($menus)): ?>
        <p style="text-align:center; margin: 20px 0; color: gray;">ไม่มีรายการสำหรับสถานะนี้</p>
    <?php else: ?>
        <?php foreach ($menus as $menu): ?>
        <div class="menu-item">
            <div class="menu-text">
                <div class="menu-title">โต๊ะที่ <?= htmlspecialchars($menu['table_id'])?></div>
                <div class="menu-subtitle" style="margin-top:5px;">สั่งเมื่อ <?= htmlspecialchars($menu['order_at'])?></div>
            </div>
            <a class="info-btn" href="order_detail.php?id=<?= $menu['table_id']?>"> 
                <img src="../../assets/img/information.png" alt="">
            </a>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
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
      text: "ข้อมูลจะถูกลบถาวร",
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

<script>
  // submit form อัตโนมัติเมื่อเลือก radio
  const radios = document.querySelectorAll('input[name="menu"]');
  radios.forEach(radio => {
    radio.addEventListener('change', () => {
      document.getElementById('menuForm').submit();
    });
  });
</script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
<footer></footer>
</html>