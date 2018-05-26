<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 


require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/modelo/order.class.php");
require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/controlador/userController.php");

class orderController{

    private $_orderModel=null;
    private $_userController=null;

    function __construct()
	{		
    }

    function getOrder($field,$value){
        $this->_orderModel=new orderModel();
        $_order=$this->_orderModel->getOrder($field,$value);
        return $_order;
    }

    function getOrders($field,$value){
        $this->_orderModel=new orderModel();
        $_orders=$this->_orderModel->getOrders($field,$value);
        return $_orders;
    }

    function insertOrder($arrayDataOrder){
        $this->_userController=new userController();
        $_customer=$this->_userController->getCustomer($_SESSION['email']);
        $_customerK=$this->_userController->getCustomerK($_SESSION['email']);
        //print_r($_customer);
        //print_r($_customerK);
        $timeparts = explode(" ",microtime());
        $currenttime = bcadd(($timeparts[0]*1000),bcmul($timeparts[1],1000));
        echo $currenttime;
        $Order = array(
            "ActAmtMat" => "",
            "ActAmtTime" => $arrayDataOrder['ActAmtTime'],
            "ActTime" => $arrayDataOrder['ActTime'],
            "AfterPICRefID" => "",
            "AmtER" => "",
            "AppEst" => "",
            "Authorized" => "",
            "BeforePicRefID" => "",
            "ContractorID" => $arrayDataOrder['ContractorID'],
            "CustomerID" => $_customer['CustomerID'],
            "CutomerFBID" => $_customerK[0],
            "DateTime" => "2018-05-09-17=>01=>56",
            "ETA" => "05/09/2018 17=>02",
            "EstAmtMat" => "300",
            "EstAmtTime" => "300.0",
            "EstTime" => "2",
            "FBID" => "-LC5hTQX5uWFOwMK_dCo",
            "Hlevels" => $arrayDataOrder['Hlevels'],
            "InvoiceNum" => "",
            "Latitude" => "42.344149235302",
            "Longitude" => "-71.0652257502079",
            "OrderNumber" => "112",
            "PaymentType" => "",
            "RepAddress" => "474 Harrison Ave",
            "RepCity" => "Boston",
            "RepState" => "Massachusetts",
            "RepZIP" => $arrayDataOrder['RepZIP'],
            "RequestType" => $arrayDataOrder['RequestType'],
            "Rtype" => $arrayDataOrder['Rtype'],
            "SchDate" => "",
            "SchTime" => "",
            "Status" => "G",
            "TransNum" => "",
            "Water" => $arrayDataOrder['Water'],
        );

    }
}