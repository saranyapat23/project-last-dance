<?php 
    require_once '../../includes/db.php'; 
    require_once '../../includes/config.php'; 
    session_start(); 

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0; 
    if ($id <= 0) { 
        header('Location: showmenu.php'); 
        exit; 
    } 

    // JOIN orders กับ menu
    $stmt = $pdo->prepare("
        SELECT od.*, m.name, m.description, m.image, o.status
        FROM orders o
        JOIN order_details od ON od.order_id = o.id
        JOIN menu m ON od.menu_id = m.menu_id
        WHERE o.id = ?
    ");
    $stmt->execute([$id]);
    $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $orders = [];
    foreach ($menus as $menu) {
        $orders[$menu['order_id']]['status'] = $menu['status'];
        $orders[$menu['order_id']]['items'][] = $menu;
    }

    // คำนวณราคารวม
    $totalPrice = 0;
    foreach ($menus as $menu) {
        $totalPrice += $menu['price'] * $menu['quantity'];
    }

    $statusMap = [
        1 => 'pending',    // รอรับออร์เดอร์
        2 => 'preparing',  // กำลังทำ
        3 => 'completed'   // เสร็จแล้ว
    ];

    // Status flow สำหรับเปลี่ยนสถานะ
    $statusFlow = [
        'pending' => 'preparing',
        'preparing' => 'completed',
        'completed' => null
    ];
    
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="../../assets/img/casino.png">
        <title>Hobby Board Game Cafe</title>
        <link rel="stylesheet" href="../../assets/css/stylemore.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="body">

    <nav class="navbar navbar-expand-lg nav-color">
        <div class="container-fluid">
            <div>
                <img src="../../assets/img/152431942_114763933966355_8265361494354481544_n.png" alt="" width="100px" height="100px">
            </div>
            <div class="ms-auto">
                <a href="https://www.youtube.com/@wachirawit007/videos">
                    <img src="./assets/img/history.png" alt="" width="60px" style="margin-right: 10px">
                </a>
            </div>
            <div class="table-number">
                Order <?= htmlspecialchars($id) ?>
            </div>
        </div>
    </nav>

    <div>
        <a href="./foodrec.php">
            <img src="./assets/img/back-arrow.png" alt="" style="width: 50px; margin: 5px 0 15px 15px;">
        </a>
    </div>

    <div class="container position-relative">
            
        <?php foreach ($orders as $order_id => $order): ?>
            <div class="menu-card">
            <h5>Status: <?= htmlspecialchars($order['status']) ?></h5>
                <?php foreach ($order['items'] as $menu): ?>
                    <div class="menu-item">
                        <img src="../../backoffice/uploads/imgmenu/<?= htmlspecialchars($menu['image']) ?>" 
                            alt="รูปภาพ" 
                            onerror="this.onerror=null; this.src='../../assets/img/preview.png';">
                        <div class="menu-text">
                            <div class="menu-title"><?= htmlspecialchars($menu['name']) ?></div>
                            <div class="menu-subtitle">
                                Note: <?= htmlspecialchars(!empty($menu['note']) ? $menu['note'] : '(ไม่ได้เพิ่มรายละเอียด)') ?>
                            </div>
                        </div>
                        <div class="menu-price"><?= htmlspecialchars($menu['quantity'] * $menu['price']) ?> ฿</div>
                    </div>
                <?php endforeach; ?>
                            <div class="total-section-just "> 
                                Total Price:  <span style=""> <?= htmlspecialchars($totalPrice) ?></span> ฿ 
                            </div>

            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
