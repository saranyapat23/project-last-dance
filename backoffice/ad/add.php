<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';

session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    

    if(!$name || !$price) {
        $error = '⚠️กรุณากรอกข้อมูลให้ครบถ้วน';
    }

    if(!$error) {
      $stmt = $pdo->prepare("SELECT COUNT(*) FROM menu WHERE name = ?");
      $stmt->execute([$name]);
      if ($stmt->fetchColumn() > 0){
          $error = 'ชื่อผู้ใช้นี้ถูกใช้ไปแล้ว กรุณาใช้ชื่ออื่น';
      }
    }


    if (!$error) {
        $stmt = $pdo->prepare("INSERT INTO menu (name, price, description) VALUES (?,?,?)");
        $stmt->execute([$name, $price, $description]);
        $_SESSION ['menu_created'] = true;
        header ('Location: showad.php');
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
<div class="container mt-4"  method="POST">
    <?php if ($error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
  <div class="details-card">
    <div class="row align-items-center" >
       <div>
    <input type="radio" class="btn-check" name="options-outlined" id="success-outlined" autocomplete="off" checked>
        <label class="btn btn-outline-secondary choose" for="success-outlined">Reccomend Menu</label>

        <input type="radio" class="btn-check" name="options-outlined" id="danger-outlined" autocomplete="off">
        <label class="btn btn-outline-secondary choose" for="danger-outlined">Food</label>

        <input type="radio" class="btn-check" name="options-outlined" id="warning-outlined" autocomplete="off">
        <label class="btn btn-outline-secondary choose" for="warning-outlined">Drink</label>

        <input type="radio" class="btn-check" name="options-outlined" id="info-outlined" autocomplete="off">
        <label class="btn btn-outline-secondary choose" for="info-outlined">Dessert</label>
        </div>
      <a  class="col-md-4" >
        <img class="img-fluid rounded" src="../../assets/img/addimg.png" alt="Burger">
      </a>
      <div class="col-md-8">
        <input class="edit_input"  type="text" placeholder="Name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required> <br>
        <input class="edit_input" type="number" placeholder="Price" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" required> <br>

        <textarea class="edit_input_detail" type="text" placeholder="Detail" value="<?= htmlspecialchars($_POST['description'] ?? '') ?>" required></textarea>
    
      </div>
    </div>

    <a  class="mt-3 btn-right">
  <button class="add-btn" type="submit">เพิ่มลงตะกร้า</button>
</a>
  </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>