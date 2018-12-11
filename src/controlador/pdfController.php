<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

//require $_SESSION['application_path'].'/vendor/autoload.php';
require $_SESSION['library_path_autoload'];
require_once($_SESSION['application_path']."/controlador/orderController.php");
require_once($_SESSION['application_path']."/controlador/userController.php");
require_once($_SESSION['application_path']."/controlador/othersController.php");
require_once($_SESSION['application_path']."/controlador/payingController.php");
require_once($_SESSION['application_path']."/controlador/emailController.php");


class pdfController{
    
    private $_orderController=null;
    private $_otherController=null;

    function __construct(){
        
    }

    function paymentConfirmation1($_orderID,$object_order,$_amount=0,$_stripe_id=""){
        
        if($_amount>0){
            $_amount=$_amount/100; 
        }
        $_invoice_number="";
        $_consecutive_invoice=0;
        $_card_data="";
        $_exp_date="";
        $_order_type="";
        $this->_otherController=new othersController();
        $this->_orderController=new orderController();
        if(isset($object_order)){
            $_order=$object_order;
        }else{
            $_order=$this->_orderController->getOrder("OrderNumber",$_orderID);
        }
        

        if(is_null($_order)){
            echo "The order number no exists [$_orderID]";
            return;
        }

        $_companyCustomerController=new userController();
        $_company=$_companyCustomerController->getCompanyById("CO000000");

        if(is_null($_company)){
            echo "The company no exists";
            return;
        }

        $_customer=$_companyCustomerController->getCustomerById($_order['CustomerID']);
        if(is_null($_customer)){
            echo "The customer no exists";
            return;
        }

        $_consecutive_invoice=$this->_otherController->getParameterValue("Parameters/InvoiceNum");
        
        if(is_null($_consecutive_invoice) or $_consecutive_invoice==""){
            $_invoice_number=$_orderID."_10000";
        }else{
            $_invoice_number=$_orderID."_".$_consecutive_invoice;
        }

        
        $_title_bill="undefined";
        switch($_order['RequestType']){
            case "E":
                $_title_bill="Emergency Roof Service";
                $_order_type= "Emergency Service";
                break;
            case "R":
                $_title_bill="Order Roof Report Service";
                $_order_type= "RoofReport Service";
                break;
            case "S":
                $_order_type= "Schedule Service";
                $_title_bill="";
            default:
                $_order_type= "Undefined";
                $_title_bill="";
                break;
        }

        $_date_invoice=date('m-d-Y');
        
        if(!empty($_stripe_id)){
            $_payingController = new payingController();
            $_result=$_payingController->getPayingData($_stripe_id);
            $_card_data=$_result->source->last4;
            $_exp_date=$_result->source->exp_month." / ".$_result->source->exp_year;
        }
       
       

        $pdf = new TCPDF();                 // create TCPDF object with default constructor args
        $pdf->AddPage();                    // pretty self-explanatory

        $pdf->SetMargins(25, 31 , 15); 
        $pdf->SetAutoPageBreak(TRUE, 35);
        $pdf -> SetX(25);
        $pdf -> SetY(31);
        
        $pdf->SetFont('times','',10);

        if(!isset($_order['SchDate']) or is_null($_order['SchDate']) or $_order['SchDate']==""){
            $_date_value=date('m-d-y');
        }else{
            $_date_value=$_order['SchDate'];
        }

        $_hmtl='
        <table>
            <tr>
                <td colspan="2">RoofServicenow no-reply@roofservicenow.com </td>
                <td></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="5">'.$pdf->Image($_SESSION['image_path']."logo_s.png",80,40,40).'</td>
            </tr>
            <tr>
                <td colspan="5"><br><br><br><br><br></td>
            </tr>
            <tr>
                <td colspan="5">Thank you for ordering an '.$_order_type.'. Below, please find your invoice details.  </td>
            </tr>
            <tr>
                <td colspan="5">Please remember to return to RoofServiceNow.com to get updates on the status of your order and to rate your service professional after the project is completed. </td>
            </tr>
        </table>
        <br>
        <br>
        <table border=".5">
            <tr>
                <td align="rigth">CO ID:</td><td>'.$_company['ComapnyLicNum'].'</td><td align="rigth">CO Name:</td><td>'.$_company['CompanyName'].'</td><td>Customer Rating:</td><td>'.$_company['CompanyRating'].'</td>
            </tr>
            <tr>
                <td align="rigth">CO License:</td><td>'.$_company['ComapnyLicNum'].'</td><td align="rigth">CO Phone:</td><td>'.$_company['CompanyPhone'].'</td><td></td><td></td>
            </tr>
            <tr>
                <td align="rigth">Service Date:</td><td>'.$_date_value.'</td><td align="rigth">SP Address:</td><td>'.$_company['CompanyAdd1'].'</td><td>'.$_company['CompanyAdd2'].'</td><td>'.$_company['CompanyAdd3'].'</td>
            </tr>
            <tr>
                <td align="rigth">Service Repair Address:</td><td colspan="2">'.$_order['RepAddress'].'</td><td></td><td></td><td></td>
            </tr>
        </table>
        <br>
        <br>
        <table bgcolor="#dcdfe5">
            <tr>
                <td><b>Invoice</b></td><td>'.$_invoice_number.'</td><td></td><td></td><td>Repair ID</td><td align="rigth">'.$_consecutive_invoice.'</td>
            </tr>
            <tr>
                <td><b>Summary</b></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <td colspan="2">'.$_title_bill.'</td><td></td><td></td><td></td><td align="rigth">$'.$_amount.'.00</td>
            </tr>
            <tr>
                <td><b>Grand Total Paid</b></td><td></td><td></td><td></td><td></td><td align="rigth"><b>$'.$_amount.'.00</b></td>
            </tr>
            <tr>
                <td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <td>Payment Date</td><td></td><td></td><td></td><td></td><td align="rigth">'.$_date_invoice.'</td>
            </tr>
            <tr>
                <td>Payment Amt</td><td></td><td></td><td></td><td></td><td align="rigth">$'.$_amount.'.00</td>
            </tr>
            <tr>
                <td>***Approved***</td><td></td><td></td><td></td><td colspan="2" align="rigth">XXXXXXXXXXXX'.$_card_data.'</td>
            </tr>
            <tr>
                <td></td><td></td><td></td><td></td><td>Exp. Date</td><td align="rigth">'.$_exp_date.'</td>
            </tr>
            <tr>
                <td>Payment Type</td><td></td><td></td><td></td><td>Exp. Date</td><td align="rigth">Online</td>
            </tr>
            <tr>
                <td colspan="6" align="center">Thank You for using RoofServiceNow</td>
            </tr>
        </table>
        <br>
        <br>
        <table>
            <tr>
                <td>http://www.roofservicenow.com/</td>
            </tr>
            <tr>
                <td>Use the link above to return to RoofServiceNow to review your order status and rate the service professional. </td>
            </tr>
            <tr>
                <td>Is your  link not working? You can log in to RoofServiceNow.com and review the invoice. </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>If you have any questions about our website, please don\'t hesitate to contact us.</td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <table>
            <tr>
                <td>RoofServiceNow LLC | Site : www.roofservicenow.com | RoofServiceNow © 2017 | info@roofservicenow.com</td>
            </tr>
        </table>
        ';
        
        $pdf->Image($_SESSION['image_path']."logo_s.png",30,180,40);
        $pdf->writeHTML($_hmtl, true, 0, true, true);

        $pdf->Output($_SESSION['invoice_path'].'invoice_'.$_invoice_number.'.pdf','F'); 

        $_result=$this->registerPathInvoice($_invoice_number,$_order['FBID'],$_amount,$_stripe_id);
        
        $_result_invoice=$this->_otherController->updateParameterValue("Parameters","InvoiceNum",$_consecutive_invoice+1);

        $_mailController = new emailController();

        $_result_mail=$_mailController->sendMailSMTP($_customer['Email'],"Roofadvizor Invoice",$_hmtl,$_SESSION['invoice_path'].'invoice_'.$_invoice_number.'.pdf');
        if($_result_mail==false){
            return $_mailController->getMessageError();
        }else{
            return true;
        }
        
    }

