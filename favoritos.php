<?php
   include 'components/conex.php';
   session_start();
   if(isset($_SESSION['user_id'])){
      $user_id = $_SESSION['user_id'];
   } else {
      $user_id = '';
      header('location:login.php');
   };
   include 'components/cart_fav.php';
   if(isset($_POST['delete'])){
      $wishlist_id = $_POST['wishlist_id'];
      $delete_wishlist_item = $conn->prepare("DELETE FROM `favoritos` WHERE id = ?");
      $delete_wishlist_item->execute([$wishlist_id]);
   }
   if(isset($_GET['delete_all'])){
      $delete_wishlist_item = $conn->prepare("DELETE FROM `favoritos` WHERE user_id = ?");
      $delete_wishlist_item->execute([$user_id]);
      header('location:favoritos.php');
   }
?>

<!DOCTYPE html>
<html lang="pt-PT">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>
FAVORITES</title>
      <link rel="shortcut icon" href="./images/favicon.png" type="image/x-icon">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
      <link rel="stylesheet" href="css/style.css">
   </head>
   <body>
      <?php include 'components/user_header.php'; ?>
      <section class="products">
         <h3 class="heading">
FAVORITES</h3>
         <div class="box-container">
            <?php
               $grand_total = 0;
               $select_wishlist = $conn->prepare("SELECT * FROM `favoritos` WHERE user_id = ?");
               $select_wishlist->execute([$user_id]);
               if($select_wishlist->rowCount() > 0){
                  while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){
                     $grand_total += $fetch_wishlist['price'];  
                     ?>
                     <form action="" method="post" class="box">
                           <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
                           <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
                           <input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
                           <input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
                           <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
                           <a href="ver.php?pid=<?= $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
                           <img src="upload/<?= $fetch_wishlist['image']; ?>">
                           <div class="name">
                              <?= $fetch_wishlist['name']; ?>
                           </div>
                           <div class="flex">
                              <div class="price"><?= $fetch_wishlist['price']; ?> MZN</div>
                              <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                           </div>
                           <input type="submit" value="Buy" class="btn" name="add_to_cart">
                           <input type="submit" value="Delete" onclick="return confirm('Deseja remover o produto dos favoritos?');" class="delete-btn" name="delete">
                        </form>


                     <?php
                  }
               } else {
                  echo '<p class="empty">No favorites found!</p>';
                  }
            ?>
         </div>
      </section>
      <?php include 'components/footer.php'; ?>
      <script src="js/script.js"></script>
   </body>
</html>