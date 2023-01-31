<?php
   include '../components/conex.php';
   session_start();
   $admin_id = $_SESSION['admin_id'];
   if(!isset($admin_id)){
      header('location:index.php');
   }
   if(isset($_POST['update_payment'])){
      $order_id = $_POST['order_id'];
      $payment_status = $_POST['payment_status'];
      $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
      $update_payment = $conn->prepare("UPDATE `pedidos` SET payment_status = ? WHERE id = ?");
      $update_payment->execute([$payment_status, $order_id]);
      $message[] = 'Estado do pagamento atualizado!';
   }
   if(isset($_GET['delete'])){
      $delete_id = $_GET['delete'];
      $delete_order = $conn->prepare("DELETE FROM `pedidos` WHERE id = ?");
      $delete_order->execute([$delete_id]);
      header('location:requests.php');
   }
?>
<!DOCTYPE html>
<html lang="pt-PT">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Requests</title>
      <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
      <link rel="stylesheet" href="../css/admin_style.css">
   </head>
   <body>
      <?php include '../components/admin_header.php'; ?>
      <section class="orders">
         <h1 class="heading">Requests</h1>
         <div class="box-container">
            <?php
               $select_orders = $conn->prepare("SELECT * FROM `pedidos`");
               $select_orders->execute();
               if($select_orders->rowCount() > 0){
                  while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){ ?>
                     <div class="box">
                        <p>Requirements: <span><?= $fetch_orders['placed_on']; ?></span> </p>
                        <p>Name: <span><?= $fetch_orders['name']; ?></span> </p>
                        <p>Number: <span><?= $fetch_orders['number']; ?></span> </p>
                        <p>Address: <span><?= $fetch_orders['address']; ?></span> </p>
                        <p>Total products: <span><?= $fetch_orders['total_products']; ?></span> </p>
                        <p>Total price: <span>$<?= $fetch_orders['total_price']; ?>/-</span> </p>
                        <p>Payment method: <span><?= $fetch_orders['method']; ?></span> </p>
                        <form action="" method="post">
                           <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                           <select name="payment_status" class="select">
                              <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
                              <option value="pending">Pending</option>
                              <option value="completed">Complete</option>
                           </select>
                           <div class="flex-btn">
                              <input type="submit" value="Atualizar" class="option-btn" name="update_payment">
                              <a href="requests.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">Delete</a>
                           </div>
                        </form>
                     </div>
                  <?php }
               } else {
                  echo '<p class="empty">No orders found</p>';
               }
            ?>
         </div>
      </section>
      <script src="../js/admin_script.js"></script>
   </body>
</html>