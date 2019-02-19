<?php

    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    require_once($_SESSION['application_path']."/controlador/userController.php");


    
    $code = $_POST['verify'];
    $table = $_POST['t'];
    $email = $_POST['u'];
    /*echo $code;
    echo $table;
    echo $email;
    return;*/
    if(strcmp($table,"c")==0){
        $table="Customers";
    }else if(strcmp($table,"co")==0){
        $table="Company";
    }else if(strcmp($table,"con")==0){
        $table="Contractors";
    }
    $_userController=new userController();
    $_result=$_userController->validateCode($email,$code,$table);

    echo $_result;
    

?>