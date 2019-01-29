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
?>