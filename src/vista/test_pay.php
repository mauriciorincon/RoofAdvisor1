<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    echo "http://" . $_SERVER['HTTP_HOST']."<br>";
    echo $_SERVER['REQUEST_URI']."<br><br>";
    
    echo "root:".$_SERVER['DOCUMENT_ROOT'];
    echo "<br><br>";
    echo "ppp_self:".dirname($_SERVER['PHP_SELF']);
    echo "<br><br>";

    //require_once($_SESSION['application_path']."/controlador/calendarController.php");
    require_once($_SESSION['application_path']."/controlador/payingController.php");
    require_once($_SESSION['application_path']."/controlador/emailController.php");
    require_once($_SESSION['application_path']."/controlador/pdfController.php");
    require_once($_SESSION['application_path']."/controlador/readXLSXController.php");
    require_once($_SESSION['application_path']."/controlador/orderController.php");
    require_once($_SESSION['application_path']."/modelo/order.class.php");
    require_once($_SESSION['application_path']."/modelo/user.class.php");
    require_once($_SESSION['application_path']."/vista/customerFAQ.php");
    require_once($_SESSION['application_path']."/controlador/smsController.php");


    require_once($_SESSION['application_path']."/controlador/userController.php");
    //echo $_SESSION['application_path']."declare user controller";
    //require_once($_SESSION['application_path']."/modelo/user.class.php");

    /*$_objPay=new payingController();

    $_objUser = new userModel();

    $properties = [
        'emailVerified' => true,
        'disabled' => false,
        'photoURL' => ''
    ];
    $userId = "nbzguSDBqvaCCX8TagjI4AC3gFb2";
    $profile = "driver";
    $_result = $_objUser->updateUserContractor($userId,$properties,$profile);
    print_r($_result);*/

    $_objMessage=new smsController();
    $_objMessage->createClientSms();
    $account = $_objMessage->getClient()->api->v2010->accounts("51079c5b-7c97-44a3-a0b0-4f75766d2347")->fetch();
    print($account->friendlyName);
    //$_objMessage->sendMessage("+12044000446","+16178987045","hello from roofservicenow");
    $_objMessage->sendMessage("+12044000446","+573017560821","hello from roofservicenow");

    //$_objMessage->getAllTallNumbers();
    //$_objMail=new emailController();
    //$_result=$_objMail->sendMailSMTP("mauricio.rincon@gmail.com","test","<h4>hello world</h4>","","");
    //echo $_result;

    //$_objExcel=new read_excel();
    //$_objExcel->generateExcel();
    return;
    /*
    //create account
    $_result=$_objPay->createAccount('supo7@yahoo.com');
    echo "<br><br>";
    echo $_result->keys->secret;
    echo "<br><br>";
    echo $_result->keys->publishable;
    echo "<br><br>";
    //echo "<br>Resultado Creacion Usuario<br>";
    var_dump($_result);

    //$_objPay->showPayingWindow1();
    //$_token=$_objPay->create_token_for_charge("mauricio@gmail.com","4242424242424242",12,20,123);
    //print_r($_token);
    echo "<br><br>";
    //$_customer=$_objPay->createCustomer("text@gmail.com",$_token);
    //print_r($_customer);
    //$_objPago=$_objPay->createChargeOtherFee(null,19600,"usd","acct_1DiBU7B2zQatABj9",1000);
    //$_objPago=$_objPay->createChargeDestination(null,5000,"usd","acct_1DiBU7B2zQatABj9",300);
    //$_objPago=$_objPay->createChargeOther(null,15000,"usd","acct_1DiBU7B2zQatABj9");

    echo "<br><br>";
    //print_r($_objPago);
    */
    $_userModel=new userController();
    $_companyArray=$_userModel->getCompanyById('CO000008');
    $_validation_code='34dsidherhfh';
    $_userData='4errerrer';
    echo $_userModel->welcomeMailCompany($_companyArray,$_validation_code,$_userData);
    //$_result=$_userModel->createAccount('CO000008','mauricio.rincon@gmail.com');
    //echo $_result;

    //$_result=$_objPay->createTransfer(5000,"usd","acct_1DiBU7B2zQatABj9");
    //var_dump($_result);

    echo "<br><br>";
    $var_usr=$_userModel->getAccount('acct_1DiBU7B2zQatABj9');
    print_r($var_usr->keys);
    echo "<br><br>";
    echo $var_usr->legal_entity->ssn_last_4 ;
    /*echo count($var_usr->external_accounts);
    print_r($var_usr->external_accounts->data);
    foreach($var_usr->external_accounts->data as $clave=>$bank){
        echo "Bank <br><br>";
        print_r($bank);
    }*/
    //return;
    //$_response=$_userModel->create_bank_account('110000000','000123456789','1234','individual');
    //var_dump($_response);
    //echo "<br><br>";
    echo "<br>Info<br>";
    $_result=$_objPay->get_transaction_account('acct_1Dq4DvERqpFpJXVH','sk_test_IrHCvop3TQyomitAeThf5CKQ');
    echo "<br>Trnasacciones<br>";
    print_r($_result);
    //$var_bank=$_userModel->get_token_bank_account('btok_1DjBC8AuRAPDfvKLluIyeFLg');
    //var_dump($var_usr);
    echo "<br><br>";
    echo "<br>Payout<br>";
    $_result=$_objPay->get_payout_account('acct_1Dq9PsEZ7uDDF7Yq','sk_test_v9B44D8b2rz96Kx3DMSQWxv9');
    print_r($_result);
    //$_result=$_objPay->get_payout_account('','');
    //print_r($var_bank->bank_account->routing_number);
    //print_r($var_bank->bank_account->account_holder_name);
    echo "<br><br>";
    //array(9) { [0]=> string(16) "external_account" [1]=> string(20) "legal_entity.dob.day" [2]=> string(22) "legal_entity.dob.month" [3]=> string(21) "legal_entity.dob.year" [4]=> string(23) "legal_entity.first_name" [5]=> string(22) "legal_entity.last_name" [6]=> string(17) "legal_entity.type" [7]=> string(19) "tos_acceptance.date" [8]=> string(17) "tos_acceptance.ip" } 
    //$var_usr['external_account']='hola';

    //$var_usr->external_accounts->create(array("external_account" => $_response['id']));
    
    /*$var_usr->legal_entity->dob->day=18;
    $var_usr->legal_entity->dob->month=9;
    $var_usr->legal_entity->dob->year=1980;
    $var_usr->legal_entity->first_name='Alex';
    $var_usr->legal_entity->last_name='Alvarez';
    //individual
    //company
    $var_usr->legal_entity->type='individual';
    $var_usr->tos_acceptance->date=time();
    $var_usr->tos_acceptance->ip=$_SERVER['REMOTE_ADDR'];
    $var_usr->legal_entity->address->city='Miami';
    $var_usr->legal_entity->address->line1='St 4588';
    $var_usr->legal_entity->address->postal_code=33101;
    $var_usr->legal_entity->address->state='FLORIDA';
    $var_usr->legal_entity->ssn_last_4=7845;
    $var_usr->legal_entity->personal_id_number=123457845;

    $file="/tmp/IMG_0029.jpeg";
    $_response=$_userModel->upload_file($file);
    echo "<br><br>";
    var_dump($_response);
    $var_usr->legal_entity->verification->document=$_response['id'];


    $var_usr->save();*/
    echo "<br><br>";
    var_dump($_userModel->getValidateAccount('acct_1DntFbD7z6TK2mJK'));

    //$_oCalendar=new calendar();

    //$_result=$_oCalendar->getEvents('07','2018');
    //print_r($_result);

    
    
    //$_objPDF=new pdfController();
    //$_objPDF->paymentConfirmation1("313",null,100);
    
    
    //$_orderModel=new orderModel();
    //$_lastOrderNumber=$_orderModel->getLasOrderNumberParameter("Parameters/LastOrderID");
    //echo "Order id: ".$_lastOrderNumber;

    //Send Mail
    


    //$_result=$_objMail->sendMailSMTP();
    //if(is_bool($_result)){
    //   echo $_objMail->getMessageError();
    //}else{
    //    echo $_result;
    //}
    /*$_information=new customerFAQ();
        $_array=$_information->getArrayOptions();
        $_output_html="";
        foreach($_array as $key => $item){
            echo $item;
            $_output_html.=call_user_func( array( "customerFAQ", $item ) );
        }
        echo $_output_html."<br><br>";
        

        echo $_information::number_1;
        echo $_information::number_2;
        echo $_information::number_3;
        echo $_information::number_4;*/

        /*$_userModel=new userModel();
        $_result=$_userModel->validateCompany('support@roofservicenow.com','123456');

        $properties = [
            'emailVerified' => true,
            'disabled' => false,
            'photoURL' => ''
        ];
        $_result_update=$_userModel->updateUserCustomer($_result->uid,$properties,'company');*/




?>
<div class="votable hide">
						<i class="fa fa-3x fa-star-o" data-vote-type="1"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="2"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="3"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="4"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="5"></i>
						
					</div>
					<div class="voted">
						<i class="fa fa-3x fa-star-o" data-vote-type="1"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="2"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="3"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="4"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="5"></i>
						
					</div>
					<i><label id="ratingCompany">Rating: 0</label></i>
<form action="http://localhost/RoofAdvisor1/index.php?controller=paying&accion=setPaying" method="post">
    Parametros;<input type="text" id="param" name="param" value='{ "stripeToken" : "xxxxiiiissss","stripeEmail":"mauricio.rincon@gmail.com","totalAmount":"50" }'/>
    <input type="submit" value="enviar pago" />
</form>