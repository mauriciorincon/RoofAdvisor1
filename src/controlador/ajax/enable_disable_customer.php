<?php
	if(!isset($_SESSION)) { 
		session_start(); 
	} 
    require_once($_SESSION['application_path']."/controlador/userController.php");

    $_customerID=$_POST['customerID'];
    $_action=$_POST['action'];

    $_companyController=new userController();
    $_result="";
    if(strcmp($_action,"Active")==0){
        $_result=$_companyController->enableCustomer($_customerID);
    }else if(strcmp($_action,"Inactive")==0){
        $_result=$_companyController->disableCustomer($_customerID);
    }

    echo $_result;
?>