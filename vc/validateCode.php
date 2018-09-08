<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
    require_once($_SESSION['application_path']."/controlador/userController.php");

    $code = $_POST['verify'];
    $table = $_POST['t'];

    echo $code;
    echo $table;
    return;
    $_userController=new userController();
    $_result=$_userController->validateCode($email,$code,$table);

    echo $_result;
    

?>