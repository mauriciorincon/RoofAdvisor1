<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");
require_once($_SESSION['application_path']."/controlador/smsController.php");
require_once($_SESSION['application_path']."/controlador/emailController.php");
require_once($_SESSION['application_path']."/modelo/user.class.php");

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
    $email = $_result['Email'];
    
    if($sendType=='phone'){
        $_mail_response = $_smsController->sendMessage("+18889811812",'+1'.$phoneNumber,
        "Thank you for registering. To verify your account, please enter the verification code: Verification code: 
            $hashActivationCode  This code expires in 10 minutes. To prevent fraud, if this code is not entered before it expires, the
        registration will be blocked.");
    }else{
        $
        $_mail_response = $_mailController->sendMailSMTP($email,"Validation Code","Thank you for registering. 
        To verify your account, please enter the verification code:<br><br> Verification code: <strong> $hashActivationCode </strong><br><br>
        This code expires in 10 minutes. To prevent fraud, if this code is not entered before it expires, the
        registration will be blocked.","","");
    }
    $user = $_result['uid'];
    $_userModel = new userModel();
    $properties = [
        'photoURL' => $hashActivationCode,
    ];
    $_result_update=$_userModel->updateUserCustomer($user,$properties,'customer');
    $_message=array(
        'title'=>"Register Customer",
        'subtitle'=>"Validation Code",
        'content'=>"A new validation code, was sent to your $sendType, please check and type it, to terminate registration ".$_mail_response,
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