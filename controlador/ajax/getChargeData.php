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
    
        //print_r($_result);
        $_string='<div>
            <table class="table table-bordered">
                <tr><td>Trans ID</td><td>'.$_result->id.'</td></tr>
                <tr><td>Amount</td><td>'.(($_result->amount)/100).'</td></tr>
                <tr><td>Email</td><td>'.$_result->source->name.'</td></tr>
                <tr><td>Card Type</td><td>'.$_result->source->brand.'</td></tr>
                <tr><td>Month</td><td>'.$_result->source->exp_month.'</td></tr>
                <tr><td>Year</td><td>'.$_result->source->exp_year.'</td></tr>
                <tr><td>Last 4</td><td>'.$_result->source->last4.'</td></tr>
                <tr><td>Status</td><td>'.$_result->status.'</td></tr>

            </table>
        </div>';
    }else{
        $_string= "Error, there are no charges for this order.";
    }
    

echo $_string;
?>