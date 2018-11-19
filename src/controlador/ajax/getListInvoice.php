<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/orderController.php");

$_orderID=$_POST['orderID'];

$_orderController = new orderController();

$_result=$_orderController->getOrderInvoices($_orderID);

$_string="";
$_payment_type="";


if(is_null($_result)){
    $_string='<tr><td colspan="5">No data found</td><tr>';
    
}else{
    foreach ($_result as $key => $invoice) {
        if(isset($invoice['payment_type']))
        {
            $_payment_type=$invoice['payment_type'];
        }else{
            $_payment_type="Undefined";
        }
        $_string.='<tr>
                    <td>'.$invoice['user_invoice_num'].'</td>
                    <td>'.$invoice['invoice_value'].'</td>
                    <td>'.$invoice['invoice_date'].'</td>
                    <td>'.$_payment_type.'</td>
                    <td><a class="btn-success btn-sm" data-toggle="modal"  
                            href="" 
                            onClick="showChargePayment(\''.$invoice['stripe_id'].'\')"> 
                            <span class="glyphicon glyphicon-usd">'.'Details'.'</span>
                        </a>
                    </td>
                    <td><a class="btn-primary btn-sm" data-toggle="modal"  
                            href="'.$invoice['path'].'" 
                            onClick="" target="_blank"> 
                            <span class="glyphicon glyphicon-save">Download</span>
                        </a>
                    </td>
                </tr>';
    }
}
echo $_string;


?>