<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");
require_once($_SESSION['application_path']."/controlador/orderController.php");

$_companyID =$_POST["companyID"];
$_contractorController=new userController();
$_result=$_contractorController->getCompanyById($_companyID);
if(isset($_result['stripeAccount'])){
    $_array_stripe_info=$_contractorController->getAccount($_result['stripeAccount']);
    $_result['compamnylegal_entity_type']=$_array_stripe_info->legal_entity->type;
    $_result['compamnylegal_entity_business_name']=$_array_stripe_info->legal_entity->business_name;
    $_result['compamnylegal_entity_business_tax_id']=$_array_stripe_info->legal_entity->business_tax_id_provided;
    $_result['compamnylegal_entity_State']=$_array_stripe_info->legal_entity->address->state;
    $_result['compamnylegal_entity_City']=$_array_stripe_info->legal_entity->address->city;
    $_result['compamnylegal_entity_Zipcode']=$_array_stripe_info->legal_entity->address->postal_code;
    $_result['compamnylegal_entity_Address']=$_array_stripe_info->legal_entity->address->line1;
    $_result['compamnylegal_entity_first_name']=$_array_stripe_info->legal_entity->first_name;
    $_result['compamnylegal_entity_last_name']=$_array_stripe_info->legal_entity->last_name;
    $_result['compamnylegal_entity_dob']=$_array_stripe_info->legal_entity->dob->month."/".$_array_stripe_info->legal_entity->dob->day."/".$_array_stripe_info->legal_entity->dob->year;
    $_result['compamnylegal_entity_last4']=$_array_stripe_info->legal_entity->ssn_last_4_provided;
    $_result['compamnylegal_entity_personal_id']=$_array_stripe_info->legal_entity->personal_id_number_provided;
    $_result['table_balance']=getBalance($_result['stripeAccount'],$_contractorController);
    if(!isset($_result['stripeSecretKey'])){
        $_stripe_secret_key='';
    }else{
        $_stripe_secret_key=$_result['stripeSecretKey'];
    }
    $_result['table_transaction']=getTransaction($_result['stripeAccount'],$_contractorController,$_stripe_secret_key);
    $_result['table_transfer']=getTransfer($_result['stripeAccount'],$_contractorController);    
    $_result['table_payout']=getPayout($_result['stripeAccount'],$_contractorController,$_stripe_secret_key);
    $_result['table_bank']=getBank($_array_stripe_info,$_result['stripeAccount']);
}
//print_r($_result);
if(is_array($_result)){
    //json_encode($phpArray)
    print_r(json_encode($_result));
}else{
    echo "Error, Company not found";
}


function getBalance($_stripeAccount,$_contractorController){
    $_string_table="";
    $_array_stripe_balance=$_contractorController->getBalanceAccount($_stripeAccount);
    $n=1;
    if(isset($_array_stripe_balance->available)){
        foreach($_array_stripe_balance->available as $clave=>$trancs){
            $_amount=0;
            if($trancs->amount==0){$_amount=0;}else{$_amount=$trancs->amount/100;}
            $_amount1=0;
            if($trancs->source_types->card==0){$_amount1=0;}else{$_amount1=$trancs->source_types->card/100;}
        $_string_table.= "<tr>".
                    "<td>".$n."</td>".
                    "<td>Available</td>".
                    "<td>".number_format($_amount, 2, '.', '')."</td>".
                    "<td>".$trancs->source_types->bank_account."</td>".
                "</tr>";
            $n++;
        }
    }
    if(isset($_array_stripe_balance->connect_reserved)){
        foreach($_array_stripe_balance->connect_reserved as $clave=>$trancs){
            $_amount=0;
            if($trancs->amount==0){$_amount=0;}else{$_amount=$trancs->amount/100;}
            $_string_table.= "<tr>".
                    "<td>".$n."</td>".
                    "<td>connect_reserved</td>".
                    "<td>".number_format($_amount, 2, '.', '')."</td>".
                    
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
            $_string_table.= "<tr>".
                    "<td>".$n."</td>".
                    "<td>Pending</td>".
                    "<td>".number_format($_amount, 2, '.', '')."</td>".
                    
                    "<td>".$trancs->source_types->bank_account."</td>".
                    
                "</tr>";
            $n++;
        }
    }
    return $_string_table;
}

