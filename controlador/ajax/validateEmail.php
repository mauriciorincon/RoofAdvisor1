<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/controlador/userController.php");
    //require_once("../../modelo/user.class.php");
    //Variable de búsqueda
    $emailSearch = $_POST['emailValue'];
    $tableSearch = $_POST['tableSearch'];
    
    
    $_userController=new userController();
    $_result=$_userController->validateEmail($tableSearch,$emailSearch);

    if($_result==true){
        echo "Error, the email is used for other user";
    }else{
        echo "Continue, email is valid";
    }
?>