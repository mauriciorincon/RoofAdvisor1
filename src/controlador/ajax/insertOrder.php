<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

require_once($_SESSION['application_path']."/controlador/orderController.php");
require_once($_SESSION['application_path']."/controlador/userController.php");

$_userController=new userController();

$_createdBy="";
$_createdTo="";
$_customerMail="";

$_companyID="";
if(isset($_POST['CompanyID'])){
    $_companyID=$_POST['CompanyID'];
}
if(isset($_POST['action_type'])){
    if(strcmp($_POST['action_type'],"create_by_company")==0){
        $_createdBy=$_POST['createdBy'];
        $_companyID=$_POST['createdBy'];
        $_user=$_userController->getCustomerById($_POST['createdTo']);
        $_createdTo=$_POST['createdTo'];
        $_customerMail=$_user['Email'];
    }else{
        $_createdBy="CO000000";
        if(strcmp($_POST['action_type'],"pay_company_roofreport")==0){
            $_user=$_userController->getCustomerById($_POST['createdTo']);
            $_customerMail=$_user['Email'];
            $_createdTo=$_POST['createdTo'];
        }
    }
}else{
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        $_customerMail=$_SESSION['email'];
        $_createdTo="0";
    }else{
        $email=$_POST['email'];
        $password=$_POST['password'];
        
        
        $_result=$_userController->loginCustomerOrden($email,$password);
        
        if(strpos($_result,'Error')>-1){
            echo $_result;
            return;
        }
    }
    $_createdBy="CO000000";
}

//$_date=$_POST['ActAmtTime'];


if(isset($_POST['stripeCharge'])){
    $_stripe_chargue=$_POST['stripeCharge'];
}else{
    $_stripe_chargue="";
}

if(isset($_POST['amount_value'])){
    $_amount_value=$_POST['amount_value'];
}else{
    $_amount_value=0;
    
}
if(isset($_POST['postCardValue'])){
    $_amount_valueP=$_POST['postCardValue'];
}else{
    $_amount_valueP=0;
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
    "postCardValue"=>$_amount_valueP,
    "amount_value"=>$_amount_value,
    "CreateBy"=>$_createdBy,
    "RepCity"=>$_POST['RepCity'],
    "RepState"=>$_POST['RepState'],
);

$_orderController=new orderController();
$_id_order=$_orderController->insertOrder($_array,$_customerMail,$_POST['action_type'],$_createdTo);
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