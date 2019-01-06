<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 


require_once($_SESSION['application_path']."/modelo/order.class.php");
require_once($_SESSION['application_path']."/controlador/userController.php");
require_once($_SESSION['application_path']."/controlador/pdfController.php");
require_once($_SESSION['application_path']."/controlador/payingController.php");
require_once($_SESSION['application_path']."/controlador/othersController.php");


class orderController{

    private $_orderModel=null;
    private $_userController=null;
    private $_otherController=null;

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

    public function insertOrder($arrayDataOrder,$emailCustomer=""){
        $_result_invoice="";
        $this->_userController=new userController();
        $this->_orderModel=new orderModel();
        if(strcmp($arrayDataOrder['RequestType'],"P")!=0){
            if(empty($emailCustomer)){
                $_customer=$this->_userController->getCustomer($_SESSION['email']);
                $_customerK=$this->_userController->getCustomerK($_SESSION['email']);
            }else{
                $_customer=$this->_userController->getCustomer($emailCustomer);
                $_customerK=$this->_userController->getCustomerK($emailCustomer);
            }
            
        }else{
            $_customer=array(
                "CustomerID"=>"",
                "City"=>"",
                "State"=>"",
            );
            $_customerK="";
        }
        
        //echo $_customer;
        //echo $_customerK;
        //exit;
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
                if(empty($arrayDataOrder['CompanyID'])){
                    $arrayDataOrder['CompanyID']="CO000000";
                }
                $arrayDataOrder['ContractorID']="";
                break;
            case "P":
                $_firstStatus="T";
                break;
            case "M":
                $_firstStatus="A";
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
            "CustomerFBID" => $_customerK,
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
            "postCardValue"=>$arrayDataOrder['postCardValue'],
            "CreateBy"=>$arrayDataOrder['CreateBy'],
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
                //create invoce for customer
                $_result_invoice=$_objPDF->paymentConfirmation1($_lastOrderNumber,$Order,$arrayDataOrder['amount_value'],$arrayDataOrder['id_stripe']);
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
        $stripeID="";
        $amount="";
        $paymentType="";
        $actionType="";
        $companySelected="";

        $this->_orderModel=new orderModel();
        

        for($n=0;$n<count($arrayFields);$n+=2){
           
            if(strcmp($arrayFields[$n],"pay_to_company")==0){
                if(strcmp($arrayFields[$n+1],"1")==0){
                    $_order=$this->getOrderByID($orderID);
                    $_payingController=new payingController();
                    $_order['RequestType']='TSE';
                    //$_order['CompanyID']=$companySelected;
                    if(!isset($this->_otherController)){
                        $this->_otherController = new othersController();
                    }
                    $_roofReportValue=$this->_otherController->getParameterValue("Parameters/roofreportTakingRate");
                    if(empty($_roofReportValue)){
                        $_roofReportValue=12500;
                    }
                    $_response_transfer=$_payingController->selectPaying("info@roofservicenow.com","",$_roofReportValue,"usd",$_order,"TSE");
                    //$_payingController->createTransfer("20000","usd",$connectAcount,$description)
                }
            }else{
                if(strcmp($arrayFields[$n],"CompanyID")==0){
                    $_orderInfo=$this->_orderModel->getOrderByID($orderID);
                    if(empty($_orderInfo['CompanyID'])){
                        $_result=$this->_orderModel->updateOrder($orderID.'/'.$arrayFields[$n],$arrayFields[$n+1]);
                    }
                    //$companySelected=$arrayFields[$n+1];
                }else{
                    $_result=$this->_orderModel->updateOrder($orderID.'/'.$arrayFields[$n],$arrayFields[$n+1]);
                }
            }
            
            
            if(strcmp($arrayFields[$n],"StripeID")==0){
                $stripeID=$arrayFields[$n+1];
            }
            if(strcmp($arrayFields[$n],"amount")==0){
                $amount=$arrayFields[$n+1];
            }
            if(strcmp($arrayFields[$n],"PaymentType")==0){
                $paymentType=$arrayFields[$n+1];
            }
            if(strcmp($arrayFields[$n],"action_type")==0){
                $actionType=$arrayFields[$n+1];
            }

        }
        if(!empty($paymentType)){
            $_objPDF=new pdfController();
            $_result_invoice=$_objPDF->paymentConfirmation2($orderID,null,$amount,$stripeID,$paymentType,$actionType);
        }
        if(is_bool($_result)){
            if(!empty($paymentType)){
                return "Thank you for your payment. An invoice has been sent to your email. Please remenber to rate your contractor and service.";
            }else{
                return "The order was update correctly.";
            }
            
        }else{
            return $_result;
        }
        
    }

    public function updateOrderLastId($orderId){
        $this->_orderModel=new orderModel();
        $this->_orderModel->updateOrderLastId($orderId);
    }

    public function getOrderInvoices($orderID){
        $this->_orderModel=new orderModel();
        return $this->_orderModel->getOrderInvoices($orderID);

    }
    
    public function getOrderCommentaries($orderID){
        $this->_orderModel=new orderModel();
        return $this->_orderModel->getOrderCommentaries($orderID);

    }

    public function insertOrderComentary($orderID,$comment){
        $_commenary=[
            "user_comment" => $_SESSION['username'],
            "date_comment" => date('m-d-Y h:m:s'),
            "text_comment" =>$comment
            ];
        $this->_orderModel=new orderModel();
        $_result=$this->_orderModel->insertOrderCommentary($orderID,$_commenary);
            
        if(strpos($_result,'Error')>-1){
            return "Error, An error occur while saving the comment";
        }else{
            return "Ok, the comment was saved successfully";    
        }
        
    }

    public function getOrderFilesInfo($orderID){
        $this->_orderModel=new orderModel();
        return $this->_orderModel->getOrderFilesInfo($orderID);

    }

    public function insertOrderFile($orderID,$file_name){
        $_file_data=[
            "user_upload" => $_SESSION['username'],
            "date_upload" => date('m-d-Y h:m:s'),
            "file_name" =>$file_name
            ];
        $this->_orderModel=new orderModel();
        $_result=$this->_orderModel->insertOrderFile($orderID,$_file_data);
            
        if(strpos($_result,'Error')>-1){
            return "Error, An error occur while saving the file data";
        }else{
            return "Ok, the file data was saved successfully";    
        }
        
    }
    

}