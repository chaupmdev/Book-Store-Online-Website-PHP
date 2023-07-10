<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id']??"";




if(isset($_POST['xem_chi_tiet']))
      {
         $_SESSION['ss-id-sach'] = $_POST['product_id'];;
         header('location:chi_tiet_sach.php');
      }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horizon | Trang chủ</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'header.php';
    
    if(isset($_GET['id-add-to-cart'])){

        if($user_id=="")
           header('location: dangnhap.php');
        else{
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
     }

    ?>

    <section class="home">

        <div class="content">
            <h3>Mở sách, mở thành công</h3>
            <p>Cảm ơn rất nhiều, những người bạn mới, những tri thức mới, chúng tôi mang đến cho bạn sự lựa chọn tốt
                nhất!</p>
            <a href="about.php" class="white-btn">Về chúng tôi</a>
        </div>

    </section>

    <section class="products">

        <h1 class="title">Tất cả sản phẩm</h1>

        <div class="box-container">

            <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `Sach` LIMIT 8") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
            ?>
            <form action="" method="post" class="box">
                <div class="image" style="background-image: url('uploaded_img/<?php echo $fetch_products['HinhAnh']; ?>');">
                        <ul class="hide">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="home.php?id-add-to-cart=<?php echo $fetch_products['MaSach']; ?>"><i class="fa fa-shopping-cart"></i></a></li>
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
                <!-- <input type="submit" value="Thêm vào giỏ" name="add_to_cart" class="btn">
                <input type="submit" value="Xem chi tiết" name="xem_chi_tiet" class="btn"
                    style="background-color: white; color: purple; border: 1px solid purple"> -->
            </form>
            <?php
      
         }
      }
      else{
         echo '<p class="empty">Không có sản phẩm nào!</p>';
      }
      ?>
        </div>

        <div class="load-more" style="margin-top: 2rem; text-align:center">
            <a href="shop.php?page=1" class="option-btn">Xem thêm</a>
        </div>

    </section>

    <section class="about">

        <div class="flex">

            <div class="image">
                <img src="images/about-img.jpg" alt="">
            </div>

            <div class="content">
                <h3>về chúng tôi</h3>
                <p>Cảm ơn rất nhiều, những người bạn mới, những tri thức mới, chúng tôi mang đến cho bạn sự lựa chọn
                    tốt nhất!</p>
                <a href="about.php" class="btn">Xem thêm</a>
            </div>

        </div>

    </section>

    <section class="home-contact">

        <div class="content">
            <h3>Gửi chúng tôi câu hỏi?</h3>
            <p>Sách của chúng tôi hiểu bạn hơn sự hiểu biết của bạn về chính bạn. Một câu nói nổi tiếng của một học
                thuyết gia: "Người đọc sách chưa chắc thành công, nhưng người thành công chắc chắn đọc sách mỗi ngãy"
            </p>
            <a href="contact.php" class="white-btn">Gửi câu hỏi</a>
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