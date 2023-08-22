<!-- thêm -->

<?php

include '../components/connect.php';
require '../admin/CheckPermission.php';

session_start();

$admin_id = $_SESSION['admin']['id'];

$admin_id = $_SESSION['admin']['id'];
$module = "PRODU";
$perm_id = 12;

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

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_category'])){

   $namecate = $_POST['namecate'];
   $namecate = filter_var($namecate, FILTER_SANITIZE_STRING);


   $select_cate = $conn->prepare("SELECT * FROM `category` WHERE namecate = ?");
   $select_cate->execute([$namecate]);

   if($select_cate->rowCount() > 0){
      $message[] = 'cate name already exists!';
   }else{

         $insert_cate = $conn->prepare("INSERT INTO `category`(namecate) VALUES(?)");
         $insert_cate->execute([$namecate]);

         $message[] = 'new category added!';

   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_cate = $conn->prepare("DELETE FROM `category` WHERE id_cate = ?");
   $delete_cate->execute([$delete_id]);
   header('location:category.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- add products section starts  -->

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>add category</h3>
      <input type="text" required placeholder="enter category name" name="namecate" maxlength="100" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="add category" name="add_category" class="btn">
   </form>

</section>

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

   <?php
      $show_category = $conn->prepare("SELECT * FROM `category`");
      $show_category->execute();
      if($show_category->rowCount() > 0){
         while($fetch_category = $show_category->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <div class="name"><?= $fetch_category['namecate']; ?></div>
      <div class="flex-btn">
         <a href="category.php?delete=<?= $fetch_category['id_cate']; ?>" class="delete-btn" onclick="return confirm('delete this category?');">delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no category added yet!</p>';
      }
   ?>

   </div>

</section>

<!-- show products section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>