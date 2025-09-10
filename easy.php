<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#e2ffadff">
    <link rel="icon" type="image/x-icon" href="../../assets/img/casino.png">
    <title>Hobby Board Game Cafe</title>
    <link rel="stylesheet" href="./assets/css/stylemore.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<nav class="navbar navbar-expand-lg nav-color">
  <div class="container-fluid">
  <div>
<img src="./assets/img/152431942_114763933966355_8265361494354481544_n.png" alt="" height="100px">
</div>

<div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item mx-2">
          <a class="nav-link d-flex flex-column align-items-center" href="https://www.facebook.com/hobbyboardgamecafe">
            <i class="fa-brands fa-facebook fa-2x"></i> 
          </a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link d-flex flex-column align-items-center" href="https://www.instagram.com/hobbyboardgamecafe/">
            <i class="fa-brands fa-instagram fa-2x"></i>
          </a>
        </li>
        <li class="nav-item mx-2">
          <a class="nav-link d-flex flex-column align-items-center" href="https://maps.app.goo.gl/SXr224kdP48e3Ewt5">
            <i class="fa-solid fa-location-dot fa-2x"></i>
          </a>
        </li>
      </ul>
    </div>
</nav> 
    
<body class="body background-customer"> 
    
<div class="container-fluid">
    <h1 class="MenuH1" style="padding: 15px 20px ">H<img src="./assets/img/casino.png" style="width: 60px; margin-right: 10px">bby Board Game Cafe</h1>
</div>
<div class="container mt-4">
  <style>
    /* การ์ด custom */
    .custom-card {
      width: 15rem;
      border: 3px solid #ccc;
      border-radius: 25px;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      text-align: center;
      padding: 1rem;
      background-color: #fff;
    }

    .custom-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    /* card-title-box */
    .card-title-box {
      position: relative; /* สำคัญสำหรับ ::after */
      display: inline-block;
      background-color: #c6e3ffff;
      padding: 10px 20px;
      border-radius: 25px;
      font-weight: bold;
      color: #333;
      text-align: center;
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      backdrop-filter: blur(5px);
      cursor: pointer;
      z-index: 1;
      text-decoration: none; /* ลบเส้นใต้ */
    }

    /* Hover effect */
    .card-title-box:hover {
      background: linear-gradient(135deg, #ff9a9e, #fad0c4);
      color: #fff;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      transform: translateY(-3px) scale(1.05);
    }

    /* Glow effect */
    .card-title-box::after {
      content: '';
      position: absolute;
      top: -5px; left: -5px;
      width: calc(100% + 10px);
      height: calc(100% + 10px);
      border-radius: 25px;
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.4);
      opacity: 0;
      transition: opacity 0.3s ease;
      z-index: 0;
    }

    .card-title-box:hover::after {
      opacity: 1;
    }

    /* รูปปรับให้สวย */
    .custom-card img {
      width: 200px;
      border-radius: 15px;
    }

    h6 {
      margin: 10px 0;
      font-weight: bold;
    }
  </style>

  <div class="row justify-content-center g-4">
    <!-- การ์ด 1 -->
    <div class="col-6 col-md-3 d-flex justify-content-center">
      <div class="card custom-card shadow-lg">
        <img src="./assets/img/master.png" alt="GAME MASTER">
        <div class="card-body">
          <h6>GAME MASTER</h6>
          <a class="card-title-box" style="margin-top: 15px; padding-bottom: 10px" href="./backoffice/login.php">Go Login</a>
        </div>
      </div>
    </div>

    <!-- การ์ด 2 -->
    <div class="col-6 col-md-3 d-flex justify-content-center">
      <div class="card custom-card shadow-lg">
        <img src="./assets/img/menu.png" alt="CUSTOMER">
        <div class="card-body">
          <h6>CUSTOMER</h6>
          <a class="card-title-box" id="customerBtn" style="margin-top: 15px;">Go Order</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<script>
  document.getElementById('customerBtn').addEventListener('click', () => {
    Swal.fire({
      title: 'เลือกโต๊ะ',
      input: 'select',
      inputOptions: {
        option1: 'โต๊ะที่ 1',
        option2: 'โต๊ะที่ 2',
        option3: 'โต๊ะที่ 3',
        option4: 'โต๊ะที่ 4',
        option5: 'โต๊ะที่ 5'
      },
      inputPlaceholder: 'Choose the Table',
      showCancelButton: true
    }).then((result) => {
      if (result.isConfirmed) {
  // ตัวอย่าง: redirect ไปหน้าใหม่ตามตัวเลือก
  switch(result.value) {
    case 'option1':
      window.location.href = '/project-last-dance/fontend/main/menu.php?table_id=1';
      break;
    case 'option2':
      window.location.href = '/project-last-dance/fontend/main/menu.php?table_id=2';
      break;
    case 'option3':
      window.location.href = '/project-last-dance/fontend/main/menu.php?table_id=3';
      break;
    case 'option4':
      window.location.href = '/project-last-dance/fontend/main/menu.php?table_id=4';
      break;
    case 'option5':
      window.location.href = '/project-last-dance/fontend/main/menu.php?table_id=5';
      break;
    default:
      // ถ้าไม่เลือกอะไร
      break;
  }
}
    });
  });
</script>
<footer></footer>
</html>