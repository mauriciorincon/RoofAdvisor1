<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    
    require_once($_SESSION['application_path']."/controlador/payingController.php");
    require_once($_SESSION['application_path']."/controlador/userController.php");

    $_report_type = $_POST['report_type'];
    $_companyID = $_POST['companyID'];

    switch($_report_type){
        case "balance":
            
            break;
        
    }

?>