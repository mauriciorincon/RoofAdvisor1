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
$_array=array(
    "RepZIP"=>$_POST['RepZIP'],
    "RequestType"=>$_POST['RequestType'],
    "Rtype"=>$_POST['Rtype'],
    "Water"=>$_POST['Water'],
    "Hlevels"=>$_POST['Hlevels'],
    "ActAmtTime"=>$_POST['ActAmtTime'],
    "ActTime"=>$_POST['ActTime'],
    "ContractorID"=>'',
    "CompanyID"=>$_POST['CompanyID'],
    "Latitude"=>$_POST['Latitude'],
    "Longitude"=>$_POST['Longitude'],
    "Address"=>$_POST['Address'],
);


$_orderController=new orderController();
$_id_order=$_orderController->insertOrder($_array);
if (is_null($_id_order)){
    echo "Error, an error ocurred traing to save Order, try again";
}else{
    if(strpos($_id_order,'Error')>-1){
        return   $_id_order;  
    }else{
        echo "Continue, Order was register correctly";
    }
    
}


?>