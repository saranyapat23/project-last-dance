<?php
require_once '../../includes/db.php';
require_once '../../includes/config.php';
session_start();

$stmt = $pdo->query("SELECT * FROM menu");
$menus = $stmt->fetchALL();


$typeMap = [
    1 => 101, // Recommend
    2 => 102, // Food
    3 => 103, // Drink
    4 => 104  // Dessert
];

$menu = isset($_GET['menu']) ? (int)$_GET['menu'] : 1;
$type_id = $typeMap[$menu];

// ดึงข้อมูลตาม type_id
$stmt = $pdo->prepare("SELECT * FROM menu WHERE type_id = ?");
$stmt->execute([$type_id]);
$menus = $stmt->fetchAll();

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
  <div><a href="./index.php"><img src="./assets/img/back-arrow.png" alt="" style="width: 50px; margin-top: 5px; margin-left: 15px; margin-bottom: 15px;"></a></div>

  <form id="menuForm" method="get">
  <div class="menu-options-customer">
    <input type="radio" id="menu1" name="menu" value="1" <?= $menu==1?"checked":"" ?>>
    <label for="menu1">RECOMMEND</label>

    <input type="radio" id="menu2" name="menu" value="2" <?= $menu==2?"checked":"" ?>>
    <label for="menu2">FOOD</label>

    <input type="radio" id="menu3" name="menu" value="3" <?= $menu==3?"checked":"" ?>>
    <label for="menu3">DRINK</label>

    <input type="radio" id="menu4" name="menu" value="4" <?= $menu==4?"checked":"" ?>>
    <label for="menu4">DESSERT</label>
  </div>
</form>
    

<div class="container mt-4">
  <div class="row justify-content-center g-5 " >

  <div class="row">
  <?php foreach ($menus as $menu): ?>
    <div class="col-6 col-md-3 d-flex justify-content-center">
      <a href="javascript:void(0);" class="card align-items-center menu-pic border-0 food-pic" style="width: 17rem; border-radius: 25px; margin-top: 30px;"> 
         <img src="https://static.vecteezy.com/system/resources/previews/025/062/054/non_2x/french-fries-on-white-bowl-isolated-on-transparent-background-fried-fast-food-snack-isolated-food-photography-junk-food-fried-potatoes-free-png.png" class="card-img-top mt-3" style="width: 200px;" height="200px" alt="...">
        <div class="card-body">
          <p class="food-font"><?= htmlspecialchars($menu['name'])?></p>
          <p class="food-font">Price <?= htmlspecialchars($menu['price']) ?> ฿</p>
        </div>
      </a>
    </div>
  <?php endforeach; ?>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous">
  </script>

 <script>
  function toggleSelect(element) {
    element.classList.toggle("selected");
  }
</script>
</body>

<footer><a href="../../backoffice/ad/add.php"><img src="../../assets/img/bin.png" class="floating-circle" alt="Circle Image"></a></footer>

</html>