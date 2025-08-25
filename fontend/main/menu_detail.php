<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';
session_start();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: showmenu.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM menu WHERE menu_id = ?");
$stmt->execute([$id]);
$menu = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$menu) {
    echo "ไม่พบข้อมูลสินค้า";
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');

    if (!$name || !$description || !$price) {
        $error = 'กรุณากรอกข้อมูลให้ครบถ้วน';
    }

    if (!$error) {
        $stmt = $pdo->prepare("UPDATE menu SET name = ?, description = ?, price = ? WHERE menu_id = ?");
        $stmt->execute([$name, $description, $price, $id]);
        $_SESSION['menu_updated'] = true;
        header('Location: showmenu.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../../assets/css/stylemore.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body class="body"> 
<?php include "../../backoffice/components/navbar.php"?>
<div><a href="../../fontend/main/menu.php"><img src="../../assets/img/back-arrow.png" alt="" style="width: 50px; margin-top: 5px; margin-left: 15px; margin-bottom: 15px;"></a></div>

<!-- Content -->
<div class="container mt-4">
  <?php if ($error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <!-- ฟอร์ม -->
 <div class="container mt-4">
  <div class="details-card" style="margin-top: -60px;">
    <div class="row align-items-center">
      <div class="col-md-4">
        <img class="img-fluid rounded" style="max-width:300px; margin-top:15px; margin-left:60px; border-radius: 15px;"  src="../../backoffice/uploads/imgmenu/<?= htmlspecialchars($menu['image']) ?>" alt="รูปภาพ" onerror="this.onerror=null; this.src='../../assets/img/preview.png';">
      </div>

      
      <div class="col-md-8">
        <p class="detail-name"><?= htmlspecialchars($menu['name']) ?></p>
        <p class="detail-name">Price <?= htmlspecialchars($menu['price']) ?> B</p>
        <p class="food-detail"><?= htmlspecialchars($menu['description']) ?></p>
      </div>  
    </div>

    <textarea class="optional-box mt-3" placeholder="Optional: Add more text if necessary"></textarea>

     <div class="mt-3 text-end">
      <button class="add-btn" type="submit">Add to Cart</button>
    </div>
  </div>
</div>

  </form>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>
