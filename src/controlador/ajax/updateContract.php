<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/driverController.php");


$_contractorID = $_POST['contractorID'];
$_contratorFirstName = $_POST['contratorFirstName'];
$_contratorLastName = $_POST['contratorLastName'];
$_contratorPhoneNumber = $_POST['contratorPhoneNumber'];
$_contratorLinceseNumber = $_POST['contratorLinceseNumber'];
$_contratorProfile = $_POST['contratorProfile'];

$_driverController=new driverController();
$result=$_driverController->updateDriver($_contractorID,$_contratorFirstName,
                                $_contratorLastName,$_contratorPhoneNumber,
                                $_contratorLinceseNumber,$_contratorProfile);
echo $result;


?>