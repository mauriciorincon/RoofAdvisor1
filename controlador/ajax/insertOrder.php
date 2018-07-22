<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
echo "llego aca";
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
$_date=$_POST['ActAmtTime'];
$_companyID="";
if(isset($_POST['CompanyID'])){
    $_companyID=$_POST['CompanyID'];
}

$_array=array(
    "RepZIP"=>$_POST['RepZIP'],
    "RequestType"=>$_POST['RequestType'],
    "Rtype"=>$_POST['Rtype'],
    "Water"=>$_POST['Water'],
    "Hlevels"=>$_POST['Hlevels'],
    "ActAmtTime"=>$_date,
    "ActTime"=>$_POST['ActTime'],
    "ContractorID"=>'',
    "CompanyID"=>$_companyID,
    "Latitude"=>$_POST['Latitude'],
    "Longitude"=>$_POST['Longitude'],
    "Address"=>$_POST['Address'],
    "id_stripe"=>$_POST['stripeCharge'],
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