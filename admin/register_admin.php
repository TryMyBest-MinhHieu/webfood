<?php

include '../components/connect.php';
require '../admin/CheckPermission.php';

session_start();

$admin_id = $_SESSION['admin']['id'];
$module = "ADMIN";
$perm_id = 4;

$valid = isset($_SESSION["admin"]["permissions"][$module]) ;

if($valid === false){
   exit("Tài khoản không có quyền sử dụng chức năng này");
}

if ($_AD->check($module, $perm_id) === false) {
   exit("Tài khoản không có quyền sử dụng chức năng này");
}

if (!isset($admin_id)) {
   header('location:admin_login.php');
};

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
   $role = $_POST['roles'];
   $role = filter_var($role, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
   $select_admin->execute([$name]);

   if ($select_admin->rowCount() > 0) {
      $message[] = 'username already exists!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'confirm passowrd not matched!';
      } else {
         $insert_admin = $conn->prepare("INSERT INTO `admin`(name, password , role_id) VALUES(?,?,?)");
         $insert_admin->execute([$name, $cpass,$role]);
         $message[] = 'new admin registered!';
         header('location:admin_accounts.php');
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php include '../components/admin_header.php' ?>

   <!-- register admin section starts  -->

   <section class="form-container">

      <form action="" method="POST">
         <h3>register new</h3>
         <input type="text" name="name" maxlength="30" required placeholder="enter your username" class="box" >
         <input type="password" name="pass" maxlength="20" required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="cpass" maxlength="20" required placeholder="confirm your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <p class="title">Chọn chức vụ</p>
         <select id="roles" name="roles" class="box">
         <?php
            $select_roles = $conn->prepare("SELECT * FROM `roles`");
            $select_roles->execute();
            if($select_roles->rowCount() > 0){
               while($fetch_role = $select_roles->fetch(PDO::FETCH_ASSOC)){ 
         ?>
            <option value=<?= $fetch_role["role_id"]; ?>><?= $fetch_role["role_name"]; ?></option>
         <?php
            }
         }else{
            echo '<option value="">None</option>';
         }
         ?>
         </select>
         
         <input type="submit" value="register now" name="submit" class="btn">
      </form>

   </section>

   <!-- register admin section ends -->
















   <!-- custom js file link  -->
   <script src="../js/admin_script.js"></script>

</body>

</html>