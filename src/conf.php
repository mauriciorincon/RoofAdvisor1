<?php
    ///////////////////////////////////////////////////////

    if (session_status() == PHP_SESSION_NONE) {
        session_start(); 
    } 
    //define application path
    if(!isset($_SESSION['application_path'])){
        $_SESSION['application_path']=$_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF']);
    }
    //echo  $_SESSION['application_path'];
    
    //$_SESSION['library_path']=$_SERVER['DOCUMENT_ROOT'].'/roofservicenow1'.'/vendor/';

    $_SESSION['library_path']=$_SESSION['application_path'].'/vendor/';

    //define library path autoload
    $_SESSION['library_path_autoload']=$_SESSION['library_path'].'autoload.php';

    //define invoice path
    $_SESSION['invoice_path']=$_SESSION['application_path'].'/invoice/';

    //define image path
    $_SESSION['image_path']=$_SESSION['application_path'].'/img/';

    //define roofservice documents
    //$_SESSION['rsn_documents_path']=$_SESSION['application_path'].'/rsndocs/';

    //define roofservice documents
    if(strcmp($_SERVER['HTTP_HOST'],'localhost')==0){
        $_dir=$_SERVER['REQUEST_URI'];
        $pos1 = strpos($_dir,"/");
        $pos2 = strpos($_dir,"/", $pos1 + 1);
        //echo "<br>hola:".substr($_dir,$pos1+1,$pos2-1);
        $_path2="/".substr($_dir,$pos1+1,$pos2-1);
        $_SESSION['rsn_documents_path']="http://" . $_SERVER['HTTP_HOST'].$_path2."/src/rsndocs/";
    }else{
        $_SESSION['rsn_documents_path']="http://" . $_SERVER['HTTP_HOST']."/src/rsndocs/";
    }
    
    //define report path
    $_SESSION['report_path']=$_SESSION['application_path'].'/roofreport/';

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
    $_SESSION['firebase_path_customer_php']=$_SESSION['library_path'].'roofadvizorz-firebase.json';
    $_SESSION['firebase_path_company_php']=$_SESSION['library_path'].'roofadvisorz-company-firebase.json';
    $_SESSION['firebase_path_driver_php']=$_SESSION['library_path'].'roofadvisorz-driver-firebase.json';

    //define path temporal
    $_SESSION['temporal_path']=$_SESSION['application_path']."/tmp/";

?>
