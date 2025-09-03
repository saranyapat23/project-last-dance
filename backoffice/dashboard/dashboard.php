<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';
session_start();

// ===== Filter by Date =====
$today = isset($_GET['date']) ? $_GET['date'] : null;

if ($today) {
    // ดึงข้อมูลเฉพาะวันนั้น
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE DATE(order_at) = ? ORDER BY order_at DESC");
    $stmt->execute([$today]);
} else {
    // ดึงทั้งหมด
    $stmt = $pdo->query("SELECT * FROM orders ORDER BY order_at DESC");
}

$menus = $stmt->fetchAll();

// ====== รายงานสรุป ======
$sql = "
SELECT mt.name AS type_name, COALESCE(SUM(od.quantity),0) AS qty
FROM menu_type mt
LEFT JOIN menu m ON m.type_id = mt.type_id
LEFT JOIN order_details od ON od.menu_id = m.menu_id
LEFT JOIN orders o ON o.id = od.order_id AND o.deleted_at IS NULL
GROUP BY mt.type_id, mt.name
ORDER BY mt.type_id
";
$type = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$typeNames = [
    101 => "เมนูอาหาร",
    102 => "เครื่องดื่ม",
    103 => "ของหวาน"
];

$labels = [];
$data = [];
foreach ($type as $row) {
    $labels[] = $row['type_name']; 
    $data[] = (int)$row['qty'];
}

// นับจำนวนเมนูทั้งหมด
$sql = "SELECT COUNT(*) AS total_menus
FROM menu
WHERE deleted_at IS NULL
  AND type_id != 101";
$totalMenus = $pdo->query($sql)->fetchColumn();

// ออเดอร์วันนี้
$stmt = $pdo->query("
    SELECT COUNT(*) AS total_orders
    FROM orders
    WHERE deleted_at IS NULL
    AND DATE(order_at) = CURDATE()
");
$totalOrders = $stmt->fetchColumn();

// ยอดขายวันนี้
$stmt = $pdo->query("
    SELECT SUM(od.price * od.quantity) AS total_sales
    FROM orders o
    JOIN order_details od ON od.order_id = o.id
    WHERE DATE(o.order_at) = CURDATE()
");

$todaySales = $stmt->fetchColumn(); 
if (!$todaySales) {
    $todaySales = 0;
}
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
  <!-- gridjs -->
  <link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
  <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
<!-- datatables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- echarts -->
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
</head>
<body class="body">

<?php include "../../backoffice/components/test.php"?>

<div class="container mt-4">
  <h2 class="mb-4 fw-bold"><i class="fa-solid fa-mug-saucer"></i> DASHBOARD</h2>
  
  <!-- Cards Row -->
  <div class="row g-4">
    <div class="col-md-3">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body text-center" style="border-radius: 20px;padding-top: 45px;">
          <i class="fa-solid fa-book-open fa-2x text-primary mb-2"></i>
          <h5 class="card-title">เมนูทั้งหมด</h5>
          <p class="fs-4 fw-bold"><?= htmlspecialchars($totalMenus) ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body text-center" style="border-radius: 20px;padding-top: 45px;">
          <i class="fa-solid fa-receipt fa-2x text-success mb-2"></i>
          <h5 class="card-title">ออเดอร์วันนี้</h5>
          <p class="fs-4 fw-bold"><?= htmlspecialchars($totalOrders) ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body text-center" style=" border-radius: 20px;padding-top: 45px;">
          <i class="fa-solid fa-sack-dollar fa-2x text-warning mb-2"></i>
          <h5 class="card-title">ยอดขายวันนี้</h5>
          <p class="fs-4 fw-bold">฿<?= htmlspecialchars($todaySales) ?></p>
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
          <canvas id="salesChart" width="400"></canvas>
        </div>

        
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-success text-white fw-bold">
          ☕ ประเภทเมนูขายดี
        </div>
        <div class="card-body">
          <div id="menuChart" style="width:100%; height:400px;"></div>
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
    <table id="ordersTable" class="table table-striped table-hover align-middle">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>โต๊ะที่</th>
          <th>วันที่</th>
          <th>เวลา</th>
          <th>สถานะ</th>
          <th>ราคารวม</th>
          <th>รายละเอียด</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; foreach ($menus as $menu): ?>
          <?php
            $status = htmlspecialchars($menu['status']);
            $statusColors = [
              'pending'   => 'warning',
              'preparing' => 'primary',
              'completed' => 'success'
            ];
            $badgeClass = $statusColors[$status] ?? 'secondary';
          ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($menu['table_id']) ?></td>
            <td><?= date('d/m/Y', strtotime($menu['order_at'])) ?></td>
            <td><?= date('H:i', strtotime($menu['order_at'])) ?> น.</td>
            <td><span class="badge bg-<?= $badgeClass ?>"><?= $status ?></span></td>
            <td>฿<?= htmlspecialchars($menu['total_price']) ?></td>
            <td>
              <a href="showmenu.php?id=<?= $menu['id'] ?>" class="btn btn-sm btn-outline-info">
                <i class="fa-solid fa-circle-info"></i>
              </a>
            </td>
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
  var chartDom = document.getElementById('menuChart');
  var myChart = echarts.init(chartDom);

  var option = {
    tooltip: {
      trigger: 'item'
    },
    legend: {
      top: '5%',
      left: 'center'
    },
    series: [
      {
        name: 'หมวดหมู่เมนู',
        type: 'pie',
        top: '5%',
        radius: ['50%', '70%'],
        avoidLabelOverlap: false,
        padAngle: 5,
        itemStyle: {
          borderRadius: 10
        },
        label: {
          show: false,
          position: 'center'
        },
        emphasis: {
          label: {
            show: true,
            fontSize: 24,
            fontWeight: 'bold'
          }
        },
        labelLine: {
          show: false
        },
        data: <?= json_encode(array_map(function($l,$d){ 
          return ["name"=>$l,"value"=>$d]; 
        }, $labels, $data)) ?>
      }
    ]
  };

  myChart.setOption(option);
</script>

<script>
  $(document).ready(function () {
    $('#ordersTable').DataTable({
      pageLength: 10,
      lengthChange: false,
      ordering: true,
      searching: true,
      language: {
        search: "ค้นหา:",
        paginate: {
          previous: "ก่อนหน้า",
          next: "ถัดไป"
        }
      }
    });
  });
</script>

</body>
</html>
