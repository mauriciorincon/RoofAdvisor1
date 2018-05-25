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

    function insertOrder($idCustomer,$arrayDataOrder){

        
        $Company = array(
            "ActAmtMat" => "",
            "ActAmtTime" => "",
            "ActTime" => "",
            "AfterPICRefID" => "",
            "AmtER" => "",
            "AppEst" => "",
            "Authorized" => "Yes",
            "BeforePicRefID" => "",
            "ContractorID" => "CN0001",
            "CustomerID" => "10",
            "CutomerFBID" => "ZvZWN9sV05gzqBpn4raxor5X8Pk2",
            "DateTime" => "2018-05-09-17=>01=>56",
            "ETA" => "05/09/2018 17=>02",
            "EstAmtMat" => "300",
            "EstAmtTime" => "300.0",
            "EstTime" => "2",
            "FBID" => "-LC5hTQX5uWFOwMK_dCo",
            "Hlevels" => "1 Story",
            "InvoiceNum" => "",
            "Latitude" => "42.344149235302",
            "Longitude" => "-71.0652257502079",
            "OrderNumber" => "112",
            "PaymentType" => "",
            "RepAddress" => "474 Harrison Ave",
            "RepCity" => "Boston",
            "RepState" => "Massachusetts",
            "RepZIP" => "02118",
            "RequestType" => "R",
            "Rtype" => "Flat",
            "SchDate" => "",
            "SchTime" => "",
            "Status" => "G",
            "TransNum" => "",
            "Water" => "Yes",
        );

    }
}