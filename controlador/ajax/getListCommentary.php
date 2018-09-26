<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/orderController.php");

$_orderID=$_POST['orderID'];

$_orderController = new orderController();

$_result=$_orderController->getOrderCommentaries($_orderID);

$_string="";
$_payment_type="";


if(is_null($_result)){
    $_string='<tr><td colspan="3">No data found</td><tr>';
    
}else{
    foreach ($_result as $key => $invoice) {
        $_string.='<tr>
                    <td>'.$invoice['user_commentary'].'</td>
                    <td>'.$invoice['date_commentary'].'</td>
                    <td>'.$invoice['text_commentary'].'</td>
                </tr>';
    }
}
echo $_string;


?>