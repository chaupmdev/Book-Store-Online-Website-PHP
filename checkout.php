<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

class SachDonHang{
   public $_maSach;
   public $_soLuong;

   public $_tongTien;

   function __construct($ma, $sl, $tt)
		{
			$this->_maSach = $ma;
			$this->_soLuong = $sl;
         $this->_tongTien = $tt;
		}
}
$mangSachMua = array();

if(!isset($user_id)){
   header('location:dangnhap.php');
}

if(isset($_POST['back-cart'])){
   header('location:cart.php');
}
$tongtien=0;
$select_cart = mysqli_query($conn, "SELECT * FROM `chitietgiohang` WHERE ID='$user_id'") or die('query failed');
            if(mysqli_num_rows($select_cart) > 0){
               while($fetch_ctgh = mysqli_fetch_assoc($select_cart)){
                  $ma_sach = $fetch_ctgh['MaSach'];
                  $select_s = mysqli_query($conn, "SELECT * FROM `sach` WHERE MaSach='$ma_sach'") or die('query failed');
                  $products = mysqli_fetch_assoc($select_s);
                  $tongtien+=$fetch_ctgh['SoLuong']*$products['GiaBan'];
               }
            }
$tiengiamvoucher=0;
$ship=0;
$_mavc = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horizon | Thanh toán</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/styleCheckout.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>Thanh toán</h3>
    </div>
    <!-- ---- -->

    <div class="main">
        <div class="cac-sp">
         <?php 
            $select_all = mysqli_query($conn, "SELECT * FROM `chitietgiohang` WHERE ID='$user_id'") or die('query failed');
            if(mysqli_num_rows($select_all) > 0){
               while($fetch_gh = mysqli_fetch_assoc($select_all)){
                  $_ma=$fetch_gh['MaSach'];
                  $select_sachs = mysqli_query($conn, "SELECT * FROM `sach` WHERE MaSach='$_ma'") or die('query failed');
                  $products_sach = mysqli_fetch_assoc($select_sachs);
                  array_push($mangSachMua, new SachDonHang($_ma, $fetch_gh['SoLuong'], $fetch_gh['SoLuong']*$products_sach['GiaBan']));
                  ?>
                  <div class="sp">
                     <div style="width:30%; height: 100px; float:left;">
                        <img src="./uploaded_img/<?php echo $products_sach['HinhAnh']; ?>" style="width:100%; height:90%">
                     </div>
                     <div style="width:68%; height: 100px; float:right;">
                        <h3><?php echo $products_sach['TenSach']; ?></h3>
                        <h3>Giá bán: <?php echo $products_sach['GiaBan']; ?></h3>
                        <h3>Số lượng mua: <b style="color: red;"><?php echo $fetch_gh['SoLuong']; ?></b></h3>
                        <h2><?php echo $fetch_gh['SoLuong']*$products_sach['GiaBan']; ?></h2>
                     </div>
                  </div>
                  <?php                  
               }}
         ?>            
         </div>
         <div class="cac-ttlh">
               <?php
                  $select_ttlt = mysqli_query($conn, "SELECT * FROM `thongtinlienhe` WHERE MaTaiKhoan='$user_id'") or die('query failed');
                  if(mysqli_num_rows($select_ttlt) > 0){
                     while($fetch_lh = mysqli_fetch_assoc($select_ttlt)){
                        ?>
                              <form method="post">
                                 <div class="div-ttlt">
                                       <?php
                           if($fetch_lh['MacDinh'] == 0)
                              echo '<div class="div-inL-ttlh"><input class="radio" name="radio-btn" type="radio" value="'.$fetch_lh['MaTTLH'].'"></div>';
                           else
                              echo '<div class="div-inL-ttlh"><input class="radio" name="radio-btn" type="radio" checked="true" value="'.$fetch_lh['MaTTLH'].'"></div>';
                           ?>
                                       <div class="div-inR-ttlh">
                                          <h3><b>Địa chỉ: </b></br><?php echo $fetch_lh['DiaChi']; ?></h3>
                                          <input type="hidden" name="maLH" value="<?php echo $fetch_lh['MaTTLH']; ?>">
                                          <h3><b>Địa chỉ cụ thể: </b></br><?php echo $fetch_lh['DiaChiCuThe']; ?></h3>
                                          <h3><b>Số điện thoại: </b><?php echo $fetch_lh['SDT']; ?></h3>
                                       </div>
                                 </div>
                                 <?php  
                                 
                     }
                  }
                  
               ?>
               
               <a href="TrangCaNhan.php#about">&emsp;<i class="fa fa-plus-circle"></i> Thêm liên hệ</a>
         </div>
         <div class="chitiet-dathang">
            
            <select name="chon-giao-hang">
               <option value="" selected="true">--Chọn loại giao hàng--</option>
               <?php
                  $select_ttgh = mysqli_query($conn, "SELECT * FROM `loaigiaohang`") or die('query failed');
                  if(mysqli_num_rows($select_ttgh) > 0){
                     while($fetch_hg = mysqli_fetch_assoc($select_ttgh)){
                        echo '<option value="'.$fetch_hg['MaLoaiGH'].'">'.$fetch_hg['TenLoaiGH'].'  ('.$fetch_hg['ChiPhi'].' đ)</option>';
                     }
                  }
                ?>                  
            </select>
            <select name="chon-thanh-toan" style="margin-top: 10px;">
                  <option value="" selected="true">--Chọn loại thanh toán--</option>
                  <option value="Tiền mặt">Tiền mặt</option>
                  <option value="Chuyển khoản">Chuyển khoản</option>
            </select>
            <br>
            <input type="text" name="txt-voucher" value="<?php echo $_POST['txt-voucher']??""; ?>" placeholder="Nhập mã voucher (nếu có)..." class="input-txt">
            <br><br>
            <?php
               if(!isset($_POST['step']) || $_POST['chon-giao-hang']=="" || $_POST['chon-thanh-toan']=="")
               {
            ?>        
            <input type="submit" name="step" value="Bước tiếp theo" class="input-submit-dathang">
            <input type="submit" name="back-cart" value="Trở về" class="input-submit-huy-bo">
            <?php
            }
            ?>
            
         </div>
         </form>
         <?php
            if(isset($_POST['step']))
            {
               $_SESSION['ma_ttlh']  = $_POST['radio-btn'];
               
               if($_POST['chon-giao-hang']!=""&&$_POST['chon-thanh-toan']!="")
               {                  
                  $maLGH = $_POST['chon-giao-hang'];
                  $_SESSION['ma_lgh']  = $maLGH;
                  $_SESSION['loai_thanh_toan']  = $_POST['chon-thanh-toan'];
                  $selectall_lgh=mysqli_query($conn,"SELECT * from `loaigiaohang` where MaLoaiGH='$maLGH'") or die('query failed');
                  $selected_products = mysqli_fetch_assoc($selectall_lgh);
                  $ship = (int)$selected_products['ChiPhi'];
                  $_SESSION['phi_ship'] = $ship;
                   if($_POST['txt-voucher']!="")
                   {
                      $_str=$_POST['txt-voucher'];
                      $select_voucher = mysqli_query($conn, "SELECT * FROM `voucher` WHERE MaVoucher='$_str'") or die('query failed');
                      if(mysqli_num_rows($select_voucher) > 0){
                         //Có tồn tại voucher->kt ngày bd và kt
                         $now = date("Y-m-d");
                         $fetch_vc = mysqli_fetch_assoc($select_voucher);
                         if(strtotime($now) > strtotime($fetch_vc['NgayBD']) && strtotime($now) < strtotime($fetch_vc['NgayKT']))
                         {
                            if($tongtien > (int)$fetch_vc['DieuKien'])
                            {
                               //Tất cả đều hợp lệ
                               $_mavc = $fetch_vc['MaVoucher'];
                               $tiengiamvoucher = $fetch_vc['TienGiam'];
                            }
                            else{
                              ?>
                              <script>handleCreateToast("error","Đơn hàng chưa đạt giá trị tối thiểu để sử dụng voucher!");</script>
                              <?php
                            }
                         }
                         else{
                           ?>
                           <script>handleCreateToast("error","Voucher không trong thời gian khuyến mãi!");</script>
                           <?php
                         }
                      }
                      else{
                        ?>
                        <script>handleCreateToast("error","Voucher không tồn tại!");</script>
                        <?php
                      }
                   }
                  ?>
                  <form method="post" class="kqCheckOut">
                   <br><input type="text" name="ghi-chu-ship" placeholder="Ghi chú giao hàng..." class="input-txt" style="margin-bottom: 15px;">
                   <h1>Tổng tiền:&ensp;<span class="cost"><?php echo $tongtien; ?></span></h1>
                   <h1>Phí giao hàng:&ensp;<span class="cost"><?php echo $ship; ?></span></h1>
                   <h1>Giảm giá voucher:&ensp;<span class="cost"><?php echo $tiengiamvoucher; ?></span></h1>
                   <h1>Tổng thanh toán:&ensp;<span class="cost"><?php echo $tongtien-$tiengiamvoucher+$ship; ?></span></h1>
                   <input type="hidden" name="tienGG" value="<?php echo $tiengiamvoucher; ?>">
                   <input type="hidden" name="maGG" value="<?php echo $_mavc; ?>">
                  <input type="submit" name="check-out" value="Hoàn tất đặt hàng" class="input-submit-dathang">
                   <input type="submit" name="tro-ve" value="Trước đó" class="input-submit-huy-bo">
                   </form>
                   <?php
               }
               else
               {
                  ?>
                  <script>handleCreateToast("error","Chưa điền đủ thông tin!");</script>
                  <?php
               }
            }
         ?>
         <div class="xac-nhan-lai">
         </div>
    </div>

    <!-- ---- -->
    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>

