<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

require_once($_SESSION['application_path']."/controlador/payingController.php");

$_paying_controller=new payingController();
$_action=$_POST['action'];

$routing_number=$_POST['myProfileBankrouting_number'];
$account_number=$_POST['myProfileBankaccount_number'];
$account_holder_name=$_POST['myProfileBankaccount_holder_name'];
$account_holder_type=$_POST['myProfileBankaccount_holder_type'];
$country=$_POST['myProfileBankCountry'];
$currency=$_POST['myProfileBankCurrency'];
$bank_id=$_POST['bank_id'];

$stripeID=$_POST['account_id'];

$_account=$_paying_controller->getAccount($stripeID);
if(is_object($_account) or is_array($_account)){
    switch ($_action){
        case 'query':
            break;
        case 'insert':
            $_result=$_paying_controller->validate_bank_account($stripeID,$account_number);
            if($_result==false){
                $_token_bank=$_paying_controller->create_bank_account($routing_number,$account_number,$account_holder_name,$account_holder_type,$country,$currency);
                if(is_object($_token_bank) or is_array($_token_bank)){
                    $_result_bank=$_paying_controller->link_bank_to_account($_account,$_token_bank);
                }else{
                    $_result_bank="Error, ".$_token_bank;
                }
            }else{
                $_result_bank="Error, The bank account is already in the user account";
            }
            break;
        case 'delete':
            $_result_bank=$_paying_controller->delete_bank_account($_account,$bank_id);
            if(is_object($_result_bank) or is_array($_result_bank)){
                $_result_bank = "The bank account was deleted successfully";
            }
            break;
        case 'setdefault':
            $_result_bank=$_paying_controller->update_bank_account($_account,$bank_id,"default_for_currency","true");
            if(is_object($_result_bank) or is_array($_result_bank)){
                $_result_bank = "The bank selected was set to default for payouts";
            }else{
                $_result_bank = "Error, ".$_result_bank;
            }
            break;
        default :
            break;
    
    }
    echo $_result_bank;
}else{
    echo  "Error, the occount was not found, try again";
}

?>