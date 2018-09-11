<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");

$_userType=$_POST['userType'];
$_userId=$_POST['userId'];
$_tempotalPass=$_POST['tempPass'];
$_newPass=$_POST['newPass'];

$_userController=new userController();
$result=$_userController->changePassword($_userType,$_userId,$_newPass);
echo $result;
?>