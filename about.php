<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id']??"";

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Horizon | Về chúng tôi</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Về chúng tôi</h3>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>Tại sao chọn chúng tôi</h3>
         <p>Sách của chúng tôi hiểu bạn hơn sự hiểu biết của bạn về chính bạn. Một câu nói nổi tiếng của một học thuyết gia: "Người đọc sách chưa chắc thành công, nhưng người thành công chắc chắn đọc sách mỗi ngãy"</p>
         <p>Cảm ơn rất nhiều, những người bạn mới, những tri thức mới, chúng tôi mang đến cho bạn sự lựa chọn tốt nhất!</p>
         <a href="contact.php" class="btn">Gửi thắc mắc</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">Thành viên của chúng tôi</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/Chau.jpg" alt="">
         <p>Đẹp trai, tài năng, tư duy sáng tạo,...là những gì mà Phạm Minh Châu không có.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Phạm Minh Châu</h3>
      </div>

      <div class="box">
         <img src="images/Dat.jpg" alt="">
         <p>Đẹp trai, học giỏi, quê ở Bến Tre, xém có người yêu, thích cô Thảo dạy quốc phòng 4.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Lê Phát Đạt</h3>
      </div>

      <div class="box">
         <img src="images/Trung.jpg" alt="">
         <p>Đẹp trai, nghiện ngập, độc thân để tập trung học, và đây là năm thứ 21 Trung tập trung học.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Phạm Thành Trung</h3>
      </div>

      <div class="box">
         <img src="images/nyChau.jpg" alt="">
         <p>Xinh gái, nhà mặt phố, mẹ làm to, đang rất hạnh phúc vì được làm người yêu Phạm Minh Châu.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Trịnh Hồng Ngân</h3>
      </div>

      <div class="box">
         <img src="images/Hai.jpg" alt="">
         <p>Đẹp trai, vui tính, hacker từ Cà Mau, bản lĩnh thì có nhưng người yêu không cho là không được làm.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Vương Chí Hải</h3>
      </div>

      <div class="box">
         <img src="images/nyHai.jpg" alt="">
         <p>Xinh gái, dễ thương, người yêu của Vương Chí Hải, người mà Chí Hải rén hơn mẹ mình.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Trịnh Sông Hương</h3>
      </div>

   </div>

</section>







<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>