<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:dangnhap.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/admin_style.css">
   <title>Admin | Voucher </title>

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
   <center><h1>DANH SÁCH TẤT CẢ VOUCHER</h3></center>
</div>
<div class="box-container">
	
   <div>
	   <center>
		<!--  -->
	   <table class="table" cellspacing="20">
		<tr>
			
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							
						<form method="POST">
							<td><select id="locvoucher" name="cbb-loc-voucher">
                    			<option value="allvoucher">Tất cả Voucher</option>
								<option value="live">Đang diễn ra</option>
								<option value="past">Đã hết hạn</option>
								<option value="future">Sắp diễn ra</option>
							</select>
							</td>
							<td><button name="btn_loc" class="button_smoke">Lọc</button></td>
						</form>
			</tr>
		   <tr>
			   <th>Mã Voucher</th>
			   <th>Tên Voucher</th>
			   <th>Điều kiện</th>
			   <th>Tiền giảm</th>
			   <th>Ngày bắt đầu</th>
			   <th>Ngày kết thúc</th>
			   <th>Thao tác</th>
		   </tr>
		   <tbody id="dsDonHang">
		   
			<?php 
				$cou=0;
				if(!isset($_POST['btn_loc']))
				{
					$fetch_query = mysqli_query($conn, "SELECT * FROM `voucher`");
					
					while($fetch = mysqli_fetch_assoc($fetch_query))
					{
						?>
						<tr>
							<td><?php echo $fetch['MaVoucher']; ?></td>
							<td><?php echo $fetch['TenVoucher']; ?></td>
							<td><?php echo $fetch['DieuKien']; ?></td>
							<td><?php echo $fetch['TienGiam']; ?></td>
							<td><?php echo $fetch['NgayBD']; ?></td>
							<td><?php echo $fetch['NgayKT']; ?></td>
							<td>
							<form method="POST">
								<button name="btn_update" class="button_blue">Sửa</button>
								<button name="btn_delete" <?php echo strcasecmp($fetch['NgayKT'],"1900-01-01")==0 ? "hidden" : "3243"; ?> class="button_red">Ngừng</button>
								<input type="hidden" name="voucher" value="<?php echo $fetch['MaVoucher']; ?>">
							</form>
							</td>
						</tr>
						<?php
						$cou+=1;
					}
				}
				else{
					if($_POST['cbb-loc-voucher'] == "allvoucher")
					{
						$fetch_query = mysqli_query($conn, "SELECT * FROM `voucher`");
					
						while($fetch = mysqli_fetch_assoc($fetch_query))
						{
							?>
							<tr>
								<td><?php echo $fetch['MaVoucher']; ?></td>
								<td><?php echo $fetch['TenVoucher']; ?></td>
								<td><?php echo $fetch['DieuKien']; ?></td>
								<td><?php echo $fetch['TienGiam']; ?></td>
								<td><?php echo $fetch['NgayBD']; ?></td>
								<td><?php echo $fetch['NgayKT']; ?></td>
								<td>
								<form method="POST">
									<button name="btn_update" class="button_blue">Sửa</button>
									<button name="btn_delete" <?php echo strcasecmp($fetch['NgayKT'],"1900-01-01")==0 ? "hidden" : "3243"; ?> class="button_red">Ngừng</button>
									<input type="hidden" name="voucher" value="<?php echo $fetch['MaVoucher']; ?>">
								</form>
								</td>
							</tr>
							<?php
							$cou+=1;
						}
					}
					else if($_POST['cbb-loc-voucher'] == "live")
					{
						?>
							<script>
								locvoucher.selectedIndex=1;
							</script>
						<?php
						$today = date('y-m-d');
						$fetch_query = mysqli_query($conn, "SELECT * FROM `voucher` WHERE NgayBD<='$today' AND NgayKT>='$today'");
					
						while($fetch = mysqli_fetch_assoc($fetch_query))
						{
							?>
							<tr>
								<td><?php echo $fetch['MaVoucher']; ?></td>
								<td><?php echo $fetch['TenVoucher']; ?></td>
								<td><?php echo $fetch['DieuKien']; ?></td>
								<td><?php echo $fetch['TienGiam']; ?></td>
								<td><?php echo $fetch['NgayBD']; ?></td>
								<td><?php echo $fetch['NgayKT']; ?></td>
								<td>														
								
									<button name="btn_update" class="button_blue">Sửa</button>
									<button name="btn_delete" <?php echo strcasecmp($fetch['NgayKT'],"1900-01-01")==0 ? "hidden" : "3243"; ?> class="button_red">Ngừng</button>
									<input type="hidden" name="voucher" value="<?php echo $fetch['MaVoucher']; ?>">
								</form>
								</td>
							</tr>
							<?php
							$cou+=1;
						}
					}
					else if($_POST['cbb-loc-voucher'] == "past"){
						?>
							<script>
								locvoucher.selectedIndex=2;
							</script>
						<?php
						$today = date('y-m-d');
						$fetch_query = mysqli_query($conn, "SELECT * FROM `voucher` WHERE NgayBD<'$today' AND NgayKT<'$today'");
					
						while($fetch = mysqli_fetch_assoc($fetch_query))
						{
							?>
							<tr>
								<td><?php echo $fetch['MaVoucher']; ?></td>
								<td><?php echo $fetch['TenVoucher']; ?></td>
								<td><?php echo $fetch['DieuKien']; ?></td>
								<td><?php echo $fetch['TienGiam']; ?></td>
								<td><?php echo $fetch['NgayBD']; ?></td>
								<td><?php echo $fetch['NgayKT']; ?></td>
								<td>
								<form method="POST">
									<button name="btn_update" class="button_blue">Sửa</button>
									<button name="btn_delete" <?php echo strcasecmp($fetch['NgayKT'],"1900-01-01")==0 ? "hidden" : "3243"; ?> class="button_red">Ngừng</button>
									<input type="hidden" name="voucher" value="<?php echo $fetch['MaVoucher']; ?>">
								</form>
								</td>
							</tr>
							<?php
							$cou+=1;
						}
					}
					else{

						?>
							<script>
								locvoucher.selectedIndex=3;
							</script>
						<?php
						$today = date('y-m-d');
						$fetch_query = mysqli_query($conn, "SELECT * FROM `voucher` WHERE NgayBD>'$today' AND NgayKT>'$today'");
					
						while($fetch = mysqli_fetch_assoc($fetch_query))
						{
							?>
							<tr>
								<td><?php echo $fetch['MaVoucher']; ?></td>
								<td><?php echo $fetch['TenVoucher']; ?></td>
								<td><?php echo $fetch['DieuKien']; ?></td>
								<td><?php echo $fetch['TienGiam']; ?></td>
								<td><?php echo $fetch['NgayBD']; ?></td>
								<td><?php echo $fetch['NgayKT']; ?></td>
								<td>
								<form method="POST">
									<button name="btn_update" class="button_blue">Sửa</button>
									<button name="btn_delete" <?php echo strcasecmp($fetch['NgayKT'],"1900-01-01")==0 ? "hidden" : "3243"; ?> class="button_red">Ngừng</button>
									<input type="hidden" name="voucher" value="<?php echo $fetch['MaVoucher']; ?>">
								</form>
								</td>
							</tr>
							<?php
							$cou+=1;
						}
					}
				}
			?>
			<tr>
						<td>Tổng cộng: <span><?php echo $cou; ?></span></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><form method="POST"><button name="add-form-voucher" class="button_smoke" style="padding: 5px 18px;"><i class="fa fa-plus-circle" aria-hidden="true"></i>&ensp;Thêm</button></form></td>
			</tr>
			
		   </tbody>
	   </table>	
	   	   <!--  -->
		   </center>
	</div>

	<?php 
		if(isset($_POST['add-form-voucher']))
		{
	?>
	<div>
	   <center>
		<!--  -->
		<div class="div-thao-tac">
			<h4>Thông tin Voucher</h4>
			<table class="table" cellspacing="20">
				<form method="POST">
				<tr>
					<td>
						<h5>Mã Voucher:</h5>
						<input type="text" name="txt_mavc" placeholder="Nhập mã voucher...">
					</td>
					<td>
						<h5>Tên Voucher:</h5>
						<input type="text" name="txt_tenvc" placeholder="Nhập tên voucher..." style="width: 350px;">
					</td>
					<td>
						<h5>Điều kiện:</h5>
						<input type="number" name="txt_dieukienvc" placeholder="Tiền cần đạt...">
					</td>
					<td>
						<h5>Tiền giảm:</h5>
						<input type="number" name="txt_tiengiamvc" placeholder="Số tiền giảm...">
					</td>
				</tr>
				<tr>
					<td>
						<h5>Ngày bắt đầu:</h5>
						<input type="text" name="txt_bdvc" placeholder="Nhập ngày bắt đầu...">
					</td>
					<td>
						<h5>Ngày kết thúc:</h5>
						<input type="text" name="txt_ktvc" placeholder="Nhập ngày kết thúc...">
					</td>	
					<td></td>
						<td></td>						
				</tr>
				<tr>
				<td></td>
						<td></td>
				<td>
						<button class="button_smoke" style="background-color: white; border:1px solid gray; color:black; box-shadow: none;">Hủy</button>
					</td>
					<td>
						<button name="add-voucher" class="button_smoke">Thêm</button>						
					</td>
				</tr>
				</form>
			</table>
			
		</div>
	   	   <!--  -->
		   </center>
	</div>
	<?php } ?>

	<?php 
		if(isset($_POST['btn_update']))
		{
			$id= $_POST['voucher'];
			$select_products = mysqli_query($conn, "SELECT * FROM `voucher` WHERE MaVoucher='$id'") or die('query failed');
			$fet = mysqli_fetch_assoc($select_products);
	?>
	<div>
	   <center>
		<!--  -->
		<div class="div-thao-tac">
			<h4>Thông tin Voucher</h4>
			<table class="table" cellspacing="20">
				<form method="POST">
				<tr>
					<td>
						<h5>Mã Voucher:</h5>
						<input type="text" name="txt_mavc" readonly="true" value="<?php echo $id; ?>">
					</td>
					<td>
						<h5>Tên Voucher:</h5>
						<input type="text" name="txt_tenvc" value="<?php echo $fet['TenVoucher']; ?>" style="width: 350px;">
					</td>
					<td>
						<h5>Điều kiện:</h5>
						<input type="number" name="txt_dieukienvc" value="<?php echo $fet['DieuKien']; ?>">
					</td>
					<td>
						<h5>Tiền giảm:</h5>
						<input type="number" name="txt_tiengiamvc" value="<?php echo $fet['TienGiam']; ?>">
					</td>
				</tr>
				<tr>
					<td>
						<h5>Ngày bắt đầu:</h5>
						<input type="text" name="txt_bdvc" value="<?php echo $fet['NgayBD']; ?>">
					</td>
					<td>
						<h5>Ngày kết thúc:</h5>
						<input type="text" name="txt_ktvc" value="<?php echo $fet['NgayKT']; ?>">
					</td>	
					<td></td>
						<td></td>						
				</tr>
				<tr>
				<td></td>
						<td></td>
				<td>
						<button class="button_smoke" style="background-color: white; border:1px solid gray; color:black; box-shadow: none;">Hủy</button>
					</td>
					<td>
						<button name="save-voucher" class="button_smoke">Lưu</button>						
					</td>
				</tr>
				</form>
			</table>
			
		</div>
	   	   <!--  -->
		   </center>
	</div>
	<?php } ?>
	
