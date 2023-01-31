<?php
   include 'components/conex.php';
   session_start();
   if(isset($_SESSION['user_id'])){
      $user_id = $_SESSION['user_id'];
   } else {
      $user_id = '';
   };
   if(isset($_POST['submit'])){
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $email = $_POST['email'];
      $email = filter_var($email, FILTER_SANITIZE_STRING);
      $pass = sha1($_POST['pass']);
      $pass = filter_var($pass, FILTER_SANITIZE_STRING);
      $cpass = sha1($_POST['cpass']);
      $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

      $select_user = $conn->prepare("SELECT * FROM `clientes` WHERE email = ?");
      $select_user->execute([$email,]);
      $row = $select_user->fetch(PDO::FETCH_ASSOC);

      if($select_user->rowCount() > 0){
         $message[] = '
         Register another email!';
      }else{
         if($pass != $cpass){
            $message[] = 'Passwords do not match!';
         } else {
            $insert_user = $conn->prepare("INSERT INTO `clientes`(name, email, password) VALUES(?,?,?)");
            $insert_user->execute([$name, $email, $cpass]);
            $message[] = "Account successfully created, please log in!";
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
      <title>Create Account -</title>
      <link rel="shortcut icon" href="./images/favicon.png" type="image/x-icon">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
      <link rel="stylesheet" href="css/style.css">
   </head>
   <body>
      <?php include 'components/user_header.php'; ?>
      <section class="form-container">
      <form action="" method="post">
   <h3>Create Account</h3>
   <input type="text" name="name" required placeholder="Username" maxlength="20"  class="box">
   <input type="email" name="email" required placeholder="Email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
   <input type="password" name="pass" required placeholder="Password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
   <input type="password" name="cpass" required placeholder="Confirm password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
   <input type="submit" value="Create Account Now" class="btn" name="submit">
   <p>Already have an account?</p>
   <a href="login.php" class="option-btn">Access Account</a>
</form>
      </section>
      <?php include 'components/footer.php'; ?>
      <script src="js/script.js"></script>
   </body>
</html>