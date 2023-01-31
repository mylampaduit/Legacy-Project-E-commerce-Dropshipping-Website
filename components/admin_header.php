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

      <a href="../admin/panel.php" class="logo">Masterpiece <span>Mart</span></a>
      <nav class="navbar">
         <a href="../admin/panel.php">Control Panel</a>
         <a href="../admin/produtos.php">Products</a>
         <a href="../admin/contas.php">Admins</a>
         <a href="../admin/clientes.php">Customers</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>
      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p>Hello <?= $fetch_profile['name']; ?>!</p>
         <a href="../admin/profile_admin.php" class="btn">Update Profile</a>
         <a href="../index.php" class="btn" target="_blank">Go to Homepage</a>
         <a href="../components/admin_logout.php" class="delete-btn" onclick="return confirm('Do you want to end the session?');">Logout</a> 
      </div>
   </section>
</header>