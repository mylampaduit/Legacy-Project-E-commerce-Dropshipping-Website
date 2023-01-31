<?php
   include 'components/conex.php';
   session_start();
   if(isset($_SESSION['user_id'])){
      $user_id = $_SESSION['user_id'];
   } else {
      $user_id = '';
      header('location:login.php');
   };

   if(isset($_POST['delete'])){
      $cart_id = $_POST['cart_id'];
      $delete_cart_item = $conn->prepare("DELETE FROM `carrinho` WHERE id = ?");
      $delete_cart_item->execute([$cart_id]);
   }

   if(isset($_GET['delete_all'])){
      $delete_cart_item = $conn->prepare("DELETE FROM `carrinho` WHERE user_id = ?");
      $delete_cart_item->execute([$user_id]);
      header('location:cart.php');
   }

   if(isset($_POST['update_qty'])){
      $cart_id = $_POST['cart_id'];
      $qty = $_POST['qty'];
      $qty = filter_var($qty, FILTER_SANITIZE_STRING);
      $update_qty = $conn->prepare("UPDATE `carrinho` SET quantity = ? WHERE id = ?");
      $update_qty->execute([$qty, $cart_id]);
      $message[] = 'Product quantity updated!';
   }
?>
<!DOCTYPE html>
<html lang="pt-PT">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Shopping Cart - ShoppingCart</title>
      <link rel="shortcut icon" href="./images/favicon.png" type="image/x-icon">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
      <link rel="stylesheet" href="css/style.css">
   </head>
   <body>
      <?php include 'components/user_header.php'; ?>
      <section class="products shopping-cart">
      <h1 class="heading">Purchased Products</h1>
         <div class="box-container">
            <?php
               $grand_total = 0;
               $select_cart = $conn->prepare("SELECT * FROM `carrinho` WHERE user_id = ?");
               $select_cart->execute([$user_id]);
               if($select_cart->rowCount() > 0){
                  while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                     ?>
                        <form action="" method="post" class="box">
                           <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                           <a href="view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
                           <img src="upload/<?= $fetch_cart['image']; ?>">
                           <div class="name"><?= $fetch_cart['name']; ?></div>
                           <div class="flex">
                              <div class="price"><?= $fetch_cart['price']; ?> $</div>
                              <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantity']; ?>">
                              <button type="submit" class="fas fa-edit" name="update_qty"></button>
                           </div>
                           <div class="sub-total">Sub Total:
                              <span>
                                 <?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?> $
                              </span>
                           </div>
                           <input type="submit" value="Delete" onclick="return confirm('Delete from your orders?');" class="delete-btn" name="delete">
                        </form>
                     <?php
                     $grand_total += $sub_total;
                  }
               } else {
                  echo '<p class="empty">Shopping cart is empty!</p>';
               }
            ?>
         </div>
      </section>
      <?php include 'components/footer.php'; ?>
      <script src="js/script.js"></script>
   </body>
</html>