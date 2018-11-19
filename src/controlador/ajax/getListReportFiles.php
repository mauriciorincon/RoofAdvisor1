<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/orderController.php");

$_orderID=$_POST['orderID'];

$_orderController = new orderController();

$_result=$_orderController->getOrderFilesInfo($_orderID);

$_string="";
$_payment_type="";


if(is_null($_result)){
    $_string='<tr><td colspan="3">No data found</td><tr>';
    
}else{
    foreach ($_result as $key => $fileInfo) {
        $_string.='<tr>
                    <td>'.$fileInfo['user_upload'].'</td>
                    <td>'.$fileInfo['date_upload'].'</td>
                    <td><a class="btn-primary btn-sm" data-toggle="modal"  
                            href="'.$fileInfo['file_name'].'" 
                            onClick="" target="_blank"> 
                            <span class="glyphicon glyphicon-save">Download</span>
                        </a>
                    </td>
                    
                </tr>';
    }
}
echo $_string;


?>