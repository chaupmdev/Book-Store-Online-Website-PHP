<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Horizon | Admin Panel</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/admin_thongke.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- admin dashboard section starts  -->

<section class="dashboard">

   <h1 class="title">Bảng điều khiển</h1>

   <div class="box-container">
   <main class="main-container">

        <div class="main-cards">

          <div class="card">
            <div class="card-inner">
              <h3>SẢN PHẨM</h3>
              <span class="material-icons-outlined">inventory_2</span>
            </div>
            <h1><?php echo getTong("sach"); ?></h1>
          </div>

          <div class="card">
            <div class="card-inner">
              <h3>ĐƠN HÀNG</h3>
              <span class="material-icons-outlined">category</span>
            </div>
            <h1><?php echo getTong("donhang"); ?></h1>
          </div>

          <div class="card">
            <div class="card-inner">
              <h3>TÀI KHOẢN</h3>
              <span class="material-icons-outlined">groups</span>
            </div>
            <h1><?php echo getTong("taikhoan"); ?></h1>
          </div>

          <div class="card">
            <div class="card-inner">
              <h3>TIN NHẮN</h3>
              <span class="material-icons-outlined">notification_important</span>
            </div>
            <h1><?php echo getTong("phanhoithacmac"); ?></h1>
          </div>

        </div>
        
        <div class="main-cards" style="margin-top: 20px;">

          <div class="card" style="background-color: #00606e;">
            <div class="card-inner">
              <h3>TỒN KHO</h3>
              <span class="material-symbols-outlined">warehouse</span>
            </div>
            <h1><?php echo getTongTonKho(); ?></h1>
          </div>

          <div class="card" style="background-color: #7d005c;">
            <div class="card-inner">
              <h3>ĐÃ BÁN</h3>
              <span class="material-symbols-outlined">point_of_sale</span>
            </div>
            <h1><?php echo getTongDaBan(); ?></h1>
          </div>

          <div class="card" style="background-color:#970035;">
            <div class="card-inner">
              <h3>ĐÁNH GIÁ</h3>
              <span class="material-symbols-outlined">star_half</span>
            </div>
            <h1><?php echo getDanhGia(); ?>/5</h1>
          </div>

          <div class="card" style="background-color: #929700;">
            <div class="card-inner">
              <h3>DOANH THU</h3>
              <span class="material-symbols-outlined">payments</span>
            </div>
            <h1><?php echo getDoanhThu(); ?></h1>
          </div>

        </div>
        
        <div class="charts">

          <div class="charts-card">
            <h2 class="chart-title">Top 5 bán chạy nhất</h2>
            <div id="bar-chart"></div>
          </div>

          <div class="charts-card">
            <h2 class="chart-title">Các đơn hàng theo tháng</h2>
            <div id="area-chart"></div>
          </div>
         <?php
            $arrTop5 = getTop5();
         ?>
          <input type="hidden" value="<?php echo getTenSach($arrTop5[0]->masach); ?>" id="name1"/>
          <input type="hidden" value="<?php echo getTenSach($arrTop5[1]->masach); ?>" id="name2"/>
          <input type="hidden" value="<?php echo getTenSach($arrTop5[2]->masach); ?>" id="name3"/>
          <input type="hidden" value="<?php echo getTenSach($arrTop5[3]->masach); ?>" id="name4"/>
          <input type="hidden" value="<?php echo getTenSach($arrTop5[4]->masach); ?>" id="name5"/>

          <input type="hidden" value="<?php echo $arrTop5[0]->soluong; ?>" id="sl1"/>
          <input type="hidden" value="<?php echo $arrTop5[1]->soluong; ?>" id="sl2"/>
          <input type="hidden" value="<?php echo $arrTop5[2]->soluong; ?>" id="sl3"/>
          <input type="hidden" value="<?php echo $arrTop5[3]->soluong; ?>" id="sl4"/>
          <input type="hidden" value="<?php echo $arrTop5[4]->soluong; ?>" id="sl5"/>
          
          <input type="hidden" value="<?php echo getSoLuongDonTrongThang(1, true); ?>" id="tc1"/>
          <input type="hidden" value="<?php echo getSoLuongDonTrongThang(2, true); ?>" id="tc2"/>
          <input type="hidden" value="<?php echo getSoLuongDonTrongThang(3, true); ?>" id="tc3"/>
          <input type="hidden" value="<?php echo getSoLuongDonTrongThang(4, true); ?>" id="tc4"/>
          <input type="hidden" value="<?php echo getSoLuongDonTrongThang(5, true); ?>" id="tc5"/>
          <input type="hidden" value="<?php echo getSoLuongDonTrongThang(6, true); ?>" id="tc6"/>
          <input type="hidden" value="<?php echo getSoLuongDonTrongThang(7, true); ?>" id="tc7"/>

          <input type="hidden" value="<?php echo getSoLuongDonTrongThang(1, false); ?>" id="tb1"/>
          <input type="hidden" value="<?php echo getSoLuongDonTrongThang(2, false); ?>" id="tb2"/>
          <input type="hidden" value="<?php echo getSoLuongDonTrongThang(3, false); ?>" id="tb3"/>
          <input type="hidden" value="<?php echo getSoLuongDonTrongThang(4, false); ?>" id="tb4"/>
          <input type="hidden" value="<?php echo getSoLuongDonTrongThang(5, false); ?>" id="tb5"/>
          <input type="hidden" value="<?php echo getSoLuongDonTrongThang(6, false); ?>" id="tb6"/>
          <input type="hidden" value="<?php echo getSoLuongDonTrongThang(7, false); ?>" id="tb7"/>
        </div>
      </main>
   </div>

