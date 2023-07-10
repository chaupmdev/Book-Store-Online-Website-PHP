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
   <title>Admin | Tài khoản</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/bootstrap.css">
<style>
	.container{
		font-size: 18px;
	}
	</style>
</head>
<body>
   
<?php include 'admin_header.php'; ?>

   <h1 class="title"> Tất cả tài khoản </h1>

   <div class="container">
	   <div id="menu-loc">
			 <input type="checkbox" checked name="showAll" id="loc0" class="showAll" value="All" /> <label for="loc0">Tất cả </label>
				<input type="checkbox" checked name="loc" id="admin" class="loc" value="1"/> <label for="admin">Admin</label>
				<input type="checkbox" checked name="loc" id="user" class="loc" value="0" /> <label for="user">User</label>
				<input type="checkbox" checked name="loc" id="khoa0" class="loc" value="-1" /> <label for="khoa0">Bị khóa</label>		  		
		   		<input type="checkbox" checked name="loc" id="khoa1" class="loc" value="-1" /> <label for="khoa1">Không khóa</label>
				<input type="search" id="timkiem" maxlength="30" style="height: 40px; width: 300px;" placeholder="Nhập tên sách để tìm kiếm" >	
				<a style="float: right;" class="btn update_btn" href="taoTaiKhoanAdmin.php">Thêm admin</a>
		</div>
     <table class="table">
		 <tr>
			 <th>Mã tài khoản</th>
			 <th>Tên đăng nhập</th>
			 <th>Họ tên</th>
			 <th>Email</th>
			 <th>Quyền</th>
			 <th>Trạng thái</th>
			 <th></th>
		 </tr>
		 <tbody id="dstaikhoan"></tbody>			   
	   </table>
	   <ul class="pagination" id="pagination"></ul>
   </div>
	
	<script src="js/Loc.js"></script>
	<script type="text/javascript" src="js/loadPhanTrang.js"></script>
	   <script type="text/javascript">
		  let vtPage= <?php echo isset($_GET["page"]) ? $_GET["page"] : 1 ?>;
		  LoadDatas(vtPage)		   
		 function LoadDatas(page,nbPage)
		   {			      			   
			vtPage = page;  		   
		   $.post(BASE_URL+API_AUTHEN,{'action':AUTHEN_VALUES_PHANTRANG,'tblname':'taikhoan','page':vtPage},function(data){
						var data = JSON.parse(data); 
						let s='';
						data.taikhoan.forEach(item=>{
							s+=`<tr id="${item.MaTaiKhoan}" class="trangthai ${item.MaQuyen} khoa${item.BiKhoa}"> <td>${item.MaTaiKhoan}</td>
							<td>${item.TenDangNhap}</td>
							<td>${item.HoTen}</td>
							<td>${item.Email}</td>
							<td>${item.MaQuyen}</td>							
							<td class="trangthai" >${item.BiKhoa == 1 ? 'Khóa':''}</td><td class="thaotac">`;
							if(item.BiKhoa == 1)
								s+=`<a onClick="capNhatTrangThaiTaiKhoan('${item.MaTaiKhoan}',0)" class=" option-btn">Mở khóa</a> `;
							else
								s+=`<a  onClick="capNhatTrangThaiTaiKhoan('${item.MaTaiKhoan}',1)" class=" option-btn">Khóa</a> `;
							s+=` <a onClick="xoaTaiKhoan('${item.MaTaiKhoan}')" id="" class="delete-btn">Xóa</a></td></tr>`;
						})			   
						dstaikhoan.innerHTML = s;
			   //load nút phân trang
					let sl = data.numpages;	
			   		loadNutPhanTrang(sl,vtPage,pagination)																			 
					})
			loc0.checked =true;
			locs.forEach(loc => loc.checked = true)
		}		   		   
		  function capNhatTrangThaiTaiKhoan(mataikhoan,trangthai)
		   {
			    $.post(BASE_URL+API_AUTHEN,{'action':AUTHEN_TRANGTHAITAIKHOAN,'mataikhoan':mataikhoan,'trangthai':trangthai},function(data){
					var data = JSON.parse(data); 
					handleCreateToast(data.type,data.msg); 					
					if(data.status == 1)
					{
						let trangThai = document.getElementById(mataikhoan).querySelector('.trangthai');
						let thaotac = document.getElementById(mataikhoan).querySelector('.thaotac');
						trangThai.innerHTML = (trangthai==1?"Khóa":"");
						s="";
						if(trangthai == 0)						
							s =`<a onClick="capNhatTrangThaiTaiKhoan('${mataikhoan}',1)" class=" option-btn">Khóa</a> `;		
						else
							s =`<a onClick="capNhatTrangThaiTaiKhoan('${mataikhoan}',0)" class=" option-btn">Mở khóa</a> `;
						thaotac.innerHTML = s+` <a onClick="xoaTaiKhoan('${mataikhoan}')" id="" class="delete-btn">Xóa</a></td></tr>`;
						
					}
						
				})
		   }
		   function xoaTaiKhoan(mataikhoan)
		   {
			   $.post(BASE_URL+API_AUTHEN,{'action':AUTHEN_XOATAIKHOAN,'mataikhoan':mataikhoan},function(data){
					var data = JSON.parse(data); 
					handleCreateToast(data.type,data.msg,`'${mataikhoan}'`); 					
					if(data.status == 1)
						document.getElementById(mataikhoan).remove();																
				})
		   }
	   </script>









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>