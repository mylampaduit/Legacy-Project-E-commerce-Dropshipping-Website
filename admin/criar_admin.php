<?php
   include '../components/conex.php';
   session_start();
   $admin_id = $_SESSION['admin_id'];
   if(!isset($admin_id)){
      header('location:index.php');
   }
   if(isset($_POST['submit'])){

      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $pass = sha1($_POST['pass']);
      $pass = filter_var($pass, FILTER_SANITIZE_STRING);
      $cpass = sha1($_POST['cpass']);
      $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

      $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
      $select_admin->execute([$name]);

      if($select_admin->rowCount() > 0){
         $message[] = 'Username already registered!';
      } else {
         if($pass != $cpass){
            $message[] = '
            Confirmation password does not match!';
         } else {
            $insert_admin = $conn->prepare("INSERT INTO `admins`(name, password) VALUES(?,?)");
            $insert_admin->execute([$name, $cpass]);
            $message[] = 'Admin successfully created!';
         }
      }
   }
?>
<!DOCTYPE html>
<html lang="pt-PT">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Register Administrators</title>
      <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
      <link rel="stylesheet" href="../css/admin_style.css">
   </head>
   <body>
      <?php include '../components/admin_header.php'; ?>
      <section class="form-container">
         <form action="" method="post">
            <h3>Create Administrator Account</h3>
            <input type="text" name="name" required placeholder="Username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="pass" required placeholder="Password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="cpass" required placeholder="Confirm Password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="Create an account" class="btn" name="submit">
         </form>
      </section>
      <script src="../js/admin_script.js"></script>
   </body>
</html>