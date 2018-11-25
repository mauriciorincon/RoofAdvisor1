<?php
    ///////////////////////////////////////////////////////

    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    //define application path
    if(!isset($_SESSION['application_path'])){
        $_SESSION['application_path']=$_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF']);
    }
    
    //define library path autoload
    $_SESSION['library_path_autoload']=$_SESSION['application_path'].'/vendor/autoload.php';

    //define invoice path
    $_SESSION['invoice_path']=$_SESSION['application_path'].'/invoice/';

    //define image path
    $_SESSION['image_path']=$_SESSION['application_path'].'/img/';

    //define path firebase javascript
    $_SESSION['firebase_path_javascript']='var config = {
        apiKey: "AIzaSyCJIT-8FqBp-hO01ZINByBqyq7cb74f2Gg",
        authDomain: "roofadvisorzapp.firebaseapp.com",
        databaseURL: "https://roofadvisorzapp.firebaseio.com",
        projectId: "roofadvisorzapp",
        storageBucket: "roofadvisorzapp.appspot.com",
        messagingSenderId: "480788526390"
    };';

    //define path firebase php
    $_SESSION['firebase_path_customer_php']=$_SESSION['application_path'].'/vendor/roofadvizorz-firebase.json';
    $_SESSION['firebase_path_company_php']=$_SESSION['application_path'].'/vendor/roofadvisorz-company-firebase.json';
    $_SESSION['firebase_path_driver_php']=$_SESSION['application_path'].'/vendor/roofadvisorz-driver-firebase.json';

?>