<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';
session_start();

$stmt = $pdo->query("SELECT * FROM orders");
$order = $stmt->fetchALL();


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
<?php include "../layout/navbar.php"?>
<div><a href="./index.php"><img src="./assets/img/back-arrow.png" alt="" style="width: 50px; margin-top: 5px; margin-left: 15px; margin-bottom: 15px;"></a></div>

  <div class="container-history">
    
    <div class="card-history">
      
      <p class="order-history-text">Order History</p>
      
        <div class="order-list">
            <?php foreach ($order as $od): ?>
                <div class="order-item">
                    <div class="order-time"><?= date('H:i:s', strtotime($od['order_at'])) ?></div>
                    <div class="order-status"><span></span><?= htmlspecialchars($od['status']) ?></div>
                    <button class="check-btn">ตรวจสอบรายการ</button>
                </div>
            <?php endforeach ?>
        </div>

    
    
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>