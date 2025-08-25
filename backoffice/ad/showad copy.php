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
  <title>AdminEdit</title>
  <link rel="stylesheet" href="../../assets/css/stylemore.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body class="body">
  <?php include "../../backoffice/components/navad.php" ?>
  <div><a href="admin_index.php"><img src="../../assets/img/back-arrow.png" alt="" style="width: 50px; margin-top: 5px; margin-left: 15px; margin-bottom: 15px;"></a></div>

  <div class="container text-center nav-monk">
    <div class="row">
      <div class="col" style="color: #d3d3d3;">
        <a href="" class="font-nav">
          < เมนูอาหาร</a>
      </div>
      <div class="col">
        เมนูแนะนำ
      </div>
      <div class="col" style="color: #d3d3d3; ">
        <a href="" class="font-nav">เมนูของหวาน ></a>
      </div>
    </div>
  </div>
  <div class="container mt-4">
    <div class="row justify-content-start">

      <!-- การ์ด เพิ่ม -->
      <div class="image-select-container col-6 col-md-3 d-flex justify-content-center">
        <a href="../../backoffice/ad/add.php" class="image-box card align-items-center menu-pic border-0 food-pic" style="width: 17rem; border-radius: 25px;" >
          <img src="../../assets/img/add (1).png" class="edit_img card-img-top mt-3" style="width: 50px; margin-top: 50px;" height="200px" alt="...">
        </a>
      </div>

<!-- การ์ด  -->
<div class="container mt-4">
  <div class="row justify-content-center g-5 " >

  <div class="row">
  <?php foreach ($menus as $menu): ?>
    <div class="col-6 col-md-3 d-flex justify-content-center">
      <a href="edit.php?id=<?= $menu['menu_id']?>" class="card align-items-center menu-pic border-0 food-pic" style="width: 17rem; border-radius: 25px; margin-top: 30px;"> 
         <img src="https://static.vecteezy.com/system/resources/previews/025/062/054/non_2x/french-fries-on-white-bowl-isolated-on-transparent-background-fried-fast-food-snack-isolated-food-photography-junk-food-fried-potatoes-free-png.png" class="card-img-top mt-3" style="width: 200px;" height="200px" alt="...">
        <div class="card-body">
          <p class="food-font"><?= htmlspecialchars($menu['name'])?></p>
          <p class="food-font">Price <?= htmlspecialchars($menu['price']) ?> ฿</p>
        </div>
      </a>
    </div>
  <?php endforeach; ?>
</div>

      <!-- การ์ด 2 -->
      <div class="image-select-container col-6 col-md-3 d-flex justify-content-center">
        <a href="javascript:void(0);" class="image-box card align-items-center menu-pic border-0 food-pic" style="width: 17rem; border-radius: 25px;" onclick="toggleSelect(this)">
          <img src="https://static.vecteezy.com/system/resources/thumbnails/023/450/138/small_2x/side-view-of-hot-latte-coffee-with-heart-latte-art-created-with-generative-ai-png.png" class="card-img-top mt-3" style="width: 220px; padding-top: 10px;" height="200px" alt="...">
          <div class="card-body">
          </div>
          <div class="overlay"></div>
        </a>
      </div>

      <!-- การ์ด 4 -->
      <div class="image-select-container col-6 col-md-3 d-flex justify-content-center">
        <a hred="javascript:void(0);" class="image-box card align-items-center menu-pic border-0 food-pic" style="width: 17rem; border-radius: 25px;" onclick="toggleSelect(this)">
          <img src="https://assets.noshu.com/uploads/2022/03/Noshu-BrownieMix-Hero-700px.png" class="card-img-top mt-3" style="width: 200px;" height="200px" alt="...">
          <div class="card-body">
            <p class="food-font">Brownnie</p>
            <p class="food-font1">Price 50 ฿</p>
          </div>
          <div class="overlay"></div>
        </a>
      </div>
    </div>
  </div>

  <div class="container mt-4">
    <div class="row justify-content-start g-5 ">

      <!-- การ์ด 5 -->
      <div class="image-select-container col-6 col-md-3 d-flex justify-content-center">
        <a href="javascript:void(0);" class="image-box card align-items-center menu-pic border-0 food-pic" style="width: 17rem; border-radius: 25px;" onclick="toggleSelect(this)">
          <img src="https://png.pngtree.com/png-vector/20240624/ourmid/pngtree-fried-rice-with-basil-minced-pork-and-egg-thai-food-transparent-png-image_12841981.png" class="card-img-top mt-3" style="width: 200px;" height="200px" alt="...">
          <div class="card-body">
            <p class="food-font">Pad Kra Pao Mhu</p>
            <p class="food-font1">Price 60 ฿</p>
          </div>
          <div class="overlay"></div>
        </a>
      </div>

      <!-- การ์ด 6 -->
      <div class="image-select-container col-6 col-md-3 d-flex justify-content-center">
        <a href="javascript:void(0);" class="image-box card align-items-center menu-pic border-0 food-pic" style="width: 17rem; border-radius: 25px;" onclick="toggleSelect(this)">
          <img src="https://img.wongnai.com/p/256x256/2025/01/18/970d6273045c4b9db8cb9b669514c06b.jpg" class="card-img-top mt-3" style="width: 200px;" height="200px" alt="...">
          <div class="card-body">
            <p class="food-font">Omlette with Rice</p>
            <p class="food-font1">Price 30 ฿</p>
            <p></p>
          </div>
          <div class="overlay"></div>
        </a>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous">
  </script>

  <script>
document.querySelectorAll('input[name="menu"]').forEach(radio => {
  radio.addEventListener('change', () => {
    document.getElementById('menuForm').submit(); // submit อัตโนมัติ
  });
});
</script>

  <script>
    function toggleSelect(element) {
      element.classList.toggle('selected');
    }
  </script>
</body>

<footer><a href="https://www.flaticon.com/"><img src="../../assets/img/bin.png" class="floating-circle" alt="Circle Image"></a></footer>

</html>