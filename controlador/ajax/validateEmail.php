<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    require_once($_SESSION['application_path']."/controlador/userController.php");
    //require_once("../../modelo/user.class.php");
    //Variable de búsqueda
    $emailSearch = $_POST['emailValue'];
    $tableSearch = $_POST['tableSearch'];
    
    
    $_userController=new userController();
    $_result=$_userController->validateEmail($tableSearch,$emailSearch);

    if($_result==true){
        echo "Error, the email already exists";
    }else{
        echo "Continue, email is valid";
    }
?>