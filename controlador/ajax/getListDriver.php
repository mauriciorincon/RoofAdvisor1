<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");

$_companyID=$_POST['companyID'];
$_userModel=new userModel();
$_array_contractors_to_show=$_userModel->getContractorsCompany($_companyID);

$_string="";

foreach ($_array_contractors_to_show as $key => $contractor) {
    echo "entro aca";
    $_driverMail="";
    if (isset($contractor['driverEmail'])){$_driverMail=$contractor['driverEmail'];}else{$_driverMail='';}
    $_string.='<tr>
        <td>'.$contractor['ContractorID'].'</td>
        <td>'.$contractor['ContNameFirst'].'</td>
        <td>'.$contractor['ContNameLast'].'</td>
        <td>'.$contractor['ContPhoneNum'].'</td>
        <td>'.$contractor['ContLicenseNum'].'</td>
        <td>'.$_driverMail .'</td>
        <td>'.$contractor['ContStatus'].'</td>
        <td><a class="btn-info btn-sm" data-toggle="modal"  
                href="#myModal2" 
                onClick=""> 
                <span class="glyphicon glyphicon-pencil"></span>
            </a>
        </td>
        <td>
            <a href="#" class="inactivate-contractor-button btn-danger btn-sm" id="inactivate-contractor-button" name="inactivate-contractor-button">
                <span class="glyphicon glyphicon-trash"></span>
            </a>
        </td>
    </tr>';
}
echo $_string;
?>