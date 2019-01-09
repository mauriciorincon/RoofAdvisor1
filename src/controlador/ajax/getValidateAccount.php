<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");
if (isset($_POST['account'])){
    $_account=$_POST['account'];

    $_userController = new userController();
    $account = $_userController->getAccount($_account);
    if(is_object($account) or is_array($account)){
        $_result=$_userController->getValidateAccount($_account);
        if(is_array($_result)){
            echo "Error, It is neccesary to make payouts to your bank account, the next fields <br>";
            print_r($_result);
        }else{
            echo $_result;
        }
        
    }else{
        echo "Error, the account was not found";
    }
}else{
    echo "Error, the account was not found";
}

?>