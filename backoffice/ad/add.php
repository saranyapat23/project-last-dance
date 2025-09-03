<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';

session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $type_ids = $_POST['type_ids'] ?? [];

    // ตรวจสอบค่าว่าง
    if (!$name || !$price || empty($type_ids) ) {
        $error = '⚠️ กรุณากรอกข้อมูลให้ครบถ้วน';
    }

     $image = null;
    if(isset($_FILES['image']) && $_FILES['image']['error'] === 0 ){
      $targetDir ='../../backoffice/uploads/imgmenu/';
      $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
      $targetPath = $targetDir . $imageName;
      if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)){
        $image = $imageName;
      } else {
        $error = 'Can not insert image';
      }
    }

    // ตรวจสอบชื่อเมนูซ้ำ
    if (!$error) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM menu WHERE name = ?");
        $stmt->execute([$name]);
        if ($stmt->fetchColumn() > 0) {
            $error = '⚠️ ชื่อนี้ถูกใช้ไปแล้ว กรุณาใช้ชื่ออื่น';
        }
    }

    // ถ้าไม่มี error → insert ทีละ type_id
   $stmt = $pdo->prepare("INSERT INTO menu (name, price, description, type_id, image) VALUES (?, ?, ?, ?, ?)");
foreach ($type_ids as $type_id) {
    $stmt->execute([$name, $price, $description, $type_id, $image]);
}
        $_SESSION['menu_created'] = true;
        header('Location: ../../backoffice/edit/showmenu.php');
        exit;
    }

    
?>

<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../assets/img//152431942_114763933966355_8265361494354481544_n.png">
    <title>Hobby Board Game Cafe</title>
    <link rel="stylesheet" href="../../assets/css/stylemore.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body class="body background-customer"> 
<?php include "../../backoffice/components/nav4test.php"?>
<div><a href="./foodrec.php"><img src="./assets/img/back-arrow.png" alt="" style="width: 50px; margin-top: 5px; margin-left: 15px; margin-bottom: 15px;"></a></div>

<!-- Content -->
<div class="container mt-4">
  <?php if ($error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <!-- ฟอร์ม -->
  <form class="details-card" method="POST" action="" enctype="multipart/form-data">
    <div class="row align-items-center">
<div class="menu-options">
     <input type="checkbox" class="btn-check" name="type_ids[]" id="recommend" value="101" autocomplete="off" checked>
<label class="btn btn-outline-secondary"  for="recommend">RECOMMEND</label>

<input type="checkbox" class="btn-check" name="type_ids[]" id="food" value="102" autocomplete="off">
<label class="btn btn-outline-secondary"  for="food">FOOD</label>

<input type="checkbox" class="btn-check" name="type_ids[]" id="drink" value="103" autocomplete="off">
<label class="btn btn-outline-secondary"  for="drink">DRINK</label>

<input type="checkbox" class="btn-check" name="type_ids[]" id="dessert" value="104" autocomplete="off">
<label class="btn btn-outline-secondary"  for="dessert">DESSERT</label></div>

      <!-- input ชื่อ ราคา รายละเอียด -->
     

 <div class="col-md-4 text-center">
        <img id="preview" 
             src="" 
             alt="รูปเมนู" 
             style="max-width:300px; margin-top:15px; border-radius:15px;"
             onerror="this.onerror=null; this.src='../../assets/img/add-image.png';">

        <div class="mt-3">
          <label for="fileInput" class="btn btn-primary rounded-pill px-4" style="cursor: pointer;  font-weight: bold;">
            เลือกรูปภาพ
          </label>
          <input type="file" id="fileInput" name="image" accept="image/*" hidden>
        </div>
      </div>

      <div class="col-md-8">
        <input class="edit_input" name="name" type="text" placeholder="Name" 
          value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required> <br>

        <input class="edit_input" name="price" type="number" placeholder="Price" 
          value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" required> <br>

       

        <textarea class="edit_input_detail" name="description" placeholder="Detail" required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
      </div>
    </div>


    <div class="button-wrapper" style="margin-top: 50px;">
        <button class="btn cancel-new" onclick="window.location.href='../../backoffice/edit/showmenu.php'">
          <p class="btn-p">Cancel</p>
        </button>
        <button class="btn confirm-new">
          <p class="btn-p" type="submit">Confirm</p>
        </button>
      </div>

  </form>
</div>

    <script>
const fileInput = document.getElementById('fileInput');
const preview = document.getElementById('preview');

fileInput.addEventListener('change', () => {
  const file = fileInput.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      preview.src = e.target.result; // แสดงภาพทันที
    }
    reader.readAsDataURL(file);
  }
});
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>