    function paymentConfirmation2($_orderID,$object_order,$_amount=0,$_stripe_id="",$_paymentType="",$_actio_type=""){
        
        if($_amount>0){
            $_amount=$_amount/100; 
        }
        $_user_mail_send="";
        $_invoice_number="";
        $_consecutive_invoice=0;
        $_card_data="";
        $_exp_date="";
        $_order_type="";
        $this->_otherController=new othersController();
        $this->_orderController=new orderController();
        if(isset($object_order)){
            $_order=$object_order;
        }else{
            $_order=$this->_orderController->getOrder("FBID",$_orderID);
        }
        

        if(is_null($_order)){
            echo "The order number no exists [$_orderID]";
            return;
        }

        $_companyCustomerController=new userController();
        $_company=$_companyCustomerController->getCompanyById($_order['CompanyID']);

        if(is_null($_company)){
            echo "The company no exists";
            return;
        }

        if(strcmp($_order['RequestType'],"P")!=0){
            $_customer=$_companyCustomerController->getCustomerById($_order['CustomerID']);
            if(is_null($_customer)){
                echo "The customer no exists";
                return;
            }
            $_user_mail_send=$_customer['Email'];
        }else{
            $_user_mail_send=$_company['CompanyEmail'];
        }
        

        $_consecutive_invoice=$this->_otherController->getParameterValue("Parameters/InvoiceNum");
        
        $_orderID=$_order['OrderNumber'];
        if(is_null($_consecutive_invoice) or $_consecutive_invoice==""){
            $_invoice_number=$_orderID."_10000";
        }else{
            $_invoice_number=$_orderID."_".$_consecutive_invoice;
        }

        
        $_title_bill="undefined";
        switch($_order['RequestType']){
            case "E":
                $_title_bill="Emergency Roof Service";
                $_order_type= "Emergency Service";
                break;
            case "R":
                $_title_bill="Order Roof Report Service";
                $_order_type= "RoofReport Service";
                break;
            case "S":
                $_order_type= "Schedule Service";
                $_title_bill="";
                break;
            case "P":
                $_order_type= "Postcard Service";
                $_title_bill="";
                break;
            default:
                $_order_type= "Undefined";
                $_title_bill="";
                break;
        }

        $_date_invoice=date('m-d-Y');
        
        if(!empty($_stripe_id)){
            $_payingController = new payingController();
            $_result=$_payingController->getPayingData($_stripe_id);
            $_card_data=$_result->source->last4;
            $_exp_date=$_result->source->exp_month." / ".$_result->source->exp_year;
        }
       
       

        $pdf = new TCPDF();                 // create TCPDF object with default constructor args
        $pdf->AddPage();                    // pretty self-explanatory

        $pdf->SetMargins(25, 31 , 15); 
        $pdf->SetAutoPageBreak(TRUE, 35);
        $pdf -> SetX(25);
        $pdf -> SetY(31);
        
        $pdf->SetFont('times','',10);

        if(!isset($_order['SchDate']) or is_null($_order['SchDate']) or $_order['SchDate']==""){
            $_date_value=date('m-d-y');
        }else{
            $_date_value=$_order['SchDate'];
        }
        
        $_actual_value=intval($_order['ActAmtTime']);
        $_actual_time=intval($_order['ActTime']);
        if($_actual_time!=0 and $_actual_value!=0){
            $_hour_value=intval($_order['ActAmtTime'])/intval($_order['ActTime']);
            $_total_invoice=intval($_order['ActAmtTime'])+intval($_order['ActAmtMat']);
        }else{
            $_hour_value=0;
            $_total_invoice=$_actual_value;
        }
        if($_total_invoice=0 or empty($_total_invoice)){
            $_actual_value=$_amount;
            $_total_invoice=$_amount;
            $_actual_time=0;
            $_hour_value=0;
        }

        switch($_actio_type){
            case "pay_emergency_service":
            $summary_text='<tr>
            <td>Time</td><td></td><td></td><td>'.$_order['ActTime'].' hrs</td><td> $'.$_hour_value.'</td><td align="rigth"> $'.$_order['ActAmtTime'].'.00</td>
        </tr>
        <tr>
            <td>Materials</td><td></td><td></td><td></td><td></td><td align="rigth"> $'.$_order['ActAmtMat'].'.00</td>
        </tr>';
                break;
            case "pay_company_roofreport":
            $summary_text='<tr>
            <td>Time</td><td></td><td></td><td>'.$_order['ActTime'].' hrs</td><td> $'.$_hour_value.'</td><td align="rigth"> $'.$_order['ActAmtTime'].'.00</td>
        </tr>
        <tr>
            <td>Materials</td><td></td><td></td><td></td><td></td><td align="rigth"> $'.$_order['ActAmtMat'].'.00</td>
        </tr>';
                break;
            case "pay_invoice_service":
            $summary_text='<tr>
            <td>Time</td><td></td><td></td><td>'.$_order['ActTime'].' hrs</td><td> $'.$_hour_value.'</td><td align="rigth"> $'.$_order['ActAmtTime'].'.00</td>
        </tr>
        <tr>
            <td>Materials</td><td></td><td></td><td></td><td></td><td align="rigth"> $'.$_order['ActAmtMat'].'.00</td>
        </tr>';
                break;
            case "pay_postcard_service":
            $summary_text='<tr>
            <td>Time</td><td></td><td></td><td>'.$_order['ActTime'].' hrs</td><td> $'.$_hour_value.'</td><td align="rigth"> $'.$_order['ActAmtTime'].'.00</td>
        </tr>
        <tr>
            <td>Materials</td><td></td><td></td><td></td><td></td><td align="rigth"> $'.$_order['ActAmtMat'].'.00</td>
        </tr>';
                break;
            case "pay_take_service":
                $summary_text='<tr><td>Take Service</td><td></td><td></td><td>--</td><td> $'.$_amount.'</td><td align="rigth"> $'.$_amount.'.00</td></tr>';
                break;
            case "pay_deposit_service":
                $summary_text='<tr><td>Material Deposit</td><td></td><td></td><td>--</td><td> $'.$_amount.'</td><td align="rigth"> $'.$_amount.'.00</td></tr>';
                break;
            default:
            $summary_text='<tr>
            <td>Time</td><td></td><td></td><td>'.$_order['ActTime'].' hrs</td><td> $'.$_hour_value.'</td><td align="rigth"> $'.$_order['ActAmtTime'].'.00</td>
        </tr>
        <tr>
            <td>Materials</td><td></td><td></td><td></td><td></td><td align="rigth"> $'.$_order['ActAmtMat'].'.00</td>
        </tr>';
        break;
        }

        $_hmtl='
        <table>
            <tr>
                <td colspan="2">RoofServicenow no-reply@roofservicenow.com\</td>
                <td></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="2">To: '.$_company['CompanyEmail'].'</td>
                <td></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="5">'.$pdf->Image($_SESSION['image_path']."logo_s.png",80,40,40).'</td>
            </tr>
            <tr>
                <td colspan="5"><br><br><br><br><br></td>
            </tr>
            <tr>
                <td colspan="5">Thank you for ordering an '.$_order_type.'. Below, please find your invoice details.  </td>
            </tr>
            <tr>
                <td colspan="5">Please remember to return to RoofServiceNow.com to get updates on the status of your order and to rate your service professional after the project is completed. </td>
            </tr>
        </table>
        <br>
        <br>
        <table  style="width: 500px;border: 1px solid black;">
            <tr>
                <td align="rigth">CO ID:</td><td>'.$_order['CompanyID'].'</td><td align="rigth">CO Name:</td><td>'.$_company['CompanyName'].'</td><td>Customer Rating:</td><td>'.$_company['CompanyRating'].'</td>
            </tr>
            <tr>
                <td align="rigth">CO License:</td><td>'.$_company['ComapnyLicNum'].'</td><td align="rigth">CO Phone:</td><td>'.$_company['CompanyPhone'].'</td><td></td><td></td>
            </tr>
            <tr>
                <td align="rigth">Service Date:</td><td>'.$_order['SchDate'].'</td><td align="rigth">SP Address:</td><td>'.$_company['CompanyAdd1'].'</td><td>'.$_company['CompanyAdd2'].'</td><td>'.$_company['CompanyAdd3'].'</td>
            </tr>
            <tr>
                <td align="rigth">Service Repair Address:</td><td colspan="2">'.$_order['RepAddress'].'</td><td></td><td></td><td></td>
            </tr>
        </table>
        <br>
        <br>
        <table bgcolor="#dcdfe5" style="width: 500px">
            <tr>
                <td><b>Invoice</b></td><td>'.$_invoice_number.'</td><td></td><td></td><td>Repair ID</td><td align="rigth">'.$_consecutive_invoice.'</td>
            </tr>
            <tr>
                <td><b>Summary</b></td><td></td><td></td><td>Hour</td><td>Rate</td><td></td>
            </tr>'    
        .$summary_text.
            '<tr>
                <td><b>Grand Total Paid</b></td><td></td><td></td><td></td><td></td><td align="rigth"><b>$'.$_total_invoice.'.00</b></td>
            </tr>
            <tr>
                <td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <td>Payment Date</td><td></td><td></td><td></td><td></td><td align="rigth">'.$_date_value.'</td>
            </tr>
            <tr>
                <td>Payment Amt</td><td></td><td></td><td></td><td></td><td align="rigth">$'.$_total_invoice.'.00</td>
            </tr>
            
            <tr>
                <td>Payment Type</td><td></td><td></td><td></td><td></td><td align="rigth">'.$_paymentType.'</td>
            </tr>
            <tr>
                <td colspan="6" align="center">Thank You for using RoofServiceNow</td>
            </tr>
        </table>
        <br>
        <br>
        <table>
            <tr>
                <td>http://www.roofservicenow.com/</td>
            </tr>
            <tr>
                <td>Use the link above to return to RoofServiceNow to review your order status and rate the service professional. </td>
            </tr>
            <tr>
                <td>Is your  link not working? You can log in to RoofServiceNow.com and review the invoice. </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>If you have any questions about our website, please don\'t hesitate to contact us.</td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <table>
            <tr>
            <td>RoofServiceNow LLC | Site : www.roofservicenow.com | RoofServiceNow © 2017 | info@roofservicenow.com</td>
            </tr>
        </table>
        ';
        
        //$pdf->Image($_SESSION['image_path']."logo.png",30,200,40);
        $pdf->writeHTML($_hmtl, true, 0, true, true);

        $pdf->Output($_SESSION['invoice_path'].'invoice_'.$_invoice_number.'.pdf','F'); 

        if($_amount==0){
            $_amount=$_total_invoice;
        }
        $_result=$this->registerPathInvoice($_invoice_number,$_order['FBID'],$_amount,$_stripe_id,$_paymentType);
        
        $_result_invoice=$this->_otherController->updateParameterValue("Parameters","InvoiceNum",$_consecutive_invoice+1);

        $_mailController = new emailController();

        $_result_mail=$_mailController->sendMailSMTP($_user_mail_send,"Roofadvizor Invoice",$_hmtl,$_SESSION['invoice_path'].'invoice_'.$_invoice_number.'.pdf');
        if($_result_mail==false){
            return $_mailController->getMessageError();
        }else{
            return true;
        }
    }

