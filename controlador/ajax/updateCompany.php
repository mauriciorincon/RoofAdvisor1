<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/RoofAdvisor/controlador/userController.php");


$_companyID =$_POST["companyID"];
$_compamnyName=$_POST["compamnyName"];
$_firstCompanyName=$_POST["firstCompanyName"];
$_lastCustomerName=$_POST["lastCustomerName"];
$_companyAddress1=$_POST["companyAddress1"];
$_companyAddress2=$_POST["companyAddress2"];
$_companyAddress3=$_POST["companyAddress3"];
$_companyPhoneNumber=$_POST["companyPhoneNumber"];
$_companyType=$_POST["companyType"];

$_userController=new userController();

$result=$_userController->updateCompany($_companyID,$_compamnyName,$_firstCompanyName,$_lastCustomerName,
                                        $_companyAddress1,$_companyAddress2,$_companyAddress3,$_companyPhoneNumber,
                                        $_companyType);
echo $result;

?>