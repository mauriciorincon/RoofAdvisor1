<?php
    require_once("../userController.php");
    //require_once("../../modelo/user.class.php");
    //Variable de búsqueda
    $emailSearch = $_POST['emailValue'];
    
    
    $_userController=new userController();
    $_result=$_userController->validateEmail($emailSearch);

    if($_result==true){
        echo "Error, the email is used for other user";
    }else{
        echo "Continue, email is valid";
    }
?>