<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


function KhoiTaoMail()
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                    //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';  
        $mail->CharSet = 'utf-8';                   //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'Fackbookneww@gmail.com';                     //SMTP username
        $mail->Password   = 'wauxmkeidjdkbryf';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->setFrom('Fackbookneww@gmail.com', 'Fackbook');                       
        $mail->isHTML(true);                        
        return $mail;        
    } catch (Exception $e) {
       return null;
    }
}
function GuiMailThongBaoTinhTrang($mailNhan, $noidung)
{
    $mail = KhoiTaoMail();    
    $mail->addAddress($mailNhan);
    $mail->Subject = 'Thông báo tình trạng đơn hàng từ HORIZON';
    $mail->Body  = "<b>$noidung</b><br>
    <span>Vui lòng truy cập <a href='http:\\localhost/PHP/PHP_23_05_2023/project/'>trang web</a> của chúng tôi để biết thêm chi tiết</span>";
    if($mail==null)
        return false;    
    if($mail->send())
            return true;
    return false;    
}
// if(GuiMailXacNhan("itdotuankha@gmail.com","123213"))
// echo "đã gửi";
// else
// echo "chưa gửi";
?>
