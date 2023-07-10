<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id']??"";



$countAll =0;
$select_countAll = mysqli_query($conn, "SELECT * FROM `sach`");
while($fwr = mysqli_fetch_assoc($select_countAll)){$countAll+=1;}

if(isset($_POST['xem_chi_tiet']))
      {
         $_SESSION['ss-id-sach'] = $_POST['product_id'];;
         header('location:chi_tiet_sach.php');
      }

      
function isExist($array, $uni)
{
   foreach($array as $_a)
   {
      if($_a == $uni)
         return true;
   }
   return false;
}
      
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horizon | Sản phẩm</title>

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
        <h3>Sản phẩm</h3>
    </div>

    <form action="" method="post">
        <div class="loc-sp">
            <div class="div-loc-theo-tac-gia">
                <select name="cbb-tac-gia" value="Lọc theo tác giả">
                    <option value="Lọc theo tác giả">Lọc theo tác giả</option>
                    <?php
               $arrTacGia = array();
               $select_tacgia = mysqli_query($conn, "SELECT * FROM `sach`") or die('query failed');
               if(mysqli_num_rows($select_tacgia) > 0){
                  while($fetch_tacgia = mysqli_fetch_assoc($select_tacgia))
                  {
                     if(!isExist($arrTacGia, $fetch_tacgia['TacGia']))
                     {
                        echo '<option value="'.$fetch_tacgia['TacGia'].'">'.$fetch_tacgia['TacGia'].'</option>';
                        array_push($arrTacGia, $fetch_tacgia['TacGia']);
                     }
                     
                  }
               }
            ?>
                </select>
            </div>
            <div class="div-loc-theo-the-loai">
                <select name="cbb-the-loai">
                    <option value="Lọc theo thể loại">Lọc theo thể loại</option>
                    <?php
                     $select_theloai = mysqli_query($conn, "SELECT * FROM `theloaisach`") or die('query failed');
                     if(mysqli_num_rows($select_theloai) > 0){
                        while($fetch_theloai = mysqli_fetch_assoc($select_theloai)){
                           echo '<option value="'.$fetch_theloai['TenTheLoai'].'">'.$fetch_theloai['TenTheLoai'].'</option>';
                        }
                     }
               ?>
                </select>
                <input type="submit" name="submit" value="Lọc sách" class="btn">
            </div>
        </div>
    </form>

    <section class="products">

        <h1 class="title">Sản phẩm mới nhất</h1>

        <div class="box-container">

            <?php  
      if(!isset($_POST['submit']))
      {
         $per_page_record = 8;
         if (isset($_GET["page"])) { $page  = $_GET["page"]; }
         else { $page=1; }
         $startfrom = ($page-1) * $per_page_record;
         $select_products = mysqli_query($conn, "SELECT * FROM `sach` LIMIT $startfrom, $per_page_record") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
         ?>
            <form action="" method="post" class="box">
               <div class="image" style="background-image: url('uploaded_img/<?php echo $fetch_products['HinhAnh']; ?>');">
                           <ul class="hide">
                              <li><a href="#"><i class="fa fa-heart"></i></a></li>
                              <li><a href="shop.php?id-add-to-cart=<?php echo $fetch_products['MaSach']; ?>"><i class="fa fa-shopping-cart"></i></a></li>
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
            echo '<p class="empty">Không có sản phẩm nào!</p>';
         }
      }
      else if($_POST['cbb-tac-gia'] != "Lọc theo tác giả" && $_POST['cbb-the-loai'] == "Lọc theo thể loại"){
         
         $per_page_record = 99;
         if (isset($_GET["page"])) { $page  = $_GET["page"]; }
         else { $page=1; }
         $startfrom = ($page-1) * $per_page_record;
         $tentg = $_POST['cbb-tac-gia'];
         $select_products_tg = mysqli_query($conn, "SELECT * FROM `sach` where TacGia='$tentg'") or die('query failed');
         if(mysqli_num_rows($select_products_tg) > 0){
            while($fetch_products_tg = mysqli_fetch_assoc($select_products_tg)){
         ?>
            <form action="shop.php?page=0" method="post" class="box">
            <div class="image" style="background-image: url('uploaded_img/<?php echo $fetch_products_tg['HinhAnh']; ?>');">
                           <ul class="hide">
                              <li><a href="#"><i class="fa fa-heart"></i></a></li>
                              <li><a href="shop.php?id-add-to-cart=<?php echo $fetch_products_tg['MaSach']; ?>"><i class="fa fa-shopping-cart"></i></a></li>
                              <li><a href="#"><i class="fa fa-comment"></i></a></li>
                           </ul>
                  </div>
                  <a href="chi_tiet_sach.php?id=<?php echo $fetch_products_tg['MaSach']; ?>"><div class="name"><?php echo $fetch_products_tg['TenSach']; ?></div>
                  <div class="tacgia">&copy;<?php echo $fetch_products_tg['TacGia']; ?></div>
                  <div class="gia"><?php echo $fetch_products_tg['GiaBan']; ?> đ</div>
                  <div class="daban">Đã bán <?php echo getDaBan($fetch_products_tg['MaSach']); ?></div></a>
                  <!-- <input type="number" min="1" name="product_quantity" value="1" class="qty"> -->
                  <input type="hidden" name="product_id" value="<?php echo $fetch_products_tg['MaSach']; ?>">
                  <input type="hidden" name="product_name" value="<?php echo $fetch_products_tg['TenSach']; ?>">
                  <input type="hidden" name="product_price" value="<?php echo $fetch_products_tg['GiaBan']; ?>">
                  <input type="hidden" name="product_image" value="<?php echo $fetch_products_tg['HinhAnh']; ?>">
            </form>
            <?php
            }
         }else{
            echo '<p class="empty">Không tìm thấy kết quả!</p>';
         }

         }
      else if($_POST['cbb-tac-gia'] == "Lọc theo tác giả" && $_POST['cbb-the-loai'] != "Lọc theo thể loại"){
         $per_page_record = 99;
         if (isset($_GET["page"])) { $page  = $_GET["page"]; }
         else { $page=1; }
         $startfrom = ($page-1) * $per_page_record;
         $tentl = $_POST['cbb-the-loai'];
         $select_maTheLoai = mysqli_query($conn, "SELECT * FROM `theloaisach` where TenTheLoai='$tentl'") or die('query failed');
         $arr_maTL = mysqli_fetch_assoc( $select_maTheLoai);
         $maTheLoai = $arr_maTL['MaTheLoai'];
         
         $select_products_tl = mysqli_query($conn, "SELECT * FROM `sach` where MaTheLoai='$maTheLoai'") or die('query failed');
         if(mysqli_num_rows($select_products_tl) > 0){
            while($fetch_products_tl = mysqli_fetch_assoc($select_products_tl)){
         ?>
            <form action="shop.php?page=0" method="post" class="box">
            <div class="image" style="background-image: url('uploaded_img/<?php echo $fetch_products_tl['HinhAnh']; ?>');">
                           <ul class="hide">
                              <li><a href="#"><i class="fa fa-heart"></i></a></li>
                              <li><a href="shop.php?id-add-to-cart=<?php echo $fetch_products_tl['MaSach']; ?>"><i class="fa fa-shopping-cart"></i></a></li>
                              <li><a href="#"><i class="fa fa-comment"></i></a></li>
                           </ul>
                  </div>
                  <a href="chi_tiet_sach.php?id=<?php echo $fetch_products_tl['MaSach']; ?>"><div class="name"><?php echo $fetch_products_tl['TenSach']; ?></div>
                  <div class="tacgia">&copy;<?php echo $fetch_products_tl['TacGia']; ?></div>
                  <div class="gia"><?php echo $fetch_products_tl['GiaBan']; ?> đ</div>
                  <div class="daban">Đã bán <?php echo getDaBan($fetch_products_tl['MaSach']); ?></div></a>
                  <!-- <input type="number" min="1" name="product_quantity" value="1" class="qty"> -->
                  <input type="hidden" name="product_id" value="<?php echo $fetch_products_tl['MaSach']; ?>">
                  <input type="hidden" name="product_name" value="<?php echo $fetch_products_tl['TenSach']; ?>">
                  <input type="hidden" name="product_price" value="<?php echo $fetch_products_tl['GiaBan']; ?>">
                  <input type="hidden" name="product_image" value="<?php echo $fetch_products_tl['HinhAnh']; ?>">
            </form>
            <?php
            }
         }
         else{
            echo '<p class="empty">Không tìm thấy kết quả!</p>';
         }
         }
      else if($_POST['cbb-tac-gia'] != "Lọc theo tác giả" && $_POST['cbb-the-loai'] != "Lọc theo thể loại")
      {$per_page_record = 99;
         if (isset($_GET["page"])) { $page  = $_GET["page"]; }
         else { $page=1; }
         $startfrom = ($page-1) * $per_page_record;
         $tentl = $_POST['cbb-the-loai'];
         $tentg = $_POST['cbb-tac-gia'];
         $select_maTheLoai = mysqli_query($conn, "SELECT * FROM `theloaisach` where TenTheLoai='$tentl'") or die('query failed');
         $arr_maTL = mysqli_fetch_assoc( $select_maTheLoai);
         $maTheLoai = $arr_maTL['MaTheLoai'];
         
         $select_products_tl = mysqli_query($conn, "SELECT * FROM `sach` where MaTheLoai='$maTheLoai' and TacGia='$tentg'") or die('query failed');
         if(mysqli_num_rows($select_products_tl) > 0){
            while($fetch_products_tl = mysqli_fetch_assoc($select_products_tl)){
         ?>
            <form action="shop.php?page=0" method="post" class="box">
            <div class="image" style="background-image: url('uploaded_img/<?php echo $fetch_products_tl['HinhAnh']; ?>');">
                           <ul class="hide">
                              <li><a href="#"><i class="fa fa-heart"></i></a></li>
                              <li><a href="shop.php?id-add-to-cart=<?php echo $fetch_products_tl['MaSach']; ?>"><i class="fa fa-shopping-cart"></i></a></li>
                              <li><a href="#"><i class="fa fa-comment"></i></a></li>
                           </ul>
                  </div>
                  <a href="chi_tiet_sach.php?id=<?php echo $fetch_products_tl['MaSach']; ?>"><div class="name"><?php echo $fetch_products_tl['TenSach']; ?></div>
                  <div class="tacgia">&copy;<?php echo $fetch_products_tl['TacGia']; ?></div>
                  <div class="gia"><?php echo $fetch_products_tl['GiaBan']; ?> đ</div>
                  <div class="daban">Đã bán <?php echo getDaBan($fetch_products_tl['MaSach']); ?></div></a>
                  <!-- <input type="number" min="1" name="product_quantity" value="1" class="qty"> -->
                  <input type="hidden" name="product_id" value="<?php echo $fetch_products_tl['MaSach']; ?>">
                  <input type="hidden" name="product_name" value="<?php echo $fetch_products_tl['TenSach']; ?>">
                  <input type="hidden" name="product_price" value="<?php echo $fetch_products_tl['GiaBan']; ?>">
                  <input type="hidden" name="product_image" value="<?php echo $fetch_products_tl['HinhAnh']; ?>">
            </form>
            <?php
            }
         }else{
            echo '<p class="empty">Không tìm thấy kết quả!</p>';
         }
      }
      else{
         echo '<p class="empty">Chưa chọn thông tin để lọc!</p>';
      }
      ?>
            
        </div>
        
               <center><div class="pagelink">
                        <?php         
                        if(isset($_GET['page'])&&$_GET['page']!=0)
                        {   
                        if($page>=2){

                           echo '<a href="shop.php?page='.($page-1).'">  Trước đó </a>';
                           
                           }
                           for ($i=1; $i<=($countAll/$per_page_record)+1; $i++) {
                              echo '<a href="shop.php?page='.$i.'">  '.$i.' </a>';                     
                              }
                              if($page<($countAll/8)){

                                 echo '<a href="shop.php?page='.($page+1).'">  Tiếp theo </a>';
                                 
                                 }
                              }
                        ?>
                        
                  </div></center>
              
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
        $conn = mysqli_connect('localhost','root','','phphorizon',3301) or die('connection failed');
        $select_products = mysqli_query($conn, "SELECT * FROM `chitietdonhang` WHERE MaSach='$masach'") or die('query failed');
        while($fetch_products = mysqli_fetch_assoc($select_products)){ $dem+=$fetch_products['SoLuong'];}
        return $dem;
    }
?>