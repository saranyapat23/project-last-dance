<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';
session_start();

$stmt = $pdo->query("SELECT * FROM tables");
$tables = $stmt->fetchALL();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $table_id = $_POST['table_id'] ?? null;
    $status   = $_POST['status'] ?? null;

 if ($table_id && in_array($status, ['OPEN', 'CLOSED'])) {
        $stmt = $pdo->prepare("UPDATE tables SET status = ? WHERE table_id = ?");
        $stmt->execute([$status, $table_id]);
        echo "success";
    } else {
        echo "invalid";
    }
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#e2ffadff">
    <link rel="icon" type="image/x-icon" href="./img/casino.png">
    <title>Hobby Board Game Cafe</title>
    <link rel="stylesheet" href="../../assets/css/stylefortable.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

   <div class="wrapper">
        <?php foreach ($tables as $table): ?>

  <div class="card-switch">
    <label class="switch">
      <input type="checkbox" class="toggle" data-id="<?= $table['table_id'] ?>"
  <?= $table['status'] === 'OPEN' ? 'checked' : '' ?>>
      <span class="slider"></span>
      <span class="card-side1"></span>
      <div class="flip-card_inner">
        
      <!-- FRONT (Login) -->
        <div class="flip-card_front">
          <div class="title">Table Status</div>
          <form class="flip-card_form" action="">
             <img id="preview"  src="../../assets/img/sad-face.png"  style="width: 50%; border-radius: 12px; margin-bottom: 20px;">
            <span class="flip-card_input " style="font-weight:600; padding: 2px; border-radius: 12px; font-size: 20px; font-weight: bold;">โต๊ะที่ <?= htmlspecialchars($table['table_id']) ?></span>
            <span class="flip-card_input" style="font-weight:600; padding: 2px; border-radius: 12px; font-size: 20px; font-weight: bold;">สถานะ: <span class="status-text"><?= htmlspecialchars($table['status']) ?></span></span>
          </form>
        </div>
        
        <!-- BACK (Sign Up) -->
        <div class="flip-card_back">
          <div class="title">Table Status</div>
          <form class="flip-card_form" action="">
            <img id="preview"  src="../../assets/img/smile.png"  style="width: 50%; border-radius: 12px; margin-bottom: 20px;">
            <span class="flip-card_input " style="font-weight:600; padding: 2px; border-radius: 12px; font-size: 20px; font-weight: bold;">โต๊ะที่ <?= htmlspecialchars($table['table_id']) ?></span>
            <span class="flip-card_input" style="font-weight:600; padding: 2px; border-radius: 12px; font-size: 20px; font-weight: bold;">สถานะ: <span class="status-text"><?= htmlspecialchars($table['status']) ?></span></span>
          </form>
        </div>

      </div>
    </label>
     <?php endforeach; ?>
  </div>
</div>

<!-- <div class="wrapper">
  <div class="card-switch">
    <label class="switch">
      <input type="checkbox" class="toggle">
      <span class="slider"></span>
      <span class="card-side"></span>
      <div class="flip-card_inner">
        
      
        <div class="flip-card_front">
          <div class="title">Login</div>
          <form class="flip-card_form" action="">
            <input class="flip-card_input" type="text" placeholder="Username" required>
            <input class="flip-card_input" type="password" placeholder="Password" required>
            <button class="flip-card_btn">Login</button>
          </form>
        </div>
        
        
        <div class="flip-card_back">
          <div class="title">Sign Up</div>
          <form class="flip-card_form" action="">
            <input class="flip-card_input" type="email" placeholder="Email" required>
            <input class="flip-card_input" type="text" placeholder="Username" required>
            <input class="flip-card_input" type="password" placeholder="Password" required>
            <button class="flip-card_btn">Sign Up</button>
          </form>
        </div>

      </div>
    </label>
  </div>
</div> -->


   <!-- <div class="wrapper">
  <div class="card-switch">
    <label class="switch">
      <input type="checkbox" class="toggle">
      <span class="slider"></span>
      <span class="card-side1"></span>
      <div class="flip-card_inner">
        
      <div class="flip-card_front">
          <div class="title">Table Status</div>
          <form class="flip-card_form" action="">
            <span class="flip-card_input " style="font-weight:600; padding: 2px; border-radius: 12px; font-size: 20px; font-weight: bold;">โต๊ะที่ 1</span>
            <span class="flip-card_input" style="font-weight:600; padding: 2px; border-radius: 12px; font-size: 20px; font-weight: bold;">สถานะ: <span class="status-text">ปิดรับออเดอร์</span></span>
          </form>
        </div>
        
        <div class="flip-card_back">
          <div class="title">Table Status</div>
          <form class="flip-card_form" action="">
            <span class="flip-card_input " style="font-weight:600; padding: 2px; border-radius: 12px; font-size: 20px; font-weight: bold;">โต๊ะที่ 1</span>
            <span class="flip-card_input" style="font-weight:600; padding: 2px; border-radius: 12px; font-size: 20px; font-weight: bold;">สถานะ: <span class="status-text">เปิดรับออเดอร์</span></span>
          </form>
        </div>

      </div>
    </label>
  </div>
</div> -->

  </body>

  <script>
document.querySelectorAll('.toggle').forEach(toggle => {
  toggle.addEventListener('change', function() {
    const tableId = this.dataset.id;
    const newStatus = this.checked ? 'OPEN' : 'CLOSED';

    // อัปเดต UI ทันที
    this.closest('.card-switch').querySelector('.status-text').textContent = newStatus;

    // ส่งไปอัปเดตใน DB ผ่าน fetch
    fetch('update_status.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `table_id=${tableId}&status=${newStatus}`
    })
    .then(res => res.text())
    .then(data => console.log(data))
    .catch(err => console.error(err));
  });
});
</script>
</html>