</section>
<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="js/admin_thongke.js"></script>
</body>
</html>

<?php
   function getTong($table)
   {
      $conn = mysqli_connect('localhost','root','','phphorizon', 3301) or die('connection failed');
      $select_all = mysqli_query($conn, "SELECT * from `$table`");
      $cou=0;
      while($fet = mysqli_fetch_assoc($select_all))
      {
         $cou+=1;
      }
      return $cou;
   }

   function getTongTonKho()
   {
      $conn = mysqli_connect('localhost','root','','phphorizon', 3301) or die('connection failed');
      $select_all = mysqli_query($conn, "SELECT * from `sach`");
      $cou=0;
      while($fet = mysqli_fetch_assoc($select_all))
      {
         $cou+=$fet['SoLuongTon'];
      }
      return $cou;
   }

   function getTongDaBan()
   {
      $conn = mysqli_connect('localhost','root','','phphorizon', 3301) or die('connection failed');
      $select_all = mysqli_query($conn, "SELECT * from `chitietdonhang`");
      $cou=0;
      while($fet = mysqli_fetch_assoc($select_all))
      {
         $cou+=$fet['SoLuong'];
      }
      return $cou;
   }

   function getDanhGia()
   {
      $conn = mysqli_connect('localhost','root','','phphorizon', 3301) or die('connection failed');
      $select_all = mysqli_query($conn, "SELECT * from `danhgia`");
      $cou=0;
      $dem=0;
      while($fet = mysqli_fetch_assoc($select_all))
      {
         $cou+=$fet['MucDanhGia'];
         $dem+=1;
      }
      return $cou/$dem;
   }

   function getDoanhThu()
   {
      $conn = mysqli_connect('localhost','root','','phphorizon', 3301) or die('connection failed');
      $select_all = mysqli_query($conn, "SELECT * from `donhang` where TrangThai='Đã giao'");
      $cou=0;
      while($fetall = mysqli_fetch_assoc($select_all))
      {
         $id = $fetall['MaDonHang'];
         $select = mysqli_query($conn, "SELECT * from `chitietdonhang` where MaDonHang='$id'");
         while($fet = mysqli_fetch_assoc($select))
         {
            $cou+=$fet['TongTien'];
         }         
      }
      return $cou;
   }
   class CTDH{
      var $masach;
      var $soluong;
  
      function CTDH($ma, $sl)
      {
          $this->masach = $ma;
          $this->soluong = $sl;
          return $this;
      }
  }

   function getTop5()
   {
      $conn = mysqli_connect('localhost','root','','phphorizon', 3301) or die('connection failed');
      $select_all = mysqli_query($conn, "SELECT MaSach FROM `chitietdonhang` GROUP BY MaSach");
      
      $array = array();

      while($fetall = mysqli_fetch_assoc($select_all))
      {
         $id = $fetall['MaSach'];
         $queryall = mysqli_query($conn, "SELECT * FROM `chitietdonhang` where MaSach='$id'");
         $cou = 0;
         while($fetquery = mysqli_fetch_assoc($queryall))
         {
            $cou+=$fetquery['SoLuong'];
         }
         $obb = new CTDH();
         $obb->masach = $id;
         $obb->soluong = $cou;

         $array[] = $obb;
      }
      //Có một array hoàn chỉnh
      $price = array_column($array, 'soluong');

      array_multisort($price, SORT_DESC, $array);
      return $array;
   }

   function getTenSach($ma)
   {
      $conn = mysqli_connect('localhost','root','','phphorizon', 3301) or die('connection failed');
      $select_all = mysqli_query($conn, "SELECT * FROM `sach` WHERE MaSach='$ma'");
      
      $fetall = mysqli_fetch_assoc($select_all);
      
      return $fetall['TenSach'];
   }

   function getSoLuongDonTrongThang($thang, $trangthai)
   {
      $year = date("Y");
      $conn = mysqli_connect('localhost','root','','phphorizon', 3301) or die('connection failed');
      $tt = ($trangthai)?"Đã giao":"Đã hủy";
      $select_all = mysqli_query($conn, "SELECT * FROM `donhang` WHERE NgayMua >= '$year-$thang-01' AND NgayMua <= '$year-$thang-30' AND TrangThai='$tt'");
      $cou=0;
      while($fetall = mysqli_fetch_assoc($select_all))
      {
         $cou+=1;
      }
      
      return $cou;
   }
 
?>