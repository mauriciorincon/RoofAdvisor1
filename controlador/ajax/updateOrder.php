<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/orderController.php");

$_orderID=$_POST['orderId'];
$_updateFields=$_POST['arrayChanges'];

$_arrayFields=explode(",",$_updateFields);

$_orderController=new orderController();

$_result=$_orderController->updateOrder($_orderID,$_arrayFields);

echo $_result;

?>