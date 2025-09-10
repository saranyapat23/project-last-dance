<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';
session_start();

$typeMap = [
    1 => 101, // Recommend
    2 => 102, // Food
    3 => 103, // Drink
    4 => 104  // Dessert
];

$menu = isset($_GET['menu']) ? (int)$_GET['menu'] : 1;
$type_id = $typeMap[$menu];

// ดึงข้อมูลตาม type_id
$stmt = $pdo->prepare("SELECT * FROM menu WHERE type_id = ?");
$stmt->execute([$type_id]);
$menus = $stmt->fetchAll();


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


ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#e2ffadff">
  <link rel="icon" type="image/x-icon" href="../../assets/img/casino.png">
  <title>Hobby Board Game Cafe</title>
  <link rel="stylesheet" href="../../assets/css/stylemore.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body class="body background-customer"> 
<?php include "../../backoffice/components/test.php"?>

<div>
  <a href="./index.php"><img src="./assets/img/back-arrow.png" alt="" style="width: 50px; margin: 5px 0 15px 15px;"></a>
</div>

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
    <div class="row">
      <?php if (!empty($menus)): ?>
        <?php foreach ($menus as $menu): ?>
  <div class="col-6 col-md-3 d-flex justify-content-center">
    <div class="card align-items-center menu-pic border-0 food-pic hot-card"
         style="width: 17rem; border-radius: 25px; margin-top: 30px; cursor:pointer; position:relative; " 
         onclick="setHotMenu(<?= $menu['menu_id']?>, '<?= htmlspecialchars($menu['name'], ENT_QUOTES) ?>')">

      <!-- Badge Hot Menu -->
        <?php if ($menu['is_hot'] == 1): ?>
          <!-- ถ้าเป็น Hot Menu -->
          <button class="d-inline-flex align-items-center bg-warning text-white rounded-pill px-2 py-1 border-0 shadow-sm" 
                  style="gap: 6px; font-size: 0.85rem; margin-top: 5px; margin-bottom: -10px;" 
                  onclick="toggleHotMenu(<?= $menu['menu_id']?>, false)">
            <i class="fa-solid fa-fire" style="color: #ff0000;"></i>
            <span class="fw-semibold">Hot Menu</span>
            <i class="fa-solid fa-xmark ms-1"></i>
          </button>
        <?php else: ?>
          <!-- ถ้าไม่ใช่ Hot Menu -->
          <button class="d-inline-flex align-items-center bg-secondary text-white rounded-pill px-2 py-1 border-0 shadow-sm" 
                  style="gap: 6px; font-size: 0.85rem; margin-top: 5px; margin-bottom: -10px;" 
                  onclick="toggleHotMenu(<?= $menu['menu_id']?>, true)">
                  <i class="fa-solid fa-map-pin"></i>
            <span class="fw-semibold">SET HOT MENU</span>
          </button>
        <?php endif; ?>


       

      <img src="../../backoffice/uploads/imgmenu/<?= htmlspecialchars($menu['image']) ?>" 
                 class="card-img-top mt-3" 
                 style="width: 200px; height:200px; object-fit:cover;" 
                 alt="รูปภาพ"
                 onerror="this.onerror=null; this.src='../../assets/img/preview.png';">

      <div class="card-body text-center">
        <p class="food-font"><?= htmlspecialchars($menu['name'])?></p>
        <p class="food-font"><small>Price <?= htmlspecialchars($menu['price']) ?> ฿</small></p>
      </div>

      <div class="d-grid gap-2 d-md-block" style="margin-bottom: 20px;">
        <a href="edit.php?id=<?= $menu['menu_id']?>" onclick="event.stopPropagation();">
          <img src="../../assets/img/pen (1).png" width="55px">
        </a>

        
        <a href="javascript:void(0);" onclick="event.stopPropagation(); confirmDelete('delete.php?id=<?= $menu['menu_id']?>', '<?= htmlspecialchars($menu['name'], ENT_QUOTES) ?>')">
          <img src="../../assets/img/deletein.png" alt="Delete" width="50px">
        </a>
      </div>
    </div>
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
</div>

<script>
document.querySelectorAll('input[name="menu"]').forEach(radio => {
  radio.addEventListener('change', () => {
    document.getElementById('menuForm').submit(); // submit อัตโนมัติ
  });
});
</script>

<?php if (!empty($_SESSION['menu_deleted'])): ?>
  <p style="color: green;">ลบเมนูเรียบร้อยแล้ว</p>
  <?php unset($_SESSION['menu_deleted']); ?>
<?php endif; ?>

<!-- SweetAlert2 -->
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

function toggleHotMenu(id, setHot) {
  if (setHot) {
    // ตั้งค่า Hot Menu
    Swal.fire({
      title: 'ตั้ง Hot Menu?',
      text: 'คุณต้องการให้เมนูนี้เป็น Hot Menu หรือไม่',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#f39c12',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'ใช่, ตั้ง Hot',
      cancelButtonText: 'ยกเลิก'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "hotmenu.php?id=" + id;
      }
    })
  } else {
    // ยกเลิก Hot Menu
    Swal.fire({
      title: 'ยกเลิก Hot Menu?',
      text: 'คุณต้องการลบเมนูนี้ออกจาก Hot Menu หรือไม่',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#e74c3c',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'ใช่, ยกเลิก',
      cancelButtonText: 'ไม่'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "hotmenu.php?id=" + id;
      }
    })
  }
}

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
<footer>
  <a href="../../backoffice/ad/add.php"><img src="../../assets/img/plus.png" class="floating-circle" alt="Circle Image"></a>
</footer>
</html>
