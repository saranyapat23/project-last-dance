<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';

session_start();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: showmenu.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM menu WHERE id = ?");
$stmt->execute([$id]);
$menu = $stmt->fetch();
if (!$menu) {
    echo "ไม่พบข้อมูลสินค้า";
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');
   

    if (!$name || !$description || !$price ) {
        $error = 'กรุณากรอกข้อมูลให้ครบถ้วน';
    }

    if(!$error) {
      $stmt = $pdo->prepare("SELECT COUNT(*) FROM menu WHERE name = ?");
      $stmt->execute([$name]);
      if ($stmt->fetchColumn() > 0){
          $error = 'ชื่อสินค้านี้ถูกใช้ไปแล้ว กรุณาใช้ชื่ออื่น';
      }
    }


    if (!$error) {
        $stmt = $pdo->prepare("UPDATE menu SET name = ?, description = ?, price = ?, stock = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $stock, $id]);

        $_SESSION['menu_updated'] = true;
        header('Location: showmenu.php');
        exit;
    }
}
?>

<?php ob_start(); ?>

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

<div><a href="./foodrec.php"><img src="./assets/img/back-arrow.png" alt="" style="width: 50px; margin-top: 5px; margin-left: 15px; margin-bottom: 15px;"></a></div>

<!-- Content -->
<div class="container mt-4">
  <div class="details-card">
    <div class="row align-items-center">
      <div class="col-md-4">
        <img class="img-detail img-fluid" src="https://www.wendys.com/sites/default/files/styles/max_650x650/public/2021-05/daves-double.png?itok=0LISzLWe" alt="Burger" class="img-fluid">
      </div>
      <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
      <div class="col-md-8">
        <p class="detail-name"><input type="text" name="name" value="<?= htmlspecialchars($menu['name']) ?>"  required></p>
        <p class="detail-name"><input type="number" name="price" value="<?= htmlspecialchars($menu['price']) ?>" required></p>
        <p class="food-detail"><input type="text" name="description" value="<?= htmlspecialchars($menu['description']) ?>" required></p>
      </div>
    </div>

    <textarea class="optional-box mt-3" placeholder="Optional: Add more text if necessary"></textarea>

    <a href="foodrec.php?added=1" class="mt-3 btn-right">
  <button type="submit">บันทึก</button>
</a>
  </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
<footer></footer>
</html>

<?php
$content = ob_get_clean();
$title = "Edit product";
?>
