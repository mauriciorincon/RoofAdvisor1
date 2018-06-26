<?php

if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/driverController.php");

$_companyID=$_POST['companyID'];
$_array_drivers=array();

$_array=array(
    "driverFirstName"=>$_POST['contractorFirstName'],
    "driverLastName"=>$_POST['contractorLastName'],
    "driverPhone"=>$_POST['contractorPhoneNumber'],
    "driverLicense"=>$_POST['contractorLinceseNumber'],
    "driverStatus"=>$_POST['contractorState'],
    "driverEmail"=>$_POST['contractorEmail'],
);
array_push($_array_drivers,$_array);


$_driverController=new driverController();
$_id_driver=$_driverController->insertDrivers($_companyID,$_array_drivers);
if (is_null($_id_driver)){
    echo "Error, an error ocurred traing to save Contractor, try again";
}else{
    echo $_id_driver."|Continue, Contractor was register correctly";
}


?>