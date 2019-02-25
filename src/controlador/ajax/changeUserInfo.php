<?php

    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    require_once($_SESSION['application_path']."/controlador/userController.php");

    $value = $_POST['value'];
    $table = $_POST['t'];
    $email = $_POST['u'];
    $pass = $_POST['p'];

    $_userController = new userController();

    
?>