<?php
    include 'config.php';
    session_start();
    
  
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/style2.css">
   <link rel="stylesheet" href="css/toastmessage.css">
    <title>ĐĂNG NHẬP | HORIZON</title>
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
    
                $tendn = mysqli_real_escape_string($conn, $_POST['input-user-name']);
                $pass = mysqli_real_escape_string($conn, $_POST['input-pass-word']);
             
                $select_users = mysqli_query($conn, "SELECT * FROM `taikhoan` WHERE TenDangNhap = '$tendn' AND MatKhau = '$pass'") or die('query failed');
             
                if(mysqli_num_rows($select_users) > 0)
                {
                     
                     $row = mysqli_fetch_assoc($select_users);
                     if($row['BiKhoa'] == '0')
                     {
                         if($row['MaQuyen'] == 'admin'){
                     
                             $_SESSION['admin_name'] = $row['HoTen'];
                             $_SESSION['admin_email'] = $row['Email'];
                             $_SESSION['admin_id'] = $row['MaTaiKhoan'];
                             header('location:admin_page.php');
                     
                         }elseif($row['MaQuyen'] == 'user'){
                     
                             $_SESSION['user_name'] = $row['HoTen'];
                             $_SESSION['user_email'] = $row['Email'];
                             $_SESSION['user_id'] = $row['MaTaiKhoan'];
                             header('location:home.php');
                     
                         }
                 
                     }
                     else{
                        ?>
                        <script>handleCreateToast("error","Tài khoản đã bị khóa!");</script>
                        <?php
                     }
                }else{
                    ?>
                    <script>handleCreateToast("error","Sai tài khoản hoặc mật khẩu!");</script>
                    <?php
                }
             
             }
            ?>
        </div></a>
        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12"> 
            <label class="lbl-seller-login-1">Trở thành bạn đồng hành của Horizon</label>
            <label class="lbl-seller-login-2">Hãy bắt đầu khám phá những điều thú vị</label>
        </div>

        <form name="form-seller-login" method="post" action="">
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 form-body-login"> 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-label-login-form">
                    <label class="lbl-seller-login-3">ĐĂNG NHẬP</label>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-input-login-form">
                    <input class="input-seller-type-text" name="input-user-name" type="text" placeholder="Tên đăng nhập...">
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-input-login-form">
                    <input class="input-seller-type-text" name="input-pass-word" type="password" placeholder="Mật khẩu...">
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 label-forget-pass">
                    <label>Quên mật khẩu?</label>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-input-login-form">
                    <input name="input-submit" class="input-submit" type="submit" value="ĐĂNG NHẬP">
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-hr">              
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 label-forget-pass">
                    <label style="color:rgb(119, 120, 121);">Chưa có tài khoản trước đó?</label>
                </div>
                <a href="dangki.php"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 div-input-regis-form">
                ĐĂNG KÍ NGAY
                </div></a>
        </div>
        </form>
    </div>
</body>
</html>

