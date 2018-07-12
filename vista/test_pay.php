<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    require_once($_SESSION['application_path']."/controlador/payingController.php");

    $_objPay=new payingController();

    $_objPay->showPayingWindow1();
?>