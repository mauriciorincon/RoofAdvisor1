<?php

require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/controlador/orderController.php");

$RepZIP=$_POST['RepZIP'];
$RequestType=$_POST['RequestType'];
$Rtype=$_POST['Rtype'];
$Water=$_POST['Water'];
$Hlevels=$_POST['Hlevels'];
$ActAmtTime=$_POST['ActAmtTime'];
$ActTime=$_POST['ActTime'];
$ContractorID=$_POST['ContractorID'];


$_array=array(
    "RepZIP"=>$_POST['RepZIP'],
    "RequestType"=>$_POST['RequestType'],
    "Rtype"=>$_POST['Rtype'],
    "Water"=>$_POST['Water'],
    "Hlevels"=>$_POST['Hlevels'],
    "ActAmtTime"=>$_POST['ActAmtTime'],
    "ActTime"=>$_POST['ActTime'],
    "ContractorID"=>$_POST['ContractorID'],
);


$_orderController=new orderController();
$_id_order=$_orderController->insertOrder($_orderController);
if (is_null($_id_order)){
    echo "Error, an error ocurred traing to save Order, try again";
}else{
    echo $_id_driver."|Continue, Order was register correctly";
}


?>