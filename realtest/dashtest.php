
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#e2ffadff">
    <link rel="icon" type="image/x-icon" href="./img/casino.png">
    <title>Hobby Board Game Cafe</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
</head>
<body>


   <div class="wrapper">
  <div class="card-switch">
    <label class="switch">
      <input type="checkbox" class="toggle">
      <span class="slider"></span>
      <span class="card-side"></span>
      <div class="flip-card_inner">
        
        <!-- FRONT (Login) -->
        <div class="flip-card_front">
          <div class="title">Login</div>
          <form class="flip-card_form" action="">
            <input class="flip-card_input" type="text" placeholder="Username" required>
            <input class="flip-card_input" type="password" placeholder="Password" required>
            <button class="flip-card_btn">Login</button>
          </form>
        </div>
        
        <!-- BACK (Sign Up) -->
        <div class="flip-card_back">
          <div class="title">Sign Up</div>
          <form class="flip-card_form" action="">
            <input class="flip-card_input" type="email" placeholder="Email" required>
            <input class="flip-card_input" type="text" placeholder="Username" required>
            <input class="flip-card_input" type="password" placeholder="Password" required>
            <button class="flip-card_btn">Sign Up</button>
          </form>
        </div>

      </div>
    </label>
  </div>
</div>

  </body>
</html>