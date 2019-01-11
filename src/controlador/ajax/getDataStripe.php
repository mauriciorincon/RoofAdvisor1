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
    $_actual_company=$this->_userModel->getCompany($_companyID);
    $_stripe_secret_key='';
    if(!isset($_actual_company['stripeSecretKey'])){
        $_stripe_secret_key='';
    }else{
        $_stripe_secret_key=$_actual_company['stripeSecretKey'];
    }
    switch($_data){
        case "balance" :
            $_array_stripe_balance=$this->getBalanceAccount($_actual_company['stripeAccount']);
            $_response="<tr>
                            <td>id</td>
                            <td>Type</td>
                            <td>Amount</td>
                            <td>Currency</td>
                            <td>bank_account</td>
                            <td>bitcoin_receiver</td>
                            <td>card</td>
                        </tr>"; 
                                            
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
                            "<td>".$trancs->source_types->card."</td>".
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
                    $_response.="<tr>".
                            "<td>".$n."</td>".
                            "<td>Pending</td>".
                            "<td>".number_format($_amount, 2, '.', '')."</td>".
                            "<td>".$trancs->currency."</td>".
                            "<td>".$trancs->source_types->bank_account."</td>".
                            "<td>".$trancs->source_types->bitcoin_receiver."</td>".
                            "<td>".$trancs->source_types->card."</td>".
                        "</tr>";
                    $n++;
                }
            }
            
            $_response.="</table>";
            break;
        case "transfer" :
            $_array_stripe_transfer=$this->get_transfer_account($_actual_company['stripeAccount']);
            $_response="<tr>
                <td>Id</td>
                <td>Amount</td>
                <td>Balance_Transaction</td>
                <td>Created</td>
                <td>Description</td>
                <td>Destination_Payment</td>
            </tr>";
            
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
            $_array_stripe_transaction=$this->get_transaction_account($_actual_company['stripeAccount'],$_stripe_secret_key);
            <tr>
                    <td>id</td>
                    <td>amount</td>
                    <td>available_on</td>
                    <td>created</td>
                    <td>currency</td>
                    <td>description</td>
                    <td>fee</td>
                    <td>net</td>
                    <td>status</td>
                    <td>type</td>
                </tr>
                <?php
                    $n=1;
                    if(isset($_array_stripe_transaction->data)){
                        foreach($_array_stripe_transaction->data as $clave=>$trancs){
                            $_amount=0;
                            if($trancs->amount==0){$_amount=0;}else{$_amount=$trancs->amount/100;}
                            $_amount_1=0;
                            if($trancs->net==0){$_amount_1=0;}else{$_amount_1=$trancs->net/100;}
                        echo "<tr>".
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
                ?>
            break;
        case "payout" :
            $_array_stripe_payout=$this->get_payout_account($_actual_company['stripeAccount'],$_stripe_secret_key);
            break;
    }
?>