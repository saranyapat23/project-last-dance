
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/152431942_114763933966355_8265361494354481544_n.png">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    
</head>
<body class="body"> 
<?php include "./backoffice/components/navbar_admin.php"?>


  <div class="login-wrapper">
  <div class="login-box center-image container-sm" style="margin-top: 100px">
     <div class="center-image">
    <img class="logmage" src="./assets/img/user (3).png" alt="" >
  </div>

    <form action="./backoffice/edit/showmenu.php" method="post">
      <h2 class="text-center mb-4">เข้าสู่ระบบ</h2>

      <div class="input-group">
  <span class="input-group-text"><i class="fa-solid fa-user-lock"></i></span>
  <input type="text" class="form-control" placeholder="Username"> 
</div>

<div class="input-group">
  <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
  <input type="password" class="form-control" placeholder="Password">
</div>

      <br> 
      <input type="submit" value="เข้าสู่ระบบ" class="btn-login">
    </form>
  </div>
</div>
  
</body>
</html>