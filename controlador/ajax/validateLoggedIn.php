<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 

    //require_once($_SESSION['application_path']."/controlador/payingController.php");

    //$_objPay=new payingController();

    

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        echo "Please Mr/Mrs ".$_SESSION['username']." please press finish button to save the order.";
        //$_objPay->showPayingWindow1();
        
    }else{
        echo "Error not logged in";
    }
?>