<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>
<header class="header">
<section class="flex">
      
      <a href="index.php" class="logo">Masterpiece <span>Mart</span></a>
      
      <nav class="navbar">
     <a href="index.php">Home</a>
     <a href="requests.php">Orders</a>
     <a href="produtos.php">Products</a>
     <a href="search.php"><i class="fas fa-search"></i></a>
  </nav>


      <div class="icons">
         <?php
            $count_wishlist_items = $conn->prepare("SELECT * FROM `favoritos` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
            $total_wishlist_counts = $count_wishlist_items->rowCount();
            $count_cart_items = $conn->prepare("SELECT * FROM `carrinho` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();
         ?>
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php          
            $select_profile = $conn->prepare("SELECT * FROM `clientes` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
               ?>
                  <p><?= $fetch_profile["name"]; ?></p>
                  <a href="UserProfile.php" class="btn">Update Profile</a>
                  <div class="flex-btn">
                     <a href="favoritos.php" class="option-btn"><i class="fas fa-heart"></i> <?= $total_wishlist_counts; ?> Favoritos</a>
                     <a href="cart.php" class="option-btn"><i class="fas fa-shopping-cart"></i> <?= $total_cart_counts; ?> Items</a>
                  </div>
                  <a href="components/user_logout.php" class="delete-btn" onclick="return confirm('Do you want to log out?');">Logout</a> 
               <?php
            } else {
               ?>
                  <div class="flex-btn">
                  <a href="createaccount.php" class="option-btn">Create</a>
                  <a href="login.php" class="option-btn">Login</a>
              </div>
               <?php
            }
         ?>      
      </div>
   </section>
</header>