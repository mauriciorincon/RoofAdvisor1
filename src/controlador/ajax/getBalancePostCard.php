<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");

$_companyID =$_POST["companyID"];
$_contractorController=new userController();
$_result=$_contractorController->getCompanyById($_companyID);
//print_r($_result);
if(is_array($_result)){
    
    if(isset($_result['postCardQuantity'])){
        
        $_array=array(
            'postCardQuantity'=>  $_result['postCardQuantity'],
            'postCardValue'=>  $_result['postCardValue'],
        );
        echo json_encode($_array);
    }else{
        $_array=array(
            'postCardQuantity'=>  0,
            'postCardValue'=>  0,
        );
        echo json_encode($_array);
    }
}else{
    echo "Error, Company not found";
}

?>