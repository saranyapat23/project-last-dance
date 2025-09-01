<?php
require_once '../../includes/db.php';
session_start();

// ดึงข้อมูลตารางทั้งหมด
$stmt = $pdo->query("SELECT * FROM tables");
$tables = $stmt->fetchALL();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hobby Board Game Cafe</title>
<link rel="stylesheet" href="../../assets/css/stylefortable.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="wrapper">
<?php foreach ($tables as $table): ?>
  <div class="card-switch">
    <label class="switch">
      <!-- Toggle checkbox -->
      <input type="checkbox" class="toggle" data-id="<?= $table['table_id'] ?>"
        <?= $table['status'] === 'OPEN' ? 'checked' : '' ?>>

      <span class="slider"></span>
      <span class="card-side1"></span>

      <div class="flip-card_inner">
        <!-- FRONT -->
        <div class="flip-card_front">
          <div class="title">Table Status</div>
          <form class="flip-card_form">
            <img class="preview" src="../../assets/img/sad-face.png"
                 style="width:50%; border-radius:12px; margin-bottom:20px;">
            <span class="flip-card_input" style="font-weight:bold; font-size:20px;">โต๊ะที่ <?= htmlspecialchars($table['table_id']) ?></span>
            <span class="flip-card_input" style="font-weight:bold; font-size:20px;">สถานะ: <span class="status-text"><?= htmlspecialchars($table['status']) ?></span></span>
          </form>
        </div>

        <!-- BACK -->
        <div class="flip-card_back">
          <div class="title">Table Status</div>
          <form class="flip-card_form">
            <img class="preview" src="../../assets/img/smile.png"
                 style="width:50%; border-radius:12px; margin-bottom:20px;">
            <span class="flip-card_input" style="font-weight:bold; font-size:20px;">โต๊ะที่ <?= htmlspecialchars($table['table_id']) ?></span>
            <span class="flip-card_input" style="font-weight:bold; font-size:20px;">สถานะ: <span class="status-text"><?= htmlspecialchars($table['status']) ?></span></span>
          </form>
        </div>
      </div>
    </label>
  </div>
<?php endforeach; ?>
</div>

<script>
// ดัก event toggle
document.querySelectorAll('.toggle').forEach(toggle => {
  toggle.addEventListener('change', function() {
    const tableId = this.dataset.id;
    const newStatus = this.checked ? 'OPEN' : 'CLOSED';

    const card = this.closest('.card-switch');
    const statusText = card.querySelectorAll('.status-text');
    const imgs = card.querySelectorAll('.preview');

    // เปลี่ยน UI ทันที
   statusText.forEach(el => el.textContent = newStatus);

    // ส่งไปอัปเดต DB
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

</body>
</html>
