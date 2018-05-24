<?php
require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/controlador/userController.php");
require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/controlador/driverController.php");



$_companyNameField = $_POST['companyName'];
$_firstNameField = $_POST['firstNameCompany'];
$_lastNameField = $_POST['lastNameCompany'];
$_phoneContactField = $_POST['phoneContactCompany'];
$_emailField = $_POST['emailValidation'];
$_typeCompanyField = $_POST['typeCompany'];
$_arrayDivers = $_POST['arrayDrivers'];

$_arrayCompany = array(
    "companyName" => "$_companyNameField",
    "firstNameCompany" => "$_firstNameField",
    "lastNameCompany" => "$_lastNameField ",
    "phoneContactCompany" => "$_phoneContactField",
    "emailValidation" => "$_emailField",
    "typeCompany" => "$_typeCompanyField",
);

$_array_drivers=array();
$_elementsCount=count($_arrayDivers);
$_elementDivisor=$_elementsCount/5;
for($n=0;$n<$_elementDivisor;$n++){
    $_array=array(
        "driverFirstName"=>$_arrayDivers[$n],
        "driverLastName"=>$_arrayDivers[$n+$_elementDivisor],
        "driverPhone"=>$_arrayDivers[$n+($_elementDivisor*2)],
        "driverLicense"=>$_arrayDivers[$n+($_elementDivisor*3)],
        "driverStatus"=>$_arrayDivers[$n+($_elementDivisor*4)],
    );
    array_push($_array_drivers,$_array);
}
//print_r($_arrayDivers);

$_userController=new userController();
$_companyID=$_userController->insertContractor($_arrayCompany);
if(strpos($_companyID,"Error")!==false){
    echo "Error register company,try again ".$_companyID;
}else{
    $_driverController=new driverController();
    $_driverController->insertDrivers($_companyID,$_array_drivers);
    echo "Continue, Company was register correctly";
}
?>