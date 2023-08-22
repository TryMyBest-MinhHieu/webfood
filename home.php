<!-- header section start -->
<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Mobile Metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   <!-- Site Metas -->
   <meta name="keywords" content="" />
   <meta name="description" content="" />
   <meta name="author" content="" />

   <!-- icons -->
   <link rel="shortcut icon" href="images/favicon.png" type="">
   <title>home</title>

   <!-- bootstrap core css -->
   <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

   <!-- swiperjs.com link -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link -->
   <link rel="stylesheet" href="css/style.css">
   <!-- <link rel="stylesheet" href="css/html.css"> -->
</head>

<body>
   <!-- header -->
   <?php include 'components/user_header.php'; ?>
   <!-- end header -->

   <!-- Trang chủ -->
   <!-- hero area 1 -->
   <!-- swiper slider chuyển động của home -->
   <section class="hero">

      <div class="swiper hero-slider">

         <div class="swiper-wrapper">

            <div class="swiper-slide slide">
               <div class="content">
                  <span>Yumy Yumy</span>
                  <h3>Thực đơn hấp dẫn</h3>
                  <a href="menu.php" class="btn">Menu</a>
               </div>
               <div class="image">
                  <img src="images/home-img-1.png" alt="">
               </div>
            </div>

            <div class="swiper-slide slide">
               <div class="content">
                  <span>Yumy Yumy</span>
                  <h3>Thực đơn hấp dẫn</h3>
                  <a href="menu.php" class="btn">see menus</a>
               </div>
               <div class="image">
                  <img src="images/home-img-2.png" alt="">
               </div>
            </div>

            <div class="swiper-slide slide">
               <div class="content">
                  <span>Yumy Yumy</span>
                  <h3>Thực đơn hấp dẫn</h3>
                  <a href="menu.php" class="btn">see menus</a>
               </div>
               <div class="image">
                  <img src="images/home-img-3.png" alt="">
               </div>
            </div>

            <div class="swiper-slide slide">
               <div class="content">
                  <span>Yumy Yumy</span>
                  <h3>Thực đơn hấp dẫn</h3>
                  <a href="menu.php" class="btn">see menus</a>
               </div>
               <div class="image">
                  <img src="images/home-img-4.png" alt="">
               </div>
            </div>


         </div>

         <div class="swiper-pagination"></div>

      </div>
   </section>
   <!-- end hero area 1 -->

   <section class="category">

      <h1 class="title">Menu</h1>

      <div class="box-container">

         <!-- <a href="category.php?category=fast food" class="box"> -->
         <a href="category.php?quanly=menu&id=1" class="box">
            <img src="images/cat-1.png" alt="">
            <h3>fast food</h3>
         </a>

         <!-- <a href="category.php?category=main dish" class="box"> -->
         <a href="category.php?quanly=menu&id=2" class="box">
            <img src="images/cat-2.png" alt="">
            <h3>main dishes</h3>
         </a>

         <!-- <a href="category.php?category=drinks" class="box"> -->
         <a href="category.php?quanly=menu&id=3" class="box">
            <img src="images/cat-3.png" alt="">
            <h3>drinks</h3>
         </a>

         <!-- <a href="category.php?category=desserts" class="box"> -->
         <a href="category.php?quanly=menu&id=4" class="box">
            <img src="images/cat-4.png" alt="">
            <h3>desserts</h3>
         </a>

      </div>

   </section>
   <!-- end category menu -->

   <!-- hero area 2 -->
   <div class="hero_area">
      <div class="bg-box">
         <img src="images/hero-bg.jpg" alt="">
      </div>
   </div>
   <!-- end hero area 2 -->

   <section class="products">

      <h1 class="title">Món ăn mới</h1>

      <div class="box-container">

         <?php
         $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
         $select_products->execute();
         if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
         ?>
               <form action="" method="post" class="box">
                  <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                  <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                  <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                  <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                  <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
                  <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
                  <img src="project images/<?= $fetch_products['image']; ?>" alt="">
                  <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
                  <div class="name"><?= $fetch_products['name']; ?></div>
                  <div class="flex">
                     <div class="price"><span>$</span><?= $fetch_products['price']; ?></div>
                     <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
                  </div>
               </form>
         <?php
            }
         } else {
            echo '<p class="empty">Chưa có sản phẩm</p>';
         }
         ?>

      </div>

      <div class="more-btn">
         <a href="menu.php" class="btn">Xem thêm</a>
      </div>

   </section>




   <!-- footer -->
   <?php include 'components/footer.php'; ?>
   <!-- end footer -->

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

   <!-- swiperjs.com -->
   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
   <script>
      var swiper = new Swiper(".hero-slider", {
         loop: true,
         grabCursor: true,
         effect: "flip",
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
      });
   </script>

</body>

</html>