<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';

session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $type_id = $_POST['type_id'] ?? '';

    // ตรวจสอบค่าว่าง
    if (!$name || !$price || !$type_id) {
        $error = '⚠️ กรุณากรอกข้อมูลให้ครบถ้วน';
    }

    // ตรวจสอบชื่อเมนูซ้ำ
    if (!$error) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM menu WHERE name = ?");
        $stmt->execute([$name]);
        if ($stmt->fetchColumn() > 0) {
            $error = '⚠️ ชื่อนี้ถูกใช้ไปแล้ว กรุณาใช้ชื่ออื่น';
        }
    }

    // ถ้าไม่มี error → insert
    if (!$error) {
        $stmt = $pdo->prepare("INSERT INTO menu (name, price, description, type_id) VALUES (?,?,?,?)");
        $stmt->execute([$name, $price, $description, $type_id]);

        $_SESSION['menu_created'] = true;
        header('Location: showad.php');
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
  <?php if ($error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <!-- ฟอร์ม -->
  <form class="details-card" method="POST" action="">
    <div class="row align-items-center">
      <!-- radio ประเภท -->
      <label>ประเภทเมนู:</label><br> 
      <select name="type_id" required> <option value="">-- เลือกประเภท --</option> <?php try { $stmt = $pdo->query("SELECT type_id, name FROM menu_type"); while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { echo "<option value='{$row['type_id']}'>" . htmlspecialchars($row['name']) . "</option>"; } } catch (PDOException $e) { echo "<option disabled>❌ Error: " . $e->getMessage() . "</option>"; } ?> </select><br><br>

      <!-- input ชื่อ ราคา รายละเอียด -->
      <div class="col-md-4">
        <img class="img-fluid rounded" src="../../assets/img/addimg.png" alt="Burger">
      </div>
      <div class="col-md-8">
        <input class="edit_input" name="name" type="text" placeholder="Name" 
          value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required> <br>

        <input class="edit_input" name="price" type="number" placeholder="Price" 
          value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" required> <br>

        <textarea class="edit_input_detail" name="description" placeholder="Detail" required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
      </div>
    </div>


    <div class="button-wrapper">
        <button class="btn cancel-new" onclick="window.location.href='../../backoffice/ad/showad.php'">
          <p class="btn-p">Cancel</p>
        </button>
        <button class="btn confirm-new">
          <p class="btn-p" type="submit">Confirm</p>
        </button>
      </div>

  </form>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>