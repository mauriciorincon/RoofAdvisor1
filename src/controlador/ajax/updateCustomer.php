<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");


$_customerID=$_POST['customerID'];
$_firstCustomerName = $_POST['firstCustomerName'];
$_lastCustomerName = $_POST['lastCustomerName'];
$_emailValidation = $_POST['emailValidation'];
if(isset($_POST['customerAddress'])){$_customerAddress = $_POST['customerAddress'];}else{$_customerAddress = "";}
if(isset($_POST['customerCity'])){$_customerCity = $_POST['customerCity'];}else{$_customerCity = "";}
if(isset($_POST['customerState'])){$_customerState = $_POST['customerState'];}else{$_customerState = "";}
if(isset($_POST['customerZipCode'])){$_customerZipCode = $_POST['customerZipCode'];}else{$_customerZipCode = "";}
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