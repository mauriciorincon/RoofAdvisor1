<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 


require_once($_SESSION['application_path']."/modelo/order.class.php");
require_once($_SESSION['application_path']."/controlador/userController.php");
require_once($_SESSION['application_path']."/controlador/pdfController.php");


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

    public function getOrderByID($orderID){
        $this->_orderModel=new orderModel();
        $_orders=$this->_orderModel->getOrderByID($orderID);
        return $_orders;
    }

    public function insertOrder($arrayDataOrder){
        $_result_invoice="";
        $this->_userController=new userController();
        $this->_orderModel=new orderModel();
        $_customer=$this->_userController->getCustomer($_SESSION['email']);
        $_customerK=$this->_userController->getCustomerK($_SESSION['email']);
        //$_lastOrderNumber=$this->_orderModel->getLastOrderNumber("Orders","OrderNumber");
        $_lastOrderNumber=$this->_orderModel->getLasOrderNumberParameter('Parameters/LastOrderID');
        $_contractor=$this->_userController->getContractorById($arrayDataOrder['ContractorID']);
        if(is_null($_lastOrderNumber)){
            $_lastOrderNumber=1;
        }else{
            $_lastOrderNumber++;
        }
        //print_r($arrayDataOrder);
        //print_r($_customerK);
        if(!empty($arrayDataOrder['SchDate'])){
            $_scheduleDate=str_replace("-","/",$arrayDataOrder['SchDate']);
        }else{
            $_scheduleDate="";
        }
        $_firstStatus="";
        switch($arrayDataOrder['RequestType']){
            case "E":
                $_firstStatus="A";
                break;
            case "S":
                $_firstStatus="A";
                break;
            case "R":
                $_firstStatus="P";
                break;

        }
        $Order = array(
            "ActAmtMat" => "",
            "ActAmtTime" => "",
            "ActTime" => "",
            "AfterPICRefID" => "",
            "AmtER" => "",
            "AppEst" => "",
            "Authorized" => $arrayDataOrder['Authorized'],
            "BeforePicRefID" => "",
            "CompanyID"=>$arrayDataOrder['CompanyID'],
            "ContractorID" => $arrayDataOrder['ContractorID'],
            "CustomerID" => $_customer['CustomerID'],
            "CutomerFBID" => $_customerK,
            "DateTime" => date('m/d/Y H:i:s'),
            "ETA" => "",
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
            "SchDate" => $_scheduleDate,
            "SchTime" => $arrayDataOrder['SchTime'],
            "Status" => "$_firstStatus",
            "TransNum" => "",
            "Water" => $arrayDataOrder['Water'],
            "StripeID"=>$arrayDataOrder['id_stripe'],
        );
       // print_r($Order);
        $_result=$this->_orderModel->insertOrder("FBID",$Order);
        
        
        if(strpos($_result,'Error')>-1){
            return null;
        }else{
            $this->updateOrderLastId($_lastOrderNumber);
            if(strcmp($arrayDataOrder['RequestType'],"E")==0 or strcmp($arrayDataOrder['RequestType'],"R")==0){
                $_objPDF=new pdfController();
                $Order['FBID']=$_result->getKey();
                $_result_invoice=$_objPDF->paymentConfirmation1($_lastOrderNumber,$Order,$arrayDataOrder['amount_value']);
            }
        }
        return $_result." - ".$_result_invoice;
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

    public function updateOrder($orderID,$arrayFields){
        $this->_orderModel=new orderModel();
        

        for($n=0;$n<count($arrayFields);$n+=2){

            $_result=$this->_orderModel->updateOrder($orderID.'/'.$arrayFields[$n],$arrayFields[$n+1]);
        }
        if(is_bool($_result)){
            return "The order was update correctly";
        }else{
            return $_result;
        }
        
    }

    public function updateOrderLastId($orderId){
        $this->_orderModel->updateOrderLastId($orderId);
    }

    

}