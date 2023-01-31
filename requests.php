<?php
   include 'components/conex.php';
   session_start();
   if(isset($_SESSION['user_id'])){
      $user_id = $_SESSION['user_id'];
   } else {
      $user_id = '';
   };
?>
<!DOCTYPE html>
<html lang="pt-PT">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>My Orders</title>
      <link rel="shortcut icon" href="./images/favicon.png" type="image/x-icon">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
      <link rel="stylesheet" href="css/style.css">
   </head>
   <body>
      <?php include 'components/user_header.php'; ?>
      <section class="orders">
         <h1 class="heading">My Orders</h1>
         <div class="box-container">
            <?php
               if($user_id == ''){
                  echo '<p class="empty">Sign in to view orders.</p>';
               } else {
                  $select_orders = $conn->prepare("SELECT * FROM `pedidos` WHERE user_id = ?");
                  $select_orders->execute([$user_id]);
                  if($select_orders->rowCount() > 0){
                     while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                        ?>
                           <div class="box">
                              <p>Req: <span><?= $fetch_orders['placed_on']; ?></span></p>
                              <p>Nome: <span><?= $fetch_orders['name']; ?></span></p>
                              <p>Email: <span><?= $fetch_orders['email']; ?></span></p>
                              <p>Number: <span><?= $fetch_orders['number']; ?></span></p>
                              <p>Address: <span><?= $fetch_orders['address']; ?></span></p>
                              <p>Payment method: <span><?= $fetch_orders['method']; ?></span></p>
                              <p>Total Products: <span><?= $fetch_orders['total_products']; ?></span></p>
                              <p>Total Price: <span>$<?= $fetch_orders['total_price']; ?>/-</span></p>
                              <p>payment status: <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
                           </div>
                        <?php
                     }
                  } else {
                     echo '<p class="empty">No Order Found!</p>';
                  }
               }
            ?>
         </div>
      </section>
      <?php include 'components/footer.php'; ?>
      <script src="js/script.js"></script>
   </body>
</html>