    function paymentConfirmation3($_companyID,$object_order,$_amount=0,$_stripe_id="",$_paymentType=""){

        if($_amount>0){
            $_amount=$_amount/100; 
        }
        
        $_invoice_number="";
        $_consecutive_invoice=0;
        $_card_data="";
        $_exp_date="";
        $_order_type="";
        $this->_otherController=new othersController();
        

        $_companyCustomerController=new userController();
        $_company=$_companyCustomerController->getCompanyById($_companyID);

        if(is_null($_company)){
            echo "The company no exists";
            return;
        }

        $_consecutive_invoice=$this->_otherController->getParameterValue("Parameters/InvoiceNum");
        
        if(is_null($_consecutive_invoice) or $_consecutive_invoice==""){
            $_invoice_number=$_companyID."_10000";
        }else{
            $_invoice_number=$_companyID."_".$_consecutive_invoice;
        }

        
        $_title_bill="Postcard Roof Service";
        $_order_type= "Postcard Service";

        $_date_invoice=date('m-d-Y');
        
        if(!empty($_stripe_id)){
            $_payingController = new payingController();
            $_result=$_payingController->getPayingData($_stripe_id);
            $_card_data=$_result->source->last4;
            $_exp_date=$_result->source->exp_month." / ".$_result->source->exp_year;
        }
       
       

        $pdf = new TCPDF();                 // create TCPDF object with default constructor args
        $pdf->AddPage();                    // pretty self-explanatory

        $pdf->SetMargins(25, 31 , 15); 
        $pdf->SetAutoPageBreak(TRUE, 35);
        $pdf -> SetX(25);
        $pdf -> SetY(31);
        
        $pdf->SetFont('times','',10);

        if(!isset($_order['SchDate']) or is_null($_order['SchDate']) or $_order['SchDate']==""){
            $_date_value=date('m-d-y');
        }else{
            $_date_value=$_order['SchDate'];
        }
        
        $_hour_value=0;
        $_total_invoice=$_amount;

        $_hmtl='
        <table>
            <tr>
                <td colspan="2">RoofServicenow no-reply@roofservicenow.com\</td>
                <td></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="2">To: '.$_company['CompanyEmail'].'</td>
                <td></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="5">'.$pdf->Image($_SESSION['image_path']."logo_s.png",80,40,40).'</td>
            </tr>
            <tr>
                <td colspan="5"><br><br><br><br><br></td>
            </tr>
            <tr>
                <td colspan="5">Thank you for ordering an '.$_order_type.'. Below, please find your invoice details.  </td>
            </tr>
            <tr>
                <td colspan="5">Please remember to return to RoofServiceNow.com to get updates on the status of your order and to rate your service professional after the project is completed. </td>
            </tr>
        </table>
        <br>
        <br>
        <table  style="width: 500px;border: 1px solid black;">
            <tr>
                <td align="rigth">CO ID:</td><td>'.$_company['CompanyID'].'</td><td align="rigth">CO Name:</td><td>'.$_company['CompanyName'].'</td><td>Customer Rating:</td><td>'.$_company['CompanyRating'].'</td>
            </tr>
            <tr>
                <td align="rigth">CO License:</td><td>'.$_company['ComapnyLicNum'].'</td><td align="rigth">CO Phone:</td><td>'.$_company['CompanyPhone'].'</td><td></td><td></td>
            </tr>
            <tr>
                <td align="rigth">Service Date:</td><td>'.$_date_value.'</td><td align="rigth">SP Address:</td><td>'.$_company['CompanyAdd1'].'</td><td>'.$_company['CompanyAdd2'].'</td><td>'.$_company['CompanyAdd3'].'</td>
            </tr>
            <tr>
                <td align="rigth">Service Repair Address:</td><td colspan="2">'.$_company['CompanyAdd1'].' '.$_company['CompanyAdd2'].' '.$_company['CompanyAdd3'].'</td><td></td><td></td><td></td>
            </tr>
        </table>
        <br>
        <br>
        <table bgcolor="#dcdfe5" style="width: 500px">
            <tr>
                <td><b>Invoice</b></td><td>'.$_invoice_number.'</td><td></td><td></td><td>Repair ID</td><td align="rigth">'.$_consecutive_invoice.'</td>
            </tr>
            <tr>
                <td><b>Summary</b></td><td></td><td></td><td></td><td>Rate</td><td></td>
            </tr>
            
            <tr>
                <td>Postcard</td><td></td><td></td><td></td><td></td><td align="rigth"> $'.$_total_invoice.'.00</td>
            </tr>
            <tr>
                <td><b>Grand Total Paid</b></td><td></td><td></td><td></td><td></td><td align="rigth"><b>$'.$_total_invoice.'.00</b></td>
            </tr>
            <tr>
                <td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <td>Payment Date</td><td></td><td></td><td></td><td></td><td align="rigth">'.$_date_value.'</td>
            </tr>
            <tr>
                <td>Payment Amt</td><td></td><td></td><td></td><td></td><td align="rigth">$'.$_total_invoice.'.00</td>
            </tr>
            
            <tr>
                <td>Payment Type</td><td></td><td></td><td></td><td></td><td align="rigth">'.$_paymentType.'</td>
            </tr>
            <tr>
                <td colspan="6" align="center">Thank You for using RoofServiceNow</td>
            </tr>
        </table>
        <br>
        <br>
        <table>
            <tr>
                <td>http://www.roofservicenow.com/</td>
            </tr>
            <tr>
                <td>Use the link above to return to RoofServiceNow to review your order status and rate the service professional. </td>
            </tr>
            <tr>
                <td>Is your  link not working? You can log in to RoofServiceNow.com and review the invoice. </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>If you have any questions about our website, please don\'t hesitate to contact us.</td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <table>
            <tr>
            <td>RoofServiceNow LLC | Site : www.roofservicenow.com | RoofServiceNow © 2017 | info@roofservicenow.com</td>
            </tr>
        </table>
        ';
        
        //$pdf->Image($_SESSION['image_path']."logo.png",30,200,40);
        $pdf->writeHTML($_hmtl, true, 0, true, true);

        $pdf->Output($_SESSION['invoice_path'].'invoice_'.$_invoice_number.'.pdf','F'); 

        if($_amount==0){
            $_amount=$_total_invoice;
        }
        $_result=$this->registerPathInvoice($_invoice_number,$_company['CompanyID'],$_amount,$_stripe_id,$_paymentType,"company");
        
        $_result_invoice=$this->_otherController->updateParameterValue("Parameters","InvoiceNum",$_consecutive_invoice+1);

        $_mailController = new emailController();

        $_result_mail=$_mailController->sendMailSMTP($_company['CompanyEmail'],"Roofadvizor Invoice",$_hmtl,$_SESSION['invoice_path'].'invoice_'.$_invoice_number.'.pdf');
        
        if($_result_mail==false){
            return $_mailController->getMessageError();
        }else{
            return true;
        }
    }

