<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");
require_once($_SESSION['application_path']."/controlador/smsController.php");
require_once($_SESSION['application_path']."/controlador/emailController.php");

$table = $_POST['t'];
$email = $_POST['u'];
$sendType = $_POST['sendway'];

$_smsController = new smsController();
$_userController = new userController();
$_mailController = new emailController();
$hashActivationCode = $_smsController->generateCodeSms(6);
if($sendType=='phone'){
    $_smsController->createClientSms();
}
$_result = $_userController->getCustomer($email);
if(is_array($_result) or is_object($_result)){
    $phoneNumber = $_result['Phone'];

    if($sendType=='phone'){
        $_mail_response = $_smsController->sendMessage("+18889811812",'+1'.$arrayCustomer['customerPhoneNumber'],"Thank you for registering at RoofServiceNow.com, your verification code is: $hashActivationCode");
    }else{
        $
        $_mail_response = $_mailController->sendMailSMTP($toAddress,"Validation Code","Thank you for registering at RoofServiceNow.com, your verification code is: $hashActivationCode","","");
    }
    $_message=array(
        'title'=>"Register Customer",
        'subtitle'=>"Validation Code",
        'content'=>"A new validation code, was sent to your phone, please check and type it, to terminate registration ".$_mail_response,
    );
//return  "OK ".$_response."<br>".$_mail_response;
}else{
    $_message=array(
        'title'=>"Register Customer",
        'subtitle'=>"Validation Code",
        'content'=>"The user was no found, ".$_result,
    );
}
print_r(json_encode($_message));
?>