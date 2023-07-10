<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];
if(!isset($user_id))
  header('location:DangNhap.php');

$select_users = mysqli_query($conn, "SELECT * FROM `taikhoan` WHERE MaTaiKhoan='$user_id'") or die('query failed');
if(mysqli_num_rows($select_users) > 0){
    while($fetch = mysqli_fetch_assoc($select_users)){
        $mail = $fetch["Email"];
    }
}

if(isset($_POST['capnhat-macdinh']))
{
    $datlammacdinh = $_POST['radio-btn'];
    mysqli_query($conn, "UPDATE `thongtinlienhe` SET MacDinh = 0 WHERE MaTaiKhoan = '$user_id'") or die('query failed');
    mysqli_query($conn, "UPDATE `thongtinlienhe` SET MacDinh = 1 WHERE MaTTLH = '$datlammacdinh'") or die('query failed');
}
if(isset($_POST['btn-huy-ttlt']))
    header('location:TrangCaNhan.php');
if(isset($_POST['btn-them-ttlt']))
{
    $mattlhrand = $mataikhoan = rand(100000000000,999999999999);
    $local1 = $_POST['dia-chi'];;
    $local2 = $_POST['dc-cu-the'];
    $numbers = $_POST['sodienthoai'];
    $isMacDinh = $_POST['radio-btn-them-ttlh']??"No";
    if(isset($_POST['radio-btn-them-ttlh']))
    {
        mysqli_query($conn, "UPDATE `thongtinlienhe` SET MacDinh = 0 WHERE MaTaiKhoan = '$user_id'") or die('query failed');
        mysqli_query($conn, "INSERT INTO `thongtinlienhe` VALUES('$mattlhrand', '$local1','$local2','$numbers',1,'$user_id' )") or die('query failed');
    }
    else{
        mysqli_query($conn, "INSERT INTO `thongtinlienhe` VALUES('$mattlhrand', '$local1','$local2','$numbers',0,'$user_id' )") or die('query failed');
    }
}


$tongChoXacNhan = 0;
$tongDangVanChuyen = 0;
$tongDangGiao = 0;
$tongDaGiao = 0;
$tongDaHuy = 0;
$tongTraHangHoanTien = 0;
$arrMaDonHang = array();

