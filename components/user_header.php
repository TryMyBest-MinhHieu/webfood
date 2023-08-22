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
      <!-- logo menu -->
      <a href="home.php" class="logo">Yumy-Yumy 😋</a>

      <!-- menu bar -->
      <nav class="navbar">
         <a href="home.php">Trang chủ</a>
         <a href="menu.php">Menu</a>
         <a href="orders.php">Đặt hàng</a>
         <a href="about.php">Thông tin</a>
         <a href="contact.php">Liên hệ</a>
      </nav>
      <!-- end menu bar -->

      <!-- icons menu bar -->
      <div class="icons">
         <!-- count number food are added to cart -->
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
         ?>
         <!-- end count number food are added to cart -->
         <a href="search.php"><i class="fas fa-search"></i></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i>
            <span>(<?= $total_cart_items; ?>)</span></a> <!-- thẻ hiển thị format số cạnh bên cart -->

         <div id="user-btn" class="fas fa-user"></div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>
      <!-- end icons menu bar -->

      <div class="profile">
         <!-- hiển thị đăng xuất và thông tin khi click icon tài khoản -->
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="name"><?= $fetch_profile['name']; ?></p>
         <div class="flex">
            <a href="profile.php" class="btn">profile</a>
            <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         </div>
         <p class="account">
            <!-- <a href="login.php">login</a> or -->
            <!-- <a href="register.php">register</a> -->
         </p> 
         <?php
            }else{
         ?>
            <p class="name">please login first!</p>
            <a href="login.php" class="btn">login as customer</a>
            <a href="./admin/home.php" class="btn">login admin page</a>
         <?php
          }
         ?>
      </div>

   </section>

</header>


