<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");

$_userType=$_POST['userType'];
$_userMail=$_POST['userMail'];

$_userController=new userController();

$_customer_info=$_userController->getCustomer($_userMail);
if(is_null($_customer_info)){
    $result="Error. User is not register¡";
}else{
    $result=$_userController->resetPassword($_userType,$_customer_info);
}
echo $result;
?>