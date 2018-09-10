<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");

$_userType=$_POST['userType'];
$_userMail=$_POST['userMail'];

$_userController=new userController();

$_user_info=$_userController->getCustomer($user);
if(is_null($_user_info)){
    echo "User is not register¡";
}else{
    
}

?>