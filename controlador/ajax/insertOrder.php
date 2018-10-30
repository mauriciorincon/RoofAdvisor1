<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

require_once($_SESSION['application_path']."/controlador/orderController.php");
require_once($_SESSION['application_path']."/controlador/userController.php");


if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
}else{
    $email=$_POST['email'];
    $password=$_POST['password'];
    
    $_userController=new userController();
    $_result=$_userController->loginCustomerOrden($email,$password);
    
    if(strpos($_result,'Error')>-1){
        echo $_result;
        return;
    }
    
}
//$_date=$_POST['ActAmtTime'];
$_companyID="";
if(isset($_POST['CompanyID'])){
    $_companyID=$_POST['CompanyID'];
}

if(isset($_POST['stripeCharge'])){
    $_stripe_chargue=$_POST['stripeCharge'];
}else{
    $_stripe_chargue="";
}
if(isset($_POST['postCardValue'])){
    $_amount_value=$_POST['postCardValue'];
}else{
    $_amount_value=0;
}

$_array=array(
    "RepZIP"=>$_POST['RepZIP'],
    "RequestType"=>$_POST['RequestType'],
    "Rtype"=>$_POST['Rtype'],
    "Water"=>$_POST['Water'],
    "Hlevels"=>$_POST['Hlevels'],
    "SchDate"=>$_POST['SchDate'],
    "SchTime"=>$_POST['SchTime'],
    "ContractorID"=>'',
    "CompanyID"=>$_companyID,
    "Latitude"=>$_POST['Latitude'],
    "Longitude"=>$_POST['Longitude'],
    "Address"=>$_POST['Address'],
    "id_stripe"=>$_stripe_chargue,
    "Authorized"=>$_POST['Authorized'],
    "postCardValue"=>$_amount_value,
);


$_orderController=new orderController();
$_id_order=$_orderController->insertOrder($_array);
if (is_null($_id_order)){
    echo "Error, an error ocurred traing to save Order, try again";
}else{
    if(strpos($_id_order,'Error')>-1){
        return   $_id_order;  
    }else{
        echo "Continue, Order was register correctly, $_id_order";
    }
    
}


?>