function getTransaction($_stripeAccount,$_contractorController,$_stripe_secret_key){
    $_array_stripe_transaction=$_contractorController->get_transaction_account($_stripeAccount,$_stripe_secret_key);
    $_string_table="";
    $n=1;
    if(isset($_array_stripe_transaction->data)){
        foreach($_array_stripe_transaction->data as $clave=>$trancs){
            $_amount=0;
            if($trancs->amount==0){$_amount=0;}else{$_amount=$trancs->amount/100;}
            $_amount_1=0;
            if($trancs->net==0){$_amount_1=0;}else{$_amount_1=$trancs->net/100;}
            $_string_table.= "<tr>".
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
    return $_string_table;
}

function getTransfer($_stripeAccount,$_contractorController){
    $_array_stripe_transfer=$_contractorController->get_transfer_account($_stripeAccount);
    $_string_table="";
    $n=1;
    if(isset($_array_stripe_transfer->data)){
        foreach($_array_stripe_transfer->data as $clave=>$trancs){
            $_amount=0;
            if($trancs->amount==0){$_amount=0;}else{$_amount=round($trancs->amount/100,2);}
            $_string_table.= "<tr>".
                    "<td>".$trancs->id."</td>".
                    "<td>".number_format($_amount, 2, '.', '')."</td>".
                    "<td>".date("F j, Y, g:i a",$trancs->created)."</td>".
                    "<td>".$trancs->description."</td>".
                    "<td>".$trancs->destination_payment."</td>".
                "</tr>";
            $n++;
        }
    }
    return $_string_table;
}

function getPayout($_stripeAccount,$_contractorController,$_stripe_secret_key){
    $_array_stripe_payout=$_contractorController->get_payout_account($_stripeAccount,$_stripe_secret_key);
    $_string_table="";
    $n=1;
    if(isset($_array_stripe_payout->data)){
        foreach($_array_stripe_payout->data as $clave=>$payout){
            $_amount=0;
            if($payout->amount==0){$_amount=0;}else{$_amount=$payout->amount/100;}
            $_string_table.= "<tr>".
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
    return $_string_table;
}

function getBank($_array_stripe_info,$_stripeAccount){
    $_array_stripe_bank=$_array_stripe_info->external_accounts->data;
    $_string_table="";
    $n=1;
    if(isset($_array_stripe_bank)){
        foreach($_array_stripe_bank as $clave=>$bank){
        $_string_table.= "<tr>".
                    "<td>".$n."</td>".
                    "<td>".$bank->account_holder_name."</td>".
                    "<td>".$bank->account_holder_type."</td>".
                    "<td>".$bank->bank_name."</td>".
                    "<td>".$bank->last4."</td>".
                    "<td>".$bank->routing_number."</td>".
                    '<td>
                        <a class="btn-primary btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Set as default bank account"'.
                        'href="#" '.
                        'onClick="actionWithBank(\'setdefault\',\''.$_stripeAccount.'\',\''.$bank->id.'\')" > '.
                        '<span class="glyphicon glyphicon-star"></span></a>
                        <a class="btn-danger btn-sm" data-toggle="modal" data-toggle1="tooltip"  title="Delete Bank Account"'.
                        'href="#" '.
                        'onClick="actionWithBank(\'delete\',\''.$_stripeAccount.'\',\''.$bank->id.'\',this)" > '.
                        '<span class="glyphicon glyphicon-trash"></span></a>
                    </td>'.
                "</tr>";
            $n++;
        }
    }
    return $_string_table;
}
?>