<?php
   if(isset($_POST['check-out']))
   {
      //Check đáp ứng
      $checkSLTon = true;
      foreach($mangSachMua as $node)
      {
         $_masach_ctdh = $node->_maSach;      
         $select_all_sach = mysqli_query($conn, "SELECT * FROM `sach` WHERE MaSach='$_masach_ctdh'") or die('query failed');
         $sach_fetch = mysqli_fetch_assoc($select_all_sach);
         if($sach_fetch['SoLuongTon'] < $node->_soLuong)
            $checkSLTon = false;
      }

      if($checkSLTon)
      {
         //Tạo đơn hàng
         $_madhhrand= rand(100000000000,999999999999);
         $_mattlh =$_SESSION['ma_ttlh']??"x";
         $_today = date('y-m-d');
         $maLGH=$_SESSION['ma_lgh'];
         $_loaithanhtoan = $_SESSION['loai_thanh_toan'];
         $_trangthai = "Chờ xác nhận";
         $tienGG = $_POST['tienGG'];
         $_tongtt = $tongtien-$tienGG+$_SESSION['phi_ship'];
         $_ghichu= $_POST['ghi-chu-ship'];
         $_mavc= $_POST['maGG'];
         mysqli_query($conn, "INSERT INTO `donhang` VALUES('$_madhhrand', '$_mattlh','$_today','$_mavc','$maLGH','$_loaithanhtoan','$_trangthai','$_tongtt','$_ghichu')") or die('query failed');
         
         //Trừ tồn kho
         foreach($mangSachMua as $node)
         {
            $select_all_sach = mysqli_query($conn, "SELECT * FROM `sach` WHERE MaSach='$node->_maSach'") or die('query failed');
            $sach_fetch = mysqli_fetch_assoc($select_all_sach);   
            $_sl_con_lai = $sach_fetch['SoLuongTon'] - $node->_soLuong;
            mysqli_query($conn, "UPDATE `sach` SET SoLuongTon = $_sl_con_lai WHERE MaSach = '$node->_maSach'") or die('query failed');
         }

         //Tạo chi tiết đơn hàng
         foreach($mangSachMua as $node)
         {
            mysqli_query($conn, "INSERT INTO `chitietdonhang` VALUES('$_madhhrand', '$node->_maSach',$node->_soLuong, $node->_tongTien)") or die('query failed');
         }  

         //Xóa giỏ hàng
         mysqli_query($conn, "DELETE FROM `chitietgiohang` WHERE ID = '$user_id'") or die('query failed');

         echo '<script>window.alert("Đã đặt hàng thành công");location.href = "/cart.php";</script>';
      }      
      else{
         echo '<label style="margin-left: 15px;">Sách trong kho không đủ cung cấp!!!</label></br></br>';
      }
   }
?>