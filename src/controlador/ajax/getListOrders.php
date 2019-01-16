<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/orderController.php");
require_once($_SESSION['application_path']."/controlador/userController.php");

$field=$_POST['field'];
$value=$_POST['value'];
$_orderController=new orderController();
$_array_orders=$_orderController->getOrders($field,$value);
//print_r($_array_orders);
$_string="";
foreach ($_array_orders as $key => $order) {
    $_order_id = isset($order['OrderNumber']) ? $order['OrderNumber'] : '';
    $_company_id = isset($order['CompanyID']) ? getCompanyName($order['CompanyID']) : ' ';
    $_contractor_id=isset($order['ContractorID']) ? getContractorName($order['ContractorID']) : ' ';
    $_created_by =isset($order['CreateBy']) ? getCompanyName($order['CreateBy']) : ' ';
    $_created_date =isset($order['DateTime']) ? $order['DateTime'] : ' ';
    $_request_type = isset($order['RequestType']) ? getRequestType($order['RequestType']) : '';
    $_status = isset($order['Status']) ? getStatus($order['Status']) : '';
   
    $_string.="<tr>".
        "<td>".$_order_id."</td>".
        "<td>".$_company_id."</td>".
        "<td>".$_contractor_id."</td>".
        "<td>".$_created_by."</td>".
        "<td>".$_created_date."</td>".
        "<td>".$_request_type."</td>".
        "<td>".$_status."</td>".
    "</tr>";
}
echo $_string;

function getStatus($status){
    $orderStatus="";
    switch ($status) {
        case "A":
            $orderStatus = "Order Open";
            break;
        case "C":
            $orderStatus = "Acepted Order";
            break;
        case "D":
            $orderStatus = "Order Assigned";
            break;
        case "E":
            $orderStatus = "Contractor Just Arrived";
            break;
        case "F":
            $orderStatus = "Estimate Sent";
            break;
        case "G":
            $orderStatus = "Estimate Approved";
            break;
        case "H":
            $orderStatus = "Work In Progress";
            break;
        case "I":
            $orderStatus = "Work Completed";
            break;
        case "J":
            $orderStatus = "Final Bill";
            break;
        case "K":
            $orderStatus = "Order Completed Paid";
            break;
        case "Z":
            $orderStatus = "Cancel work";
            break;
        case "P":
            $orderStatus = "Report In Progress";
            break;
        case "R":
            $orderStatus = "Report In Progress";
            break;
        case "S":
            $orderStatus = "Report Complete";
            break;
        case "T":
            $orderStatus = "Orden In Progress";
            break;
        case "U":
            $orderStatus = "Orden Asigned";
            break;
        case "M":
            $orderStatus = "Mailed";
            break;
        default:
            $orderStatus = "Undefined";
    }
    return $orderStatus;
}

function getRequestType($requestType){
    $RT="";
    switch ($requestType) {
        case "E":
            $RT = "Emergency";
            break;
        case "S":
            $RT = "Schedule";
            break;
        case "R":
            $RT = "RoofReport";
            break;
        case "P":
            $RT = "PostCard";
            break;
        case "M":
            $RT = "Re-roof or New";
            break;
        default:
            $RT = "No value found";
    }
    return $RT;
}

function getCompanyName($companyID){
    $_userController = new userController();
    $_result=$_userController->getCompanyById($companyID);
    if(is_object($_result) or is_array($_result)){
        $_results=$_result['CompanyName'];
    }else{
        $_results=$companyID;
    }
    return $_results;
}

function getContractorName($contractorID){
    $_userController = new userController();
    $_result=$_userController->getContractorById($contractorID);
    if(is_object($_result) or is_array($_result)){
        $_results=$_result['ContNameFirst']." ".$_result['ContNameLast'];
    }else{
        $_results=$contractorID;
    }
    return $_results;
}
?>