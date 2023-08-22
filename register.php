<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

    $errorPassword="";
    $errorRepass="";
    $errorFullname="";
    $errorPhone="";
    $errorEmail="";


if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $pass = $_POST['pass'];
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = $_POST['cpass'];
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $check1 = 0; $check2 = 0; $check3 = 0; $check4 = 0; $check5 = 0; $check6 = 0;



   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);


   if(empty($name)){
      $errorFullname = "Vui lòng nhập họ và tên";
      $check3++;
  }
  else{
      if(!preg_match("/^[a-zA-Z ]*$/",$name)){
          $errorFullname = 'Họ và tên sai định dạng';
          $check3++;
      }
      else{
          $errorFullname="";
          $check3=0;
      }
  }

  if(empty($email)){
   $errorEmail = "Vui lòng nhập email";
   $check4++;
}
else{
   if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
       $errorEmail = 'Email sai định dạng';
       $check4++;
   }else{
   
   if($select_user->rowCount() > 0){
      $errorEmail = 'email đã tồn tại';
      $check4++;
   }
   else{
      $errorEmail='';
      $check4=0;
   }
}
}

if(empty($number)){
   $errorPhone = "Vui lòng nhập số điện thoại";
   $check5++;
}
else{
   if(!preg_match('/^[0-9]{10}+$/', $number)){
       $errorPhone = 'Số điện thoại sai định dạng';
       $check5++;
   }
   else{
       $errorPhone="";
       $check5=0;
   }
}


  if(empty($pass)){
      $errorPassword = "Vui lòng nhập mật khẩu";
      $check1++;
  }
  else{
      if(strlen(trim($pass)) < 8 || strlen(trim($pass)) > 16){
          $errorPassword = 'Mật khẩu phải có 8-16 ký tự';
          $check1++;
      }
      else{
          $errorPassword="";
          $check1=0;
      }
  }

  if(empty($cpass)){
      $errorRepass = "Vui lòng nhập lại mật khẩu";
      $check2++;
  }
  else{
      if(strcmp($pass,$cpass) != 0 ){
          $errorRepass = 'Nhập lại mật khẩu không khớp';
          $check2++;
      }
      else{
          $errorRepass="";
          $check2=0;
      }
  }

   $validate = $check1 + $check2 + $check3 + $check4 + $check5 ;
         if($validate==0){
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, number, password) VALUES(?,?,?,?)");
         $insert_user->execute([$name, $email, $number, $cpass]);
         $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
         $select_user->execute([$email, $pass]);
         $row = $select_user->fetch(PDO::FETCH_ASSOC);
         if($select_user->rowCount() > 0){
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
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
   <!-- <link rel="stylesheet" href="css/style.css"> -->
   <link rel="stylesheet" href="css/style.css?php echo time(); ?>">
   <!-- icons -->
   <link rel="shortcut icon" href="images/favicon.png" type="">
   <title>register</title>
</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<section class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" placeholder="enter your name" class="box" maxlength="50"
      value="<?php echo (!empty($name)) ? $name:false;?>">
      <span class="error"><?php echo $errorFullname;?></span>
      <input type="text" name="email" placeholder="enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')"
      value="<?php echo (!empty($email)) ? $email:false;?>">
      <span class="error"><?php echo $errorEmail;?></span>
      <input type="text" name="number" placeholder="enter your number" class="box" min="0" max="9999999999" maxlength="10"
      value="<?php echo (!empty($number)) ? $number:false;?>">
      <span class="error"><?php echo $errorPhone;?></span>
      <input type="password" name="pass" placeholder="enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')"
      value="<?php echo (!empty($pass)) ? $pass:false;?>">
      <span class="error"><?php echo $errorPassword;?></span>
      <input type="password" name="cpass" placeholder="confirm your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')"
      value="<?php echo (!empty($cpass)) ? $cpass:false;?>">
      <span class="error"><?php echo $errorRepass;?></span>
      <br><br><br>
      <input type="submit" value="register now" name="submit" class="btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</section>











<?php include 'components/footer.php'; ?>







<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>