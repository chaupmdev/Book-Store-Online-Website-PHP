<?php
include 'config.php';

$user_id = $_SESSION['user_id']??"";

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Horizon | Về chúng tôi</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/toastmessage.css">
	

</head>
<body>

<header class="header">

   <div class="header-1">
      <div class="flex">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <p><a href="dangnhap.php">Đăng nhập</a> | <a href="dangki.php">Đăng ký</a> </p>
      </div>
   </div>

   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo"><img class="img-logo" src="images/logo.png"></a>

         <nav class="navbar">
            <a href="home.php">Trang chủ</a>
            <a href="about.php">Chúng tôi</a>
            <a href="shop.php?page=1">Sản phẩm</a>
            <a href="contact.php">Phản hồi</a>
            <!-- <a href="orders.php">Đơn hàng</a> -->
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
               $select_cart_number = mysqli_query($conn, "SELECT * FROM `chitietgiohang` WHERE ID = '$user_id'") or die('query failed');
               $cart_rows_number = mysqli_num_rows($select_cart_number); 
            ?>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
         

         <?php
         
         if(!isset($_SESSION['user_id'])){
            echo '<div class="user-box">';
            echo '<p>Chưa đăng nhập tài khoản</p>';
            echo '<a href="dangnhap.php" class="delete-btn">Đăng nhập</a>';
            echo "</div>";
         } 
         else
         {
            echo '<div class="user-box">';
            echo '<p>Người dùng: <span>'.$_SESSION['user_name']??"".'</span></p>';
            echo '<p>Email: <span>'.$_SESSION['user_email']??"".'</span></p>';
            echo '<a href="TrangCaNhan.php" class="delete-btn" style="margin-top:15px">Trang cá nhân</a>';
            echo "</div>"; 
         }
          ?>
          </div>
      </div>
      
   </div>

</header>
<ul class="notifications"></ul>
<script src="js/toastmessage.js"></script>
<script src="js/script.js"></script>

</body>
</html>