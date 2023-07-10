
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   
  
   <link rel="stylesheet" type="text/css" href="../css/style2.css">
   <link rel="stylesheet" href="css/toastmessage.css">
    <title>HORIZON</title>
</head>
<body style="background-color: rgb(243, 245, 245);">
<ul class="notifications"></ul>
<script src="js/toastmessage.js"></script>
<?php
    include 'config.php';

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
                    <script>handleCreateToast("error","Tên đăng nhập đã tồn tại!!!");</script>
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
                    <script>handleCreateToast("error","Mật khẩu nhập lại không đúng!");</script>
                    <?php
                }else{
                    mysqli_query($conn, "INSERT INTO `taikhoan` VALUES('$mataikhoan','$tendn', '$cpass', '$name', '$email', 0 , 'admin')") or die('query failed');
                    ?>
                    <script>handleCreateToast("success","Tạo tài khoản thành công!!!");</script>
                    <?php
                    header('location:admin_page.php');
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


<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>';
   }
}
?>
    <div class="container"> 
        <form name="form-seller-register" method="post" action="">
            
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 form-body-regis" style="left: 50% ;transform: translateX(-50%); margin-top: 70px;"> 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-label-login-form">
                    <label class="lbl-seller-login-3">TẠO TÀI KHOẢN ADMIN</label>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-input-login-form">
                    <input class="input-seller-type-text" name="input-full-name" type="text" placeholder="Họ và tên..." >
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-input-login-form">
                    <input class="input-seller-type-text" name="input-email" type="email" placeholder="Email liên lạc..." >
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-input-login-form">
                    <input class="input-seller-type-text" name="input-ten-dn" type="text" placeholder="Tên đăng nhập..." >
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-input-login-form">
                    <input class="input-seller-type-text" name="input-pass-word" type="password" placeholder="Mật khẩu..." >
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-input-login-form">
                    <input class="input-seller-type-text" name="input-retype-pass-word" type="password" placeholder="Nhập lại mật khẩu..." >
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-input-login-form">
                    <input name="input-submit" class="input-submit" type="submit" value="Thêm admin">
                </div>               
            </div>
            
        </form>
    </div>

</body>
</html>