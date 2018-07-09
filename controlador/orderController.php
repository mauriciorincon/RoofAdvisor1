<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 


require_once($_SESSION['application_path']."/modelo/order.class.php");
require_once($_SESSION['application_path']."/controlador/userController.php");

class orderController{

    private $_orderModel=null;
    private $_userController=null;

    function __construct()
	{		
    }

    public function getOrder($field,$value){
        $this->_orderModel=new orderModel();
        $_order=$this->_orderModel->getOrder($field,$value);
        return $_order;
    }

    public function getOrders($field,$value){
        $this->_orderModel=new orderModel();
        $_orders=$this->_orderModel->getOrders($field,$value);
        return $_orders;
    }

    public function getOrdersAll(){
        $this->_orderModel=new orderModel();
        $_orders=$this->_orderModel->getOrdersAll();
        return $_orders;
    }

    public function insertOrder($arrayDataOrder){
        $this->_userController=new userController();
        $this->_orderModel=new orderModel();
        $_customer=$this->_userController->getCustomer($_SESSION['email']);
        $_customerK=$this->_userController->getCustomerK($_SESSION['email']);
        $_lastOrderNumber=$this->_orderModel->getLastOrderNumber("Orders","OrderNumber");
        $_contractor=$this->_userController->getContractorById($arrayDataOrder['ContractorID']);
        if(is_null($_lastOrderNumber)){
            $_lastOrderNumber=1;
        }else{
            $_lastOrderNumber++;
        }
        //print_r($arrayDataOrder);
        //print_r($_customerK);
        
        $Order = array(
            "ActAmtMat" => "",
            "ActAmtTime" => $arrayDataOrder['ActAmtTime'],
            "ActTime" => $arrayDataOrder['ActTime'],
            "AfterPICRefID" => "",
            "AmtER" => "",
            "AppEst" => "",
            "Authorized" => "",
            "BeforePicRefID" => "",
            "CompanyID"=>$arrayDataOrder['CompanyID'],
            "ContractorID" => $arrayDataOrder['ContractorID'],
            "CustomerID" => $_customer['CustomerID'],
            "CutomerFBID" => $_customerK,
            "DateTime" => time('Y-m-d H:i:s'),
            "ETA" => time('Y-m-d H:i:s'),
            "EstAmtMat" => "",
            "EstAmtTime" => "",
            "EstTime" => "",
            "FBID" => "",
            "Hlevels" => $arrayDataOrder['Hlevels'],
            "InvoiceNum" => "",
            "Latitude" => $arrayDataOrder['Latitude'],
            "Longitude" => $arrayDataOrder['Longitude'],
            "OrderNumber" => "$_lastOrderNumber",
            "PaymentType" => "",
            "RepAddress" => $arrayDataOrder['Address'],
            "RepCity" => $_customer['City'],
            "RepState" => $_customer['State'],
            "RepZIP" => $arrayDataOrder['RepZIP'],
            "RequestType" => $arrayDataOrder['RequestType'],
            "Rtype" => $arrayDataOrder['Rtype'],
            "SchDate" => $arrayDataOrder['ActAmtTime'],
            "SchTime" => $arrayDataOrder['ActTime'],
            "Status" => "A",
            "TransNum" => "",
            "Water" => $arrayDataOrder['Water'],
        );
       // print_r($Order);
        $result=$this->_orderModel->insertOrder("",$Order);
        return $result;
    }

    public function getCountRating($field,$value){
        $this->_orderModel=new orderModel();
        $_count=$this->_orderModel->getCountRating($field,$value);
        return $_count;
    }

    public function getRatingsContractor($value){
        $this->_orderModel=new orderModel();
        $_ratings=$this->_orderModel->getRating("IdContractor",$value);
        return $_ratings;
    }

    public function getRatingsByCompany($value){
        $this->_orderModel=new orderModel();
        $_ratings=$this->_orderModel->getRating("IdCompany",$value);
        return $_ratings;
    }

    public function getOrderByCompany($companyID){
        $this->_orderModel=new orderModel();
        $_orders=$this->_orderModel->getOrders('CompanyID',$companyID);
        return $_orders;

    }

    

}