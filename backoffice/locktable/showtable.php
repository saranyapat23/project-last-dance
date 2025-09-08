<?php
require_once '../../includes/db.php';
session_start();

$stmt = $pdo->query("SELECT * FROM tables");
$tables = $stmt->fetchAll();
?>
<!-- จากนั้นแสดงสถานะจาก $tables ใน HTML -->

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hobby Board Game Cafe</title>
<link rel="stylesheet" href="../../assets/css/stylefortable.css">
<link rel="icon" type="image/x-icon" href="../../assets/img/casino.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="body row ">
<?php include "../components/test.php"?>




        <div class="wrapper container-fluid mx-auto" style="max-width: 1425px;">
          <div class="row g-4 my-4"> <!-- g-4 = ระยะห่างระหว่าง card, my-4 = เว้นบนล่าง -->
            <?php foreach ($tables as $table): ?>
              <div class="col-6 col-md-4 col-lg-3">
                <div class="card-switch card-switch-new h-100 p-3"> <!-- p-3 = padding -->
                  <div class="flip-card_inner p-3 border rounded bg-light text-center">
                    <div class="title">TABLE <?= htmlspecialchars($table['number']) ?></div>
                    <div class="flip-card_form">
                      <img class="preview forlazy-oat" 
                          src="../../assets/img/<?= $table['status'] === 'OPEN' ? 'ui-element (1).png' : 'ui-element.png' ?>">
                        <p class="flip-card_input-new"><?= $table['status'] === 'OPEN' ? 'เปิดเมื่อ ' : 'ปิดเมื่อ ' ?> <?= date('H:i', strtotime($table['update_at'])) ?></p> 
                      <p class="flip-card_input status-text">สถานะ : <?= htmlspecialchars($table['status']) ?></p>
                      <?php
                        $btnText = $table['status'] === 'OPEN' ? '' : '';
                        $btnColor = $table['status'] === 'OPEN' ? '#198754' : '#dc3545';
                        $btnStateClass = $table['status'] === 'OPEN' ? 'is-open' : 'is-closed';
                      ?>
                      <button class="btn btn-lg toggle-btn custom-button <?= $btnStateClass ?>"
                          data-id="<?= $table['table_id'] ?>"
                          data-status="<?= $table['status'] ?>"
                          style="background-color: <?= $btnColor ?>; color:white;">
                        <?= $btnText ?>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>



<script>
document.querySelectorAll('.toggle-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    const tableId = this.dataset.id;
    const statusTextEl = this.closest('.card-switch').querySelector('.status-text');
    const imgEl = this.closest('.card-switch').querySelector('.preview');
    const timeEl = this.closest('.card-switch').querySelector('.flip-card_input-new'); // ดึง element เวลา
    const currentStatus = this.dataset.status;

    // สลับสถานะ
    const newStatus = currentStatus === 'OPEN' ? 'CLOSED' : 'OPEN';

    fetch('update_status.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `table_id=${tableId}&status=${newStatus}`
    })
    .then(res => res.text())
    .then(data => {
      if (data === "success") {
        this.dataset.status = newStatus;
        this.textContent = newStatus === 'OPEN' ? ' ' : ' ';
        this.style.backgroundColor = newStatus === 'OPEN' ? '#198754' : '#dc3545';

        // อัปเดตสถานะ
        statusTextEl.textContent = "สถานะ : " + newStatus;

        // อัปเดตรูป
        imgEl.src = '../../assets/img/' + (newStatus === 'OPEN' ? 'ui-element (1).png' : 'ui-element.png');

        // ✅ อัปเดตเวลาเปิด/ปิดทันที
        const now = new Date();
        const hh = now.getHours().toString().padStart(2, '0');
        const mm = now.getMinutes().toString().padStart(2, '0');
        timeEl.textContent = (newStatus === 'OPEN' ? 'เปิดเมื่อ ' : 'ปิดเมื่อ ') + `${hh}:${mm}`;
      } else {
        alert("เกิดข้อผิดพลาดในการอัปเดตสถานะ");
      }
    })
    .catch(err => console.error(err));
  });
});

</script>






</body>
</html>