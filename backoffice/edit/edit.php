<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';
session_start();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: showmenu.php');
    exit;
}

// ดึงข้อมูลเมนูเก่า
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

    // ค่าเริ่มต้นใช้รูปเก่า
    $imageName = $menu['image'];

    // ถ้ามีการอัปโหลดรูปใหม่
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../backoffice/uploads/imgmenu/';
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $imageName;

        // ย้ายไฟล์ไปเก็บ
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $error = 'ไม่สามารถอัปโหลดรูปได้';
        }
    }

    if (!$name || !$description || !$price) {
        $error = 'กรุณากรอกข้อมูลให้ครบถ้วน';
    }

    if (!$error) {
        $stmt = $pdo->prepare("UPDATE menu SET name = ?, description = ?, price = ?, image = ? WHERE menu_id = ?");
        $stmt->execute([$name, $description, $price, $imageName, $id]);
        $_SESSION['menu_updated'] = true;
        header('Location: showmenu.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../../assets/img/casino.png">
  <title>แก้ไขเมนู | Hobby Board Game Cafe</title>
  <link rel="stylesheet" href="../../assets/css/stylemore.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="body " > 
<?php include "../../backoffice/components/navbar.php"?>


<div class="container mt-4">
  <?php if ($error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form class="details-card" method="POST" action="" enctype="multipart/form-data">
    <div class="row align-items-center">

      <h1 class="fancy-title">แก้ไขเมนู</h1>

      

      <!-- รูป -->
      <div class="col-md-4 text-center">
        
        <img id="preview" 
             src="../../backoffice/uploads/imgmenu/<?= htmlspecialchars($menu['image']) ?>" 
             alt="รูปเมนู" 
             style="max-width:300px; margin-top:15px; border-radius:15px;"
             onerror="this.onerror=null; this.src='../../assets/img/addimg.png';">

        <div class="mt-3">
          <label for="fileInput" class="btn btn-primary rounded-pill px-4">
            เลือกรูปภาพ
          </label>
          <input type="file" id="fileInput" name="image" accept="image/*" hidden>
        </div>
      </div>

      <!-- ฟอร์มกรอกข้อมูล -->
      <div class="col-md-8">
        <input class="edit_input" name="name" type="text" 
          value="<?= htmlspecialchars($menu['name']) ?>" required> <br>

        <input class="edit_input" name="price" type="number" placeholder="Price" 
          value="<?= htmlspecialchars($menu['price']) ?>" required> <br>

        
        <textarea class="edit_input_detail" name="description" required><?= htmlspecialchars($menu['description']) ?></textarea>
      </div>
    </div>

    <div class="mt-3 text-end">
      <button class="add-btn" type="submit">บันทึก</button>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// preview รูปใหม่ที่เลือก
document.getElementById('fileInput').addEventListener('change', function(event) {
  const file = event.target.files[0];
  if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
          document.getElementById('preview').src = e.target.result;
      }
      reader.readAsDataURL(file);
  }
});
</script>
</body>
</html>