$select_ttlh = mysqli_query($conn, "SELECT * FROM `thongtinlienhe` WHERE MaTaiKhoan='$user_id'") or die('query failed');
if(mysqli_num_rows($select_ttlh) > 0){
    while($fetch_ttlh = mysqli_fetch_assoc($select_ttlh)){
        $mattlh_con = $fetch_ttlh['MaTTLH'];
        $select_ttlh_con = mysqli_query($conn, "SELECT * FROM `donhang` WHERE MaTTLH='$mattlh_con'") or die('query failed');
        if(mysqli_num_rows($select_ttlh_con) > 0){
          while($fetch_ttlh_con = mysqli_fetch_assoc($select_ttlh_con)){
              array_push($arrMaDonHang,$fetch_ttlh_con['MaDonHang']);
              if($fetch_ttlh_con['TrangThai'] == "Chờ xác nhận")
                $tongChoXacNhan+=1;
              else if($fetch_ttlh_con['TrangThai'] == "Đang xử lý")
                $tongDangVanChuyen+=1;
              else if($fetch_ttlh_con['TrangThai'] == "Đang giao")
                $tongDangGiao+=1;
              else if($fetch_ttlh_con['TrangThai'] == "Đã giao")
                $tongDaGiao+=1;
              else if($fetch_ttlh_con['TrangThai'] == "Đã hủy")
                $tongDaHuy+=1;
              else  $tongTraHangHoanTien+=1;
          }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Horizon | Trang cá nhân </title>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="css/stylePF.css" />
    
</head>

<body>

    <header>
        <div class="user">
            <img src="images/khach-hang.jpg" alt="" />
            <h3 class="name"><?php echo $_SESSION['user_name']??"" ?></h3>
        </div>

        <nav class="navbar">
            <ul>
                <li><a href="#home">Bảng điều khiển</a></li>
                <li><a href="#about">Thông tin cá nhân</a></li>
                <li><a href="#education">Đơn hàng</a></li>
                <li><a href="logout.php">Đăng xuất</a></li>
                <li><a href="home.php">Về trang chủ</a></li>
            </ul>
        </nav>
    </header>

    <div id="menu" class="fas fa-bars"></div>

    <section class="home" id="home">

        <h3>Horizon xin chào !</h3>
        <h1>Khách hàng, <span><?php echo $_SESSION['user_name']??"" ?></span></h1>
        <p>
            Đây là trang cá nhân của bạn, nơi đây có tất cả các thông tin về tài khoản, các đơn hàng, và xem được tình
            trạng đơn đặt hàng bạn sau khi đặt hàng của bạn. Gửi cho tôi thắc mắc của bạn về điều gì đó...
        </p>

        <a href="contact.php">
            <button class="btn">Gửi tin nhắn <i class="fas fa-user"></i></button>
        </a>
    </section>

    <section class="about" id="about">
        <h1 class="heading">
            <span>Thông tin cá nhân</span>
        </h1>

        <div class="row">
            <div class="info">
                <h3><span>Họ tên: </span> <?php echo $_SESSION['user_name']??"" ?></h3>
                <h3><span>Email: </span> <?php echo $mail; ?></h3>
                <h3><span>Loại: </span> Khách hàng tin cậy</h3>
                <form method="post" action="TrangCaNhan.php#about">
                    <input type="submit" name="tao-ttlh"
                        style="border-radius:20px;width:200px; height:35px; background-color: #e5e2e2;"
                        value='Tạo thông tin liên hệ'>
                </form>
            </div>
            <div class="counter">
                <div class="box">
                    <span>2+</span>
                    <h3>Năm thành viên</h3>
                </div>
                <div class="box">
                    <span>100+</span>
                    <h3>Đơn hàng</h3>
                </div>
                <div class="box">
                    <span>30+</span>
                    <h3>Đánh giá</h3>
                </div>
                <div class="box">
                    <span>120+</span>
                    <h3>Hạng tín dụng</h3>
                </div>
            </div>

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




                <input type="submit" name="capnhat-macdinh"
                    style="margin-top:30px;margin-left:30px;color:white;border-radius:5px;width:200px; height:35px; background-color: purple; padding-left:5px"
                    value='Đặt làm địa chỉ mặc định'>
            </form>

        </div>
    </section>

    <?php
        if(isset($_POST['tao-ttlh']))
        {
            ?>
    <form action="TrangCaNhan.php#about" method="post"  class="form-add-localship">
        <h1>Thông tin liên hệ</h1>
        <select class="select-location" name="province" id="province">
            <option value="">Tỉnh/Thành phố</option>
        </select>
        <select class="select-location" name="district" id="district">
            <option value="">Quận/Huyện</option>
        </select>
        <select class="select-location" name="ward" id="ward">
            <option value="">Phường/Xã</option>
        </select>
        <br>
        <input type="text" id="result" name="dia-chi" required placeholder="Số nhà và tên đường..." class="box2"><br>
        <input type="text" name="dc-cu-the" required placeholder="Địa chỉ cụ thể..." class="box2"><br>
        <input type="text" name="sodienthoai" required placeholder="Số điện thoại..." class="box2"><br><br><br>
        <label><input class="checkbox" name="radio-btn-them-ttlh" value="macdinh" type="checkbox" placeholder="ssss">&ensp;Đặt làm mặc
            định</label>
        <br><input type="submit" value="Thêm" name="btn-them-ttlt"
            style="padding-left:0px;margin-top:30px;color:white;border-radius:5px;width:100px; height:35px; background-color: purple;">
            <input type="submit" value="Hủy" name="btn-huy-ttlt"
            style="padding-left:0px;margin-top:30px;margin-left:10px;color:purple;border-radius:5px;width:100px; height:35px; background-color: whitesmoke;border: 1px solid purple;">
    </form>
    
    <?php
        }
      ?>

    <section class="education" id="education">
        <h1 class="heading">
            Tất cả
            <span>Đơn hàng</span>
        </h1>

        <div class="box-container">

            <div class="box">
                <i class="fas"></i>
                <span>Chờ xác nhận</span>
                <h3><?php echo $tongChoXacNhan; ?></h3>
                <p>
                    Chờ người bán xác nhận
                </p>
                <form method="post">
                    <button name="xct-ChoXacNhan" class="btn-xem-chi-tiet">Xem chi tiết</button>
                </form>
            </div>
            <div class="box">
                <i class="fas"></i>
                <span>Đang xử lý</span>
                <h3><?php echo $tongDangVanChuyen; ?></h3>
                <p>
                    Nhà cung cấp đang xử lý
                </p>
                <form method="post">
                    <button name="xct-DangVanChuyen" class="btn-xem-chi-tiet">Xem chi tiết</button>
                </form>
            </div>
            <div class="box">
                <i class="fas"></i>
                <span>Đang giao</span>
                <h3><?php echo $tongDangGiao; ?></h3>
                <p>
                    Đơn hàng đang giao đến bạn
                </p>
                <form method="post">
                    <button name="xct-DangGiao" class="btn-xem-chi-tiet">Xem chi tiết</button>
                </form>
            </div>
            <div class="box">
                <i class="fas"></i>
                <span>Đã giao</span>
                <h3><?php echo $tongDaGiao; ?></h3>
                <p>
                    Người mua đã nhận được hàng
                </p>
                <form method="post">
                    <button name="xct-DaGiao" class="btn-xem-chi-tiet">Xem chi tiết</button>
                </form>
            </div>
            <div class="box">
                <i class="fas"></i>
                <span>Đã hủy</span>
                <h3><?php echo $tongDaHuy; ?></h3>
                <p>
                    Đơn hàng đã bị hủy
                </p>
                <form method="post">
                    <button name="xct-DaHuy" class="btn-xem-chi-tiet">Xem chi tiết</button>
                </form>
            </div>
            <div class="box">
                <i class="fas"></i>
                <span>Bị từ chối</span>
                <h3><?php echo $tongTraHangHoanTien; ?></h3>
                <p>
                    Đơn hàng gặp trục trặc
                </p>
                <form method="post">
                    <button name="xct-TraHang" class="btn-xem-chi-tiet">Xem chi tiết</button>
                </form>
            </div>

        </div>


        <?php 
        if(isset($_POST['xct-ChoXacNhan']))
        {
          echo '<div class="container-xem-chi-tiet">';
          echo '<h1>Thông tin các đơn hàng:</h1>';
            foreach($arrMaDonHang as $dh)
            {
                $demTongDon=0;
              $select_dh = mysqli_query($conn, "SELECT * FROM `donhang` WHERE MaDonHang='$dh'") or die('query failed');
              if(mysqli_num_rows($select_dh) > 0){
                  while($fetch_dh = mysqli_fetch_assoc($select_dh)){
                    if($fetch_dh['TrangThai'] == "Chờ xác nhận")
                    {
                      $_ma = $fetch_dh['MaDonHang'];
                      $select_ctdh = mysqli_query($conn, "SELECT * FROM `chitietdonhang` WHERE MaDonHang='$_ma'") or die('query failed');
                      while($fetctdh = mysqli_fetch_assoc($select_ctdh))
                      {
                        $demTongDon+=$fetctdh['TongTien'];
                        $_slDon = $fetctdh['SoLuong'];
                        $_masach=$fetctdh['MaSach'];
                        $select_ctsach = mysqli_query($conn, "SELECT * FROM `sach` WHERE MaSach='$_masach'") or die('query failed');
                        $fetctsach = mysqli_fetch_assoc($select_ctsach);
                        $_tensach =$fetctsach['TenSach'];
                        $_anh =$fetctsach['HinhAnh'];
                        $_mattlh= $fetch_dh['MaTTLH'];
                        $select_ctttlt = mysqli_query($conn, "SELECT * FROM `thongtinlienhe` WHERE MaTTLH='$_mattlh'") or die('query failed');
                        $fetctttlh = mysqli_fetch_assoc($select_ctttlt);
                        $_dc=$fetctttlh['DiaChi'];
                        $_dcct=$fetctttlh['DiaChiCuThe'];
                        $_sdtLH=$fetctttlh['SDT'];

                        $_maship= $fetch_dh['MaLoaiGH'];
                        $select_ship = mysqli_query($conn, "SELECT * FROM `loaigiaohang` WHERE MaLoaiGH='$_maship'") or die('query failed');
                        $fetcship = mysqli_fetch_assoc($select_ship);
                        $_tenship=$fetcship['TenLoaiGH'];
                        $_tgship=$fetcship['ThoiGian'];
                        $_tienship=$fetcship['ChiPhi'];

                        $_mavoucher= $fetch_dh['MaVoucher'];
                        $select_vc = mysqli_query($conn, "SELECT * FROM `voucher` WHERE MaVoucher='$_mavoucher'") or die('query failed');
                        $fetcvoucher = mysqli_fetch_assoc($select_vc);
                        $_tienvc=$fetcvoucher['TienGiam'];
                        $dongia = $fetch_dh['ThanhTien'];
                        $_tongthanhtoan = $fetch_dh['ThanhTien']*$_slDon-$_tienvc;
                        ?>
                        <div class="another-donhang">
                            <div class="another-donhang-l">
                                <center>
                                    <div style="width: 85%; height:210px;">
                                        <img src="uploaded_img/<?php echo $_anh; ?>" width="100%" height="100%">
                                    </div>
                                </center>

                            </div>
                            <form method="post">
                            <div class="another-donhang-c1">
                                <h4>Mã đơn: <b><?php echo $fetch_dh['MaDonHang']; ?></b></h4>
                                <input type="hidden" name="madonhanghuy" value="<?php echo $fetch_dh['MaDonHang']; ?>">
                                <h4>Tên sách: <?php echo $_tensach; ?></h4>
                                <h4>Địa chỉ nhận hàng: <b><?php echo $_dc; ?></b></h4>
                                <h4>Địa chỉ cụ thể: <b><?php echo $_dcct; ?></b></h4>
                                <h4>Số điện thoại: <b><?php echo $_sdtLH; ?></b></h4>
                                <h4>Thanh toán: <b><?php echo $fetch_dh['PhuongThucThanhToan']; ?></b></h4>
                            </div>
                            <div class="another-donhang-c2">                                
                                <h4>Ngày mua: <b><?php echo $fetch_dh['NgayMua']; ?></b></h4>
                                <h4>Voucher: <b><?php echo $fetch_dh['MaVoucher']; ?></b></h4>
                                <h4>Loại giao hàng: <b><?php echo $_tenship; ?> (<b><?php echo $_tgship; ?></b> ngày)</b></h4>
                                <h4>Đơn giá: <b style="color: red"><?php echo $fetctsach['GiaBan'];; ?> đ</b></h4>
                                <h4>Số lượng: <b style="color: red"><?php echo $_slDon; ?></b></h4>
                                <h4>Thành tiền: <b style="color: red"><?php echo $fetctdh['TongTien']; ?> đ</b></h4>
                            </div>
                            
                            
                        </div>
                        <?php
                      }
                      ?>

                            <div class="another-donhang tong">
                                <button name="cxn-HuyDonHang" class="btn_huydon">Hủy đơn
                                    hàng</button>
                                <h4>Thành tiền: <b style="color: red"><?php echo $demTongDon+$_tienship-$_tienvc; ?> đ</b></h4>
                                <h4>Giảm: <b style="color: red"><?php echo $_tienvc; ?></b></h4>
                                <h4>Phí ship: <b style="color: red"><?php echo $_tienship; ?></b></h4>
                                <h4>Tổng đơn: <b style="color: red"><?php echo $demTongDon; ?></b></h4>
                                
                                
                               
                                
                            </div>
                            </form>
                <?php
                    }
                  }
                }
                else
                  echo '<h3>Không có bất kì đơn nào!</h3>';
            }
            echo '</div>';
        }
        if(isset($_POST['xct-DangVanChuyen']))
        {
          echo '<div class="container-xem-chi-tiet">';
          echo '<h1>Thông tin các đơn hàng:</h1>';
            foreach($arrMaDonHang as $dh)
            {
                $demTongDon=0;
              $select_dh = mysqli_query($conn, "SELECT * FROM `donhang` WHERE MaDonHang='$dh'") or die('query failed');
              if(mysqli_num_rows($select_dh) > 0){
                  while($fetch_dh = mysqli_fetch_assoc($select_dh)){
                    if($fetch_dh['TrangThai'] == "Đang xử lý")
                    {
                      $_ma = $fetch_dh['MaDonHang'];
                      $select_ctdh = mysqli_query($conn, "SELECT * FROM `chitietdonhang` WHERE MaDonHang='$_ma'") or die('query failed');
                      while($fetctdh = mysqli_fetch_assoc($select_ctdh))
                      {
                        $demTongDon+=$fetctdh['TongTien'];
                        $_slDon = $fetctdh['SoLuong'];
                        $_masach=$fetctdh['MaSach'];
                        $select_ctsach = mysqli_query($conn, "SELECT * FROM `sach` WHERE MaSach='$_masach'") or die('query failed');
                        $fetctsach = mysqli_fetch_assoc($select_ctsach);
                        $_tensach =$fetctsach['TenSach'];
                        $_anh =$fetctsach['HinhAnh'];
                        $_mattlh= $fetch_dh['MaTTLH'];
                        $select_ctttlt = mysqli_query($conn, "SELECT * FROM `thongtinlienhe` WHERE MaTTLH='$_mattlh'") or die('query failed');
                        $fetctttlh = mysqli_fetch_assoc($select_ctttlt);
                        $_dc=$fetctttlh['DiaChi'];
                        $_dcct=$fetctttlh['DiaChiCuThe'];
                        $_sdtLH=$fetctttlh['SDT'];

                        $_maship= $fetch_dh['MaLoaiGH'];
                        $select_ship = mysqli_query($conn, "SELECT * FROM `loaigiaohang` WHERE MaLoaiGH='$_maship'") or die('query failed');
                        $fetcship = mysqli_fetch_assoc($select_ship);
                        $_tenship=$fetcship['TenLoaiGH'];
                        $_tgship=$fetcship['ThoiGian'];
                        $_tienship=$fetcship['ChiPhi'];

                        $_mavoucher= $fetch_dh['MaVoucher'];
                        $select_vc = mysqli_query($conn, "SELECT * FROM `voucher` WHERE MaVoucher='$_mavoucher'") or die('query failed');
                        $fetcvoucher = mysqli_fetch_assoc($select_vc);
                        $_tienvc=$fetcvoucher['TienGiam'];
                        $dongia = $fetch_dh['ThanhTien']-$_tienship;
                        $_tongthanhtoan = $fetch_dh['ThanhTien']*$_slDon-$_tienvc;
                        ?>
                        <div class="another-donhang">
                            <div class="another-donhang-l">
                                <center>
                                    <div style="width: 85%; height:210px;">
                                        <img src="uploaded_img/<?php echo $_anh; ?>" width="100%" height="100%">
                                    </div>
                                </center>

                            </div>
                            <form method="post">
                            <div class="another-donhang-c1">
                                <h4>Mã đơn: <b><?php echo $fetch_dh['MaDonHang']; ?></b></h4>
                                <input type="hidden" name="madonhanghuy" value="<?php echo $fetch_dh['MaDonHang']; ?>">
                                <h4>Tên sách: <?php echo $_tensach; ?></h4>
                                <h4>Địa chỉ nhận hàng: <b><?php echo $_dc; ?></b></h4>
                                <h4>Địa chỉ cụ thể: <b><?php echo $_dcct; ?></b></h4>
                                <h4>Số điện thoại: <b><?php echo $_sdtLH; ?></b></h4>
                                <h4>Thanh toán: <b><?php echo $fetch_dh['PhuongThucThanhToan']; ?></b></h4>
                            </div>
                            <div class="another-donhang-c2">                                
                                <h4>Ngày mua: <b><?php echo $fetch_dh['NgayMua']; ?></b></h4>
                                <h4>Voucher: <b><?php echo $fetch_dh['MaVoucher']; ?></b></h4>
                                <h4>Loại giao hàng: <b><?php echo $_tenship; ?> (<b><?php echo $_tgship; ?></b> ngày)</b></h4>
                                <h4>Đơn giá: <b style="color: red"><?php echo $fetctsach['GiaBan'];; ?> đ</b></h4>
                                <h4>Số lượng: <b style="color: red"><?php echo $_slDon; ?></b></h4>
                                <h4>Thành tiền: <b style="color: red"><?php echo $fetctdh['TongTien']; ?> đ</b></h4>
                            </div>
                            
                            
                        </div>
                        <?php
                      }
                      ?>

                            <div class="another-donhang tong">
                                <button name="cxn-HuyDonHang" class="btn_huydon">Hủy đơn
                                    hàng</button>
                                <h4>Thành tiền: <b style="color: red"><?php echo $demTongDon+$_tienship-$_tienvc; ?> đ</b></h4>
                                <h4>Giảm: <b style="color: red"><?php echo $_tienvc; ?></b></h4>
                                <h4>Phí ship: <b style="color: red"><?php echo $_tienship; ?></b></h4>
                                <h4>Tổng đơn: <b style="color: red"><?php echo $demTongDon; ?></b></h4>
                                
                                
                               
                                
                            </div>
                            </form>
                <?php
                    }
                  }
                }
                else
                  echo '<h3>Không có bất kì đơn nào!</h3>';
            }
            echo '</div>';
        }
        if(isset($_POST['xct-DangGiao']))
        {
          echo '<div class="container-xem-chi-tiet">';
          echo '<h1>Thông tin các đơn hàng:</h1>';
            foreach($arrMaDonHang as $dh)
            {
                $demTongDon=0;
              $select_dh = mysqli_query($conn, "SELECT * FROM `donhang` WHERE MaDonHang='$dh'") or die('query failed');
              if(mysqli_num_rows($select_dh) > 0){
                  while($fetch_dh = mysqli_fetch_assoc($select_dh)){
                    if($fetch_dh['TrangThai'] == "Đang giao")
                    {
                      $_ma = $fetch_dh['MaDonHang'];
                      $select_ctdh = mysqli_query($conn, "SELECT * FROM `chitietdonhang` WHERE MaDonHang='$_ma'") or die('query failed');
                      while($fetctdh = mysqli_fetch_assoc($select_ctdh))
                      {
                        $demTongDon+=$fetctdh['TongTien'];
                        $_slDon = $fetctdh['SoLuong'];
                        $_masach=$fetctdh['MaSach'];
                        $select_ctsach = mysqli_query($conn, "SELECT * FROM `sach` WHERE MaSach='$_masach'") or die('query failed');
                        $fetctsach = mysqli_fetch_assoc($select_ctsach);
                        $_tensach =$fetctsach['TenSach'];
                        $_anh =$fetctsach['HinhAnh'];
                        $_mattlh= $fetch_dh['MaTTLH'];
                        $select_ctttlt = mysqli_query($conn, "SELECT * FROM `thongtinlienhe` WHERE MaTTLH='$_mattlh'") or die('query failed');
                        $fetctttlh = mysqli_fetch_assoc($select_ctttlt);
                        $_dc=$fetctttlh['DiaChi'];
                        $_dcct=$fetctttlh['DiaChiCuThe'];
                        $_sdtLH=$fetctttlh['SDT'];

                        $_maship= $fetch_dh['MaLoaiGH'];
                        $select_ship = mysqli_query($conn, "SELECT * FROM `loaigiaohang` WHERE MaLoaiGH='$_maship'") or die('query failed');
                        $fetcship = mysqli_fetch_assoc($select_ship);
                        $_tenship=$fetcship['TenLoaiGH'];
                        $_tgship=$fetcship['ThoiGian'];
                        $_tienship=$fetcship['ChiPhi'];

                        $_mavoucher= $fetch_dh['MaVoucher'];
                        $select_vc = mysqli_query($conn, "SELECT * FROM `voucher` WHERE MaVoucher='$_mavoucher'") or die('query failed');
                        $fetcvoucher = mysqli_fetch_assoc($select_vc);
                        $_tienvc=$fetcvoucher['TienGiam'];
                        $dongia = $fetch_dh['ThanhTien']-$_tienship;
                        $_tongthanhtoan = $fetch_dh['ThanhTien']*$_slDon-$_tienvc;
                        ?>
                        <div class="another-donhang">
                            <div class="another-donhang-l">
                                <center>
                                    <div style="width: 85%; height:210px;">
                                        <img src="uploaded_img/<?php echo $_anh; ?>" width="100%" height="100%">
                                    </div>
                                </center>

                            </div>
                            <form method="post">
                            <div class="another-donhang-c1">
                                <h4>Mã đơn: <b><?php echo $fetch_dh['MaDonHang']; ?></b></h4>
                                <input type="hidden" name="madonhanghuy" value="<?php echo $fetch_dh['MaDonHang']; ?>">
                                <h4>Tên sách: <?php echo $_tensach; ?></h4>
                                <h4>Địa chỉ nhận hàng: <b><?php echo $_dc; ?></b></h4>
                                <h4>Địa chỉ cụ thể: <b><?php echo $_dcct; ?></b></h4>
                                <h4>Số điện thoại: <b><?php echo $_sdtLH; ?></b></h4>
                                <h4>Thanh toán: <b><?php echo $fetch_dh['PhuongThucThanhToan']; ?></b></h4>
                            </div>
                            <div class="another-donhang-c2">                                
                                <h4>Ngày mua: <b><?php echo $fetch_dh['NgayMua']; ?></b></h4>
                                <h4>Voucher: <b><?php echo $fetch_dh['MaVoucher']; ?></b></h4>
                                <h4>Loại giao hàng: <b><?php echo $_tenship; ?> (<b><?php echo $_tgship; ?></b> ngày)</b></h4>
                                <h4>Đơn giá: <b style="color: red"><?php echo $fetctsach['GiaBan'];; ?> đ</b></h4>
                                <h4>Số lượng: <b style="color: red"><?php echo $_slDon; ?></b></h4>
                                <h4>Thành tiền: <b style="color: red"><?php echo $fetctdh['TongTien']; ?> đ</b></h4>
                            </div>
                            
                            
                        </div>
                        <?php
                      }
                      ?>

                            <div class="another-donhang tong">
                                <h4>Thành tiền: <b style="color: red"><?php echo $demTongDon+$_tienship-$_tienvc; ?> đ</b></h4>
                                <h4>Giảm: <b style="color: red"><?php echo $_tienvc; ?></b></h4>
                                <h4>Phí ship: <b style="color: red"><?php echo $_tienship; ?></b></h4>
                                <h4>Tổng đơn: <b style="color: red"><?php echo $demTongDon; ?></b></h4>
                                
                                
                               
                                
                            </div>
                            </form>
                <?php
                    }
                  }
                }
                else
                  echo '<h3>Không có bất kì đơn nào!</h3>';
            }
            echo '</div>';
        }
        if(isset($_POST['xct-DaGiao']))
        {
          echo '<div class="container-xem-chi-tiet">';
          echo '<h1>Thông tin các đơn hàng:</h1>';
            foreach($arrMaDonHang as $dh)
            {
                $demTongDon=0;
              $select_dh = mysqli_query($conn, "SELECT * FROM `donhang` WHERE MaDonHang='$dh'") or die('query failed');
              if(mysqli_num_rows($select_dh) > 0){
                  while($fetch_dh = mysqli_fetch_assoc($select_dh)){
                    if($fetch_dh['TrangThai'] == "Đã giao")
                    {
                      $_ma = $fetch_dh['MaDonHang'];
                      $select_ctdh = mysqli_query($conn, "SELECT * FROM `chitietdonhang` WHERE MaDonHang='$_ma'") or die('query failed');
                      while($fetctdh = mysqli_fetch_assoc($select_ctdh))
                      {
                        $demTongDon+=$fetctdh['TongTien'];
                        $_slDon = $fetctdh['SoLuong'];
                        $_masach=$fetctdh['MaSach'];
                        $select_ctsach = mysqli_query($conn, "SELECT * FROM `sach` WHERE MaSach='$_masach'") or die('query failed');
                        $fetctsach = mysqli_fetch_assoc($select_ctsach);
                        $_tensach =$fetctsach['TenSach'];
                        $_anh =$fetctsach['HinhAnh'];
                        $_mattlh= $fetch_dh['MaTTLH'];
                        $select_ctttlt = mysqli_query($conn, "SELECT * FROM `thongtinlienhe` WHERE MaTTLH='$_mattlh'") or die('query failed');
                        $fetctttlh = mysqli_fetch_assoc($select_ctttlt);
                        $_dc=$fetctttlh['DiaChi'];
                        $_dcct=$fetctttlh['DiaChiCuThe'];
                        $_sdtLH=$fetctttlh['SDT'];

                        $_maship= $fetch_dh['MaLoaiGH'];
                        $select_ship = mysqli_query($conn, "SELECT * FROM `loaigiaohang` WHERE MaLoaiGH='$_maship'") or die('query failed');
                        $fetcship = mysqli_fetch_assoc($select_ship);
                        $_tenship=$fetcship['TenLoaiGH'];
                        $_tgship=$fetcship['ThoiGian'];
                        $_tienship=$fetcship['ChiPhi'];

                        $_mavoucher= $fetch_dh['MaVoucher'];
                        $select_vc = mysqli_query($conn, "SELECT * FROM `voucher` WHERE MaVoucher='$_mavoucher'") or die('query failed');
                        $fetcvoucher = mysqli_fetch_assoc($select_vc);
                        $_tienvc=$fetcvoucher['TienGiam'];
                        $dongia = $fetch_dh['ThanhTien']-$_tienship;
                        $_tongthanhtoan = $fetch_dh['ThanhTien']*$_slDon-$_tienvc;
                        ?>
                        <div class="another-donhang">
                            <div class="another-donhang-l">
                                <center>
                                    <div style="width: 85%; height:210px;">
                                        <img src="uploaded_img/<?php echo $_anh; ?>" width="100%" height="100%">
                                    </div>
                                </center>

                            </div>
                            <form method="post">
                            <div class="another-donhang-c1">
                                <h4>Mã đơn: <b><?php echo $fetch_dh['MaDonHang']; ?></b></h4>
                                <input type="hidden" name="madonhang_dg" value="<?php echo $fetch_dh['MaDonHang']; ?>">
                                <h4>Tên sách: <?php echo $_tensach; ?></h4>
                                <h4>Địa chỉ nhận hàng: <b><?php echo $_dc; ?></b></h4>
                                <h4>Địa chỉ cụ thể: <b><?php echo $_dcct; ?></b></h4>
                                <h4>Số điện thoại: <b><?php echo $_sdtLH; ?></b></h4>
                                <h4>Thanh toán: <b><?php echo $fetch_dh['PhuongThucThanhToan']; ?></b></h4>
                            </div>
                            <div class="another-donhang-c2">                                
                                <h4>Ngày mua: <b><?php echo $fetch_dh['NgayMua']; ?></b></h4>
                                <h4>Voucher: <b><?php echo $fetch_dh['MaVoucher']; ?></b></h4>
                                <h4>Loại giao hàng: <b><?php echo $_tenship; ?> (<b><?php echo $_tgship; ?></b> ngày)</b></h4>
                                <h4>Đơn giá: <b style="color: red"><?php echo $fetctsach['GiaBan'];; ?> đ</b></h4>
                                <h4>Số lượng: <b style="color: red"><?php echo $_slDon; ?></b></h4>
                                <h4>Thành tiền: <b style="color: red"><?php echo $fetctdh['TongTien']; ?> đ</b></h4>
                            </div>
                            
                            
                        </div>
                        <?php
                      }
                      ?>

                            <div class="another-donhang tong">
                                <button name="cxn-DanhGia" class="btn_huydon">Đánh giá</button>
                                <h4>Thành tiền: <b style="color: red"><?php echo $demTongDon+$_tienship-$_tienvc; ?> đ</b></h4>
                                <h4>Giảm: <b style="color: red"><?php echo $_tienvc; ?></b></h4>
                                <h4>Phí ship: <b style="color: red"><?php echo $_tienship; ?></b></h4>
                                <h4>Tổng đơn: <b style="color: red"><?php echo $demTongDon; ?></b></h4>
                                
                                
                               
                                
                            </div>
                            </form>
                <?php
                    }
                  }
                }
                else
                  echo '<h3>Không có bất kì đơn nào!</h3>';
            }
            echo '</div>';
            
            ?>            
            
            <?php
            
        }
        if(isset($_POST['xct-DaHuy']))
        {
          echo '<div class="container-xem-chi-tiet">';
          echo '<h1>Thông tin các đơn hàng:</h1>';
            foreach($arrMaDonHang as $dh)
            {
                $demTongDon=0;
              $select_dh = mysqli_query($conn, "SELECT * FROM `donhang` WHERE MaDonHang='$dh'") or die('query failed');
              if(mysqli_num_rows($select_dh) > 0){
                  while($fetch_dh = mysqli_fetch_assoc($select_dh)){
                    if($fetch_dh['TrangThai'] == "Đã hủy")
                    {
                      $_ma = $fetch_dh['MaDonHang'];
                      $select_ctdh = mysqli_query($conn, "SELECT * FROM `chitietdonhang` WHERE MaDonHang='$_ma'") or die('query failed');
                      while($fetctdh = mysqli_fetch_assoc($select_ctdh))
                      {
                        $demTongDon+=$fetctdh['TongTien'];
                        $_slDon = $fetctdh['SoLuong'];
                        $_masach=$fetctdh['MaSach'];
                        $select_ctsach = mysqli_query($conn, "SELECT * FROM `sach` WHERE MaSach='$_masach'") or die('query failed');
                        $fetctsach = mysqli_fetch_assoc($select_ctsach);
                        $_tensach =$fetctsach['TenSach'];
                        $_anh =$fetctsach['HinhAnh'];
                        $_mattlh= $fetch_dh['MaTTLH'];
                        $select_ctttlt = mysqli_query($conn, "SELECT * FROM `thongtinlienhe` WHERE MaTTLH='$_mattlh'") or die('query failed');
                        $fetctttlh = mysqli_fetch_assoc($select_ctttlt);
                        $_dc=$fetctttlh['DiaChi'];
                        $_dcct=$fetctttlh['DiaChiCuThe'];
                        $_sdtLH=$fetctttlh['SDT'];

                        $_maship= $fetch_dh['MaLoaiGH'];
                        $select_ship = mysqli_query($conn, "SELECT * FROM `loaigiaohang` WHERE MaLoaiGH='$_maship'") or die('query failed');
                        $fetcship = mysqli_fetch_assoc($select_ship);
                        $_tenship=$fetcship['TenLoaiGH'];
                        $_tgship=$fetcship['ThoiGian'];
                        $_tienship=$fetcship['ChiPhi'];

                        $_mavoucher= $fetch_dh['MaVoucher'];
                        $select_vc = mysqli_query($conn, "SELECT * FROM `voucher` WHERE MaVoucher='$_mavoucher'") or die('query failed');
                        $fetcvoucher = mysqli_fetch_assoc($select_vc);
                        $_tienvc=$fetcvoucher['TienGiam'];
                        $dongia = $fetch_dh['ThanhTien']-$_tienship;
                        $_tongthanhtoan = $fetch_dh['ThanhTien']*$_slDon-$_tienvc;
                        ?>
                        <div class="another-donhang">
                            <div class="another-donhang-l">
                                <center>
                                    <div style="width: 85%; height:210px;">
                                        <img src="uploaded_img/<?php echo $_anh; ?>" width="100%" height="100%">
                                    </div>
                                </center>

                            </div>
                            <form method="post">
                            <div class="another-donhang-c1">
                                <h4>Mã đơn: <b><?php echo $fetch_dh['MaDonHang']; ?></b></h4>
                                <input type="hidden" name="madonhanghuy" value="<?php echo $fetch_dh['MaDonHang']; ?>">
                                <h4>Tên sách: <?php echo $_tensach; ?></h4>
                                <h4>Địa chỉ nhận hàng: <b><?php echo $_dc; ?></b></h4>
                                <h4>Địa chỉ cụ thể: <b><?php echo $_dcct; ?></b></h4>
                                <h4>Số điện thoại: <b><?php echo $_sdtLH; ?></b></h4>
                                <h4>Thanh toán: <b><?php echo $fetch_dh['PhuongThucThanhToan']; ?></b></h4>
                            </div>
                            <div class="another-donhang-c2">                                
                                <h4>Ngày mua: <b><?php echo $fetch_dh['NgayMua']; ?></b></h4>
                                <h4>Voucher: <b><?php echo $fetch_dh['MaVoucher']; ?></b></h4>
                                <h4>Loại giao hàng: <b><?php echo $_tenship; ?> (<b><?php echo $_tgship; ?></b> ngày)</b></h4>
                                <h4>Đơn giá: <b style="color: red"><?php echo $fetctsach['GiaBan'];; ?> đ</b></h4>
                                <h4>Số lượng: <b style="color: red"><?php echo $_slDon; ?></b></h4>
                                <h4>Thành tiền: <b style="color: red"><?php echo $fetctdh['TongTien']; ?> đ</b></h4>
                            </div>
                            
                            
                        </div>
                        <?php
                      }
                      ?>

                            <div class="another-donhang tong">
                                <button name="cxn-DatLai" class="btn_huydon">Đặt hàng lại</button>
                                <h4>Thành tiền: <b style="color: red"><?php echo $demTongDon+$_tienship-$_tienvc; ?> đ</b></h4>
                                <h4>Giảm: <b style="color: red"><?php echo $_tienvc; ?></b></h4>
                                <h4>Phí ship: <b style="color: red"><?php echo $_tienship; ?></b></h4>
                                <h4>Tổng đơn: <b style="color: red"><?php echo $demTongDon; ?></b></h4>
                                
                                
                               
                                
                            </div>
                            </form>
                <?php
                    }
                  }
                }
                else
                  echo '<h3>Không có bất kì đơn nào!</h3>';
            }
            echo '</div>';
        }
        if(isset($_POST['xct-TraHang']))
        {
            $demTongDon=0;
          echo '<div class="container-xem-chi-tiet">';
          echo '<h1>Thông tin các đơn hàng:</h1>';
            foreach($arrMaDonHang as $dh)
            {
              $select_dh = mysqli_query($conn, "SELECT * FROM `donhang` WHERE MaDonHang='$dh'") or die('query failed');
              if(mysqli_num_rows($select_dh) > 0){
                  while($fetch_dh = mysqli_fetch_assoc($select_dh)){
                    if($fetch_dh['TrangThai'] == "Bị từ chối")
                    {
                      $_ma = $fetch_dh['MaDonHang'];
                      $select_ctdh = mysqli_query($conn, "SELECT * FROM `chitietdonhang` WHERE MaDonHang='$_ma'") or die('query failed');
                      while($fetctdh = mysqli_fetch_assoc($select_ctdh))
                      {
                        $demTongDon+=$fetctdh['TongTien'];
                        $_slDon = $fetctdh['SoLuong'];
                        $_masach=$fetctdh['MaSach'];
                        $select_ctsach = mysqli_query($conn, "SELECT * FROM `sach` WHERE MaSach='$_masach'") or die('query failed');
                        $fetctsach = mysqli_fetch_assoc($select_ctsach);
                        $_tensach =$fetctsach['TenSach'];
                        $_anh =$fetctsach['HinhAnh'];
                        $_mattlh= $fetch_dh['MaTTLH'];
                        $select_ctttlt = mysqli_query($conn, "SELECT * FROM `thongtinlienhe` WHERE MaTTLH='$_mattlh'") or die('query failed');
                        $fetctttlh = mysqli_fetch_assoc($select_ctttlt);
                        $_dc=$fetctttlh['DiaChi'];
                        $_dcct=$fetctttlh['DiaChiCuThe'];
                        $_sdtLH=$fetctttlh['SDT'];

                        $_maship= $fetch_dh['MaLoaiGH'];
                        $select_ship = mysqli_query($conn, "SELECT * FROM `loaigiaohang` WHERE MaLoaiGH='$_maship'") or die('query failed');
                        $fetcship = mysqli_fetch_assoc($select_ship);
                        $_tenship=$fetcship['TenLoaiGH'];
                        $_tgship=$fetcship['ThoiGian'];
                        $_tienship=$fetcship['ChiPhi'];

                        $_mavoucher= $fetch_dh['MaVoucher'];
                        $select_vc = mysqli_query($conn, "SELECT * FROM `voucher` WHERE MaVoucher='$_mavoucher'") or die('query failed');
                        $fetcvoucher = mysqli_fetch_assoc($select_vc);
                        $_tienvc=$fetcvoucher['TienGiam'];
                        $dongia = $fetch_dh['ThanhTien']-$_tienship;
                        $_tongthanhtoan = $fetch_dh['ThanhTien']*$_slDon-$_tienvc;
                        ?>
                        <div class="another-donhang">
                            <div class="another-donhang-l">
                                <center>
                                    <div style="width: 85%; height:210px;">
                                        <img src="uploaded_img/<?php echo $_anh; ?>" width="100%" height="100%">
                                    </div>
                                </center>

                            </div>
                            <form method="post">
                            <div class="another-donhang-c1">
                                <h4>Mã đơn: <b><?php echo $fetch_dh['MaDonHang']; ?></b></h4>
                                <input type="hidden" name="madonhanghuy" value="<?php echo $fetch_dh['MaDonHang']; ?>">
                                <h4>Tên sách: <?php echo $_tensach; ?></h4>
                                <h4>Địa chỉ nhận hàng: <b><?php echo $_dc; ?></b></h4>
                                <h4>Địa chỉ cụ thể: <b><?php echo $_dcct; ?></b></h4>
                                <h4>Số điện thoại: <b><?php echo $_sdtLH; ?></b></h4>
                                <h4>Thanh toán: <b><?php echo $fetch_dh['PhuongThucThanhToan']; ?></b></h4>
                            </div>
                            <div class="another-donhang-c2">                                
                                <h4>Ngày mua: <b><?php echo $fetch_dh['NgayMua']; ?></b></h4>
                                <h4>Voucher: <b><?php echo $fetch_dh['MaVoucher']; ?></b></h4>
                                <h4>Loại giao hàng: <b><?php echo $_tenship; ?> (<b><?php echo $_tgship; ?></b> ngày)</b></h4>
                                <h4>Đơn giá: <b style="color: red"><?php echo $fetctsach['GiaBan'];; ?> đ</b></h4>
                                <h4>Số lượng: <b style="color: red"><?php echo $_slDon; ?></b></h4>
                                <h4>Thành tiền: <b style="color: red"><?php echo $fetctdh['TongTien']; ?> đ</b></h4>
                            </div>
                            
                            
                        </div>
                        <?php
                      }
                      ?>

                            <div class="another-donhang tong">
                                <h4>Thành tiền: <b style="color: red"><?php echo $demTongDon+$_tienship-$_tienvc; ?> đ</b></h4>
                                <h4>Giảm: <b style="color: red"><?php echo $_tienvc; ?></b></h4>
                                <h4>Phí ship: <b style="color: red"><?php echo $_tienship; ?></b></h4>
                                <h4>Tổng đơn: <b style="color: red"><?php echo $demTongDon; ?></b></h4>
                                
                                
                               
                                
                            </div>
                            </form>
                <?php
                    }
                  }
                }
                else
                  echo '<h3>Không có bất kì đơn nào!</h3>';
            }
            echo '</div>';
        }

        if(isset($_POST['cxn-DanhGia']))
            {
                $_cacdonhang = $_POST['madonhang_dg'];
                $today = date('y-m-d');
                ?>
                <div class="box-danh-gia">
                    <form method="post">
                    <input type="text" readonly="true" name="datenow" required placeholder="<?php echo $today;?>" class="box-date">
                    <select class="select-location" name="chon-sach-danh-gia" style="width: 100%; margin-top:10px">
                        <option value="" selected="true">-Chọn sách đánh giá-</option>
                        <?php
                            $select_all_danggia = mysqli_query($conn, "SELECT * FROM `chitietdonhang` WHERE MaDonHang='$_cacdonhang'") or die('query failed');
                            while($fetcdanggia = mysqli_fetch_assoc($select_all_danggia))
                            {
                                $_maSach = $fetcdanggia['MaSach'];
                                $select_all_sach = mysqli_query($conn, "SELECT * FROM `sach` WHERE MaSach='$_maSach'") or die('query failed');
                                $fetcSach = mysqli_fetch_assoc($select_all_sach);
                                echo '<option value="'.$_maSach.'">'.$fetcSach['TenSach'].'</option>';
                            }
                        ?>
                    </select>
                    <textarea name="message" class="box" placeholder="Nhận xét về sản phẩm..." id="" cols="30" rows="3"></textarea>
                    <label style="margin-top:10px">Số sao đánh giá:&emsp;</label>
                    <input type="number" min="1" max="5" name="quantity_star" value="5" class="qty" style="border: 1px solid rgb(184, 181, 181);border-radius:5px;width: 80px; height: 40px;margin-top:10px">
                    <input type="submit" value="Đánh giá" name="btn-them-danhgia"
                        style="padding-left:0px;margin-left:10px;color:white;border-radius:5px;width:100px; height:35px; background-color: purple;margin-top:10px; float:right">    
                    <input type="submit" value="Hủy" name="btn-huy-danggia"
                    style="padding-left:0px;margin-left:10px;color:purple;border-radius:5px;width:100px; height:35px; background-color: whitesmoke;border: 1px solid purple;margin-top:10px; float:right">
                    </form>
                </div>
                <?php
            }
      ?>
      




    </section>

    <a href="#home" class="top">
        <img src="images/muiTen.PNG" alt="" style="height: 55px; width: 55px; border-radius: 50%;">
    </a>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/scriptPF.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"
        integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/app.js"></script>
</body>

</html>

<?php
    if(isset($_POST['cxn-HuyDonHang']))
    {
        $_maddh = $_POST['madonhanghuy'];
        $select_all_donhang = mysqli_query($conn, "UPDATE `donhang` SET TrangThai='Đã hủy' WHERE MaDonHang='$_maddh'");
        echo '<script>location.href = "/TrangCaNhan.php#education";</script>';
    }

    if(isset($_POST['cxn-DatLai']))
    {
        $_maddh = $_POST['madonhanghuy'];
        $select_all_donhang = mysqli_query($conn, "UPDATE `donhang` SET TrangThai='Chờ xác nhận' WHERE MaDonHang='$_maddh'");
    }

    if(isset($_POST['btn-them-danhgia']))
    {

        $_masachdanggia = $_POST['chon-sach-danh-gia'];
        $_content_danggia = $_POST['message'];
        $_star_numbers = $_POST['quantity_star'];
        $today = date('y-m-d');
        
        if($_masachdanggia !="" && $_content_danggia !="")
        {
            $arrFeedback = mysqli_query($conn,"SELECT * FROM `danhgia` WHERE ID='$user_id' and MaSach='$_masachdanggia'");
            if(mysqli_num_rows($arrFeedback)<=0)
            {
                mysqli_query($conn, "INSERT INTO `danhgia` VALUES('$user_id', '$_masachdanggia', '$_content_danggia', $_star_numbers, '$today')") or die('query failed');
                echo '<script>window.alert("Đã đánh giá thành công")</script>';
            }
            else
                echo '<script>window.alert("Đã đánh giá sản phẩm trước đó")</script>';
        }
        else{
            echo '<script>window.alert("Chưa điền đủ thông tin")</script>';
        }
    }
?>