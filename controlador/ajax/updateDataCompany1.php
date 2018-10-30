<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");

$_companyID=$_POST['companyID'];
$_updateFields=$_POST['arrayChanges'];

$_arrayFields=explode(",",$_updateFields);

$_userController=new userController();

$_result=$_userController->updateCompanyFields($_companyID,$_arrayFields);

echo $_result;

?>