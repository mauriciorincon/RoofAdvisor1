<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

$_orderID=$_POST['orderID'];

$_file_path=$_SESSION['application_path'].'/invoice/invoice_'.$_orderID.'.pdf';
//echo $_file_path;
if(file_exists($_file_path)){
    echo '<p><a href="invoice/invoice_'.$_orderID.'.pdf" target="_blank" class="btn btn-primary btn-lg active" role="button">View Invoice</a></p>
    <p><a onclick="generateInvoice('.$_orderID.')" class="btn btn-primary btn-lg active" role="button">Generate Invoice again</a></p>
    <p> <a onclick="sendInvoiceEmail('.$_orderID.')" class="btn btn-primary btn-lg active" role="button">Send the invoice for mail</a></p>';
}else{
    
    echo '<h3>The invoice is not generated yet</h3><br>
    <h3>Please click the link to generate the invoice <a onclick="generateInvoice('.$_orderID.')">Generate Invoice</a></h3>';
}

?>