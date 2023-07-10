<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:dangnhap.php');
}

$today = date('y-m-d');

if(isset($_POST['send'])){

   $maph = rand(1000000000,9999999999);
   $msg = mysqli_real_escape_string($conn, $_POST['message']);

   mysqli_query($conn, "INSERT INTO `phanhoithacmac` VALUES('$maph', '$msg', '$today', '(Chưa trả lời)', '$user_id')") or die('query failed');
   $message[] = 'Đã gửi đi!';
   }


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Horizon | Phản hồi</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Phản hồi</h3>
</div>

<section class="contact">

   <form action="" method="post">
      <h3>Bạn muốn nói điều gì đó ?</h3>
      <input type="text" readonly="true" name="datenow" required placeholder="<?php echo $today;?>" class="box">
      <textarea name="message" class="box" placeholder="Lời nhắn cho chúng tôi..." id="" cols="30" rows="10"></textarea>
      <input type="submit" value="Gửi đi" name="send" class="btn">
   </form>

</section>

<section class="contact">
<?php

   $select_phtm = mysqli_query($conn, "SELECT * FROM `phanhoithacmac` where MaTaiKhoan='$user_id'") or die('query failed');
   ?>

      <center><div class="messenger-box">
      <?php
   if(mysqli_num_rows($select_phtm) > 0)
   {      
      while($fetch_phtm = mysqli_fetch_assoc($select_phtm)){
         ?>
            <div class="message-l">
               <h2 style="float: left; color: #4b4a4a;">(<?php echo $fetch_phtm['NgayGui']; ?>)&nbsp;</h2>
               <h1 style="float: left; color: purple;">Câu hỏi:&ensp;</h1>
               <h2 style="float: left; color: #4b4a4a;"><?php echo $fetch_phtm['NoiDungPhanHoi']; ?></h2>
            </div>
            <div class="message-r">
               <h1 style="float: left; color: purple;">Horizon trả lời:&ensp;</h1>
               <h2 style="float: left; color: #4b4a4a;"><?php echo $fetch_phtm['NoiDungTraLoi']; ?></h2>
            </div>
         <?php
      }
   }
   else
   {
      echo '<p class="empty">Chưa có tin nhắn nào!</p>';
   }
   ?>
   </div></center>
   <?php
?>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>