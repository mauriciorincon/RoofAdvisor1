<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    require_once($_SESSION['application_path']."/controlador/orderController.php");
    $_orderID=$_POST['orderID'];
    $_comment=$_POST['commentary'];

    $_orderController = new orderController();

    $_result=$_orderController->insertOrderComentary($_orderID,$_comment);
    echo $_result;
?>