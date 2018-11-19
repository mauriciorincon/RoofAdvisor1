<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");

$_userType=$_POST['userType'];
$_userMail=$_POST['userMail'];

$_userController=new userController();
if(strcmp($_userType,"customer")==0){
    $_user_info=$_userController->getCustomer($_userMail);
}else if (strcmp($_userType,"company")==0){
    $_user_info=$_userController->getCompanyE($_userMail);
}


if(is_null($_user_info)){
    $result="Error. User is not register¡";
}else{
    $result=$_userController->resetPassword($_userType,$_user_info);
}
echo $result;
?>