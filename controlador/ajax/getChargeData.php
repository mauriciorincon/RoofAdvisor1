<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    require_once($_SESSION['application_path']."/controlador/payingController.php");


    $_chargeID=$_POST['chargeID'];
    $_objPay=new payingController();
    $_string="";
    if(!empty($_chargeID)){
        $_result=$_objPay->getPayingData($_chargeID);
    
        $_string='<div>
            <table class="table table-bordered">
                <tr><td>Charge ID</td><td>'.$_result->id.'</td></tr>
                <tr><td>Object</td><td>'.$_result->object.'</td></tr>
                <tr><td>Amount</td><td>'.$_result->amount.'</td></tr>
                <tr><td>Paid</td><td>'.$_result->paid.'</td></tr>
                <tr><td>Email</td><td>'.$_result->receipt_email.'</td></tr>
                <tr><td>Id card</td><td>'.$_result->source->id.'</td></tr>
                <tr><td>Card</td><td>'.$_result->source->object.'</td></tr>
                <tr><td>Brand</td><td>'.$_result->source->brand.'</td></tr>
                <tr><td>Brand</td><td>'.$_result->source->exp_month.'</td></tr>
                <tr><td>Brand</td><td>'.$_result->source->exp_year.'</td></tr>
                <tr><td>Last4</td><td>'.$_result->source->last4.'</td></tr>
                <tr><td>Last4</td><td>'.$_result->status.'</td></tr>

            </table>
        </div>';
    }else{
        $_string= "Error, there are no charges for this order.";
    }
    

echo $_string;
?>