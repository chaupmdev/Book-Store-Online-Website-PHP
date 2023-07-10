<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id']??"";

$ma_sach = $_GET['id']??"";

if(isset($ma_sach))
{
   $select_products = mysqli_query($conn, "SELECT * FROM `sach` where MaSach='$ma_sach'") or die('query failed');
         if(mysqli_num_rows($select_products) > 0)
         {
            $fetch_products = mysqli_fetch_assoc($select_products);

            $matl = $fetch_products['MaTheLoai'];
            $select = mysqli_query($conn, "SELECT * FROM `theloaisach` where MaTheLoai='$matl'") or die('query failed');
            if(mysqli_num_rows($select) > 0)
            {
               $fetch = mysqli_fetch_assoc($select);
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
    <title>Horizon | Chi tiết sách</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style2.css">
</head>

<body>

    <?php include 'header.php';
    if(isset($_POST['add-to-cart'])){
      if($user_id=="")
      {
         header('location:dangnhap.php');
      }
      else{
         $product_quantity = $_POST['product_quantity'];
         if(checkSLTonKho($ma_sach, $product_quantity))
         {
         $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `chitietgiohang` WHERE MaSach = '$ma_sach' AND ID = '$user_id'") or die('query failed');
   
         if(mysqli_num_rows($check_cart_numbers) > 0){
            $laySL=mysqli_query($conn, "SELECT * FROM `chitietgiohang` WHERE MaSach = '$ma_sach' AND ID = '$user_id'") or die('query failed');
            $arr_sl=mysqli_fetch_assoc($laySL);
            $sl=$arr_sl['SoLuong']+$product_quantity;
            mysqli_query($conn, "UPDATE `chitietgiohang` SET SoLuong = '$sl' WHERE ID = '$user_id' and MaSach='$ma_sach'") or die('query failed');
            ?>
            <script>handleCreateToast("success","Đã thêm sản phẩm vào Giỏ hàng!");</script>
            <?php
         }else{
            mysqli_query($conn, "INSERT INTO `chitietgiohang` VALUES('$user_id', '$ma_sach','$product_quantity')") or die('query failed');
            ?>
            <script>handleCreateToast("success","Đã thêm sản phẩm vào Giỏ hàng!");</script>
            <?php
         }
         }
         else{
            ?>
            <script>handleCreateToast("error","Số lượng mua đã lớn hơn số lượng tồn kho!");</script>
            <?php
         }
      }
   }
   if(isset($_POST['buy-now'])){
       if($user_id=="")
       {
          header('location:dangnhap.php');
       }
       else{
          $product_quantity = $_POST['product_quantity'];
          if(checkSLTonKho($ma_sach, $product_quantity))
         {
          $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `chitietgiohang` WHERE MaSach = '$ma_sach' AND ID = '$user_id'") or die('query failed');
    
          if(mysqli_num_rows($check_cart_numbers) > 0){
             $laySL=mysqli_query($conn, "SELECT * FROM `chitietgiohang` WHERE MaSach = '$ma_sach' AND ID = '$user_id'") or die('query failed');
             $arr_sl=mysqli_fetch_assoc($laySL);
             $sl=$arr_sl['SoLuong']+$product_quantity;
             mysqli_query($conn, "UPDATE `chitietgiohang` SET SoLuong = '$sl' WHERE ID = '$user_id' and MaSach='$ma_sach'") or die('query failed');
             ?>
            <script>handleCreateToast("success","Đã thêm sản phẩm vào Giỏ hàng!");</script>
            <?php
          }else{
             mysqli_query($conn, "INSERT INTO `chitietgiohang` VALUES('$user_id', '$ma_sach','$product_quantity')") or die('query failed');
             ?>
            <script>handleCreateToast("success","Đã thêm sản phẩm vào Giỏ hàng!");</script>
            <?php
          }
          header('location:checkout.php');
         }
         else{
            ?>
            <script>handleCreateToast("error","Số lượng mua đã lớn hơn số lượng tồn kho!");</script>
            <?php
         }
       }
    }
   
    ?>

    <div class="container">
      
        <div class="chitiet-div-anh-sp">
            <img class="chitiet-img-anh-sp" src="uploaded_img/<?php echo $fetch_products['HinhAnh'];?>">
        </div>
        <form method="post">
            <div class="chitiet-div-thong-tin-sp">

                <h1 class="chitiet-h1-ten"><?php echo $fetch_products['TenSach'] ?></h1>
                <h3 class="chitiet-tacgia-theloai">Tác giả: <?php echo $fetch_products['TacGia'] ?></h3>
                <h3 class="chitiet-tacgia-theloai">Thể loại: <?php echo $fetch['TenTheLoai'] ?></h3>
                <h1 class="chitiet-giaban-sach"><?php echo $fetch_products['GiaBan'] ?> đ</h1>
                <input type="number" min="1" name="product_quantity" value="1" class="qty">
                <h3 class="chitiet-tacgia-theloai">(Số lượng còn lại <span
                        style="color:black;"><?php echo $fetch_products['SoLuongTon'] ?></span>)</h3>
                <input type="submit" value="Mua ngay" name="buy-now" class="chitiet-btn-mua-ngay">
                <input type="submit" value="Thêm vào giỏ" name="add-to-cart" class="chitiet-btn-them-vao-gio">
                <h3 class="chitiet-tacgia-theloai">Bản quyền sách thuộc @<?php echo $fetch_products['MaNXB'] ?></h3>

            </div>
        </form>
        <div class="chitiet-noi-dung-sach">
            <h1 class="chitiet-h1-ten" style="font-size:25px; color:black">Tổng quan nội dung:</h1>
            <?php
               $arrNoiDung = explode('#',$fetch_products['NoiDungTomTat']);
            ?>
            <p class="chitiet-tacgia-theloai" style="word-wrap: break-word;">
                <?php echo $arrNoiDung[0]; ?></p></br></br>
            <p class="chitiet-tacgia-theloai" style="word-wrap: break-word;">
                <?php echo $arrNoiDung[1]; ?></p></br></br>
            <p class="chitiet-tacgia-theloai" style="word-wrap: break-word;">
                <?php echo $arrNoiDung[2]; ?></p>
        </div>

        <section class="products">
            <div class="chitiet-danh-gia-sach">
                <h1 class="chitiet-h1-ten" style="font-size:25px;color:black">Đánh giá của người đọc:</h1>

                <?php

         $select_danhgia = mysqli_query($conn, "SELECT * FROM `danhgia` where MaSach='$ma_sach'") or die('query failed');
         if(mysqli_num_rows($select_danhgia) > 0)
         {
            $toida =0;
            $type =$_POST['btn_type']??"Xem thêm bình luận";
            if($type == "Đóng bớt bình luận")
            {
               $toida+=4;
            }
            else
            {
               $toida=2;
            }
            while($fetch_dg = mysqli_fetch_assoc($select_danhgia)){
               if($toida>0){
               $toida-=1;
               $sao = $fetch_dg['MucDanhGia'];
               $idNguoiBL = $fetch_dg['ID'];
               $select_users = mysqli_query($conn, "SELECT * FROM `taikhoan` where MaTaiKhoan='$idNguoiBL'") or die('query failed');
               $fetch_user = mysqli_fetch_assoc($select_users);
               ?>

                <p class="chitiet-tacgia-theloai" style="word-wrap: break-word;color:purple;margin-top:5px">
                    <?php echo $fetch_user['HoTen']?></p>

                <?php
               while($sao > 0){
                  echo '<img style="margin-right:5px" src="images/stars.jpg">';
                  $sao-=1;
               }
               echo '</br><p style="word-wrap: break-word;margin-top:10px;font-size:18px;color:#434242;">'.$fetch_dg['NgayDanhGia'].'</p><br>';
               echo '<p class="chitiet-tacgia-theloai" style="word-wrap: break-word;margin-top:0px">'.$fetch_dg['NoiDung'].'</p><br>';
               
               ?>

                <?php
            } }   
            echo '<form action="" method="post"><input class="btn" name="xem-them-bl" type="submit" value="'.$type.'">';
            if($type == "Đóng bớt bình luận") {     
               $type = "Xem thêm bình luận";}
               else{$type = "Đóng bớt bình luận";}
            echo '<input type="hidden" name="btn_type" value="'.$type.'"></form>';
            
         }
         else
         {
            echo '<p class="empty">Chưa có bình luận nào!</p>';
         }
      ?>

            </div>
        </section>

    </div>



    <section class="footer">

        <div class="box-container" style="width:100%;">

            <div class="box">
                <h3>Thông tin cửa hàng</h3>
                <a href="home.php">Trang chủ</a>
                <a href="about.php">Chúng tôi</a>
                <a href="shop.php">Sản phẩm</a>
                <a href="contact.php">Phản hồi</a>
            </div>

            <div class="box">
                <h3>Thông tin người dùng</h3>
                <a href="login.php">Đăng nhập</a>
                <a href="register.php">Tạo tài khoản</a>
                <a href="cart.php">Giỏ hàng</a>
                <a href="orders.php">Đặt hàng</a>
            </div>

            <div class="box">
                <h3>Thông tin liên hệ</h3>
                <p> <i class="fas fa-phone"></i> (+84).123.456.789 </p>
                <p> <i class="fas fa-phone"></i> (+84).987.654.321 </p>
                <p> <i class="fas fa-envelope"></i> nhom3php@gmail.com </p>
                <p> <i class="fas fa-map-marker-alt"></i> Mã bưu cục: 0800 </p>
            </div>

            <div class="box">
                <h3>Mạng xã hội</h3>
                <a href="#"> <i class="fab fa-facebook-f"></i> Facebook </a>
                <a href="#"> <i class="fab fa-twitter"></i> Twitter </a>
                <a href="#"> <i class="fab fa-instagram"></i> Instagram </a>
                <a href="#"> <i class="fab fa-linkedin"></i> Youtube </a>
            </div>

        </div>

        <p class="credit"> &copy; Bản quyền @ <?php echo date('Y'); ?> by <span>3rd Group PHP Cô Yến</span> </p>

    </section>
    <script src="js/script.js"></script>
</body>

</html>

<?php
   function checkSLTonKho($id, $sl)
   {
      $conn = mysqli_connect('localhost','root','','phphorizon', 3301) or die('connection failed');
      $select_all = mysqli_query($conn, "SELECT * from `sach` WHERE MaSach='$id'");
      $fetch = mysqli_fetch_assoc($select_all);
      return ($sl<=$fetch['SoLuongTon'])?true:false;
   }
?>