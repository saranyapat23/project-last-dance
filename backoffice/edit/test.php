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
<html lang="th">
<head>
<meta charset="UTF-8">
<title>Edit Product</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-3">
<h2>แก้ไขสินค้า</h2>

<?php if ($error): ?>
<p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="">
    <div class="mb-2">
        <label>ชื่อสินค้า</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($menu['name']) ?>" required>
    </div>
    <div class="mb-2">
        <label>ราคา</label>
        <input type="number" name="price" class="form-control" value="<?= htmlspecialchars($menu['price']) ?>" required>
    </div>
    <div class="mb-2">
        <label>รายละเอียด</label>
        <input type="text" name="description" class="form-control" value="<?= htmlspecialchars($menu['description']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">บันทึก</button>
</form>


</body>
</html>
