<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
    require_once($_SESSION['application_path']."/controlador/userController.php");

    $email = $_POST['emailValidation'];
    $code = $_POST['codeValidateField'];
    $table = $_POST['table'];

    $_userController=new userController();
    $_result=$_userController->validateCode($email,$code,$table);

    echo $_result;
    

?>