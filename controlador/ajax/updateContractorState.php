<?php
require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/controlador/driverController.php");


$_contractorID = $_POST['contractorID'];
$_contratorState = $_POST['contratorState'];

$_driverController=new driverController();
$result=$_driverController->updateDriverState($_contractorID,$_contratorState);

echo $result;


?>