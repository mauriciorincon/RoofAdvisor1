<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");

$_customerID =$_POST["customerID"];
$_contractorController=new userController();
$_result=$_contractorController->getCustomerById($_customerID);
//print_r($_result);
if(is_array($_result)){
    //json_encode($phpArray)
    print_r(json_encode($_result));
}else{
    echo "Error, Customer not found";
}

?>