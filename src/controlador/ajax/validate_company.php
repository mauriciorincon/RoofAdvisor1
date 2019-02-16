<?php
	if(!isset($_SESSION)) { 
		session_start(); 
	} 
    require_once($_SESSION['application_path']."/controlador/userController.php");
    

    $_companyID=$_POST['companyID'];
    $_action=$_POST['action'];

    $_companyController=new userController();
    $_result="";
    if(strcmp($_action,"0")==0){
        $_result=$_companyController->invalidateCompany($_companyID);
    }else if(strcmp($_action,"1")==0){
        $_result=$_companyController->validateCompany($_companyID);
    }

    echo $_result;
?>