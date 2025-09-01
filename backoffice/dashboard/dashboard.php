<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';
session_start();


$today = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// ดึงเฉพาะ order ที่ตรงกับวันนั้น
$stmt = $pdo->prepare("SELECT * FROM orders WHERE DATE(order_at) = ?");
$stmt->execute([$today]);
$menus = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cafe Dashboard</title>
  <link rel="icon" type="image/x-icon" href="../../assets/img/coffee-icon.png">
  <link rel="stylesheet" href="../../assets/css/stylemore.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="body">

<?php include "../../backoffice/components/navbar_admin.php"?>

<div class="container mt-4">
  <h2 class="mb-4 fw-bold"><i class="fa-solid fa-mug-saucer"></i> DASHBOARD</h2>
  
  <!-- Cards Row -->
  <div class="row g-4">
    <div class="col-md-3">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body text-center" style="border-radius: 20px;padding-top: 45px;">
          <i class="fa-solid fa-book-open fa-2x text-primary mb-2"></i>
          <h5 class="card-title">เมนูทั้งหมด</h5>
          <p class="fs-4 fw-bold">25</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body text-center" style="border-radius: 20px;padding-top: 45px;">
          <i class="fa-solid fa-receipt fa-2x text-success mb-2"></i>
          <h5 class="card-title">ออเดอร์วันนี้</h5>
          <p class="fs-4 fw-bold">48</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body text-center" style=" border-radius: 20px;padding-top: 45px;">
          <i class="fa-solid fa-sack-dollar fa-2x text-warning mb-2"></i>
          <h5 class="card-title">ยอดขายวันนี้</h5>
          <p class="fs-4 fw-bold">฿3,250</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
  <div class="card shadow-sm border-0 rounded-3">
    <div class="card-body text-center" style="border-radius: 20px;padding-top: 30px;">
      <h5 class="card-title">เลือกวัน</h5>
      <form method="get">
        <input 
          type="date" 
          class="form-control text-center" 
          name="date" 
          value="<?= isset($_GET['date']) ? htmlspecialchars($_GET['date']) : date('Y-m-d') ?>" 
          onchange="this.form.submit()"
        >
      </form>
      <p class="fs-6 mt-2 fw-bold">
        <?= isset($_GET['date']) ? $_GET['date'] : date('Y-m-d') ?>
      </p>
    </div>
  </div>
</div>
  </div>

  <!-- Charts Section -->
  <div class="row mt-5" >
    <div class="col-md-8">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white fw-bold">
          📈 ยอดขาย 7 วันย้อนหลัง
        </div>
        <div class="card-body">
          <canvas id="salesChart"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-success text-white fw-bold">
          ☕ ประเภทเมนูขายดี
        </div>
        <div class="card-body">
          <canvas id="menuChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Table Section -->
  <div class="card shadow-sm border-0 rounded-3 mt-5">
    <div class="card-header bg-dark text-white fw-bold">
      <i class="fa-solid fa-clock-rotate-left"></i> ออเดอร์ล่าสุด
    </div>
    <div class="card-body">
       
      <table class="table table-hover align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>ลูกค้า</th>
            <th>เมนูที่สั่ง</th>
            <th>ราคารวม</th>
            <th>เวลา</th>
          </tr>
        </thead>
        <tbody>
             <?php foreach ($menus as $menu): ?>
          <tr>
            <td><?= htmlspecialchars($menu['id'])?></td>
            <td><?= htmlspecialchars($menu['table_id'])?></td>
            <td>สั่ง </td>
            <td><?= htmlspecialchars($menu['total_price'])?></td>
            <td><?= htmlspecialchars($menu['order_at'])?></td>
          </tr>
              <?php endforeach; ?>
        </tbody>
      </table>
  
    </div>
  </div>

</div>

<!-- Chart.js Script -->
<script>
  // Line Chart - Sales (7 Days)
  const salesCtx = document.getElementById('salesChart').getContext('2d');
  new Chart(salesCtx, {
    type: 'line',
    data: {
      labels: ['25 Aug', '26 Aug', '27 Aug', '28 Aug', '29 Aug', '30 Aug', '31 Aug'],
      datasets: [{
        label: 'ยอดขาย (บาท)',
        data: [2200, 3100, 2800, 3500, 4000, 3700, 3250],
        borderColor: 'rgba(75, 192, 192, 1)',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        fill: true,
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'top' }
      }
    }
  });

  // Doughnut Chart - Menu Categories
  const menuCtx = document.getElementById('menuChart').getContext('2d');
  new Chart(menuCtx, {
    type: 'doughnut',
    data: {
      labels: ['เมนูอาหาร', 'เครื่องดื่ม', 'ของหวาน'],
      datasets: [{
        data: [55, 25, 15],
        backgroundColor: [
          'rgba(54, 162, 235, 0.7)',
          'rgba(255, 206, 86, 0.7)',
          'rgba(255, 99, 132, 0.7)',
        ],
        borderColor: [
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(255, 99, 132, 1)',
        ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'bottom' }
      }
    }
  });
</script>

</body>
</html>
