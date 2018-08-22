<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

require $_SESSION['application_path'].'/vendor/autoload.php';
require_once($_SESSION['application_path']."/controlador/orderController.php");
require_once($_SESSION['application_path']."/controlador/userController.php");
require_once($_SESSION['application_path']."/controlador/othersController.php");

class pdfController{
    
    private $_orderController=null;
    private $_otherController=null;

    function __construct(){
        
    }

    function paymentConfirmation1($_orderID,$object_order,$_amount=0,$_stripe_id=""){
        
        $_invoice_number="";
        $_consecutive_invoice=0;
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
        $_company=$_companyCustomerController->getCompanyById("CO000003");

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
                break;
            case "R":
                $_title_bill="Order Roof Report Service";
                break;
        }

        $_date_invoice=date('m-d-Y');
        
        /*print_r($_order);
        print_r($_company);
        print_r($_customer);
        return;*/

        $pdf = new TCPDF();                 // create TCPDF object with default constructor args
        $pdf->AddPage();                    // pretty self-explanatory

        $pdf->SetMargins(25, 31 , 15); 
        $pdf->SetAutoPageBreak(TRUE, 35);
        $pdf -> SetX(25);
        $pdf -> SetY(31);
        
        $pdf->SetFont('times','',10);

        $_hmtl='
        <table>
            <tr>
                <td colspan="2">RoofAdvisorz no-reply@roofadvisorz.com </td>
                <td></td>
                <td colspan="2">Email Message to homeowner after they submit payment</td>
            </tr>
            <tr>
                <td colspan="5">'.$pdf->Image($_SESSION['application_path']."/img/logo.png",80,50,40).'</td>
            </tr>
            <tr>
                <td colspan="5"><br><br><br><br><br></td>
            </tr>
            <tr>
                <td colspan="5">Thank you! Here\'s your invoice for the emergency repair service. </td>
            </tr>
            <tr>
                <td colspan="5">Please review the information below.  Remember to return to RoofAdvisorZ.com to rate your service professional after the project is completed. </td>
            </tr>
        </table>
        <br>
        <br>
        <table border=".5">
            <tr>
                <td>Service Pro ID:</td><td>'.$_order['CompanyID'].'</td><td>SP Name:</td><td>'.$_company['CompanyName'].'</td><td>Customer Rating:</td><td>'.$_company['CompanyRating'].'</td>
            </tr>
            <tr>
                <td>License:</td><td>'.$_company['ComapnyLicNum'].'</td><td>SP Phone:</td><td>'.$_company['CompanyPhone'].'</td><td></td><td></td>
            </tr>
            <tr>
                <td>Service Date:</td><td>'.$_order['SchDate'].'</td><td>SP Address:</td><td>'.$_company['CompanyAdd1'].'</td><td>'.$_company['CompanyAdd2'].'</td><td>'.$_company['CompanyAdd3'].'</td>
            </tr>
            <tr>
                <td>Service Repair Address</td><td colspan="2">'.$_order['RepAddress'].'</td><td></td><td></td><td></td>
            </tr>
        </table>
        <br>
        <br>
        <table bgcolor="#dcdfe5">
            <tr>
                <td><b>Invoice</b></td><td>'.$_invoice_number.'</td><td></td><td></td><td>Repair ID</td><td align="rigth">8690940</td>
            </tr>
            <tr>
                <td><b>Summary</b></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <td colspan="2">'.$_title_bill.'</td><td></td><td></td><td></td><td align="rigth">$'.$_amount.',00</td>
            </tr>
            <tr>
                <td><b>Grand Total Paid</b></td><td></td><td></td><td></td><td></td><td align="rigth"><b>$'.$_amount.',00</b></td>
            </tr>
            <tr>
                <td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <td>Payment Date</td><td></td><td></td><td></td><td></td><td align="rigth">'.$_date_invoice.'</td>
            </tr>
            <tr>
                <td>Payment Amt</td><td></td><td></td><td></td><td></td><td align="rigth">$'.$_amount.',00</td>
            </tr>
            <tr>
                <td>***Approved***</td><td></td><td></td><td></td><td></td><td align="rigth">XXXXXXXXXXXX5020</td>
            </tr>
            <tr>
                <td></td><td></td><td></td><td></td><td>Exp. Date</td><td align="rigth">jul-19</td>
            </tr>
            <tr>
                <td colspan="6" align="center">Thank You for using RoofAdvisorZ</td>
            </tr>
        </table>
        <br>
        <br>
        <table>
            <tr>
                <td>http://www.roofadvisorz.com/idx/invoice1.html?verify=0f3c991b4507ade9d74828a1e6d9ec61c8e367sa</td>
            </tr>
            <tr>
                <td>Use the link above to return to rate the service professional.</td>
            </tr>
            <tr>
                <td>Is your  link not working? You can log in to RoofAdvisorZ.com and review the invoice.</td>
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
                <td>Viaplix LLC | Site : ww.viaplix.com | Viaplix © 2017 | info@viaplix.com</td>
            </tr>
        </table>
        ';
        
