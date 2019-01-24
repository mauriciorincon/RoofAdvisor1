<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    
    require_once($_SESSION['application_path']."/controlador/payingController.php");
    require_once($_SESSION['application_path']."/controlador/userController.php");
    require_once($_SESSION['application_path']."/controlador/readXLSXController.php");
    
    $_report_type = $_POST['report_type'];
    $_companyID = $_POST['companyID'];

    $_excelGenerate = new read_excel();
    $_paying_controller = new payingController();
    $_user_controller = new userController();

    $_actual_company=$_user_controller->getCompany($_companyID);

    $_stripe_secret_key='';
    if(!isset($_actual_company['stripeSecretKey'])){
        $_stripe_secret_key='';
    }else{
        $_stripe_secret_key=$_actual_company['stripeSecretKey'];
    }

    $_array_options=explode(",",$_POST['report_type']);
    if(count($_array_options)==0){
        return "No options selected";
    }else{
        $n=0;
        while(isset($_array_options[$n])){
            switch($_array_options[$n]){
                case "Balance":
                    $_array_stripe_balance=$_paying_controller->get_balance_account($_actual_company['stripeAccount']);
                    if(is_object($_array_stripe_balance) or is_array($_array_stripe_balance)){
                        foreach($_array_stripe_balance->available as $clave=>$trancs){
                            if($trancs->amount==0){$_amount=0;}else{$_amount=$trancs->amount/100;}
                            $array_data=[
                                1,
                                "Available",
                                number_format($_amount, 2, '.', ''),
                                $trancs->source_types->bank_account."</td>",
                            ];
                        }
                    }
                    $_text_url = $_excelGenerate->generateExcelData($_array_options[$n],(array) $_array_stripe_balance,"");
                    break;
                case "Transfer":
                    break;
                case "Transactions":
                    break;
                case "Pay outs":
                    break;
            }
            $n++;
        }

        
    }

    //$_text_url = $_excelGenerate->generateExcel();

    

    

    echo $_text_url;

?>