    public function registerPathInvoice($_orderID,$firebaseOrderID,$_invioce_value,$_stripe_id,$_paymentType="online",$_source_payment="order"){
        $_path='/invoice/invoice_'.$_orderID.'.pdf';
        $_path2="";
        if(is_null($this->_otherController)){
            $this->_otherController=new othersController();
        }

        if(strcmp($_SERVER['HTTP_HOST'],'localhost')==0){
            $_dir=$_SERVER['REQUEST_URI'];
            $pos1 = strpos($_dir,"/");
            $pos2 = strpos($_dir,"/", $pos1 + 1);
            //echo "<br>hola:".substr($_dir,$pos1+1,$pos2-1);
            $_path2="/".substr($_dir,$pos1+1,$pos2-1);
            $_path1="http://" . $_SERVER['HTTP_HOST'].$_path2.$_path;
        }else{
            $_path1="http://" . $_SERVER['HTTP_HOST'].$_path;
        }

        $_invoice_data = [
            'path' => $_path2.$_path,
            'user_invoice_num' => $_orderID,
            'user_orderFBID' => $firebaseOrderID,
            'invoice_value' => $_invioce_value,
            'invoice_date' => date('m-d-Y'),
            'stripe_id'=>$_stripe_id,
            'payment_type'=>$_paymentType,
        ];
        //$_invoice_data='{"'.$_orderID.'":{"path":"'.$_path.'","invoice_num":"'.$_orderID.'","orderFBID":"'.$firebaseOrderID.'"}}';
        $this->_otherController=new othersController();
        $_result=$this->_otherController->setInvoicePath($firebaseOrderID,$_orderID,"",$_invoice_data);


        if(strcmp($_source_payment,"order")==0){
            if(is_null($this->_orderController)){
                $this->_orderController=new orderController();
            }
            $_updateFields="InvoiceNum,$_path1";
            $_arrayFields=explode(",",$_updateFields);
            $_result_order=$this->_orderController->updateOrder($firebaseOrderID,$_arrayFields);
    
        }
        
        if($_result==true){
            return true;
        }else{
            return false;
        }

    }
}
?>
