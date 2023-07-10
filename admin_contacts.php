<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_contacts.php');
}
if(isset($_POST['repli']))
{
   $nd= $_POST['noidungtraloi'];
   $maph = $_POST['ma_phan_hoi'];
   mysqli_query($conn, "UPDATE `phanhoithacmac` SET NoiDungTraLoi = '$nd' WHERE MaPhanHoi = '$maph'") or die('query failed');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin | Tin nhắn</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="messages">

   <h1 class="title"> Hộp thư </h1>

   <div class="box-container">
   <?php
      $select_message = mysqli_query($conn, "SELECT * FROM `phanhoithacmac`") or die('query failed');
      if(mysqli_num_rows($select_message) > 0){
         while($fetch_message = mysqli_fetch_assoc($select_message)){
            if($fetch_message['NoiDungTraLoi'] == "(Chưa trả lời)")
            {
      
   ?>
   <form method="post">
   <div class="box">
      <input type="hidden" name="ma_phan_hoi" value="<?php echo $fetch_message['MaPhanHoi']; ?>">
      <p> Mã phản hồi : <span><?php echo $fetch_message['MaPhanHoi']; ?></span> </p>
      <p> Mã tài khoản : <span><?php echo $fetch_message['MaTaiKhoan']; ?></span> </p>
      <p> Ngày gửi : <span><?php echo $fetch_message['NgayGui']; ?></span> </p>
      <p> Nội dung thắc mắc : <span><?php echo $fetch_message['NoiDungPhanHoi']; ?></span> </p>
      <input name="noidungtraloi" style="width:100%; height: 40px; margin-bottom: 10px;border:1px solid gray; border-radius:3px" type="text" placeholder="Nhập nội dung phản hồi...">
      <input class="delete-btn" type="submit" name="repli" style="float:left; background-color: purple;margin-right:10px; width:120px" value="Trả lời">
      <a href="admin_contacts.php?delete=<?php echo $fetch_message['MaPhanHoi']; ?>" onclick="return confirm('Xóa nội dung tin nhắn?');" class="delete-btn">Xóa tin nhắn</a>
   </div>
   </form>
   <?php
   }
      }
   }else{
      echo '<p class="empty">Không có tin nhắn nào!</p>';
   }
   ?>
   </div>

</section>









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>