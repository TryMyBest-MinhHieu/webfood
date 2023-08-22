<?php

include '../components/connect.php';
require '../admin/CheckPermission.php';

session_start();

$admin_id = $_SESSION['admin']['id'];
$module = "AUTH";
$perm_id = 9;

$valid = isset($_SESSION["admin"]["permissions"][$module]) ;

if($valid === false){
   exit("Tài khoản không có quyền sử dụng chức năng này");
}

if($_AD->check($module,$perm_id) === false){
   exit("Tài khoản không có quyền sử dụng chức năng này");
}

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_role = $conn->prepare("DELETE FROM `roles` WHERE role_id = ?");
   $delete_role->execute([$delete_id]);
   $delete_role_permission = $conn->prepare("DELETE FROM `roles_permissions` WHERE role_id = ?");
   $delete_role_permission->execute([$delete_id]);
   header('location:auth.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admins accounts</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- admins accounts section starts  -->

<section class="accounts">

   <h1 class="heading">Bảng phân quyền cho tài khoản hệ thống </h1>

   <div class="box-container">

   <div class="box">
      <p>Tạo nhóm quyền</p>
      <a href="Create_Role.php" class="option-btn">New</a>
   </div>

   <?php
      $selecct_role = $conn->prepare("SELECT * FROM `roles`");
      $selecct_role->execute();
      if($selecct_role->rowCount() > 0){
         while($fetch_role = $selecct_role->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <p> ID : <span><?= $fetch_role['role_id']; ?></span> </p>
      <p> Name : <span><?= $fetch_role['role_name']; ?></span> </p>
      <div class="flex-btn">
        <a href="auth.php?delete=<?= $fetch_role['role_id']; ?>" class="delete-btn" onclick="return confirm('delete this role?');">delete</a>
        <a href="update_role.php?update=<?= $fetch_role['role_id']; ?>&role_name=<?= $fetch_role['role_name']; ?>" class="option-btn">update</a>;
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no role available</p>';
      }
   ?>

   </div>

</section>

<!-- admins accounts section ends -->




















<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>