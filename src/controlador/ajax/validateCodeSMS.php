<?php

    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    require_once($_SESSION['application_path']."/controlador/userController.php");


    
    $code = $_POST['verify'];
    $table = $_POST['t'];
    $email = $_POST['u'];
    $pass = $_POST['p'];
    /*echo $code;
    echo $table;
    echo $email;
    return;*/
    $_userController = new userController();
    if(strcmp($table,"c")==0){
        $table1="Customers";

        $_objUser = $_userController->getCustomer($email);
        $phoneNumber = $_objUser['Phone'];        
    }else if(strcmp($table,"co")==0){
        $table1="Company";
        $_objUser = $_userController->getCompanyE($email);   
        $phoneNumber = $_objUser['CompanyPhone'];
        
    }else if(strcmp($table,"con")==0){
        $table="Contractors";
    }
    //echo $table1;
    $_userController=new userController();
    $_result=$_userController->validateCode($email,$code,$table1);

    if(is_array($_objUser) or is_object($_objUser)){
        //echo $_result;
        if(strpos($_result,"Error")===false){
            //echo "entro bien:".strpos("Error",$_result);
            $_string_message = '<div class="alert alert-success">Registration success<br> welcome to RoofServiceNow now you can login';
            switch($table1){
                case "Customers":
                    $_string_button = '<br><br>'.
                    '<div class="alert alert-warning" role="alert">
                        <center><button type="button" id="lastFinishButtonOrder" class="btn btn-default" data-dismiss="modal" onclick="loginUser(\''.$email."','".$pass.'\',\'step8\')">Finish the order</button></center>
                    </div>';
                    break;
                case "Company":
                    $_string_button = '<br><br>                                       
                    <div class="alert alert-warning" role="alert">
                        <center><a  id="lastFinishButtonOrder" class="btn-success btn-lg" href="?controller=user&accion=dashboardCompany">Accept</button></center>
                    </div>';
                    break;
            }
                
        }else{
            //echo "entro error:".strpos("Error",$_result);
            $_string_message = '<div class="alert alert-danger"><strong>Error register '.$table1.' validation code is incorrect</strong><br>Your registration phone:<a href="#">'. $phoneNumber .'</a><br>Your registration email:<a href="#">'. $email .'</a></div>'.
            '<h4>Type your activation code</h4><input type="text" id="activation_code_input" />'.
            '<br><br><strong>Did not get a code?</strong>'.
            '<button type="button" id="resendCode" class="btn-primary btn-sm" onclick="resendValidationCode(\'' . $email  . '\',\'\',\'phone\',\''.$table.'\')">Resend Code</button>'.
            '<a href="#" class="btn-primary btn-sm" onclick="resendValidationCode(\'' . $email  .  '\',\'\',\'mail\',\''.$table.'\')">SEND ME THE VALIDATION CODE BY EMAIL</a>';
            $_string_button = '<br><br>                                       
                <div class="alert alert-warning" role="alert">
                    <center><button type="button" id="lastFinishButtonOrder" class="btn-success btn-lg" onclick="validate_sms_code(\''.$table.'\',\''. $email .'\')">Validate Code</button></center>
                </div>';
            
        }
        $_message=array(
            'title'=>"Register $table1",
            'subtitle'=>"",
            'content'=>$_string_message,
            'button' =>$_string_button,
            'extra' =>$_result,
        );
    }else{
        $_string_message = '<div class="alert alert-danger"><strong>Error register '.$table1.' user was not found</strong><br>Your registration phone:<a href="#">'. $phoneNumber .'</a><br>Your registration email:<a href="#">'. $email .'</a></div>'.
        '<h4>Type your activation code</h4><input type="text" id="activation_code_input" />'.
        '<br><br><strong>Did not get a code?</strong>'.
        '<button type="button" id="resendCode" class="btn-primary btn-sm" onclick="resendValidationCode(\'' . $email  . '\',\'\',\'phone\',\''.$table.'\')">Resend Code</button>'.
        '<a href="#" class="btn-primary btn-sm" onclick="resendValidationCode(\'' . $email  .  '\',\'\',\'mail\',\'co\')">SEND ME THE VALIDATION CODE BY EMAIL</a>';
        $_string_button = '<br><br>                                       
            <div class="alert alert-warning" role="alert">
                <center><button type="button" id="lastFinishButtonOrder" class="btn-success btn-lg" onclick="validate_sms_code(\''.$table.'\',\''. $email .'\')">Validate Code</button></center>
            </div>';
        $_message=array(
            'title'=>"Register $table1",
            'subtitle'=>"",
            'content'=>$_string_message,
            'button' =>$_string_button,
            'extra' =>$_result,
        );
    }

    print_r(json_encode($_message));
    

?>