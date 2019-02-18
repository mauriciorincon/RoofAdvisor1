<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 


require_once($_SESSION['application_path']."/modelo/order.class.php");
require_once($_SESSION['application_path']."/controlador/userController.php");
require_once($_SESSION['application_path']."/controlador/pdfController.php");
require_once($_SESSION['application_path']."/controlador/payingController.php");
require_once($_SESSION['application_path']."/controlador/othersController.php");
require_once($_SESSION['application_path']."/controlador/smsController.php");


class orderController{

    private $_orderModel = null;
    private $_userController = null;
    private $_otherController = null;
    private $_smsController = null;

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

    public function insertOrder($arrayDataOrder,$emailCustomer="",$action_type,$createdTo="0"){
        $_result_invoice="";
        $this->_userController=new userController();
        $this->_orderModel=new orderModel();
        
        if(strcmp($arrayDataOrder['RequestType'],"P")!=0){
            if(empty($emailCustomer)){
                $_customer=$this->_userController->getCustomer($_SESSION['email']);
                $_customerK=$this->_userController->getCustomerK($_SESSION['email']);
            }else{
                if(strcmp($createdTo,"0")==0){
                    $_customer=$this->_userController->getCustomer($emailCustomer);
                    $_customerK=$this->_userController->getCustomerK($emailCustomer);
                }else{
                    $_customer=$this->_userController->getCustomerById($createdTo);
                    $_customerK=$this->_userController->getCustomerKById($createdTo);
                }
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
        $_ActAmtMat="";
        $_ActAmtTime="";
        $_ActTime="";
        $_EstAmtMat="";
        $_EstAmtTime="";
        $_EstTime="";
        switch($arrayDataOrder['RequestType']){
            case "E":
                $_firstStatus="A";
                break;
            case "S":
                $_firstStatus="A";
                break;
            case "G":
                $_firstStatus="A";
                break;
            case "R":
                $_firstStatus="P";
                if(empty($arrayDataOrder['CompanyID'])){
                    $arrayDataOrder['CompanyID']="CO000000";
                }
                $arrayDataOrder['ContractorID']="";
                $_otherController= new othersController();
                $_reportValue = $_otherController->getParameterValue("Parameters"."/"."AmountReport");
                if(empty($_reportValue)){
                    $_reportValue=0;
                }else{
                    $_reportValue=$_reportValue/100;
                }
                $_ActAmtMat="$_reportValue";
                $_ActAmtTime="0";
                $_ActTime="0";
                $_EstAmtMat="$_reportValue";
                $_EstAmtTime="0";
                $_EstTime="0";
                break;
            case "P":
                $_firstStatus="T";
                break;
            case "M":
                $_firstStatus="A";
                break;
        }
        $Order = array(
            "ActAmtMat" => $_ActAmtMat,
            "ActAmtTime" => $_ActAmtTime,
            "ActTime" => $_ActTime,
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
            "EstAmtMat" => $_EstAmtMat,
            "EstAmtTime" => $_EstAmtTime,
            "EstTime" => $_EstTime,
            "FBID" => "",
            "Hlevels" => $arrayDataOrder['Hlevels'],
            "InvoiceNum" => "",
            "Latitude" => $arrayDataOrder['Latitude'],
            "Longitude" => $arrayDataOrder['Longitude'],
            "OrderNumber" => "$_lastOrderNumber",
            "PaymentType" => "",
            "RepAddress" => $arrayDataOrder['Address'],
            "RepCity" => $arrayDataOrder['RepCity'],
            "RepState" => $arrayDataOrder['RepState'],
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
                $_result_invoice=$_objPDF->paymentConfirmation1($_lastOrderNumber,$Order,$arrayDataOrder['amount_value'],$arrayDataOrder['id_stripe'],$action_type);
                
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
                    
                    if(strcmp($_order['CreateBy'],"CO000000")==0){
                        if(!isset($this->_otherController)){
                            $this->_otherController = new othersController();
                        }
                        $_roofReportValue=$this->_otherController->getParameterValue("Parameters/roofreportTakingRate");
                        if(empty($_roofReportValue)){
                            $_roofReportValue=12500;
                        }
                        $_response_transfer=$_payingController->selectPaying("info@roofservicenow.com","",$_roofReportValue,"usd",$_order,"TSE");
                    }
                    
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
            if(strcmp($arrayFields[$n],"Status")==0){
                $_status = $arrayFields[$n+1];
                if(strcmp($_status,"D")==0 or strcmp($_status,"E")==0 or strcmp($_status,"F")==0 or strcmp($_status,"I")==0 or strcmp($_status,"J")==0 or strcmp($_status,"K")==0){
                    if($this->_smsController ==null){
                        $this->_smsController = new smsController();
                    }
                    $_msg = "";
                    $_order=$this->getOrderByID($orderID);
                    $_id_customer = $_order['CustomerFBID'];
                    $this->_userController=new userController();
                    $_companyName = $this->_userController->getNode("Company/".$_order['CompanyID']."/CompanyName");
                    $_contractorName = $this->_userController->getNode("Contractors/".$_order['ContractorID']."/ContNameFirst");
                    $_contractorLastName = $this->_userController->getNode("Contractors/".$_order['ContractorID']."/ContNameLast");
                    switch($_status){
                        case "A":
                            $_msg = "RoofServiceNow has received your job order $orderID. A service professional will be confirming shortly.";
                            break;
                        case "D":
                            if(strcmp($_order['RequestType'],'R')){
                                $_msg = "$_contractorName $_contractorLastName, from RoofServiceNow, is working on your request for a roof report.  We will let you know when completed.";
                            }else{
                                $_msg = "$_companyName has confirmed your order $orderID. $_contractorName $_contractorLastName will be contacting you shortly.";
                            }
                            break;
                        case "E":
                            $_msg = "$_contractorName $_contractorLastName<Pro> has just arrived at your location.";
                            break;
                        case "F":
                            $_msg = "$_contractorName $_contractorLastName has sent you an estimate for order $orderID. Please login to RoofServiceNow and approve the estimate. https://roofservicenow.com/index.php?controller=user&accion=dashboardCustomer";
                            break;
                        case "I":
                            $_msg = "$_contractorName $_contractorLastName has completed the job and will send you a final invoice shortly.";
                            break;
                        case "J":
                            $_msg = "$_companyName has sent you a final invoice. Please login to RoofServiceNow and to make final payment. https://roofservicenow.com/index.php?controller=user&accion=dashboardCustomer";
                            break;
                        case "K":
                            if(strcmp($_order['RequestType'],'R')){
                                $_msg = "Your report is complete. Please login to RoofserviceNow to download your report. Thank you for using RoofServiceNow.";
                            }else{
                                $_msg = "Thank you for using RoofserviceNow. Please take a minute to rate your experience with $_contractorName $_contractorLastName.";
                            }
                            break;
                    }
                    $_customer = $this->_userController->getNode("Customers/".$_id_customer);
                    $_smsClient = $this->_smsController->createClientSms();
                    print_r($_customer);
                    $this->_smsController->sendMessage("+18889811812",$_customer['Phone'],$_msg);
                }
                

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