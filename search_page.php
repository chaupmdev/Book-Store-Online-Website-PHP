<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id']??"";



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Horizon | Tìm kiếm sản phẩm</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; 
if(isset($_GET['id-add-to-cart'])){
   $id_sach=$_GET['id-add-to-cart'];
   $product_quantity = 1;

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `chitietgiohang` WHERE MaSach = '$id_sach' AND ID = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $laySL=mysqli_query($conn, "SELECT * FROM `chitietgiohang` WHERE MaSach = '$id_sach' AND ID = '$user_id'") or die('query failed');
      $arr_sl=mysqli_fetch_assoc($laySL);
      $sl=$arr_sl['SoLuong']+$product_quantity;
      mysqli_query($conn, "UPDATE `chitietgiohang` SET SoLuong = '$sl' WHERE ID = '$user_id' and MaSach='$id_sach'") or die('query failed');
      ?>
           <script>handleCreateToast("success","Đã thêm sản phẩm vào Giỏ hàng!");</script>
           <?php
   }else{
      mysqli_query($conn, "INSERT INTO `chitietgiohang` VALUES('$user_id', '$id_sach','$product_quantity')") or die('query failed');
      ?>
      <script>handleCreateToast("success","Đã thêm sản phẩm vào Giỏ hàng!");</script>
      <?php
   }
}
?>
<div class="heading">
   <h3>Tìm sản phẩm</h3>
</div>

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search" placeholder="Nhập tên sản phẩm..." class="box">
      <input type="submit" name="submit" value="Tìm kiếm" class="btn">
   </form>
</section>

<section class="products" style="padding-top: 0;">

   <div class="box-container">
   <?php
      if(isset($_POST['submit'])){
         $search_item = $_POST['search'];
         $select_products = mysqli_query($conn, "SELECT * FROM `sach` WHERE TenSach LIKE '%{$search_item}%'") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
         while($fetch_products = mysqli_fetch_assoc($select_products)){
   ?>
   <form action="" method="post" class="box">
   <div class="image" style="background-image: url('uploaded_img/<?php echo $fetch_products['HinhAnh']; ?>');">
                        <ul class="hide">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="search_page.php?id-add-to-cart=<?php echo $fetch_products['MaSach']; ?>"><i class="fa fa-shopping-cart"></i></a></li>
                            <li><a href="#"><i class="fa fa-comment"></i></a></li>
                        </ul>
                </div>
                <a href="chi_tiet_sach.php?id=<?php echo $fetch_products['MaSach']; ?>"><div class="name"><?php echo $fetch_products['TenSach']; ?></div>
                <div class="tacgia">&copy;<?php echo $fetch_products['TacGia']; ?></div>
                <div class="gia"><?php echo $fetch_products['GiaBan']; ?> đ</div>
                <div class="daban">Đã bán <?php echo getDaBan($fetch_products['MaSach']); ?></div></a>
                <!-- <input type="number" min="1" name="product_quantity" value="1" class="qty"> -->
                <input type="hidden" name="product_id" value="<?php echo $fetch_products['MaSach']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['TenSach']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['GiaBan']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['HinhAnh']; ?>">
         </form>
   <?php
            }
         }else{
            echo '<p class="empty">Không tìm thấy kết quả!</p>';
         }
      }else{
         echo '<p class="empty">Tìm kiếm sản phẩm nào đó!</p>';
      }
   ?>
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