        $pdf->Image($_SESSION['application_path']."/img/logo.png",30,200,40);
        $pdf->writeHTML($_hmtl, true, 0, true, true);

        $pdf->Output($_SESSION['application_path'].'/invoice/invoice_'.$_invoice_number.'.pdf','F'); 

        $_result=$this->registerPathInvoice($_invoice_number,$_order['FBID'],$_amount,$_stripe_id);
        
        $_result_invoice=$this->_otherController->updateParameterValue("Parameters","InvoiceNum",$_consecutive_invoice+1);
        
        return true;
    }

    function paymentConfirmation2($_orderID){
        $this->_orderController=new orderController();
        $_order=$this->_orderController->getOrder("OrderNumber",$_orderID);

        if(is_null($_order)){
            echo "The order number no exists";
            return;
        }

        $_companyCustomerController=new userController();
        $_company=$_companyCustomerController->getCompanyById($_order['CompanyID']);

        if(is_null($_company)){
            echo "The company no exists";
            return;
        }

        $_customer=$_companyCustomerController->getCustomerById($_order['CustomerID']);
        if(is_null($_customer)){
            echo "The customer no exists";
            return;
        }

        
        /*print_r($_order);
        print_r($_company);
        print_r($_customer);
        return;*/

        $pdf = new TCPDF();                 // create TCPDF object with default constructor args
        $pdf->AddPage();                    // pretty self-explanatory

        $pdf->SetMargins(25, 31 , 15); 
        $pdf->SetAutoPageBreak(TRUE, 35);
        $pdf -> SetX(25);
        $pdf -> SetY(31);
        
        $pdf->SetFont('times','',10);

        $_hmtl='
        <table>
            <tr>
                <td colspan="2">RoofAdvisors no-reply@roofadvisorz.com\</td>
                <td></td>
                <td colspan="2">Email Message to homeowner after they submit payment</td>
            </tr>
            <tr>
                <td colspan="2">To: JDOE@yahoo.com</td>
                <td></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="5">'.$pdf->Image($_SESSION['application_path']."/img/logo.png",80,50,40).'</td>
            </tr>
            <tr>
                <td colspan="5"><br><br><br><br><br></td>
            </tr>
            <tr>
                <td colspan="5">Thank you!	Here\'s your invoice for the emergency repair for time and materials by '.$_company['CompanyName'].' professional. </td>
            </tr>
            <tr>
                <td colspan="5">Please review the information below.  Remember to return to RoofAdvisorZ.com to rate your service professional. </td>
            </tr>
        </table>
        <br>
        <br>
        <table border=".5">
            <tr>
                <td>Service Pro ID:</td><td>'.$_order['CompanyID'].'</td><td>SP Name:</td><td>'.$_company['CompanyName'].'</td><td>Customer Rating:</td><td>'.$_company['CompanyRating'].'</td>
            </tr>
            <tr>
                <td>License:</td><td>'.$_company['ComapnyLicNum'].'</td><td>SP Phone:</td><td>'.$_company['CompanyPhone'].'</td><td></td><td></td>
            </tr>
            <tr>
                <td>Service Date:</td><td>'.$_order['SchDate'].'</td><td>SP Address:</td><td>'.$_company['CompanyAdd1'].'</td><td>'.$_company['CompanyAdd2'].'</td><td>'.$_company['CompanyAdd3'].'</td>
            </tr>
            <tr>
                <td>Service Repair Address</td><td colspan="2">'.$_order['RepAddress'].'</td><td></td><td></td><td></td>
            </tr>
        </table>
        <br>
        <br>
        <table bgcolor="#dcdfe5">
            <tr>
                <td><b>Invoice</b></td><td>8690940_02</td><td></td><td></td><td>Repair ID</td><td align="rigth">8690940</td>
            </tr>
            <tr>
                <td><b>Summary</b></td><td></td><td></td><td>Hour</td><td>Rate</td><td></td>
            </tr>
            <tr>
                <td>Time</td><td></td><td></td><td>3 hrs</td><td> $150,00</td><td align="rigth"> $450,00</td>
            </tr>
            <tr>
                <td>Materials</td><td></td><td></td><td></td><td></td><td align="rigth"> $250,00</td>
            </tr>
            <tr>
                <td><b>Grand Total Paid</b></td><td></td><td></td><td></td><td></td><td align="rigth"><b>$700,00</b></td>
            </tr>
            <tr>
                <td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <td>Payment Date</td><td></td><td></td><td></td><td></td><td align="rigth">18/01/18</td>
            </tr>
            <tr>
                <td>Payment Amt</td><td></td><td></td><td></td><td></td><td align="rigth">$700,00</td>
            </tr>
            
            <tr>
                <td></td><td></td><td></td><td></td><td>Exp. Date</td><td align="rigth">jul-19</td>
            </tr>
            <tr>
                <td colspan="6" align="center">Thank You for using RoofAdvisorZ</td>
            </tr>
        </table>
        <br>
        <br>
        <table>
            <tr>
                <td>http://www.roofadvisorz.com/idx/invoice1.html?verify=0f3c991b4507ade9d74828a1e6d9ec61c8e367sa</td>
            </tr>
            <tr>
                <td>Use the link above to return to rate the service professional.</td>
            </tr>
            <tr>
                <td>Is your  link not working? You can log in to RoofAdvisorZ.com and review the invoice.</td>
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
                <td>Viaplix LLC | Site : ww.viaplix.com | Viaplix © 2017 | info@viaplix.com</td>
            </tr>
        </table>
        ';
        
        //$pdf->Image($_SESSION['application_path']."/img/logo.png",30,200,40);

        $pdf->writeHTML($_hmtl, true, 0, true, true);

        $pdf->Output($_SESSION['application_path'].'/invoice/invoice_v2_'.$_orderID.'.pdf','F'); 
        $_result=$this->registerPathInvoice($_orderID,$_order['FBID']);
        return true;
    }

    public function registerPathInvoice($_orderID,$firebaseOrderID,$_invioce_value,$_stripe_id){
        $_path=$_SESSION['application_path'].'/invoice/invoice_'.$_orderID.'.pdf';
        if(is_null($this->_otherController)){
            $this->_otherController=new othersController();
        }


        $_invoice_data = [
            'path' => $_path,
            'user_invoice_num' => $_orderID,
            'user_orderFBID' => $firebaseOrderID,
            'invoice_value' => $_invioce_value,
            'invoice_date' => date('m-d-Y'),
            'stripe_id'=>$_stripe_id,
        ];
        //$_invoice_data='{"'.$_orderID.'":{"path":"'.$_path.'","invoice_num":"'.$_orderID.'","orderFBID":"'.$firebaseOrderID.'"}}';
        $this->_otherController=new othersController();
        $_result=$this->_otherController->setInvoicePath($firebaseOrderID,$_orderID,"",$_invoice_data);
        if(is_null($this->_orderController)){
            $this->_orderController=new orderController();
        }
        $_updateFields="InvoiceNum,$_path";
        $_arrayFields=explode(",",$_updateFields);
        //$_result=$this->_orderController->updateOrder($_orderID,$_arrayFields);

        //$_path.="InvoiceNum,".$_path;
        //$_arrayFields=explode(",",$_path);
        $_result_order=$this->_orderController->updateOrder($firebaseOrderID,$_arrayFields);
        if($_result==true){
            return true;
        }else{
            return false;
        }

    }
}
?>