<?php
require_once("../driverController.php");


$_contractorID = $_POST['contractorID'];
$_contratorState = $_POST['contratorState'];

$_driverController=new driverController();
$result=$_driverController->updateDriverState($_contractorID,$_contratorState);

echo $result;


?>