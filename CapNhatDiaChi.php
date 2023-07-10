<?php

include 'Api/connection.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:.php');
}
if(isset($_GET["mattlh"]))
{
	$mattlh = $_GET["mattlh"];
	$sql = "select * from thongtinlienhe where maTTLH = $mattlh";	
	$lh = executeResult($sql,true);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Horizon | Đơn hàng</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/bootstrap.css">
<style>
    textarea {
        padding: 10px 20px;
    }

    .loidl {
        color: red;
        position: absolute;
        margin-left: 2px;
        font-size: 13px;
    }

    .ViewLoi {
        position: relative;
    }

    .bomtom {
        margin-bottom: 40px;
    }
</style>
</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Thêm địa chỉ</h3>
</div>

<div class="container">
	<center>
<form method="post">
    <div class="modal-body" style="height:600px; padding:50px;">
        <div class="row">
            <div class="row">
                <div class="col-6 bomtom">
                    <input type="text" id="HoVaTen" name="HoVaTen" class="box w-100 tt_lh" placeholder="Họ và tên" title="Nhập học và tên người nhận" />
                    <div class="ViewLoi">
                        <span class="loidl"></span>
                    </div>
                </div>

                <div class="col-6 bomtom">
                    <input type="text" id="SoDienThoai" class="w-100 phone" name="SoDienThoai" maxlength="10" placeholder="Số điện thoại" title="Nhập số điện thoại người nhận" />
                    <div class="ViewLoi">
                        <span class="loidl"></span>
                    </div>
                </div>
            </div>
            <div class="row bomtom">
                <div class="col-4">			
					<input hidden id="xa" value="@s[0].Trim()" />
					<input hidden id="quan" value="@s[1].Trim()" />
					<input hidden id="tinh" value="@s[2].Trim()" />
                    <select name="tinh" id="province" ></select>
                </div>
                <div class="col-4">
                    <select class="" name="quan" id="district">
                    	<option value=""> Chọn </option>
                    </select>
                </div>
                <div class="col-4">
                     <select class="" name="xa" id="ward">
						<option value=""> Chọn </option>
					</select>
                </div>
                <div class=" col-12 ViewLoi">
                    <span class="loidl"></span>
                </div>
				<input id="result" value="" name="QueQuan" hidden />
            </div>
            <div class="row" style="padding:25px;">
                <textarea maxlength="100" name="DiaChiCuThe" id="diachicuthe"  placeholder="Địa chỉ cụ thể" title="Nhập địa chỉ của thể" class="w-100" style="min-height:100px; max-height:200px; max-width: 500px;"></textarea>
                <div class="ViewLoi" style="margin-left:-12px;">
                    <span class="loidl"></span>
                </div>
            </div>
            <div class="row">                
                <div class=" col-12">
                    <div class="form-check form-switch" style="padding-top:25px;">
                        <input class="form-check-input" type="checkbox" value="1" name="MacDinh" role="switch" id="macdinh">
                        <label for="macdinh">Đặt làm mặt định</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div>
            <input type="button" value="Hủy Lưu" id="HuyLuuDiaChi" class="btn btn-outline-danger" data-bs-dismiss="modal">
        </div>
        <div>
            <a value="Lưu" id="KT" class="btn btn-outline-info">Lưu</a>
            <button id="ThemDiaChiMoi" type="submit" hidden data-bs-dismiss="modal">lllll</button>
        </div>
    </div>
</form>
</center>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="js/ThemDiaChiMoi.js"></script>
<script src="js/kiemTraChuoiSo.js"></script>
</div>







<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>