</div>


<!-- custom js file link  -->

	<script src="js/admin_script.js"></script>
</body>
</html>

<?php
	if(isset($_POST['add-voucher']))
	{
		if($_POST['txt_mavc'] == "" || $_POST['txt_tenvc'] == ""|| $_POST['txt_dieukienvc'] == ""|| $_POST['txt_tiengiamvc'] == ""|| $_POST['txt_bdvc'] == ""|| $_POST['txt_ktvc'] == "")
		{
			echo '<script>window.alert("Thiếu thông tin thêm thất bại!")</script>';						
		}
		else
		{
			if(isExitsPKVvoucher($_POST['txt_mavc']))
			{
				echo '<script>window.alert("Mã voucher đã tồn tại!")</script>';
			}
			else{
				$mavc =$_POST['txt_mavc'];$tenvc = $_POST['txt_tenvc'];$dkvc=$_POST['txt_dieukienvc'];$ggvc=$_POST['txt_tiengiamvc'];$dayBD=$_POST['txt_bdvc'];$dayKT=$_POST['txt_ktvc'];
				$select_products = mysqli_query($conn, "INSERT INTO `voucher` VALUES('$mavc','$tenvc',$dkvc,$ggvc,'$dayBD','$dayKT')") or die('query failed');
				echo '<script>window.alert("Tạo thành công!")</script>';
			}
		}
	}

	function isExitsPKVvoucher($pk)
	{
		$conn = mysqli_connect('localhost','root','','phphorizon', 3301) or die('connection failed');
        $select_products = mysqli_query($conn, "SELECT * FROM `voucher` WHERE MaVoucher='$pk'") or die('query failed');
		return (mysqli_num_rows($select_products)>0)?true:false;
	}
	if(isset($_POST['btn_delete']))
	{
		$id= $_POST['voucher'];
		$select_products = mysqli_query($conn, "UPDATE `voucher` set NgayBD='1900-01-01', NgayKT='1900-01-01' WHERE MaVoucher='$id'") or die('query failed');
		echo '<script>window.alert("Đã ngừng hoạt động voucher!")</script>';
	}

	if(isset($_POST['save-voucher']))
	{
		if($_POST['txt_mavc'] == "" || $_POST['txt_tenvc'] == ""|| $_POST['txt_dieukienvc'] == ""|| $_POST['txt_tiengiamvc'] == ""|| $_POST['txt_bdvc'] == ""|| $_POST['txt_ktvc'] == "")
		{
			echo '<script>window.alert("Thiếu thông tin thêm thất bại!")</script>';						
		}
		else{
			$mavc =$_POST['txt_mavc'];$tenvc = $_POST['txt_tenvc'];$dkvc=$_POST['txt_dieukienvc'];$ggvc=$_POST['txt_tiengiamvc'];$dayBD=$_POST['txt_bdvc'];$dayKT=$_POST['txt_ktvc'];
			$select_products = mysqli_query($conn, "UPDATE `voucher` set TenVoucher='$tenvc',DieuKien=$dkvc,TienGiam=$ggvc, NgayBD='$dayBD', NgayKT='$dayKT' WHERE MaVoucher='$mavc'") or die('query failed');
			echo '<script>window.alert("Cập nhật thông tin thành công!")</script>';
		}
	}
?>