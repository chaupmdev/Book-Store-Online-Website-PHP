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
   <title>Admin | Đơn hàng </title>

   <!-- font awesome cdn link  -->

<!--   <link rel="stylesheet" href="css/style.css">-->
<style>
	.box-container{
		font-size: 20px;
		text-align: center;		
	}
</style>
</head>
<body>
   
<?php include 'admin_header.php'; ?>

<div class="heading">
   <center><h1>Danh sách đơn hàng</h3></center>
</div>
<div class="box-container">
	<div>
            <input type="checkbox" checked name="showAll" id="loc0" class="showAll" value="All" /> <label for="loc0">Tất cả </label>
            <input type="checkbox" checked name="loc" id="loc1" class="loc" value="Chờ xác nhận"/> <label for="loc1">Chờ xác nhận </label>
            <input type="checkbox" checked name="loc" id="loc2" class="loc" value="Đang xử lý" /> <label for="loc2">Đang xử lý </label>
            <input type="checkbox" checked name="loc" id="loc3" class="loc" value="Đang giao" /> <label for="loc3">Đang giao </label>
            <input type="checkbox" checked name="loc" id="loc4" class="loc" value="Đã giao" /> <label for="loc4">Đã giao </label>
            <input type="checkbox" checked name="loc" id="loc5" class="loc" value="Đã hủy" /> <label for="loc5">Đã hủy </label>
            <input type="checkbox" checked name="loc" id="loc6" class="loc" value="Bị từ chối" /> <label for="loc6">Bị từ chối </label>
			<input type="search" id="timkiem" maxlength="30" style=" height: 40px; width: 300px;" placeholder="Nhập mã đơn hàng để tìm kiếm" >		
	</div>
   <div>
	   <center>
	   <table class="table" cellspacing="20">
		   <tr>
			   <th>Mã đơn hàng</th>
			   <th>Ngày mua</th>
			   <th>Loại giao hàng</th>
			   <th>Phương thức thanh toán</th>
			   <th>Thành tiền</th>
			   <th>Trạng thái</th>
			   <th></th>
		   </tr>
		   <tbody id="dsDonHang">
		   </tbody>
	   </table>		   
		   </center>
	</div>
	
</div>


<!-- custom js file link  -->

<script type="text/javascript">
	const dsDonHang = document.getElementById('dsDonHang');
	$.post(BASE_URL+API_AUTHEN,{'action':AUTHEN_VALUES,'tblName':'donhang'},function(data){			
		var data = JSON.parse(data);
			dsDonHang.innerHTML = doDuLieuDonHang(data);
	} )
timkiem.addEventListener('input',()=>{
	console.log(timkiem.value)
	$.post(BASE_URL+API_AUTHEN,{'action':AUTHEN_TIMKIEMDONHANG,'txtsearch': timkiem.value},function(data){			
		var data = JSON.parse(data);			
		dsDonHang.innerHTML = doDuLieuDonHang(data);
	} )
})
function doDuLieuDonHang(data)
	{
		if(data.status == -1)
			return data.msg;
		let s ='';		
		data.donhang.forEach(item =>{
			s+=`<tr class="${taoClassLoai(item.TrangThai)} trangthai" id="${item.MaDonHang}" >
			   <td>${item.MaDonHang}</td>
			   <td>${item.NgayMua}</td>
			   <td>${item.MaTTLH}</td>			   
			   <td>${item.PhuongThucThanhToan}</td>
			   <td>${item.ThanhTien}</td>
			   <td>${item.TrangThai}</td>
			   <td><a href="chiTietDonHang.php?maDonHang=${item.MaDonHang}">Chi tiết</a></td>
		   </tr>`;
			})
		return s;
	}
</script>
<script src="js/Loc.js"></script>
	<script src="js/admin_script.js"></script>
</body>
</html>