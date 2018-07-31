<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/orderController.php");
require_once($_SESSION['application_path']."/controlador/userController.php");

$_orderID =$_POST["orderId"];

$_orderController=new orderController();
$_result=$_orderController->getOrder('OrderNumber',$_orderID);

if(is_null($_result)){
    "Error, no order were found.";
}else{
    $_companyCustomerContractorController=new userController();
    $_company=$_companyCustomerContractorController->getCompanyById($_result['CompanyID']);

    if(!is_null($_company)){
        $_result=array_merge($_result,$_company);
    }

    $_customer=$_companyCustomerContractorController->getCustomerById($_result['CustomerID']);
    if(!is_null($_customer)){
        $_result=array_merge($_result,$_customer);
    }
    $_contractor=$_companyCustomerContractorController->getContractorById($_result['ContractorID']);
    if(!is_null($_contractor)){
        $_result=array_merge($_result,$_contractor);
    }
    
}

echo json_encode($_result);


/*$_string='<div>
            <table class="table table-bordered">
                <tr><td>Order ID</td><td>'.$_result['OrderNumber'].'</td></tr>
                <tr><td>Company</td><td>'.$_result['CompanyID'].'</td></tr>
                <tr><td>Contractor</td><td>'.$_result['ContractorID'].'</td></tr>
                <tr><td>Customer</td><td>'.$_result['CustomerID'].'</td></tr>
                <tr><td>Schedule Date</td><td>'.$_result['SchDate'].'</td></tr>
                <tr><td>Schedule Time</td><td>'.$_result['SchTime'].'</td></tr>
                <tr><td>Status</td><td>'.$_result['Status'].'</td></tr>
                <tr><td>Description</td><td>'.$_result['Hlevels'].", ".$_result['Rtype'].", ".$_result['Water'].'</td></tr>
            </table>
        </div>';
echo $_string;*/
//print_r($_result);
?>