<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 

    
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        echo "Please Mr/Mrs ".$_SESSION['username']." please press finish button to save the order.";
        
    }else{
        echo "Error not logged in";
    }
?>