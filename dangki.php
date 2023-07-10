<?php
    include 'config.php';

  

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
  
   <link rel="stylesheet" type="text/css" href="../css/style2.css">
   <link rel="stylesheet" href="css/toastmessage.css">
    <title>ĐĂNG KÍ | HORIZON</title>
</head>
<body style="background-color: rgb(243, 245, 245);">

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


    <div class="container"> 
    <a href="home.php"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <img class="img-seller-login-home" src="../images/logo.png">
            <label class="lbl-back-home-page">Trang chủ</label>
            <ul class="notifications"></ul>
            <script src="js/toastmessage.js"></script>
            <?php
              if(isset($_POST['input-submit'])){
    
                if(!empty($_POST['input-full-name'])||!empty($_POST['input-email'])||!empty($_POST['input-ten-dn'])||!empty($_POST['input-pass-word'])||!empty($_POST['input-retype-pass-word']))
               {
                $mataikhoan = rand(1000000000,9999999999);
               $name = mysqli_real_escape_string($conn, $_POST['input-full-name']);
               $email = mysqli_real_escape_string($conn, $_POST['input-email']);
               $tendn = mysqli_real_escape_string($conn, $_POST['input-ten-dn']);
               $pass = mysqli_real_escape_string($conn, $_POST['input-pass-word']);
               $cpass = mysqli_real_escape_string($conn, $_POST['input-retype-pass-word']);
        
               
            
               $kt_tenDN = mysqli_query($conn, "SELECT * FROM `taikhoan` WHERE TenDangNhap = '$tendn'") or die('query failed');
                $kt_MaTK =  mysqli_query($conn, "SELECT * FROM `taikhoan` WHERE MaTaiKhoan = '$mataikhoan'") or die('query failed');
        
            
               if(mysqli_num_rows($kt_tenDN) > 0){
                ?>
                <script>handleCreateToast("error","Tên đăng nhập đã được sử dụng!");</script>
                <?php
               }
               else if(mysqli_num_rows($kt_MaTK) > 0)
               {
                ?>
                <script>handleCreateToast("error","Hệ thống bận thử lại sau!");</script>
                <?php
                 }
               else{
                  if($pass != $cpass){
                    ?>
            <script>handleCreateToast("error","Nhập lại mật khẩu không đúng!");</script>
            <?php
                  }else{
                     mysqli_query($conn, "INSERT INTO `taikhoan` VALUES('$mataikhoan','$tendn', '$cpass', '$name', '$email', 0 , 'user')") or die('query failed');
                     ?>
            <script>handleCreateToast("success","Tạo tài khoản thành công!");</script>
            <?php
                     header('location:dangnhap.php');
                  }
               }
               }
               else{
                ?>
            <script>handleCreateToast("error","Vui lòng điền đầy đủ thông tin!");</script>
            <?php
               }
            }
            ?>
        </div></a>
        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12"> 
            <label class="lbl-seller-login-1">Trở thành bạn đồng hành của Horizon</label>
            <label class="lbl-seller-login-2">Hãy đăng kí một tài khoản ngay bây giờ</label>
        </div>

        <form name="form-seller-register" method="post" action="">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 form-body-regis"> 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-label-login-form">
                    <label class="lbl-seller-login-3">ĐĂNG KÍ THÀNH VIÊN</label>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-input-login-form">
                    <input class="input-seller-type-text" name="input-full-name" type="text" placeholder="Họ và tên...">
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-input-login-form">
                    <input class="input-seller-type-text" name="input-email" type="email" placeholder="Email liên lạc...">
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-input-login-form">
                    <input class="input-seller-type-text" name="input-ten-dn" type="text" placeholder="Tên đăng nhập...">
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-input-login-form">
                    <input class="input-seller-type-text" name="input-pass-word" type="password" placeholder="Mật khẩu...">
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-input-login-form">
                    <input class="input-seller-type-text" name="input-retype-pass-word" type="password" placeholder="Nhập lại mật khẩu...">
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-input-login-form">
                    <input name="input-submit" class="input-submit" type="submit" value="ĐĂNG KÍ NGAY">
                </div>                
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 label-forget-pass">
                    <label style="color:rgb(119, 120, 121);">Có tài khoản trước đó?</label><a href="dangnhap.php"><span>&ensp;Đăng nhập</span></a>
                </div>
        </div>
        </form>
    </div>
</body>
</html>