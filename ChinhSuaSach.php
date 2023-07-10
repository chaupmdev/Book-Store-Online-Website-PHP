<?php

include 'Api/connection.php';

//session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_GET["masach"]))
{	
	$maSach = getGET("masach");
	$sach = executeResult("SELECT * FROM `sach` WHERE MaSach ='$maSach'",true);
}

if(isset($_POST['thaoTac'])){
   $thaoTac = getPOST("thaoTac");
   $tenSach = getPOST("tenSach");
   $maTheLoai = getPOST('maTheLoai');
   $tacGia = getPOST('tacGia');
   $nhaXuatBan = getPOST('nhaXuatBan');
   $soTrang = getPOST('soTrang');
   $giaBan = getPOST('giaBan');
   $soLuongTon = getPOST('soLuongTon');
   $noiDungTQ = getPOST('noiDungTQ');	   
	   $anh = $_POST['tenAnh'];
	$chk = true;
	   if(strcasecmp($thaoTac,'Cập nhật')==0)
	   {		   
		   $ma = getPOST("maSachcn");
		   $sql = "UPDATE `sach` SET `TenSach`='$tenSach',`TacGia`='$tacGia',`SoTrang`='$soTrang',`GiaBan`='$giaBan',`SoLuongTon`='$soLuongTon',`MaTheLoai`='$maTheLoai',`MaNXB`='$nhaXuatBan',`HinhAnh`='$anh',`NoiDungTomTat`='$noiDungTQ' WHERE MaSach ='$ma'";
	   }
	   else
	   {
		   $select_chk_sach = executeResult("SELECT * FROM sach WHERE TenSach = '$tenSach'");	
		   if(count($select_chk_sach) > 0){				   
				$chk = false;
			  	$message[] = 'Tên sản phẩm không hợp lệ!';	   			   
		   }else{
			   $sl_sach = executeResult("SELECT count(*) as sl FROM sach",true);	   
			   $ma = "sach00".$sl_sach["sl"];
			   $sql ="INSERT INTO `sach`(`MaSach`, `TenSach`, `TacGia`, `SoTrang`, `GiaBan`, `SoLuongTon`, `MaTheLoai`, `MaNXB`, `HinhAnh`, `NoiDungTomTat`) VALUES ('$ma','$tenSach','$tacGia','$soTrang','$giaBan','$soLuongTon','$maTheLoai','$nhaXuatBan','$anh','$noiDungTQ')";
	   }
	   }
	   try
	   {	if($chk)
	   {
      		$add_sach_query = execute($sql);
		   if($_FILES['anh']!=null)
		   {
			   $anh = $_FILES['anh']['name'];
			   $image_size = $_FILES['anh']['size'];
			   $image_tmp_name = $_FILES['anh']['tmp_name'];
			   $image_folder = 'uploaded_img/'.$anh;
      			move_uploaded_file($image_tmp_name, $image_folder);		
		   }
            	$message[] = 'Cập nhật thành công!';		   
	   }
       }
	   catch (Exception $e)
	   {
         $message[] = 'Cập nhật thất bại!';      
	   }	   
}

//if(isset($_GET['delete'])){
//   $delete_id = $_GET['delete'];
//   $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
//   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
//   unlink('uploaded_img/'.$fetch_delete_image['image']);
//   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
//   header('location:admin_products.php');
//}

//if(isset($_POST['update_product'])){
//
//   $update_p_id = $_POST['update_p_id'];
//   $update_name = $_POST['update_name'];
//   $update_price = $_POST['update_price'];
//
//   mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');
//
//   $update_image = $_FILES['update_image']['name'];
//   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
//   $update_image_size = $_FILES['update_image']['size'];
//   $update_folder = 'uploaded_img/'.$update_image;
//   $update_old_image = $_POST['update_old_image'];
//
//   if(!empty($update_image)){
//      if($update_image_size > 2000000){
//         $message[] = 'Kích thước ảnh quá lớn!';
//      }else{
//         mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
//         move_uploaded_file($update_image_tmp_name, $update_folder);
//         unlink('uploaded_img/'.$update_old_image);
//      }
//   }
//
//   header('location:admin_products.php');
//
//}
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
   <link rel="stylesheet" href="css/style.css">

   <!-- custom admin css file link  -->
<style>

	.box.text{
		max-width: 100%;
		min-width: 100%;
		min-height: 200px;
		max-height: 600px;
		word-break: break-all;
	}
	</style>
</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

   <h1 class="title">Thêm sách</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Thêm sản phẩm</h3>
	   <span>Chọn thể loại: </span><select name="maTheLoai" class="select" id="theloai" title="chọn thể loại"></select>
	   <input type="text" style="display: none" name="maSachcn" value="<?php echo isset($maSach) ? $maSach : '' ?>">
      <input type="text" name="tenSach" value="<?php echo isset($sach) ? $sach["TenSach"] :'' ?>" class="box" placeholder="Nhập tên sách..." required>
	   <input type="text" name="tacGia" value="<?php echo isset($sach) ? $sach["TacGia"] :'' ?>" class="box" placeholder="Nhập tác giả" required>
	   <input type="text" name="nhaXuatBan" value="<?php echo isset($sach) ? $sach["MaNXB"] :'' ?>" class="box" placeholder="Nhập nhà xuất bản" required>
	   <input type="text" name="soTrang" value="<?php echo isset($sach) ? $sach["SoTrang"] :'' ?>" class="box" placeholder="Nhập số trang" required>
      <input type="text" name="giaBan" value="<?php echo isset($sach) ? $sach["GiaBan"] :'' ?>" name="gia" class="box number" placeholder="Nhập giá bán" required>
	   <input type="text" name="soLuongTon" value="<?php echo isset($sach) ? $sach["SoLuongTon"] :'' ?>"  name="soLuongTon" class="box number" placeholder="Nhập số lượng tồn" required>	   	   
	   <input type="file"  class="box" accept="image/jpg, image/jpeg, image/png" name="anh" capture="camera" id="imageInput" <?php echo !isset($maSach) ? 'required':'' ?>>
	   <input style="display: none" type="text" name="tenAnh" value="<?php echo isset($sach) ? $sach["HinhAnh"] :'' ?>"id="image">
	  <textarea class="box text"  name="noiDungTQ" placeholder="Nhập nội dung tổng quát" required><?php echo isset($sach) ? $sach["NoiDungTomTat"] :'' ?></textarea><br>
      <input type="submit" value="<?php echo isset($maSach) ? 'Cập nhật': 'Thêm sách' ?>" name="thaoTac" class="btn">	
   </form>
	<img style="width: 300px;" id="previewImage" src="uploaded_img/<?php echo isset($sach) ? $sach["HinhAnh"] :'' ?>" alt="ảnh sách">
</section>

	
	
	
	<script type="text/javascript" src="js/kiemTraChuoiSo.js"></script>
	
	<script>
		$.post(BASE_URL+API_AUTHEN,{'action':AUTHEN_VALUES,'tblName':'theloaisach'},function(data){
			var data = JSON.parse(data); 
			let s='<select>';
			data["theloaisach"].forEach(item=>{
				s+=`<option value="${item.MaTheLoai}" >${item["TenTheLoai"]}</option>`;
			})
			theloai.innerHTML =s;
		})
			
	</script>
<!-- product CRUD section ends -->

<!-- show products  -->
<!-- custom admin js file link  -->
<!--<script src="js/admin_script.js"></script>-->
<script src="js/editImg.js"></script>
</body>
</html>