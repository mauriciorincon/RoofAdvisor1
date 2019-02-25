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
$_inBussinessSince = $_POST['inBussinessSince'];
$_licenseNumber = $_POST['licenseNumber'];
$_expirationDate = $_POST['expirationDate'];


$_arrayCompany = array(
    "companyName" => "$_companyNameField",
    "firstNameCompany" => "$_firstNameField",
    "lastNameCompany" => "$_lastNameField ",
    "phoneContactCompany" => "$_phoneContactField",
    "emailValidation" => "$_emailField",
    "typeCompany" => "$_typeCompanyField",
    "password" => "$_password",
    "InBusinessSince" => "$_inBussinessSince",
    "ComapnyLicNum" => "$_licenseNumber",
    "LicExpiration" => "$_expirationDate",
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
    
    $_string_message = "Error register company,try again $_companyID";
    $_message=array(
        'title'=>"Register Company",
        'subtitle'=>"",
        'content'=>$_string_message,
    );
}else{
    $_string_message = '<div class="alert alert-success">Registration success<br>Your registration phone:<a href="#" onclick="setDataChangePhoneMail(\''. $_arrayCompany['emailValidation'] .'\',\'co\',\''. $_arrayCompany['phoneContactCompany'] .'\',\'phone\')">'. $_arrayCompany['phoneContactCompany'] .'</a><br>Your registration email:<a href="#" onclick="setDataChangePhoneMail(\''. $_arrayCompany['emailValidation'] .'\',\'co\',\''. $_arrayCompany['emailValidation'] .'\',\'email\')">'. $_arrayCompany['emailValidation'] .'</a></div><br>'.
    '<h4>Type your activation code</h4><input type="text" id="activation_code_input" />'.
    '<br><br><strong>Did not get a code?</strong>'.
    '<button type="button" id="resendCode" class="btn-primary btn-sm" onclick="resendValidationCode(\'' . $_arrayCompany['emailValidation'] . '\',\'\',\'phone\',\'co\')">Resend Code</button>'.
    '<a href="#" class="btn-primary btn-sm" onclick="resendValidationCode(\'' . $_arrayCompany['emailValidation'] .  '\',\'\',\'mail\',\'co\')">SEND ME THE VALIDATION CODE BY EMAIL</a>';
    $_string_button = '<br><br>                                       
    <div class="alert alert-warning" role="alert">
        <center><button type="button" id="lastFinishButtonOrder" class="btn-success btn-lg" data-dismiss="modal" onclick="validate_sms_code(\'co\',\''. $_arrayCompany['emailValidation'] .'\')">Validate Code</button></center>
    </div>';

    if(count($_array_drivers)>0){
        $_pos=strpos($_companyID,"*");
        if($_pos!==false){
            $_consecutive=substr($_companyID,0,$_pos);
        }
        $_driverController=new driverController();
        $_driverController->insertDrivers($_consecutive,$_array_drivers);
    }
    
    $_message=array(
        'title'=>"Register Company",
        'subtitle'=>"",
        'content'=>$_string_message,
        'button' =>$_string_button,
        'extra' =>$_companyID,
    );

}
print_r(json_encode($_message));
?>