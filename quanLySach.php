<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin | Sản phẩm</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/bootstrap.css">
	<style>
		table
		{
			font-size: 20px;
			text-align: center;
		}
		#menu-loc
		{
			font-size: 20px;
		}
				
				
	</style>

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->
<div class="container">
	<h1 class="title">Tất cả sách</h1>	
	<a href="ChinhSuaSach.php" class="btn btn-danger">Thêm sách</a>
	<a href="QuanLyLoaiSach.php" class="btn delete-btn">Danh mục loại sách</a>
	<center>		
		<div id="menu-loc">
			 <input type="checkbox" checked name="showAll" id="loc0" class="showAll" value="All" /> <label for="loc0">Tất cả </label>
				<input type="checkbox" checked name="loc" id="loc1" class="loc" value="1"/> <label for="loc1">Còn nhiều hàng</label>
				<input type="checkbox" checked name="loc" id="loc2" class="loc" value="0" /> <label for="loc2">Sắp hết hàng</label>
				<input type="checkbox" checked name="loc" id="loc3" class="loc" value="-1" /> <label for="loc3">Hết hàng</label>
				<input type="search" id="timkiem" maxlength="50" style="height: 40px; width: 300px;" placeholder="Nhập tên sách để tìm kiếm" >	
		</div>
		<table class="table" cellspacing="40" >
			<tr>
				<th>Sách</th>
				<th>Tác giả</th>
				<th>Giá bán</th>
				<th>Số lượng tồn kho</th>
				<th ></th>
			</tr>
			<tbody id="tblsach">
			</tbody>
		</table>
		<h4 id="tb" hidden>Không tìm thấy dữ liệu theo yêu cầu</h4>
		<div>
			<ul class="pagination" id="pagination"></ul>
		</div>
	</center>
	</div>
<!-- show products  -->	
	<!-- <script src="js/Loc.js"></script> -->
	<script type="text/javascript" src="js/loadPhanTrang.js"></script>
	   <script type="text/javascript">
		  let vtPage=1;
		  LoadDatas(1)		   
		 function LoadDatas(page,nbPage)
		   {			      	
			let conHang = loc1.checked
			let sapHetHang = loc2.checked
			let hetHang = loc3.checked
		

			vtPage = page;  		   
		   $.post(BASE_URL+API_AUTHEN,{'action':'LoadPhanTrangLocSach','page':vtPage,'conHang':conHang,'sapHetHang':sapHetHang,'hetHang':hetHang,'txttimkiem':timkiem.value},function(data){
						var data = JSON.parse(data); 
						let s='';

						if(data.status==1)
						{
							tb.hidden = true;
							data.sach.forEach(item=>{
								s+=`<tr class="trangthai ${item.SoLuongTon == 0 ? "loc3": item.SoLuongTon <10 ? "loc2":"loc1" }"> <td><img width="150px;" src="uploaded_img/${item.HinhAnh}" alt=""><br><b>${item.TenSach}<b></td>
								<td>Tác giả</td>
								<td>${item.GiaBan.toLocaleString("de-DE")}đ</td>
								<td>${item.SoLuongTon}</td>
								<td><a href="ChinhSuaSach.php?masach=${item.MaSach}" class="option-btn">Cập nhật</a> <a id=""  class="delete-btn">Xóa</a></td></tr>`;
							})	
						}
						else
							tb.hidden = false;
						tblsach.innerHTML = s;						
			   //load nút phân trang
					let sl = data.numpages;	
			   		loadNutPhanTrang(sl,vtPage,pagination)																			 
					})
		}	
		document.querySelectorAll('.loc').forEach(loc=>{
			loc.addEventListener("click",()=>{							
				LoadDatas(1);				
			})
		});	   
		timkiem.addEventListener("input",()=>{
			LoadDatas(1);	
		})		   
	   </script>
<!-- custom admin js file link  -->
<!--<script src="js/admin_script.js"></script>-->

</body>
</html>