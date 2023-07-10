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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
<!--   <link rel="stylesheet" href="css/style.css">-->
<style>
		#trangthai,
		.box-container{
			font-size: 20px;
		}
	</style>
</head>
<body>
   
<?php include 'admin_header.php'; ?>
	

<div class="heading">
<center><h1>ĐƠN HÀNG</h3></center>
</div>
<div class="box-container">
	<div class="info" id="info">
		<center>
			<div>
				<div >
					<span>Mã đơn hàng: <span id="madonhang"></span></span><br>
					<span>Ngày mua: <span id="ngaymua"></span></span><br>
					<span>Mã Voucher: <span id="mavouvher"></span></span><br>
					<span>Phương thức giao hàng: <span id="loaigiaohang"></span></span><br>
					<span>Phương thức thanh toán: <span id="ppthanhtoan"></span></span><br>
					<span>Thành tiền: <span id="thanhtien"></span>đ</span><br>
					<span>Ghi chú: <span id="ghichu"></span></span><br>
				</div>
				<div >
					<center><b>Thông tin người nhận</b></center><br>
					<span>Tài khoản: <span id="taikhoan"></span></span><br>
					<span>Họ tên người nhận: <span id="hoten"></span> | </span><span id="sdt"></span><br>
					<span>Địa chỉ: <span id="diachi"></span></span><br>
					<span id="dccuthe"></span>
				</div>			
				<button style="cursor: pointer" class="option-btn" id="trangthai" title="click vào đây để chuyển trạng thái"></button>
				<button style="cursor: pointer;display: none;" class="delete-btn" id="tuchoidonhang">Từ chối</button>
			</div>
		</center>
	</div>
   <div><br>
	  <center>
		  <h3>Chi tiết đơn hàng</h3>		  
	   <table class="table" cellspacing="20">
		   <tr>
			   <th>Sách</th>
			   <th>Giá bán</th>
			   <th>Số lượng</th>
			   <th>Tổng tiền</th>			   
		   </tr>		   
		   <tbody id="chiTietDonHang">
		   </tbody>

	   </table>		  
	</center>
	</div>
</div>
<script src="js/config2.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
	<script type="text/javascript">
	const chiTietDonHang = document.getElementById('chiTietDonHang');
	const trangthai = document.getElementById('trangthai');
	$.post(BASE_URL+API_AUTHEN,{'action':AUTHEN_CTDHS,
								'maDonHang':'<?php echo $_GET["maDonHang"] ?>'
							   },function(data){			
		var data = JSON.parse(data);
		if(data.status ==-1)
			{
				document.getElementById('info').innerHTML = data.msg;
				return;
			}
		var dh = data.donhang;
		
		document.getElementById('madonhang').innerHTML=dh.MaDonHang;
		document.getElementById('ngaymua').innerHTML=dh.NgayMua;
		document.getElementById('mavouvher').innerHTML=dh.MaVoucher;
		document.getElementById('loaigiaohang').innerHTML=dh.TenLoaiGH;
		document.getElementById('ppthanhtoan').innerHTML=dh.PhuongThucThanhToan;
		document.getElementById('thanhtien').innerHTML=dh.ThanhTien.toLocaleString('de-DE');
		document.getElementById('ghichu').innerHTML=dh.GhiChu;
		document.getElementById('taikhoan').innerHTML=dh.HoTen;
		document.getElementById('sdt').innerHTML=dh.SDT;
		document.getElementById('diachi').innerHTML=dh.DiaChi;
		document.getElementById('dccuthe').innerHTML=dh.DiaChiCuThe;
		trangthai.innerHTML=dh.TrangThai.trim();
		console.log(dh.TrangThai);
		if(dh.TrangThai.trim()=="Đang xử lý"||dh.TrangThai.trim()=="Chờ xác nhận")	
			loadNutHuy();		
		let s =``;		
		data.chitietdonhang.forEach(item =>{
		s+=`<tr>
			<td><center>
				<img style="width: 100px; height: 100px;" src="uploaded_img/${item.HinhAnh}"><br>
				<b>${item.TenSach}</b>
				</center>
			</td>			   
		   <td>${item.GiaBan}</td>
		    <td>${item.SoLuong}</td>
		    <td>${item.TongTien}</td>
		   </tr>`;
		});
		chiTietDonHang.innerHTML =s;
	} )
		trangthai.addEventListener("click",function(){					
			if(trangthai.innerHTML!="Đã hủy" && trangthai.innerHTML!="Đã giao")
				{			
					trangthai.disabled = true;		
					handleCreateToast("info","Đang xử lý thao tác của bạn");
					$.post(BASE_URL+API_AUTHEN,{'action':AUTHEN_CAPNHATTRANGTHAI,
								'maDonHang':'<?php echo $_GET["maDonHang"] ?>',
								'trangthai':`${trangthai.innerHTML}`
							   },function(data){	
						data = JSON.parse(data)
						if(data.status == 1)	
						{
							handleCreateToast("success","Cập nhật trạng thái đơn hàng thành công");											
								trangthai.innerHTML = data.trangthai;		
							if(data.TrangThai!="Đang xử Lý")
							{
								tuchoidonhang.style.display = 'none';
							}
						}
						else
							handleCreateToast("error","Đã xảy ra lỗi, vui lòng thử lại");	
						
						trangthai.disabled = false;									
							
					});
				}
			else
				handleCreateToast("warning","Không thể cập nhật trạng thái đơn hàng "+trangthai.innerHTML,'w1');
		})
function loadNutHuy()
{
	console.log("lsdkfdkjsfdsdsfdsf");
	tuchoidonhang.style.display = 'block';
			tuchoidonhang.addEventListener("click",()=>{
				tuchoidonhang.disabled = true;
				handleCreateToast("info","Đang xử lý thao tác của bạn");
				$.post(BASE_URL+API_AUTHEN,{'action':'TuChoiDonHang',
								'maDonHang':'<?php echo $_GET["maDonHang"]?>'
								,'trangThai' : `${trangthai.innerHTML}` 
							   },function(data){	
						data = JSON.parse(data)
						if(data.status == 1)														
						{
							handleCreateToast("success","Cập thật thông tin thành công")
							trangthai.innerHTML = data.trangthai;
							tuchoidonhang.hidden = true;
							tuchoidonhang.style.display = 'none';	
						}	
						else
							handleCreateToast("error","Đã xảy ra lỗi, vui lòng thử lại");		
						tuchoidonhang.disabled = false;																	
							
					});
			});
}
</script>

</html>