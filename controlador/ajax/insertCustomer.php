<?php
require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/controlador/userController.php");


$_firstCustomerName = $_POST['firstCustomerName'];
$_lastCustomerName = $_POST['lastCustomerName'];
$_emailValidation = $_POST['emailValidation'];
$_customerAddress = $_POST['customerAddress'];
$_customerCity = $_POST['customerCity'];
$_customerState = $_POST['customerState'];
$_customerZipCode = $_POST['customerZipCode'];
$_customerPhoneNumber = $_POST['customerPhoneNumber'];



$_arrayCompany = array(
    "firstCustomerName" => "$_firstCustomerName",
    "lastCustomerName" => "$_lastCustomerName",
    "emailValidation" => "$_emailValidation",
    "customerAddress" => "$_customerAddress",
    "customerCity" => "$_customerCity",
    "customerState" => "$_customerState",
    "customerZipCode" => "$_customerZipCode",
    "customerPhoneNumber" => "$_customerPhoneNumber",
);

$_userController=new userController();
$_companyID=$_userController->insertCustomer($_arrayCompany);
echo "Continue, Company was register correctly";

?>