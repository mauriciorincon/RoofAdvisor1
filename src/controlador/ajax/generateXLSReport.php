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
    //print_r($_array_options);
    
    if(count($_array_options)==0){
        return "No options selected";
    }else{
        $n=0;
        $_big_array_info = array();
        while(isset($_array_options[$n])){
            switch($_array_options[$n]){
                case "Balance":
                    $_array_info=array();
                    $_array_stripe_balance=$_paying_controller->get_balance_account($_actual_company['stripeAccount']);
                    if(is_object($_array_stripe_balance) or is_array($_array_stripe_balance)){
                        $array_data=["ID","TYPE","AMOUNT","BANK_ACCOUNT",];
                        array_push($_array_info,$array_data);
                        foreach($_array_stripe_balance->available as $clave=>$trancs){
                            $_amount=0;
                            if($trancs->amount==0){$_amount=0;}else{$_amount=$trancs->amount/100;}
                            $array_data=[1,"Available",number_format($_amount, 2, '.', ''),$trancs->source_types->bank_account,];
                            array_push($_array_info,$array_data);
                        }
                        if(isset($_array_stripe_balance->connect_reserved)){
                            foreach($_array_stripe_balance->connect_reserved as $clave=>$trancs){
                                $_amount=0;
                                if($trancs->amount==0){$_amount=0;}else{$_amount=$trancs->amount/100;}
                                $array_data=[1,"connect_reserved",number_format($_amount, 2, '.', ''),$trancs->source_types->bank_account,];
                                array_push($_array_info,$array_data);
                            }
                        }
                        if(isset($_array_stripe_balance->pending)){
                            foreach($_array_stripe_balance->pending as $clave=>$trancs){
                                $_amount=0;
                                if($trancs->amount==0){$_amount=0;}else{$_amount=$trancs->amount/100;}
                                $array_data=[1,"Pending",number_format($_amount, 2, '.', ''),$trancs->source_types->bank_account,];
                                array_push($_array_info,$array_data);
                            }
                        }
                    }
                    //$_text_url = $_excelGenerate->generateExcelData($_array_options[$n],$_array_info,"");
                    break;
                case "Transfer":
                    $_array_info=array();
                    $_array_stripe_transfer=$_paying_controller->get_transfer_account($_actual_company['stripeAccount']);
                    if(isset($_array_stripe_transfer->data)){
                        $array_data=["ID","AMOUNT","CREATED","DESCRIPTION","DESTINATION_PAYMENT",];
                        array_push($_array_info,$array_data);
                        foreach($_array_stripe_transfer->data as $clave=>$trancs){
                            $_amount=0;
                            if($trancs->amount==0){$_amount=0;}else{$_amount=round($trancs->amount/100,2);}
                            $array_data=[$trancs->id,number_format($_amount, 2, '.', ''),date("F j, Y, g:i a",$trancs->created),$trancs->description,$trancs->destination_payment,];
                            array_push($_array_info,$array_data);
                        }
                    }
                    //$_text_url = $_excelGenerate->generateExcelData($_array_options[$n],$_array_info,"");
                    break;
                case "Transactions":
                    break;
                case "Pay outs":
                    break;
            }
            if(!empty($_array_options[$n])){
                $_array_tmp=[
                    $_array_options[$n],
                    $_array_info,
                ];
                array_push($_big_array_info,$_array_tmp);
            }
            
            $n++;
            
        }
        //print_r($_big_array_info);
        $_text_url = $_excelGenerate->generateExcelDataM($_big_array_info);
        
    }

    //$_text_url = $_excelGenerate->generateExcel();

    

    

    echo $_text_url;

?>