<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    
    require_once($_SESSION['application_path']."/controlador/payingController.php");
    require_once($_SESSION['application_path']."/controlador/userController.php");


    $_paying_controller = new payingController();
    $_user_controller = new userController();

    $_data = $_POST['option'];
    $_companyID = $_POST['companyID'];

    $_response="";
    $_actual_company=$_user_controller->getCompany($_companyID);
    $_stripe_secret_key='';
    if(!isset($_actual_company['stripeSecretKey'])){
        $_stripe_secret_key='';
    }else{
        $_stripe_secret_key=$_actual_company['stripeSecretKey'];
    }
    switch($_data){
        case "balance" :
            $_array_stripe_balance=$_paying_controller->get_balance_account($_actual_company['stripeAccount']);
            $_response=" "; 
                                            
            $n=1;
            if(isset($_array_stripe_balance->available)){
                foreach($_array_stripe_balance->available as $clave=>$trancs){
                    $_amount=0;
                    if($trancs->amount==0){$_amount=0;}else{$_amount=$trancs->amount/100;}
                    $_amount1=0;
                    if($trancs->source_types->card==0){$_amount1=0;}else{$_amount1=$trancs->source_types->card/100;}
                $_response.="<tr>".
                            "<td>".$n."</td>".
                            "<td>Available</td>".
                            "<td>".number_format($_amount, 2, '.', '')."</td>".
                            "<td>".$trancs->currency."</td>".
                            "<td>".$trancs->source_types->bank_account."</td>".
                            "<td>".$trancs->source_types->bitcoin_receiver."</td>".
                            "<td>".number_format($_amount1, 2, '.', '')."</td>".
                        "</tr>";
                    $n++;
                }
            }
            if(isset($_array_stripe_balance->connect_reserved)){
                foreach($_array_stripe_balance->connect_reserved as $clave=>$trancs){
                    $_amount=0;
                    if($trancs->amount==0){$_amount=0;}else{$_amount=$trancs->amount/100;}
                $_response.="<tr>".
                            "<td>".$n."</td>".
                            "<td>connect_reserved</td>".
                            "<td>".number_format($_amount, 2, '.', '')."</td>".
                            "<td>".$trancs->currency."</td>".
                            "<td>".""."</td>".
                            "<td>".""."</td>".
                            "<td>".""."</td>".
                        "</tr>";
                    $n++;
                }
            }
            if(isset($_array_stripe_balance->pending)){
                foreach($_array_stripe_balance->pending as $clave=>$trancs){
                    $_amount=0;
                    if($trancs->amount==0){$_amount=0;}else{$_amount=$trancs->amount/100;}
                    $_amount1=0;
                    if($trancs->source_types->card==0){$_amount1=0;}else{$_amount1=$trancs->source_types->card/100;}
                    $_response.="<tr>".
                            "<td>".$n."</td>".
                            "<td>Pending</td>".
                            "<td>".number_format($_amount, 2, '.', '')."</td>".
                            "<td>".$trancs->currency."</td>".
                            "<td>".$trancs->source_types->bank_account."</td>".
                            "<td>".$trancs->source_types->bitcoin_receiver."</td>".
                            "<td>".number_format($_amount1, 2, '.', '')."</td>".
                        "</tr>";
                    $n++;
                }
            }
            
            break;
        case "transfer" :
            $_array_stripe_transfer=$_paying_controller->get_transfer_account($_actual_company['stripeAccount']);
            $_response=" ";
            
                $n=1;
                if(isset($_array_stripe_transfer->data)){
                    foreach($_array_stripe_transfer->data as $clave=>$trancs){
                        $_amount=0;
                        if($trancs->amount==0){$_amount=0;}else{$_amount=round($trancs->amount/100,2);}
                        $_response.= "<tr>".
                                    "<td>".$trancs->id."</td>".
                                    "<td>".number_format($_amount, 2, '.', '')."</td>".
                                    "<td>".$trancs->balance_transaction."</td>".
                                    "<td>".date("F j, Y, g:i a",$trancs->created)."</td>".
                                    "<td>".$trancs->description."</td>".
                                    "<td>".$trancs->destination_payment."</td>".
                                "</tr>";
                        $n++;
                    }
                }
            
            break;
        case "transaction" :
            $_array_stripe_transaction=$_paying_controller->get_transaction_account($_actual_company['stripeAccount'],$_stripe_secret_key);
            $_response=" ";
                
                $n=1;
                if(isset($_array_stripe_transaction->data)){
                    foreach($_array_stripe_transaction->data as $clave=>$trancs){
                        $_amount=0;
                        if($trancs->amount==0){$_amount=0;}else{$_amount=$trancs->amount/100;}
                        $_amount_1=0;
                        if($trancs->net==0){$_amount_1=0;}else{$_amount_1=$trancs->net/100;}
                        $_response.= "<tr>".
                                "<td>".$trancs->id."</td>".
                                "<td>".number_format($_amount, 2, '.', '')."</td>".
                                "<td>".$trancs->available_on."</td>".
                                "<td>".date("F j, Y, g:i a",$trancs->created)."</td>".
                                "<td>".$trancs->currency."</td>".
                                "<td>".$trancs->description."</td>".
                                "<td>".$trancs->fee."</td>".
                                "<td>".number_format($_amount_1, 2, '.', '')."</td>".
                                "<td>".$trancs->status."</td>".
                                "<td>".$trancs->type."</td>".
                            "</tr>";
                        $n++;
                    }
                }
                
            break;
        case "payout" :
            $_array_stripe_payout=$_paying_controller->get_payout_account($_actual_company['stripeAccount'],$_stripe_secret_key);
            $_response=" ";
                    
            $n=1;
            if(isset($_array_stripe_payout->data)){
                foreach($_array_stripe_payout->data as $clave=>$payout){
                    $_amount=0;
                    if($payout->amount==0){$_amount=0;}else{$_amount=$payout->amount/100;}
                    $_response="<tr>".
                            "<td>".$payout->id."</td>".
                            "<td>".number_format($_amount, 2, '.', '')."</td>".
                            "<td>".date("F j, Y, g:i a",$payout->created)."</td>".
                            "<td>".date("F j, Y, g:i a",$payout->arrival_date)."</td>".
                            "<td>".$payout->currency."</td>".
                            "<td>".$payout->description."</td>".
                            "<td>".$payout->destination."</td>".
                        "</tr>";
                    $n++;
                }
            }
                    
            break;
    }
    echo $_response;
?>