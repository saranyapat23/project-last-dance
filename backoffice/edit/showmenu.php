<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';
session_start();

$stmt = $pdo->query("SELECT * FROM menu");
$menus = $stmt->fetchALL();
?>

<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecMenu</title>
    <link rel="stylesheet" href="../../assets/css/stylemore.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body class="body"> 
<?php include "../../backoffice/components/navbar.php"?>

<div><a href="./index.php"><img src="./assets/img/back-arrow.png" alt="" style="width: 50px; margin-top: 5px; margin-left: 15px; margin-bottom: 15px;"></a></div>

<div class="container text-center nav-monk">
  <div class="row">
    <div class="col" style="color: #d3d3d3;">
        <a href="./foodmenu.php" class="font-nav">< เมนูอาหาร</a>
    </div>
    <div class="col">
      เมนูแนะนำ
    </div>
    <div class="col" style="color: #d3d3d3; ">
      <a href="./foodsweet.php" class="font-nav">เมนูของหวาน ></a>
    </div>
  </div>
</div>
<div class="container mt-4">
  <div class="row justify-content-center g-5 " >

    <!-- การ์ด 1 -->
    <div class="col-6 col-md-3 d-flex justify-content-center">
    <?php foreach ($menus as $menu): ?>
      <a class="card align-items-center menu-pic border-0 food-pic" style="width: 17rem; border-radius: 25px;"> 
        <img src="https://www.wendys.com/sites/default/files/styles/max_650x650/public/2021-05/daves-double.png?itok=0LISzLWe" class="card-img-top mt-3" style="width: 200px;" height="200px" alt="...">
        <div class="card-body">
        <p class="food-font">  <?=  htmlspecialchars($menu['name'])?> </p>
       <p class="food-font"> Price <?=  htmlspecialchars($menu['price']) ?> ฿</p>
        </div>
      </a>
      <?php endforeach;?>
    </div>

    <!-- การ์ด 2 -->
    <div class="col-6 col-md-3 d-flex justify-content-center">
      <a href="" class="card align-items-center menu-pic border-0 food-pic" style="width: 17rem; border-radius: 25px; ">
        <img src="https://static.vecteezy.com/system/resources/previews/025/062/054/non_2x/french-fries-on-white-bowl-isolated-on-transparent-background-fried-fast-food-snack-isolated-food-photography-junk-food-fried-potatoes-free-png.png" class="card-img-top mt-3" style="width: 200px;" height="200px" alt="...">
        <div class="card-body">
          <p class="food-font">French Fires</p>
          <p class="food-font1">Price 80 ฿</p>
        </div>
      </a>
    </div>

    <!-- การ์ด 3 -->
    <div class="col-6 col-md-3 d-flex justify-content-center">
      <a href="" class="card align-items-center menu-pic border-0 food-pic" style="width: 17rem; border-radius: 25px; ">
        <img src="https://static.vecteezy.com/system/resources/thumbnails/023/450/138/small_2x/side-view-of-hot-latte-coffee-with-heart-latte-art-created-with-generative-ai-png.png" class="card-img-top mt-3" style="width: 220px;" height="200px" alt="...">
        <div class="card-body">
          <p class="food-font">Latte</p>
          <p class="food-font1">Price 35 ฿</p>
        </div>
      </a>
    </div>

    <!-- การ์ด 4 -->
    <div class="col-6 col-md-3 d-flex justify-content-center">
      <a hred="" class="card align-items-center menu-pic border-0 food-pic" style="width: 17rem; border-radius: 25px; ">
        <img src="https://assets.noshu.com/uploads/2022/03/Noshu-BrownieMix-Hero-700px.png" class="card-img-top mt-3" style="width: 200px;" height="200px" alt="...">
        <div class="card-body">
          <p class="food-font">Brownnie</p>
          <p class="food-font1">Price 50 ฿</p>
        </div>
      </a>
    </div>
  </div>
</div>

<div class="container mt-4">
  <div class="row justify-content-center g-5 " >

    <!-- การ์ด 5 -->
    <div class="col-6 col-md-3 d-flex justify-content-center">
      <a href="" class="card align-items-center menu-pic border-0 food-pic" style="width: 17rem; border-radius: 25px;">
        <img src="https://png.pngtree.com/png-vector/20240624/ourmid/pngtree-fried-rice-with-basil-minced-pork-and-egg-thai-food-transparent-png-image_12841981.png" class="card-img-top mt-3" style="width: 200px;" height="200px" alt="...">
        <div class="card-body">
          <p class="food-font">Pad Kra Pao Mhu</p>
          <p class="food-font1">Price 60 ฿</p>
        </div>
      </a>
    </div>

    <!-- การ์ด 6 -->
    <div class="col-6 col-md-3 d-flex justify-content-center">
      <a href="" class="card align-items-center menu-pic border-0 food-pic" style="width: 17rem; border-radius: 25px; ">
        <img src="https://img.wongnai.com/p/256x256/2025/01/18/970d6273045c4b9db8cb9b669514c06b.jpg" class="card-img-top mt-3" style="width: 200px;" height="200px" alt="...">
        <div class="card-body">
          <p class="food-font">Omlette with Rice</p>
          <p class="food-font1">Price 30 ฿</p>
          <p></p>
        </div>
      </a>
    </div>

    <!-- การ์ด 7 -->
    <div class="col-6 col-md-3 d-flex justify-content-center">
      <a href="" class="card align-items-center menu-pic border-0 food-pic" style="width: 17rem; border-radius: 25px; ">
        <img src="https://www.7-eleven.ca/_next/image?url=https%3A%2F%2Fimages.contentstack.io%2Fv3%2Fassets%2Fbltbb619fd5c667ba2d%2Fblt0bca16d59fb153f3%2F67ad604170ce63843238ab5c%2FPortuguese-Egg-Tart-Product-Card.png&w=3840&q=75" class="card-img-top mt-3" style="width: 200px;" height="200px" alt="...">
        <div class="card-body">
          <p class="food-font">Egg Tart</p>
          <p class="food-font1">Price 25 ฿</p>
        </div>
      </a>
    </div>

    <!-- การ์ด 8 -->
    <div class="col-6 col-md-3 d-flex justify-content-center">
      <a href="" class="card align-items-center menu-pic border-0 food-pic" style="width: 17rem; border-radius: 25px; ">
        <img src="https://png.pngtree.com/png-vector/20240329/ourmid/pngtree-iced-mocha-freshness-dessert-refreshing-png-image_12063939.png" class="card-img-top mt-3" style="width: 150px;" height="200px" alt="...">
        <div class="card-body">
          <p class="food-font">Mocca</p>
          <p class="food-font1">Price 35 ฿</p>
        </div>
      </a>
    </div>
  </div>
</div>

  <!-- ถ้ามีพารามิเตอร์ added=1 -->
<?php if (isset($_GET['added']) && $_GET['added'] == 1): ?>
  <div class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center modal-blur" id="successModal" style="z-index: 9999;">
    <div class="custom-modal shadow">
      <h5>เพิ่มลงตะกร้าสำเร็จ</h5>
      <button type="button" class="btn-confirm" onclick="closeModal()">ตกลง</button>
    </div>
  </div>
<?php endif; ?>

<script>
  function closeModal() {
    const url = new URL(window.location);
    url.searchParams.delete('added');
    window.location.href = url; // redirect หน้าปัจจุบันโดยไม่มีพารามิเตอร์
  }
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
<footer><a href="../../ForReal-main/cart.php"><img src="../../assets/img/cart-fix.png" class="floating-circle" alt="Circle Image"></a></footer>
</html>