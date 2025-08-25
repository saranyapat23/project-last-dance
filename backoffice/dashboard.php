
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/152431942_114763933966355_8265361494354481544_n.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="body"> 
<?php include "./backoffice/components/navbar_admin.php"?>

  <div class="center-image">
    <img class="logmage" src="./assets/img/loginuser.png" alt="" >
  </div>




  <div class="login-box center-image container-sm" style="margin-top: 40px">
  <form action="./backoffice/edit/showmenu.php" method="post">
    <div class="input-icon">
      <img src="./assets/img/goin.png" alt="user">
     <input type="text" name="username" placeholder="Username" >
    </div>
      
    <div class="input-icon">
      <img src="./assets/img/lock.png" alt="">
    <input type="password" name="password" placeholder="Password">
  </div>
    <br> 
    <input type="submit" value="เข้าสู่ระบบ" >
  </form>
</html>