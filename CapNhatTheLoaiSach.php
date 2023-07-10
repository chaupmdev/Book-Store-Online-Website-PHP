<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

// if(!isset($admin_id)){
//    header('location:login.php');
// };
if(isset($_GET["maTheLoai"]))
{
    $maTheLoai = $_GET["maTheLoai"];
    $tenTheLoai = $_GET["tenTheLoai"];
}
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

   <form >
      <h3>Thêm thể loại sách</h3>	   
      <label <?php echo empty($maTheLoai) ? 'hidden' : '' ?> for="maTheLoai">Mã thể loại</label>
      <input type="text"   name="maTheLoai" id="maTheLoai" <?php echo empty($maTheLoai) ? 'hidden' : 'disabled' ?> value="<?php echo !empty($maTheLoai) ? $maTheLoai : '' ?>" class="box" placeholder="Mã thể loại...">	   
      <label for="tenTheLoai">Tên thể loại</label>
      <input type="text" id="tenTheLoai" value="<?php echo !empty($maTheLoai) ? $tenTheLoai : '' ?>" class="box" placeholder="Nhập tên thể loại..." required>
      <a class="btn" id="capNhat" onclick="capNhatSach()"><?php echo !empty($maTheLoai) ? 'Cập nhật' : 'Thêm' ?></a>
</section>	
</body>
<?php
if(empty($maTheLoai))
{
    ?>
    <script>
            
        function capNhatSach()
        {
            if(tenTheLoai.value.trim()==null||tenTheLoai.value.trim()=="")
            {
                handleCreateToast("error","Tên thể loại không được để trống!!!","er1"); 
                return;
            }
            console.log("ádfkjsdhfd")
            $.post(BASE_URL+API_AUTHEN,{'action':"ThemTheLoai",'tenTheLoai':tenTheLoai.value },function(data){
            var data = JSON.parse(data);             
            if(data.status==1)
            {
                handleCreateToast(data.type,data.msg); 
                tenTheLoai.value = "";
                return;
            }      
            else
                handleCreateToast(data.type,data.msg,"er1");                     
            })
        }
        
    </script>
    <?php
}
else
{
    ?>
    <script>         
        function capNhatSach()
        {
            if(tenTheLoai.value.trim()==null||tenTheLoai.value.trim()=="")
            {
                handleCreateToast("error","Tên thể loại không được để trống!!!","er1"); 
                return;
            }
            $.post(BASE_URL+API_AUTHEN,{'action':"CapNhatTheLoai",'maTheLoai':'<?php echo $maTheLoai?>','tenTheLoai':tenTheLoai.value },function(data){
            var data = JSON.parse(data); 
             
            if(data.status==1)
            {
                handleCreateToast(data.type,data.msg);                 
                return;
            }
            else
                handleCreateToast(data.type,data.msg,"er1"); 
            })
        }
        
    </script>
    <?php
}
?>
</html>
