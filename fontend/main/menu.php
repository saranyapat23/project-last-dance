<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';
session_start();

// รับค่า table_id จาก QR code
if (isset($_GET['table_id'])) {
    $_SESSION['table_id'] = (int)$_GET['table_id'];
}

// ถ้าไม่มีทั้ง GET และ SESSION → แสดง error
if (!isset($_SESSION['table_id'])) {
    die("ไม่พบข้อมูลโต๊ะ กรุณา scan QR code ใหม่");
}

// ✅ ตรวจสอบสถานะโต๊ะ
$table_id = $_SESSION['table_id'];
$stmt = $pdo->prepare("SELECT status FROM tables WHERE table_id = ?");
$stmt->execute([$table_id]);
$status = $stmt->fetchColumn();

if ($status !== 'OPEN') {
    echo "
    <div style='display:flex; flex-direction:column; align-items:center; justify-content:center; height:100vh; font-family:sans-serif; background: '>
        <img src='../../assets/img/pig.png' alt='โต๊ะปิด' style='width:150px; margin-bottom:20px; opacity:0.7;'>
        <h2 style='color:red; text-align:center;'>❌ โต๊ะนี้ถูกปิดใช้งาน</h2>
        <p style='color:#555; margin-top:10px;'>กรุณาติดต่อพนักงานเพื่อเปิดใช้งานโต๊ะ</p>
    </div>
    ";
    exit;
}


$stmt = $pdo->query("SELECT * FROM menu");
$menus = $stmt->fetchALL();

$typeMap = [
    1 => 101, // Recommend
    2 => 102, // Food
    3 => 103, // Drink
    4 => 104  // Dessert
];

$menu = isset($_GET['menu']) ? (int)$_GET['menu'] : 1;
$type_id = $typeMap[$menu];

// ดึงข้อมูลตาม type_id

if ($menu == 1) {
    // Recommend menu → is_hot = 1
    $stmt = $pdo->prepare("SELECT * FROM menu WHERE is_hot = 1");
    $stmt->execute();
    $menus = $stmt->fetchAll();
} else {
    // Food/Drink/Dessert → query ตาม type_id
    $type_id = $typeMap[$menu];
    $stmt = $pdo->prepare("SELECT * FROM menu WHERE type_id = ?");
    $stmt->execute([$type_id]);
    $menus = $stmt->fetchAll();
}

if (isset($_GET['table_id'])) {
    $_SESSION['table_id'] = (int)$_GET['table_id'];
}

?>




<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#e2ffadff">
    <link rel="icon" type="image/x-icon" href="../../assets/img/casino.png">
    <title>Hobby Board Game Cafe</title>
    <link rel="stylesheet" href="../../assets/css/stylemore.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
</head>
<body class="body background-customer"> 


<?php include "../layout/navbar.php"?>

<div><a href="./index.php"><img src="./assets/img/back-arrow.png" alt="" style="width: 50px; margin-top: 5px; margin-left: 15px; margin-bottom: 15px;"></a></div>

<form id="menuForm" method="get">
  <div class="menu-options-customer">
    <input type="radio" id="menu1" name="menu" value="1" <?= $menu==1?"checked":"" ?>>
    <label for="menu1">RECOMMEND</label>

    <input type="radio" id="menu2" name="menu" value="2" <?= $menu==2?"checked":"" ?>>
    <label for="menu2">FOOD</label>

    <input type="radio" id="menu3" name="menu" value="3" <?= $menu==3?"checked":"" ?>>
    <label for="menu3">DRINK</label>

    <input type="radio" id="menu4" name="menu" value="4" <?= $menu==4?"checked":"" ?>>
    <label for="menu4">DESSERT</label>
  </div>
</form>


<div class="container mt-4">
  <div class="row justify-content-center g-5">
    <?php if (!empty($menus)): ?>
      <?php foreach ($menus as $menu): ?>
        <div class="col-6 col-md-3 d-flex justify-content-center">
          <a href="../../fontend/main/menu_detail.php?id=<?= $menu['menu_id'] ?>" 
             class="card align-items-center menu-pic border-0 food-pic" 
             style="width: 17rem; border-radius: 25px; margin-top: 30px;">
            
            <img src="../../backoffice/uploads/imgmenu/<?= htmlspecialchars($menu['image']) ?>" 
                 class="card-img-top mt-3" 
                 style="width: 200px; height:200px; object-fit:cover;" 
                 alt="รูปภาพ"
                 onerror="this.onerror=null; this.src='../../assets/img/preview.png';">
            
            <div class="card-body">
              <p class="food-font"><?= htmlspecialchars($menu['name'])?></p>
              <p class="food-font"><small>Price <?= htmlspecialchars($menu['price']) ?> ฿</small></p>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="text-center" style="padding: 50px; color: #777; width: 100%;">
        <img src="../../assets/img/empty.png" alt="ไม่มีเมนู" style="width: 120px; opacity: 0.7;">
        <p style="margin-top: 20px; font-size: 18px;">ยังไม่มีเมนูในหมวดนี้</p>
      </div>
    <?php endif; ?>
  </div>
</div>



<script>
document.querySelectorAll('input[name="menu"]').forEach(radio => {
  radio.addEventListener('change', () => {
    document.getElementById('menuForm').submit(); // submit อัตโนมัติ
  });
});
</script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
<footer><a href="../../fontend/cart/cartmenu.php"><img src="../../assets/img/cartRRR.png" class="floating-circle" alt="Circle Image"></a></footer>

</html>