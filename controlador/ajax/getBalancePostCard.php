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
    if(isset($_result['postCardValue'])){
        echo $_result['postCardValue'];
    }else{
        echo 0;
    }
}else{
    echo "Error, Company not found";
}

?>