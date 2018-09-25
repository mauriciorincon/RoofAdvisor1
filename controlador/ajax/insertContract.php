<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");
require_once($_SESSION['application_path']."/controlador/driverController.php");



$_companyNameField = $_POST['companyName'];
$_firstNameField = $_POST['firstNameCompany'];
$_lastNameField = $_POST['lastNameCompany'];
$_phoneContactField = $_POST['phoneContactCompany'];
$_emailField = $_POST['emailValidation'];
$_typeCompanyField = $_POST['typeCompany'];
$_password= $_POST["password"];
$_arrayDivers = $_POST['arrayDrivers'];


$_arrayCompany = array(
    "companyName" => "$_companyNameField",
    "firstNameCompany" => "$_firstNameField",
    "lastNameCompany" => "$_lastNameField ",
    "phoneContactCompany" => "$_phoneContactField",
    "emailValidation" => "$_emailField",
    "typeCompany" => "$_typeCompanyField",
    "password" => "$_password",
);

$_array_drivers=array();
$_elementsCount=count($_arrayDivers);
$_elementDivisor=$_elementsCount/7;
for($n=0;$n<$_elementDivisor;$n++){
    if(!empty($_arrayDivers[$n]) and !empty($_arrayDivers[$n+$_elementDivisor])){
    $_array=array(
        "driverFirstName"=>$_arrayDivers[$n],
        "driverLastName"=>$_arrayDivers[$n+$_elementDivisor],
        "driverPhone"=>"+1".$_arrayDivers[$n+($_elementDivisor*2)],
        "driverLicense"=>$_arrayDivers[$n+($_elementDivisor*3)],
        "driverEmail"=>$_arrayDivers[$n+($_elementDivisor*4)],
        "driverStatus"=>$_arrayDivers[$n+($_elementDivisor*5)],
        "driverProfile"=>$_arrayDivers[$n+($_elementDivisor*6)],
    );
    array_push($_array_drivers,$_array);
    }
}
//print_r($_arrayDivers);

$_userController=new userController();
$_companyID=$_userController->insertCompany($_arrayCompany);

$_consecutive="";
if(strpos($_companyID,"Error")!==false){
    echo "Error register company,try again ".$_companyID."";
}else{
    if(count($_array_drivers)>0){
        $_pos=strpos($_companyID,"*");
        if($_pos!==false){
            $_consecutive=substr($_companyID,0,$_pos);
        }
        $_driverController=new driverController();
        $_driverController->insertDrivers($_consecutive,$_array_drivers);
    }
    echo "Continue, Company was register correctly please check your email, to validate the user".$_consecutive;
}
?>