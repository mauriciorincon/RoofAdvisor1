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
$_password=$_POST['password'];



$_arrayCustomer = array(
    "firstCustomerName" => "$_firstCustomerName",
    "lastCustomerName" => "$_lastCustomerName",
    "emailValidation" => "$_emailValidation",
    "customerAddress" => "$_customerAddress",
    "customerCity" => "$_customerCity",
    "customerState" => "$_customerState",
    "customerZipCode" => "$_customerZipCode",
    "customerPhoneNumber" => "$_customerPhoneNumber",
    "password"=>$_password,
);

$_userController=new userController();
$_customerID=$_userController->insertCustomer($_arrayCustomer);
if(strpos($_customerID,"Error")!==false){
    echo "Error register customer,try again <br>".$_customerID;
}else{
    echo "Continue, Customer was register correctly please check your email, to validate the user";
}

?>