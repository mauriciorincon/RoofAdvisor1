<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    require_once($_SESSION['application_path']."/controlador/userController.php");
    //require_once("../../modelo/user.class.php");
    //Variable de búsqueda
    $email = $_POST['userClientOrder'];
    $password = $_POST['passwordClientOrder'];
    
    
    $_userController=new userController();
    $_result=$_userController->loginCustomerOrden($email,$password);

    return $_result;
?>