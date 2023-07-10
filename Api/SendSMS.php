<?php


require_once __DIR__ . '/twilio-sms-master/vendor/autoload.php';

use App\SmsSender;
use Twilio\Rest\Client;

function GuiTinNhanSMS($soDienThoai,$noiDung)
{
    try
    {
        $sid          = 'AC9d38d96bb199ec6185c4ea7cf6b1407e';
        $token        = '47623bce8e92f2a2df83475160af9ea3';
        $twilioNumber = '+12707169113';

        $twilioClient = new Client($sid, $token);
        $sender       = new SmsSender($twilioClient);

        $to      = '+84'.$soDienThoai;
        $payload = [
            'from' => $twilioNumber,
            'body' => $noiDung.' - '. uniqid('hsjs', true),
        ];

        $sender($to, $payload);
        return true;
    }
    catch(Exception $e)
    {
        return false;
    }
}
?>


