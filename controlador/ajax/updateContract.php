<?php
require_once("../driverController.php");


$_contractorID = $_POST['contractorID'];
$_contratorFirstName = $_POST['contratorFirstName'];
$_contratorLastName = $_POST['contratorLastName'];
$_contratorPhoneNumber = $_POST['contratorPhoneNumber'];
$_contratorLinceseNumber = $_POST['contratorLinceseNumber'];

$_driverController=new driverController();
$result=$_driverController->updateDriver($_contractorID,$_contratorFirstName,
                                $_contratorLastName,$_contratorPhoneNumber,
                                $_contratorLinceseNumber);
echo $result;


?>