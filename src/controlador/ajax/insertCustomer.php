<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");
require_once($_SESSION['application_path']."/modelo/user.class.php");


$_userController=new userController();

if(!isset($_POST['source_call'])){
    $_source_call='Order';
}else{
    $_source_call=$_POST['source_call'];
}
if(!isset($_POST['CompanyID'])){
    $_companyID='CO000000';
}else{
    $_companyID=$_POST['CompanyID'];
}
if(!isset($_POST['termsServiceAgree'])){
    $_accept_terms=0;
}else{
    $_accept_terms=$_POST['termsServiceAgree'];
}
if(strcmp("source_call","Customer_register")==0){
    if($_accept_terms==0){
        $_path="../../?controller=user&accion=showRegisterCustomer&aditionalMessage=Please you have to accept the terms, to create the customer account";
        $_SESSION['post_info'] = $_POST;
        header("Location: $_path");
        return;
    }
}
if(strcmp('Customer_register',$_source_call)==0){
    if(isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']){
        //var_dump($_POST['g-recaptcha-response']);
        $_secret="6LeiZnkUAAAAAE0V7yDVIYLwwoZoZaG6c_A6HyWF";
        $_ip=$_SERVER['REMOTE_ADDR'];
    
        $_capcha=$_POST['g-recaptcha-response'];
    
        $_result=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$_secret&response=$_capcha&remoteip=$_ip");
    
        //echo "<br>";
        //echo "<br>";
        //echo "<br>";
        //var_dump($_result);
    
        $_array=json_decode($_result,true);
    
        if($_array['success']){
            //echo "todo bien";
        }else{
            $_path="../../?controller=user&accion=showRegisterCustomer&aditionalMessage=Please check the captcha";
            $_SESSION['post_info'] = $_POST;
            header("Location: $_path");
            return;
        }
    }else{
        //$_userModel=new userModel();
        //$_array_state=$_userModel->getNode('Parameters/state');
        //require_once("../../vista/head.php");
        //require_once("../../vista/register_customer.php");
        //require_once("../../vista/footer.php");
        //echo "fill capcha";
        $_path="../../?controller=user&accion=showRegisterCustomer&aditionalMessage=Please check the captcha";
        $_SESSION['post_info'] = $_POST;
        header("Location: $_path");
        return;
    }
}



$_firstCustomerName = $_POST['firstCustomerName'];
$_lastCustomerName = $_POST['lastCustomerName'];
$_emailValidation = $_POST['emailValidation'];
$_customerAddress = "";
$_customerCity = "";
$_customerState = "";
$_customerZipCode = "";
$_customerPhoneNumber = $_POST['customerPhoneNumber'];
$_password=$_POST['inputPassword'];

$_selectionType="";

if(!isset($_POST['selectionType'])){
    $_selectionType="";
}else{
    $_selectionType=$_POST['selectionType'];
}

$_arrayCustomer = array(
    "firstCustomerName" => "$_firstCustomerName",
    "lastCustomerName" => "$_lastCustomerName",
    "emailValidation" => "$_emailValidation",
    "customerAddress" => "$_customerAddress",
    "customerCity" => "$_customerCity",
    "customerState" => "$_customerState",
    "customerZipCode" => "$_customerZipCode",
    "customerPhoneNumber" => "$_customerPhoneNumber",
    "password"=>$_password,
    "CompanyID"=>$_companyID,
);


$_customerID=$_userController->insertCustomer($_arrayCustomer,$_selectionType);

if(strpos($_customerID,"Error")!==false){
    if(strcmp($_source_call,'Customer_register')==0){
        $_path="../../?controller=user&accion=showRegisterCustomer&aditionalMessage=Error registering customer <br>".$_customerID;
        $_SESSION['post_info'] = $_POST;
        header("Location: $_path");
    }else{
        echo $_customerID;
    }
    //echo "Error registering customer <br>".$_customerID;
}else{
    switch($_source_call){
        case "company_dash":
            echo $_customerID;
            break;
        case "Customer_register":
            $_message=array(
                'title'=>"Register Customer",
                'subtitle'=>"Thank you for register",
                'content'=>"Customer was register correctly please check the code that was sent to your phone.",
                'emailUser' =>$_emailValidation,
                'passUser' =>$_password,
            );
            $_SESSION['response'] = $_message;
            $_path="../../?controller=user&accion=showMessage";
            header("Location: $_path");
            break;
        case "Order":
            $_message=array(
                'title'=>"Verification Checkpoint",
                'subtitle'=>"Customer was register correctly",
                'content'=>"We sent a Verification Code to your phone: $_customerPhoneNumber",
            );
            print_r(json_encode($_message));
            break;
        case "Company":
            $_message=array(
                'title'=>"Register Customer",
                'subtitle'=>"Thank you for register",
                'content'=>"Customer was register correctly $_customerID",
                'customerID'=>$_customerID,
            );
            print_r(json_encode($_message));
            break;
    }
}

?>