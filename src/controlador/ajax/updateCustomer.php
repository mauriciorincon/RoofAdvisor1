<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");


$_customerID=$_POST['customerID'];
$_firstCustomerName = $_POST['firstCustomerName'];
$_lastCustomerName = $_POST['lastCustomerName'];
$_emailValidation = $_POST['emailValidation'];
$_customerAddress = $_POST['customerAddress'];
$_customerCity = $_POST['customerCity'];
$_customerState = $_POST['customerState'];
$_customerZipCode = $_POST['customerZipCode'];
$_customerPhoneNumber = $_POST['customerPhoneNumber'];

$_arrayCustomer = array(
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

$_result=$_userController->updateCustomer($_customerID,$_arrayCustomer);
if(strpos($_result,"Error")!==false){
    echo "Error update customer,try again <br>".$_customerID;
}else{
    echo "Continue, Customer was update correctly";
}

?>