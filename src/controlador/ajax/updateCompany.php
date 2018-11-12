<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");


$_companyID =$_POST["companyID"];
$_compamnyName=$_POST["compamnyName"];
$_firstCompanyName=$_POST["firstCompanyName"];
$_lastCompanyName=$_POST["lastCompanyName"];
$_companyAddress1=$_POST["companyAddress1"];
$_companyAddress2=$_POST["companyAddress2"];
$_companyAddress3=$_POST["companyAddress3"];
$_companyPhoneNumber=$_POST["companyPhoneNumber"];
$_companyType=$_POST["companyType"];

$_PayInfoBillingAddress1=$_POST["PayInfoBillingAddress1"];
$_PayInfoBillingAddress2=$_POST["PayInfoBillingAddress2"];
$_PayInfoBillingCity=$_POST["PayInfoBillingCity"];
$_PayInfoBillingST=$_POST["PayInfoBillingST"];
$_PayInfoBillingZip=$_POST["PayInfoBillingZip"];
$_PayInfoCCExpMon=$_POST["PayInfoCCExpMon"];
$_PayInfoCCExpYr=$_POST["PayInfoCCExpYr"];
$_PayInfoCCNum=$_POST["PayInfoCCNum"];
$_PayInfoCCSecCode=$_POST["PayInfoCCSecCode"];
$_PayInfoName=$_POST["PayInfoName"];
$_PrimaryFName=$_POST["PrimaryFName"];
$_PrimaryLName=$_POST["PrimaryLName"];

$_InsLiabilityAgencyName=$_POST["InsLiabilityAgencyName"];
$_InsLiabilityAgtName=$_POST["InsLiabilityAgtName"];
$_InsLiabilityAgtNum=$_POST["InsLiabilityAgtNum"];
$_InsLiabilityPolNum=$_POST["InsLiabilityPolNum"];
$_Status_Rating=$_POST["Status_Rating"];


$_userController=new userController();

$result=$_userController->updateCompany($_companyID,$_compamnyName,$_firstCompanyName,$_lastCompanyName,
                                        $_companyAddress1,$_companyAddress2,$_companyAddress3,$_companyPhoneNumber,
                                        $_companyType,$_PayInfoBillingAddress1,$_PayInfoBillingAddress2,$_PayInfoBillingCity,
                                        $_PayInfoBillingST,$_PayInfoBillingZip,$_PayInfoCCExpMon,$_PayInfoCCExpYr,
                                        $_PayInfoCCNum,$_PayInfoCCSecCode,$_PayInfoName,$_PrimaryFName,
                                        $_PrimaryLName,$_InsLiabilityAgencyName,$_InsLiabilityAgtName,$_InsLiabilityAgtNum,
                                        $_InsLiabilityPolNum,$_Status_Rating);
echo $result;

?>