<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 

    //require_once($_SESSION['application_path']."/controlador/payingController.php");

    //$_objPay=new payingController();

    

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        $_message=array(
            'message'=>"Please Mr/Mrs ".$_SESSION['username']." please press finish button to save the order.",
            'profile'=>$_SESSION['profile'],
        );
        echo json_encode($_message);
        
        //$_objPay->showPayingWindow1();
        
    }else{
        $_message=array(
            'message'=>"Error not logged in",
            'profile'=>"",
        );
        echo json_encode($_message);
    }
?>