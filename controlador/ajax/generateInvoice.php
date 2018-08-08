<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/pdfController.php");


$_orderID=$_POST['orderID'];
$_objPDF=new pdfController();
$_result=$_objPDF->paymentConfirmation1($_orderID);

if(is_bool($_result)){    
    echo "Correct";
    
    
}else{
    echo " Error generating Invoice - ".$_result;
}
?>