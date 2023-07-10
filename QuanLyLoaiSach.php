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
   <center><h1>Danh sách thể loại sách</h3></center>
</div>
<div class="box-container">
<a href="CapNhatTheLoaiSach.php" class="btn insert-btn ">Thêm mới</a>

   <div>
	   <center>
	   <table class="table" cellspacing="20">
		   <tr>
			   <th>Mã thể loại</th>
			   <th>Ten thể loại</th>			   
			   <th></th>
		   </tr>
		   <tbody  id="dsTheLoai">
            
		   </tbody>
	   </table>		   
		   </center>
	</div>
	
</div>


<!-- custom js file link  -->

<script type="text/javascript">
	const dsTheLoai = document.getElementById('dsTheLoai');
	$.post(BASE_URL+API_AUTHEN,{'action':'TheLoaiSach'},function(data){			
		var data = JSON.parse(data);
        dsTheLoai.innerHTML = doDuLieuTheLoaiSach(data);
	} )
function doDuLieuTheLoaiSach(data)
	{
		if(data.status == -1)
			return data.msg;
		let s ='';		
		data.data.forEach(item =>{
			s+=`<tr id = ${item.SoLuongSach} >
			   <td>${item.MaTheLoai}</td>
			   <td>${item.TenTheLoai}</td>               
               <td><a href="CapNhatTheLoaiSach.php?maTheLoai=${item.MaTheLoai}&tenTheLoai=${item.TenTheLoai}" class="btn update-btn">Sửa</a><button onclick="XoaTheLoai('${item.MaTheLoai}','${item.TenTheLoai}')"  class = "delete-btn">Xóa</button></td>
		   </tr>`;
			})
		return s;
	}
    function XoaTheLoai(maTL,ten)
    {
        
        $.post(BASE_URL+API_AUTHEN,{'action':'XoaTheLoai','maTheLoai':maTL},function(data){			
		var data = JSON.parse(data);
        if(data.status==1)
        {            
            handleCreateToast("success","Xóa thể loại thành công");
            document.getElementById(maTL).remove();
        }
        else
            handleCreateToast("info",data.msg);
	} )
    }
</script>
	<script src="js/admin_script.js"></script>
</body>
</html>