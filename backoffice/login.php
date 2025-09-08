<?php
require_once './includes/db.php';

$message = '';
$type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM employee WHERE username = ?");
    $stmt->execute([$username]);
    $employee = $stmt->fetch();

    // แบบง่าย: เทียบรหัสตรงๆ (ยังไม่ใช้ password_hash)
    if ($employee && $password === $employee['password']) {
        $message = "เข้าสู่ระบบสำเร็จ!";
        $type = "success";
        // ส่งไปหน้า dashboard หลัง 2 วิ
        echo "<script>
                setTimeout(function(){
                    window.location.href='../../project-last-dance/backoffice/dashboard/dashboard.php';
                },1000);
              </script>";
    } else {
        $message = "Username หรือ Password ไม่ถูกต้อง";
        $type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>เข้าสู่ระบบ</title>
  <link rel="icon" type="image/x-icon" href="./assets/img/152431942_114763933966355_8265361494354481544_n.png">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="body">
<nav class="navbar navbar-expand-lg nav-color">
  <div class="container-fluid">
    <div>
      <img src="./assets/img/152431942_114763933966355_8265361494354481544_n.png" alt="" width="100px" height="100px">
    </div>
    <div class="table-number">Admin</div>
  </div>
</nav>

<div class="login-wrapper">
  <div class="login-box center-image container-sm" style="margin-top: 100px">
    <div class="center-image">
      <img class="logmage" src="./assets/img/user (3).png" alt="">
    </div>

    <form method="post">
      <h2 class="text-center mb-4">เข้าสู่ระบบ</h2>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <div class="input-group mb-3">
        <span class="input-group-text"><i class="fa-solid fa-user-lock"></i></span>
        <input type="text" name="username" class="form-control" placeholder="Username" required>
      </div>

      <div class="input-group mb-3">
        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>

      <input type="submit" value="เข้าสู่ระบบ" class="btn-login">
    </form>
  </div>
</div>


      <?php if ($message): ?>
        <script>
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            }
          });

          Toast.fire({
            icon: "<?= $type ?>",
            title: "<?= $message ?>"
          });
        </script>
        <?php endif; ?>

</body>
</html>
