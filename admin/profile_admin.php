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

      $update_profile_name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
      $update_profile_name->execute([$name, $admin_id]);

      $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
      $prev_pass = $_POST['prev_pass'];

      $old_pass = sha1($_POST['old_pass']);
      $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);

      $new_pass = sha1($_POST['new_pass']);
      $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);

      $confirm_pass = sha1($_POST['confirm_pass']);
      $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

      if($old_pass == $empty_pass){
         $message[] = '
         Enter the current password!';
      } elseif ($old_pass != $prev_pass){
         $message[] = '
         Enter the new password!';
      } elseif ($new_pass != $confirm_pass){
         $message[] = '
         Confirm the new password!';
      } else {
         if($new_pass != $empty_pass){
            $update_admin_pass = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
            $update_admin_pass->execute([$confirm_pass, $admin_id]);
            $message[] = '
            Password successfully updated!';
         } else {
            $message[] = '
            Please enter the new password!';
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
      <title>Update Profile</title>
      <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
      <link rel="stylesheet" href="../css/admin_style.css">
   </head>
   <body>
      <?php include '../components/admin_header.php'; ?>
      <section class="form-container">
         <form action="" method="post">
            <h3>Update Profile</h3>
            <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">
            <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" required placeholder="Username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="old_pass" placeholder="Current Password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="new_pass" placeholder="New Password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="confirm_pass" placeholder="Confirm new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="Update" class="btn" name="submit">
         </form>
      </section>
      <script src="../js/admin_script.js"></script>
   </body>
</html>