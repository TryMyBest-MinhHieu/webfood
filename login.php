<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = $_POST['pass'];
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if(empty($email) || empty($pass)){
      if(empty($email) && empty($pass)){
         $message[] = 'Vui lòng điền thông tin đăng nhập';
      }

      if(empty($email) && !empty($pass)){
         $message[] = 'vui lòng điền email!';
      }

      if(!empty($email) && empty($pass)){
         $message[] = 'vui lòng điền password!';
      }
      
   }else{
      if($select_user->rowCount() > 0){
         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');
      }else{
         $message[] = 'email hoặc mật khẩu không chính xác!';
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
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <!-- icons -->
   <link rel="shortcut icon" href="images/favicon.png" type="">
   <title>login</title>
</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<section class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <input type="email" name="email" placeholder="enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')"
      value="<?php echo (!empty($email)) ? $email:false;?>">
      <input type="password" name="pass" placeholder="enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')"
      value="<?php echo (!empty($pass)) ? $pass:false;?>">
      <input type="submit" value="login now" name="submit" class="btn">
      <p>don't have an account? <a href="register.php">register now</a></p>
   </form>

</section>











<?php include 'components/footer.php'; ?>






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>