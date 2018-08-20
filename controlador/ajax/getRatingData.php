<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

require_once($_SESSION['application_path']."/controlador/ratingController.php");

$_orderID=$_POST['orderID'];
$_ratingController=new ratingController();

$_result=$_ratingController->getRatingByOrder($_orderID);

if(is_array($_result)){
    //json_encode($phpArray)
    print_r(json_encode($_result));
}else{
    echo "Error, rating not found";
}



?>