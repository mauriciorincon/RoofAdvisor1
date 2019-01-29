<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");
require_once($_SESSION['application_path']."/controlador/orderController.php");

$_companyID =$_POST["companyID"];
$_contractorController=new userController();
$_result=$_contractorController->getCompanyById($_companyID);
if(isset($_result['stripeAccount'])){
    $_array_stripe_info=$_contractorController->getAccount($_result['stripeAccount']);
    array_push($_result,$_array_stripe_info);
    //print_r($_array_stripe_info);
}
//print_r($_result);
if(is_array($_result)){
    //json_encode($phpArray)
    print_r(json_encode($_result));
}else{
    echo "Error, Company not found";
}

?>