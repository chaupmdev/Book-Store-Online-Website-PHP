<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id']??"";
if($user_id=="")
{
   header('location:dangnhap.php');
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Horizon | Giỏ hàng</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php';
if(isset($_POST['update_cart'])){
   $caert_masach=$_POST['product_masach'];
   $cart_quantity = $_POST['cart_quantity'];
   if(checkSLTonKho($caert_masach, $cart_quantity))
   {
      mysqli_query($conn, "UPDATE `chitietgiohang` SET SoLuong = '$cart_quantity' WHERE ID = '$user_id' and MaSach='$caert_masach'") or die('query failed');
      ?>
            <script>handleCreateToast("success","Cập nhật giỏ hàng thành công!");</script>
            <?php
   }
   else{
      ?>
            <script>handleCreateToast("error","Số lượng tồn kho không đủ đáp ứng!");</script>
            <?php
   }
}

if(isset($_GET['id-delete'])){
   $caert_masach=$_GET['id-delete'];
   mysqli_query($conn, "DELETE FROM `chitietgiohang` WHERE ID = '$user_id' and MaSach='$caert_masach'") or die('query failed');
   ?>
            <script>handleCreateToast("success","Đã xóa sản phẩm khỏi giỏ hàng!");</script>
            <?php
}

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `chitietgiohang` WHERE ID = '$user_id'") or die('query failed');
   ?>
            <script>handleCreateToast("success","Đã xóa tất cả sản phẩm trong giỏ!");</script>
            <?php
}
?>

<div class="heading">
   <h3>Giỏ hàng</h3>
</div>

<div  class="shopping-cart">

   <h1 class="title">Sản phẩm trong giỏ</h1>

   <div class="box-container">
      <?php
         $grand_total = 0;
         $select_cart = mysqli_query($conn, "SELECT * FROM `chitietgiohang` WHERE ID = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){   
      ?>
      <div class="box">
      <form action="" method="post">
         
         
         <?php 
         $lik=$fetch_cart['MaSach'];
            $select_img = mysqli_query($conn, "SELECT * FROM `sach` WHERE MaSach = '$lik'") or die('query failed');
            $img_sp=mysqli_fetch_assoc($select_img);
         ?>
         
         <div class="image" style="background-image: url('uploaded_img/<?php echo $img_sp['HinhAnh']; ?>');">
                        <ul class="hide">
                            <li><a href="cart.php?id-delete=<?php echo $img_sp['MaSach']; ?>"><i class="fa fa-trash"></i></a></li>
                        </ul>
         </div>
         <a href="chi_tiet_sach.php?id=<?php echo $img_sp['MaSach']; ?>"><div class="name"><?php echo $img_sp['TenSach']; ?></div>
                <div class="tacgia">&copy;<?php echo $img_sp['TacGia']; ?></div>
                <div class="gia"><?php echo $img_sp['GiaBan']; ?> đ</div>
                <div class="daban">Đã bán <?php echo getDaBan($img_sp['MaSach']); ?></div></a></br>
                <div class="gia"></div>
         <input type="hidden" name="product_masach" value="<?php echo $fetch_cart['MaSach']; ?>">
         <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['SoLuong']; ?>">
         <input type="submit" name="update_cart" value="Cập nhật" class="option-btn">
         </form>
         <div class="sub-total"> Thành tiền : <span><?php echo $sub_total = ($fetch_cart['SoLuong'] * $img_sp['GiaBan']); ?> đ</span> </div>
      </div>
      <?php
      $grand_total += $sub_total;
         }
      }else{
         echo '<p class="empty">Giỏ hàng trống!</p>';
      }
      ?>
   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('Xác nhận xóa tất cả?');">Xóa tất cả</a>
   </div>

   <div class="cart-total">
      <p>Tổng tiền giỏ hàng : <span><?php echo $grand_total; ?> đ</span></p>
      <div class="flex">
         <a href="shop.php" class="option-btn">Tiếp tục mua sắm</a>
         <a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">Thanh toán</a>
      </div>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
<?php
function getDaBan($masach)
    {
        $dem=0;
        $conn = mysqli_connect('localhost','root','','phphorizon', 3301) or die('connection failed');
        $select_products = mysqli_query($conn, "SELECT * FROM `chitietdonhang` WHERE MaSach='$masach'") or die('query failed');
        while($fetch_products = mysqli_fetch_assoc($select_products)){ $dem+=$fetch_products['SoLuong'];}
        return $dem;
    }

    ?>

<?php
   function checkSLTonKho($id, $sl)
   {
      $conn = mysqli_connect('localhost','root','','phphorizon', 3301) or die('connection failed');
      $select_all = mysqli_query($conn, "SELECT * from `sach` WHERE MaSach='$id'");
      $fetch = mysqli_fetch_assoc($select_all);
      return ($sl<=$fetch['SoLuongTon'])?true:false;
   }
?>