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
$table1 = "";

$_smsController = new smsController();
$_userController = new userController();
$_mailController = new emailController();
$hashActivationCode = $_smsController->generateCodeSms(6);
if($sendType=='phone'){
    $_smsController->createClientSms();
}
switch($table){
    case "c":
        $_result = $_userController->getCustomer($email);
        $table1="customer";
        break;
    case "co":
        $_result = $_userController->getCompanyE($email);   
        $table1="company";
        break;
}

if(is_array($_result) or is_object($_result)){
    switch($table){
        case "c":
            $phoneNumber = $_result['Phone'];
            $email = $_result['Email'];
            break;
        case "co":
            $phoneNumber = $_result['CompanyPhone'];
            $email = $_result['CompanyEmail'];
            break;
    }
    
    
    if($sendType=='phone'){
        $_mail_response = $_smsController->sendMessage("+18889811812",'+1'.$phoneNumber,
        "Thank you for registering. To verify your account, please enter the verification code: Verification code: 
            $hashActivationCode  This code expires in 10 minutes. ");
    }else{
        $_mail_response = $_mailController->sendMailSMTP($email,"Validation Code","Thank you for registering. 
        To verify your account, please enter the verification code:<br><br> Verification code: <strong> $hashActivationCode </strong><br><br>
        This code expires in 10 minutes. ","","");
    }
    $user = $_result['uid'];
    $_userModel = new userModel();
    $properties = [
        'photoURL' => $hashActivationCode,
    ];
    
    $_result_update=$_userModel->updateUserCustomer($user,$properties,$table1);
    switch($table){
        case "c":
            $_string_message = '<div class="alert alert-success">Registration success<br>A new validation code, was sent to your '.$sendType.', please check and type it, to complete registration <br>Your registration phone:<a href="#" onclick="setDataChangePhoneMail(\''. $email .'\',\''.$table.'\',\''. $phoneNumber .'\',\'phone\')">'. $phoneNumber .'</a><br>Your registration email:<a href="#" onclick="setDataChangePhoneMail(\''. $email .'\',\''.$table.'\',\''. $email .'\',\'email\')">'. $email .'</a></div><br>'.
            '<h4>Type your activation code</h4><input type="text" id="activation_code_input" />'.
            '<br><br><strong>Did not get a code?</strong>'.
            '<button type="button" id="resendCode" class="btn-primary btn-sm" onclick="resendValidationCode(\'' . $email . '\',\'\',\'phone\',\''.$table.'\')">Resend Code</button>'.
            '<a href="#" class="btn-primary btn-sm" onclick="resendValidationCode(\'' . $email .  '\',\'\',\'mail\',\''.$table.'\')">SEND ME THE VALIDATION CODE BY EMAIL</a>';
            $_string_button = '<br><br>                                                                                  
            <div class="alert alert-warning" role="alert">
                <center><button type="button" id="lastFinishButtonOrder" class="btn-success btn-lg"  onclick="validate_sms_code(\''.$table.'\',\''. $email .'\')">Validate Code</button></center>
            </div>';
            break;
        case "co":
            $_string_message = '<div class="alert alert-success">Registration success<br>A new validation code, was sent to your '.$sendType.', please check and type it, to complete registration <br>Your registration phone:<a href="#" onclick="setDataChangePhoneMail(\''. $email .'\',\''.$table.'\',\''. $phoneNumber .'\',\'phone\')">'. $phoneNumber .'</a><br>Your registration email:<a href="#" onclick="setDataChangePhoneMail(\''. $email .'\',\''.$table.'\',\''. $email .'\',\'email\')">'.$email .'</a></div><br>'.
            '<h4>Type your activation code</h4><input type="text" id="activation_code_input" />'.
            '<br><br><strong>Did not get a code?</strong>'.
            '<button type="button" id="resendCode" class="btn-primary btn-sm" onclick="resendValidationCode(\'' . $email  . '\',\'\',\'phone\',\''.$table.'\')">Resend Code</button>'.
            '<a href="#" class="btn-primary btn-sm" onclick="resendValidationCode(\'' . $email  .  '\',\'\',\'mail\',\''.$table.'\')">SEND ME THE VALIDATION CODE BY EMAIL</a>';
            $_string_button = '<br><br>                                       
            <div class="alert alert-warning" role="alert">
                <center><button type="button" id="lastFinishButtonOrder" class="btn-success btn-lg" onclick="validate_sms_code(\''.$table.'\',\''. $email .'\')">Validate Code</button></center>
            </div>';
            break;
    }
    $_message=array(
        'title'=>"Register $table1",
        'subtitle'=>'<div class="alert alert-success">A new validation code, was sent to your '.$sendType.', please check and type it, to complete registration </div>',
        'content'=>$_string_message,
        'button' =>$_string_button,
        'extra' =>$_result_update,
    );
    
}else{        
    $_string_message = '<div class="alert alert-danger"><strong>Error register '.$table1.' user was not found</strong><br>Your registration phone:<a href="#" onclick="setDataChangePhoneMail(\''. $email .'\',\''.$table.'\',\''. $phoneNumber .'\',\'phone\')" >'. $phoneNumber .'</a><br>Your registration email:<a href="#" onclick="setDataChangePhoneMail(\''. $email .'\',\''.$table.'\',\''. $email .'\',\'email\')">'. $email .'</a></div>'.
        '<h4>Type your activation code</h4><input type="text" id="activation_code_input" />'.
        '<br><br><strong>Did not get a code?</strong>'.
        '<button type="button" id="resendCode" class="btn-primary btn-sm" onclick="resendValidationCode(\'' . $email  . '\',\'\',\'phone\',\''.$table.'\')">Resend Code</button>'.
        '<a href="#" class="btn-primary btn-sm" onclick="resendValidationCode(\'' . $email  .  '\',\'\',\'mail\',\'co\')">SEND ME THE VALIDATION CODE BY EMAIL</a>';
    $_string_button = '<br><br>                                       
        <div class="alert alert-warning" role="alert">
            <center><button type="button" id="lastFinishButtonOrder" class="btn-success btn-lg" onclick="validate_sms_code(\''.$table.'\',\''. $email .'\')">Validate Code</button></center>
        </div>';
    $_message=array(
        'title'=>"Register $table1",
        'subtitle'=>'<div class="alert alert-danger"><strong>Error register '.$table1.' user was not found</strong></div>',
        'content'=>$_string_message,
        'button' =>$_string_button,
        'extra' =>$_result_update,
    );
            
}
print_r(json_encode($_message));
?>