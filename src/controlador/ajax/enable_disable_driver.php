<?php
	if(!isset($_SESSION)) { 
		session_start(); 
	} 
    require_once($_SESSION['application_path']."/controlador/driverController.php");
    

    $_contractorID=$_POST['contractorID'];
    $_action=$_POST['action'];

    $_driverController=new driverController();
    $_result="";
    if(strcmp($_action,"Active")==0){
        $_result=$_driverController->enableDriver($_contractorID);
    }else if(strcmp($_action,"Inactive")==0){
        $_result=$_driverController->disableDriver($_contractorID);
    }

    echo $_result;
?>