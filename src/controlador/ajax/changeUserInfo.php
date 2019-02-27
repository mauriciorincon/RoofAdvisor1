<?php

    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    require_once($_SESSION['application_path']."/controlador/userController.php");



    $value = $_POST['value'];
    $table = $_POST['t'];
    $email = $_POST['u'];
    $type = $_POST['type'];

    $_userController = new userController();
    switch($table){
        case 'c':
            $table1 = "customer";
            $user=$_userController->getCustomer($email);
            break;
        case 'co':
            $table1 = "company";
            $user=$_userController->getCompanyE($email);
            break;
    }

    if(strcmp($type,"phone")==0){
        $value="+1".$value;
        
    }
    
    $_result = $_userController->updateUserPorperty($user['uid'],$table1,$type,$value);
    if($table=='c'){
        if(strcmp($type,"phone")==0){
            $_userController->updateCustomerByField($user['CustomerID'],"Phone",$value);
        }else if(strcmp($type,"email")==0){
            $_userController->updateCustomerByField($user['CustomerID'],"Email",$value);
        }
    }else if($table=='co'){
        if(strcmp($type,"phone")==0){
            $_update_string = "CompanyPhone,$value";
            $_arrayFields=explode(",",$_update_string);
        }else if(strcmp($type,"email")==0){
            $_update_string = "CompanyEmail,$value";
            $_arrayFields=explode(",",$_update_string);
        }
        $_userController->updateCompanyFields($user['CompanyID'],$_arrayFields);
    }
    $_string_message = '';
    $_string_button = '';
    if(is_object($_result) or is_array($_result)){
        if($type=='email'){
            $email = $value;
            if(strcmp($table,'c')==0){
                $phoneNumber = $user['Phone'];
            }else if(strcmp($table,'co')==0){
                $user['CompanyPhone'] = str_replace("+1", "", $user['CompanyPhone']);

                $phoneNumber = $user['CompanyPhone'];
            }
        }
        if($type=='phone'){
            $phoneNumber = $value;
            if(strcmp($table,'c')==0){
                $email = $user['Email'];
            }else if(strcmp($table,'co')==0){
                $email = $user['CompanyEmail'];
            }
        }
        $_string_message = '<div class="alert alert-success">Registration success<br>Please resend a new code to phone/email to complete registration 
            <br>Your registration phone:<a href="#" onclick="setDataChangePhoneMail(\''. $email .'\',\''.$table.'\',\''. $phoneNumber .'\',\'phone\')">'. $phoneNumber .'</a>
            <br>Your registration email:<a href="#" onclick="setDataChangePhoneMail(\''. $email .'\',\''.$table.'\',\''. $email .'\',\'email\')">'. $email .'</a></div><br>'.
            '<h4>Type your activation code</h4><input type="text" id="activation_code_input" />'.
            '<br><br><strong>Did not get a code?</strong>'.
            '<button type="button" id="resendCode" class="btn-primary btn-sm" onclick="resendValidationCode(\'' . $email . '\',\'\',\'phone\',\''.$table.'\')">Resend Code</button>'.
            '<a href="#" class="btn-primary btn-sm" onclick="resendValidationCode(\'' . $email .  '\',\'\',\'mail\',\''.$table.'\')">SEND ME THE VALIDATION CODE BY EMAIL</a>';
        $_string_button = '<br><br>                                                                                  
            <div class="alert alert-warning" role="alert">
                <center><button type="button" id="lastFinishButtonOrder" class="btn-success btn-lg"  onclick="validate_sms_code(\''.$table.'\',\''. $email .'\')">Validate Code</button></center>
            </div>';
        $_message = "The $type was changed correctly.";

    }else{
        $_message = "Error, $_result";
    }
    $_message=array(
        'title'=>"Change phone/email",
        'subtitle'=>$_message,
        'content'=>$_string_message,
        'button' =>$_string_button,
        'extra' =>'',
    );
    print_r(json_encode($_message));
?>