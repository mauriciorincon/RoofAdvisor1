<?php
	if(!isset($_SESSION)) { 
		session_start(); 
	} 
    require_once($_SESSION['application_path']."/controlador/userController.php");
    

    $_companyID=$_POST['companyID'];
    $_action=$_POST['action'];

    $_companyController=new userController();
    $_result="";
    if(strcmp($_action,"Active")==0){
        $_result=$_companyController->enableCompany($_companyID);
    }else if(strcmp($_action,"Inactive")==0){
        $_result=$_companyController->disableCompany($_companyID);
    }

    echo $_result;
?>