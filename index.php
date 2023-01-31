<?php
   include 'components/conex.php';
   session_start();
   if(isset($_SESSION['user_id'])){
      $user_id = $_SESSION['user_id'];
   } else {
      $user_id = '';
   };
   include 'components/cart_fav.php';
?>
<!DOCTYPE html>
<html lang="pt-PT">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Masterpiece Mart | HomePage</title>
      <link rel="shortcut icon" href="./images/favicon.png" type="image/x-icon">
      <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
      <link rel="stylesheet" href="css/style.css">
   </head>
   <body>
      <?php include 'components/user_header.php'; ?>
      <div class="home-bg">
         <section class="home">
           <h1>Experience art in a whole new dimension with our digital creations</h1>
         <a href="produtos.php" class="btn" >See Products</a>
     </section>
  </div>
      </div>
      <?php include 'components/footer.php'; ?>

      <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
      <script src="js/script.js"></script>
    
   </body>
</html>