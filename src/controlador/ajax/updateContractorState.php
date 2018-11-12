<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/driverController.php");


$_contractorID = $_POST['contractorID'];
$_contratorState = $_POST['contratorState'];

$_driverController=new driverController();
$result=$_driverController->updateDriverState($_contractorID,$_contratorState);

echo $result;


?>