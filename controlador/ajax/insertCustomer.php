<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");
require_once($_SESSION['application_path']."/modelo/user.class.php");



if(isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']){
    var_dump($_POST['g-recaptcha-response']);
    $_secret="6LeiZnkUAAAAAE0V7yDVIYLwwoZoZaG6c_A6HyWF";
    $_ip=$_SERVER['REMOTE_ADDR'];

    $_capcha=$_POST['g-recaptcha-response'];

    $_result=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$_secret&response=$_capcha&remoteip=$_ip");

    echo "<br>";
    echo "<br>";
    echo "<br>";
    var_dump($_result);

    $_array=json_decode($_result,true);

    if($_array['success']){
        echo "todo bien";
    }else{
       return; 
    }
}else{
    $_userModel=new userModel();
    $_array_state=$this->_userModel->getNode('Parameters/state');
    require_once("vista/head.php");
    require_once("vista/register_customer.php");
    require_once("vista/footer.php");
    //echo "fill capcha";
    //$_path="../../?controller=user&accion=showRegisterCustomer&aditionalMessage='Please check the captcha'";

    //header("Location: $_path");
    return;
}



$_firstCustomerName = $_POST['firstCustomerName'];
$_lastCustomerName = $_POST['lastCustomerName'];
$_emailValidation = $_POST['emailValidation'];
$_customerAddress = $_POST['customerAddress'];
$_customerCity = $_POST['customerCity'];
$_customerState = $_POST['customerState'];
$_customerZipCode = $_POST['customerZipCode'];
$_customerPhoneNumber = $_POST['customerPhoneNumber'];
$_password=$_POST['password'];

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
);


$_customerID=$_userController->insertCustomer($_arrayCustomer,$_selectionType);

if(strpos($_customerID,"Error")!==false){
    echo "Error register customer,try again <br>".$_customerID;
}else{
    if(strcmp($_selectionType,'newCustomer')==0){
        echo $_customerID;
    }else{
        echo "Continue, Customer was register correctly please check your email, to validate the user";
    }
    
}

?>