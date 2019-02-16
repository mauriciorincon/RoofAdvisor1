<?php
if(!isset($_SESSION)) { 
        session_start(); 
} 


require_once($_SESSION['application_path']."/modelo/user.class.php");
require_once($_SESSION['application_path']."/controlador/emailController.php");
require_once($_SESSION['application_path']."/controlador/calendarController.php");
require_once($_SESSION['application_path']."/controlador/orderController.php");
require_once($_SESSION['application_path']."/controlador/othersController.php");
require_once($_SESSION['application_path']."/controlador/payingController.php");
require_once($_SESSION['application_path']."/vista/customerFAQ.php");
require_once($_SESSION['application_path']."/vista/usefull_urls.php");


//include 'vendor/autoload.php';
//include 'vendor/vendor/ktamas77/firebase-php/src/firebaseLib.php';

/*const DEFAULT_URL = 'https://test-b56ee.firebaseio.com/';
const DEFAULT_TOKEN = 'AIzaSyB5fQhYpfj-DinOoMBxCyWgMwG7Ks61OoA';
const DEFAULT_PATH = 'test-b56ee';*/

/*const DEFAULT_URL = 'https://pruebabasedatos-eacf6.firebaseio.com/';
const DEFAULT_TOKEN = '2r3VP6qms0ibMPC8ENJN3vOzr9dFaLexO5T9X3yZ';
const DEFAULT_PATH = 'pruebabasedatos-eacf6';*/


class userController{

    private $_userModel=null;
    private $_orderController=null;
    private $_otherController=null;
    private $_sendMail=null;
    private $_user="";
    private $_pass="";

    function __construct()
	{	
        //echo "fue construido objeto customerController";	
    }
    
    public function showLoginContractor(){
        
        /*if(isset($_SESSION['loggedin'])){
            if($_SESSION['loggedin']==true){
                $this->dashboardCompany($_SESSION['email']);
            }
        }*/
		require_once("vista/head.php");
		require_once("vista/login_contractor.php");
		require_once("vista/footer.php");
    }

    public function showLoginClient(){
        
		require_once("vista/head.php");
		require_once("vista/login_client.php");
		require_once("vista/footer.php");
    }

    public function showRegisterContractor(){
        $this->_otherController=new othersController();
        $_profileList=$this->_otherController->getParameterValue("Parameters/profile");

        require_once("vista/head.php");
        require_once("vista/register_contractor.php");
        require_once("vista/footer.php");
    }

    public function showRegisterCustomer(){
        $this->_userModel=new userModel();
        $_array_state=$this->_userModel->getNode('Parameters/state');
        require_once("vista/head.php");
        require_once("vista/register_customer.php");
        require_once("vista/footer.php");
    }

    public function resetPasswordCustomer(){
        $_user_type="customer";
        require_once("vista/head.php");
        require_once("vista/recover_password.php");
        require_once("vista/footer.php");
    }

    public function resetPasswordCompany(){
        $_user_type="company";
        require_once("vista/head.php");
        require_once("vista/recover_password.php");
        require_once("vista/footer.php");
    }

    public function changePasswordS(){
        require_once("vista/head.php");
        require_once("vista/resetPassword.php");
        require_once("vista/footer.php");
    }
    

    public function loginCustomer(){
        if(!isset($_POST['userClient']) or !isset($_POST['passwordClient'])){
            $this->showLoginClient();
        }else{
            $this->_user=$_POST['userClient'];
            $this->_pass=$_POST['passwordClient'];

            $this->_userModel=new userModel();
            $_result=$this->_userModel->validateCustomer($this->_user,$this->_pass);
            
            if(is_array($_result) or gettype($_result)=="object"){
                if($_result->emailVerified==1){
                    $this->cleanVariables();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $_result->displayName;
                    $_SESSION['start'] = time();
                    $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
                    $_SESSION['email'] = $_result->email;
                    $_SESSION['profile'] = 'customer';
                    $this->dashboardCustomer($this->_user);
                }else{
                    Header("Location: ?aditionalMessage=It seems that you have not validated your email, please check your email&controller=user&accion=showLoginClient");
                }
            }elseif(is_string($_result)){
                Header("Location: ?aditionalMessage=User or password are incorrect, please try again&controller=user&accion=showLoginClient");
            }
        }
    }

    public function loginCustomerOrden($user,$password){
        $this->_user=$user;
        $this->_pass=$password;

        //echo  $this->_user=$user;
        //echo $this->_pass=$password;
        $this->_userModel=new userModel();
        $_result=$this->_userModel->validateCustomer($this->_user,$this->_pass);
        //echo "datos de usuario:".gettype($_result)."<br>";
        //print_r($_result);
        if(is_array($_result) or gettype($_result)=="object"){
            //echo " 1 ";
            if($_result->emailVerified==1){
                
                $_data_customer=$this->_userModel->getCustomer($this->_user);
                if(!is_null($_data_customer)){
                    $this->cleanVariables();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $_result->displayName;
                    $_SESSION['start'] = time();
                    $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
                    $_SESSION['email'] = $_result->email;
                    $_SESSION['profile'] = 'customer';

                    
                    echo '<script>
                        var email_user_logued=\''.$_SESSION['email'].'\';
                    </script>';

                    return "Welcome Mr/Mrs <b>[".$_SESSION['username']."]</b>, please press finish button to save the order.";
                }else{
                    return "Error, please comunicate with RoofServiceNow for help";
                }
                
            }else{
                //echo " 3 ";
                return "Error, It seems that you have not validated your email, please check your email";
            }
            //echo " 4 ";
        }elseif(strcmp(gettype($_result),"string")==0){
            //echo " 5 ";
            return "Error, User or password are incorrect, please try again";
        }
        //echo " 6 ";
    }

    public function loginContractor(){
        
        if(!isset($_POST['userContractor']) or !isset($_POST['passwordContractor'])){
            $this->showLoginContractor();
        }else{
            $this->_user=$_POST['userContractor'];
            $this->_pass=$_POST['passwordContractor'];
            $this->_userModel=new userModel();
            //echo "va a llamar a validar company";
            $_result=$this->_userModel->validateCompany($this->_user,$this->_pass);
            //print_r($_result);
            //return;
            if(is_array($_result) or gettype($_result)=="object"){
                //print_r($_result);
                if($_result->emailVerified==1){
                    $_data_company=$this->_userModel->getCompany($this->_user);
                    if(!is_null($_data_company)){
                        $this->cleanVariables();
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $_data_company['CompanyName'];
                        $_SESSION['start'] = time();
                        $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
                        $_SESSION['email'] = $_result->email;
                        
                        if(strcmp($_data_company['CompanyID'],"CO000000")==0){
                            $_SESSION['profile'] = 'admin';
                            $_SESSION['loggedin'] = true;
                            $_SESSION['username'] = $_data_company['CompanyName'];
                            $_SESSION['start'] = time();
                            $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
                            $_SESSION['email'] = $_result->email;
                            $this->dashboardAdmin($this->_user);
                        }else{
                            $_SESSION['profile'] = 'company';
                            $_SESSION['profile-employee'] = 'Admin';
                            $this->dashboardCompany($this->_user);
                        }
                        

                        return "Welcome Mr/Mrs <b>[".$_SESSION['username']."]</b>, please press finish button to save the order.";
                    }else{
                        return "Error, please comunicate with RoofServiceNow for help";
                    }
                }else{
                    Header("Location: ?aditionalMessage=It seems that your acount is not validate, please check your email&controller=user&accion=showLoginContractor");
                }
            }elseif(is_string($_result)){
                $_result=$this->_userModel->validateEmployee($this->_user,$this->_pass);
                
                if(is_array($_result) or gettype($_result)=="object"){
                    if($_result->emailVerified==1){
                        $_employee=$this->_userModel->getContractor($this->_user);
                        $_data_company=$this->_userModel->getCompanyByID($_employee['CompanyID']);
                        if(!is_null($_data_company)){
                            $this->cleanVariables();
                            $_SESSION['loggedin'] = true;
                            $_SESSION['username'] = $_data_company['CompanyName'];
                            $_SESSION['start'] = time();
                            $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
                            $_SESSION['email'] = $_data_company['CompanyEmail'];

                            
                            if(strcmp($_data_company['CompanyID'],"CO000000")==0){
                                $_SESSION['profile'] = 'admin';
                                $_SESSION['loggedin'] = true;
                                $_SESSION['username'] = $_data_company['CompanyName'];
                                $_SESSION['start'] = time();
                                $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
                                $_SESSION['email'] = $_data_company['CompanyEmail'];
                                $this->dashboardAdmin($this->_user);
                            }else{
                                $_SESSION['profile'] = 'company';
                                $_SESSION['profile-employee'] = $_employee['ContractorProfile'];
                                $this->dashboardCompany($_data_company['CompanyEmail']);
                            }
                        }else{
                            Header("Location: ?aditionalMessage=User is not related to a company&controller=user&accion=showLoginContractor");
                        }
                    }else{
                        Header("Location: ?aditionalMessage=It seems that your acount is not validate, please check your email&controller=user&accion=showLoginContractor");
                    }
                }else{
                    Header("Location: ?aditionalMessage=User or password are incorrect, please try again&controller=user&accion=showLoginContractor");
                }
                
            }
        }
        

    }



    public function validateEmail($table,$email){
        $this->_userModel=new userModel();
        $_result=$this->_userModel->validateEmail($table,$email);
        return $_result;
    }

    public function insertCompany($arrayContractor){
        $this->_userModel=new userModel();
        $_lastCompanyID=$this->_userModel->getLastNodeCompany("Company","CompanyID");
        
        if (is_null($_lastCompanyID)){
            $_newCompanyId="CO000001";
        }else{
            $_tmp=substr($_lastCompanyID,2);
            $_tmp=intval($_tmp)+1;
            $_newCompanyId="CO".str_pad($_tmp, 6, "0", STR_PAD_LEFT);
        }
        $hashActivationCode = md5( rand(0,1000) );
        $password = rand(1000,5000);

        $_responseU=$this->insertUserDatabase($arrayContractor['emailValidation'],$arrayContractor['phoneContactCompany'],$arrayContractor['companyName'],$hashActivationCode,$arrayContractor['password'],'company');
        
        if(is_array($_responseU) or gettype($_responseU)=="object"){
            
    
    
            $Company = array(
                    "ComapnyLicNum" => $arrayContractor['ComapnyLicNum'],
                    "CompanyAdd1" => "",
                    "CompanyAdd2" => "",
                    "CompanyAdd3" => "",
                    "CompanyEmail" => $arrayContractor['emailValidation'],
                    "CompanyID" => "$_newCompanyId",
                    "CompanyName" => $arrayContractor['companyName'],
                    "CompanyPhone" => $arrayContractor['phoneContactCompany'],
                    "CompanyRating" => "",
                    "CompanyStatus" => "Inactive",
                    "CompanyType" => $arrayContractor['typeCompany'],
                    "InsLiabilityAgencyName" => "",
                    "InsLiabilityAgtName" => "",
                    "InsLiabilityAgtNum" => "",
                    "InsLiabilityPolNum" => "",
                    "PayInfoBillingAddress1" => "",
                    "PayInfoBillingAddress2" => "",
                    "PayInfoBillingCity" => "",
                    "PayInfoBillingST" => "",
                    "PayInfoBillingZip" => "",
                    "PayInfoCCExpMon" => "",
                    "PayInfoCCExpYr" => "",
                    "PayInfoCCNum" => "",
                    "PayInfoCCSecCode" => "",
                    "PayInfoName" => "",
                    "PrimaryFName" => $arrayContractor['firstNameCompany'],
                    "PrimaryLName" => $arrayContractor['lastNameCompany'],
                    "Status_Rating" => "5.0",
                    "uid" => $_responseU->uid,
                    "postCardValue" =>0,
                    "InBusinessSince"=>$arrayContractor['InBusinessSince'],
                    "LicExpiration"=>$arrayContractor['LicExpiration'],
                    "Verified"=>'',
                    "TermsDateAccept"=>date("m-d-Y H:i:s"),
                    "TermsIpAccept"=>$_SERVER['REMOTE_ADDR'],
            );
            $_resultUser="User created correctly <br>";
            $_resultCompany=$this->_userModel->insertContractor($_newCompanyId,$Company);

            $_mail_body=$this->welcomeMailCompany($Company,$hashActivationCode,$_responseU);
            
            
            $this->_sendMail=new emailController();
            $_mail_response=$this->_sendMail->sendMailSMTP($arrayContractor['emailValidation'],"Email Verification",$_mail_body,"",$_SESSION['image_path']."logo_s.png");

            if($_mail_response==false){
                $_mail_response="Error ".$_resultUser."<br>".$_resultCompany."<br>".$this->_sendMail->getMessageError();
            }else{
                $_mail_response="OK ".$_mail_response;
            }

            
            return $_newCompanyId."*".$_resultUser.$_resultCompany."<br>".$_mail_response;
        }else{
            return "Error".$_responseU;
        }
        
    }

    public function getListCompany($field="",$value=""){
        $this->_userModel=new userModel();
        $_result=$this->_userModel->getListCompany('Company',$field,$value);
        return $_result;
    }
    public function getListData($table,$field="",$value=""){
        $this->_userModel=new userModel();
        $_result=$this->_userModel->getListData($table,$field,$value);
        return $_result;
    }

    public function insertCustomer($arrayCustomer,$_selectionType=""){
        $_response="";
        $_uid_user="";
        $_responseU="undefined";
        $this->_userModel=new userModel();
        $_lastCustomerID=$this->_userModel->getLasCustomerNumberParameter("Parameters/LastCustomerID");
        
        //$_lastCustomerID=$this->_userModel->getLastNodeCustomer("Customers","CustomerID");
        if (is_null($_lastCustomerID)){
            $_lastCustomerID=1;
        }else{
            $_lastCustomerID++;
        }
        $this->updateCustomerLastId($_lastCustomerID);
        
        $hashActivationCode = md5( rand(0,1000) );
        if(strcmp($_selectionType,"newCustomer")!=0){
            $_responseU=$this->insertUserDatabase($arrayCustomer['emailValidation'],$arrayCustomer['customerPhoneNumber'],$arrayCustomer['firstCustomerName'].' '.$arrayCustomer['lastCustomerName'],$hashActivationCode,$arrayCustomer['password'],'customer');    
            if(gettype($_responseU)=="object"){
                $_uid_user=$_responseU->uid;
            }else{
                $_uid_user="undefined";
            }
        }else{
            $_uid_user="undefined";
        }
        
        
        if(is_array($_responseU) or gettype($_responseU)=="object" or strcmp($_selectionType,"newCustomer")==0){
            
            //$hashActivationCode = $this->_userModel->getKeyNode('Customers');
            //$hashActivationCode = 'FBID';
            $Customer = array(
                "Address" =>  $arrayCustomer['customerAddress'],
                "City" =>  $arrayCustomer['customerCity'],
                "CustomerID" =>  "$_lastCustomerID",
                "Email" =>  $arrayCustomer['emailValidation'],
                "FBID" =>  '',
                "Fname" =>  $arrayCustomer['firstCustomerName'],
                "Lname" =>  $arrayCustomer['lastCustomerName'],
                "Phone" =>  $arrayCustomer['customerPhoneNumber'],
                "State" =>  $arrayCustomer['customerState'],
                "Timestamp" =>  date("m-d-Y H:i:s"),
                "ZIP" =>  $arrayCustomer['customerZipCode'],
                "uid" => $_uid_user,
                "CompanyID"=>$arrayCustomer['CompanyID'],
                "TermsDateAccept"=>date("m-d-Y H:i:s"),
                "TermsIpAccept"=>$_SERVER['REMOTE_ADDR'],
            );
            
            $_response=$this->_userModel->insertCustomer('FBID',$Customer);
            
            if(strcmp($_selectionType,"newCustomer")!=0){
                $_mail_body=$this->welcomeMail($arrayCustomer,$hashActivationCode,$_responseU);
            }
            
            

            if(strcmp($_selectionType,"newCustomer")!=0){
                $this->_sendMail=new emailController();
                $_mail_response=$this->_sendMail->sendMailSMTP($arrayCustomer['emailValidation'],"Email Verification",$_mail_body,"",$_SESSION['image_path']."logo_s.png");
                if($_mail_response==false){
                    return "Error ".$_response."<br>".$this->_sendMail->getMessageError();
                }else{
                    //return "OK ".$_response."<br>".$_mail_response;
                }
            }
        }else{
            return "Error ".$_response." response create user: ".$_responseU;
        } 
        return $_lastCustomerID;
        

    }


    
    public function validateCode($user,$code,$table){
        if(strcmp($table,'Company')==0){
            $this->_userModel=new userModel();
            $_result=$this->_userModel->validateCompanyByID($user);
            
            if(is_array($_result) or gettype($_result)=="object" ){
                //print_r($_result);
                if(strcmp($_result->photoUrl,$code)==0){
                    
                    $properties = [
                        'emailVerified' => true,
                        'disabled' => false,
                        'photoURL' => ''
                    ];
                    $_result_update=$this->_userModel->updateUserCustomer($user,$properties,'company');
                    if(is_array($_result_update) or gettype($_result_update)=="object" ){
                        $_message=$this->messageValidateUser('Your account was validated correctly. Now you can use RoofServiceNow!','notice-success','company');
                        return $_message;
                    }else{
                        $_message=$this->messageValidateUser('An error occurs valdiating your user'.$_result_update,'notice-danger','company');

                        return $_message;
                        
                    }
                    
                }else{
                    $_message=$this->messageValidateUser('An error occurs valdiating your user','notice-danger','company');
                    return $_message;
                }
            }else{
                
                return "Error, the user company was no found";
            }
            $this->_userModel=new userModel();
            $_result=$this->_userModel->validateCustomerByID($user);
            if(is_array($_customer)){
                //print_r($_customer);
                if(strcmp($_customer['ComapnyLicNum'],$code)==0){
                    $this->_userModel->updateContractor($_customer['CompanyID'].'/ComapnyLicNum','');  
                    return "The code is correct";
                }else{
                    return "Error, the code is incorrect";    
                }
            }else{
                return "Error, the user was no found";
            }
        }else if(strcmp($table,'Customers')==0){
            $this->_userModel=new userModel();
            $_result=$this->_userModel->validateCustomerByID($user);
            if(is_array($_result) or gettype($_result)=="object" ){
                if(strcmp($_result->photoUrl,$code)==0){
                    $properties = [
                        'emailVerified' => true,
                        'disabled' => false,
                        'photoURL' => ''
                    ];
                    $_result_update=$this->_userModel->updateUserCustomer($user,$properties,'customer');
                    if(is_array($_result_update) or gettype($_result_update)=="object" ){
                        $_message=$this->messageValidateUser('Your account was validated correctly. Now you can use RoofServiceNow!','notice-success','Customers');
                        return $_message;
                    }else{
                        $_message=$this->messageValidateUser('An error occurs valdiating your user'.$_result_update,'notice-danger','Customers');
                        return $_message;
                    }
                }else{
                    $_message=$this->messageValidateUser('An error occurs valdiating your user','notice-danger','Customers');
                    return $_message;
                }
            }else{
                return "Error, the user was no found";
            }

        }else if(strcmp($table,'Contractors')==0){
            $this->_userModel=new userModel();
            $_result=$this->_userModel->validateContractorByID($user);
            if(is_array($_result) or gettype($_result)=="object" ){
                if(strcmp($_result->photoUrl,$code)==0){
                    $properties = [
                        'emailVerified' => true,
                        'disabled' => false,
                        'photoURL' => ''
                    ];
                    $_result_update=$this->_userModel->updateUserContractor($user,$properties,'driver');
                    if(is_array($_result_update) or gettype($_result_update)=="object" ){
                        $_message=$this->messageValidateUser('Your account was validated correctly. Now you can use RoofServiceNow!','notice-success','Contractors');
                        return $_message;
                    }else{
                        $_message=$this->messageValidateUser('An error occurs valdiating your user'.$_result_update,'notice-danger','Contractors');
                        return $_message;
                    }
                }
            }
        }
    }

    public function getCompany($companyID){
        
        $this->_userModel=new userModel();
        $_array_companies=$this->_userModel->getDataTable("Company");
        foreach ($_array_companies as $key => $company) {
            if(strcmp($company["CompanyID"],$companyID)==0){
                return $company;
            }
        }

    }

    public function dashboardCustomer($_id_customer=""){
       
        
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['profile']) && $_SESSION['profile'] == 'customer'){
            if(empty($_id_customer)){
                $_id_customer=$_SESSION['email'];
            }
            
            $_userMail=$_id_customer;
            $this->_userModel=new userModel();

            $_actual_customer=$this->_userModel->getCustomer($_userMail);
            $_SESSION['username']=$_actual_customer['Fname'].' '.$_actual_customer['Lname'];
            //echo "hola".$_userMail;
            //print_r($_actual_customer);
            
            $_array_customer_to_show=$this->_userModel->getOrdersCustomer($_actual_customer['CustomerID']);

            

            
            $this->_userModel=new userModel();
            $_array_state=$this->_userModel->getNode('Parameters/state');

            $_menu_item=$this->getItemMenu();
            $_divs_info=$this->fillInformationMenu();

            $_information=new usefullURLS();
            $_array_urls=$_information->fillInfoUrls();
            //$_menu_urls=$this->getItemMenuURLS("Miami-Dade County");
            //$_menu_urls1=$this->getItemMenuURLS("Broward County");
            //$_menu_urls2=$this->getItemMenuURLS("Palm Beach County");
            //$_menu_urls3=$this->getItemMenuURLS("Monroe County");
            

            require_once("vista/head.php");
            require_once("vista/dashboard_customer.php");
            require_once("vista/footer.php");
            
        }else{
            $this->showLoginClient();
        
        }
    }
    
    public function dashboardCompany($_id_company=""){
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['profile']) && $_SESSION['profile'] == 'company'){

            if(empty($_id_company)){
                $_id_company=$_SESSION['email'];
            }
            $_userMail=$_id_company;
            $this->_userModel=new userModel();

            //echo "company id".$_id_company;
            $_actual_company=$this->_userModel->getCompany($_userMail);
            //print_r($_actual_company);
            $_array_contractors_to_show=$this->_userModel->getContractorsCompany($_actual_company['CompanyID']);
            $_array_customer_to_show=$this->_userModel->getListData('Customers','CompanyID',$_actual_company['CompanyID']);
            
            if(isset($_actual_company['stripeAccount'])){
                $_array_stripe_info=$this->getAccount($_actual_company['stripeAccount']);
                if(is_object($_array_stripe_info) or is_array($_array_stripe_info)){
                    if (strlen($_array_stripe_info->legal_entity->dob->month)==1){
                        $_array_stripe_info->legal_entity->dob->month="0".$_array_stripe_info->legal_entity->dob->month;
                    }
                    if (strlen($_array_stripe_info->legal_entity->dob->day)==1){
                        $_array_stripe_info->legal_entity->dob->day="0".$_array_stripe_info->legal_entity->dob->day;
                    }
                    if ($_array_stripe_info->legal_entity->business_tax_id_provided==1){
                        $_array_stripe_info->legal_entity->business_tax_id_provided ="Provided";
                    }
                    if ($_array_stripe_info->legal_entity->ssn_last_4_provided==1){
                        $_array_stripe_info->legal_entity->ssn_last_4_provided ="Provided";
                    }
                    if ($_array_stripe_info->legal_entity->personal_id_number_provided==1){
                        $_array_stripe_info->legal_entity->personal_id_number_provided ="Provided";
                    }
                    
                }
                $_array_stripe_bank=$_array_stripe_info->external_accounts->data;
                $_array_stripe_balance=$this->getBalanceAccount($_actual_company['stripeAccount']);

                if(!isset($_actual_company['stripeSecretKey'])){
                    $_stripe_secret_key='';
                }else{
                    $_stripe_secret_key=$_actual_company['stripeSecretKey'];
                }
                $_array_stripe_transaction=$this->get_transaction_account($_actual_company['stripeAccount'],$_stripe_secret_key);

                $_array_stripe_transfer=$this->get_transfer_account($_actual_company['stripeAccount']);

                $_array_stripe_payout=$this->get_payout_account($_actual_company['stripeAccount'],$_stripe_secret_key);
                //print_r($_array_stripe_payout);
            }else{
                $_array_stripe_info=null;
                $_array_stripe_bank=array();
                $_array_stripe_balance=array();
                $_array_stripe_transaction=array();
                $_array_stripe_transfer=array();
                $_array_stripe_payout=array();
            }
            

            

            

            
            

            $_array_orders_to_show=array();

            
            $_orderController=new orderController();
            $_array_orders_to_show=$_orderController->getOrderByCompany($_actual_company['CompanyID']);
            
            $_array_orders_without_comapny=$_orderController->getOrderByCompany("");
            foreach($_array_orders_without_comapny as $key => $order){
                array_push($_array_orders_to_show,$order);
            }

            $this->_userModel=new userModel();
            $_array_state=$this->_userModel->getNode('Parameters/state');

            $this->_otherController=new othersController();
            $_profileList=$this->_otherController->getParameterValue("Parameters/profile");

            $_information=new usefullURLS();
            $_array_urls=$_information->fillInfoUrls();
            
            require_once("vista/head.php");
            require_once("vista/dashboard_company.php");
            require_once("vista/footer.php");
        }else{
            $this->showLoginContractor();
        }
    }

    public function dashboardAdmin($_id_company=""){
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['profile']) && $_SESSION['profile'] == 'admin'){

            if(empty($_id_company)){
                $_id_company=$_SESSION['email'];
            }
            $_userMail=$_id_company;
            $this->_userModel=new userModel();

            //echo "company id".$_id_company;
            $_actual_company=$this->_userModel->getCompany($_userMail);

            //print_r($_actual_company);
            $_array_contractors_to_show=$this->_userModel->getContractorsCompany($_actual_company['CompanyID']);
            
            $_array_orders_to_show=array();

            $this->_otherController=new othersController();
            $_profileList=$this->_otherController->getParameterValue("Parameters/profile");
            
            $_orderController=new orderController();
            $_orderController=new orderController();
            $_array_orders_to_show=$_orderController->getOrdersAll();
            
                        
            require_once("vista/head.php");
            require_once("vista/dashboard_admin.php");
            require_once("vista/footer.php");
        }else{
            $this->showLoginContractor();
        }
    }
    
    public function updateCompany($_companyID,$_compamnyName,$_firstCompanyName,$_lastCompanyName,
                                    $_companyAddress1,$_companyAddress2,$_companyAddress3,$_companyPhoneNumber,
                                    $_companyType,$_PayInfoBillingAddress1,$_PayInfoBillingAddress2,$_PayInfoBillingCity,
                                    $_PayInfoBillingST,$_PayInfoBillingZip,$_PayInfoCCExpMon,$_PayInfoCCExpYr,
                                    $_PayInfoCCNum,$_PayInfoCCSecCode,$_PayInfoName,$_PrimaryFName,
                                    $_PrimaryLName,$_InsLiabilityAgencyName,$_InsLiabilityAgtName,$_InsLiabilityAgtNum,
                                    $_InsLiabilityPolNum,$_Status_Rating,$_licenseNumber,$_businessSince,$_expirationDate,$_verifiedCompany){
        
        $_aditional_message="";
    $_result=$this->validateAllFieldsCompany($_companyID,$_compamnyName,$_firstCompanyName,$_lastCompanyName,
    $_companyAddress1,$_companyAddress2,$_companyAddress3,$_companyPhoneNumber,
    $_companyType,$_PayInfoBillingAddress1,$_PayInfoBillingAddress2,$_PayInfoBillingCity,
    $_PayInfoBillingST,$_PayInfoBillingZip,$_PayInfoCCExpMon,$_PayInfoCCExpYr,
    $_PayInfoCCNum,$_PayInfoCCSecCode,$_PayInfoName,$_PrimaryFName,
    $_PrimaryLName,$_InsLiabilityAgencyName,$_InsLiabilityAgtName,$_InsLiabilityAgtNum,
    $_InsLiabilityPolNum,$_Status_Rating,$_licenseNumber,$_businessSince,$_expirationDate,$_verifiedCompany);

        $this->_userModel=new userModel(); 
        $_array_update=[
            'Company/'.$_companyID.'/ComapnyLicNum' => $_licenseNumber,
            'Company/'.$_companyID.'/CompanyName' => $_compamnyName,
            'Company/'.$_companyID.'/PrimaryFName' => $_firstCompanyName,
            'Company/'.$_companyID.'/PrimaryLName' => $_lastCompanyName,
            'Company/'.$_companyID.'/CompanyAdd1' => $_companyAddress1,
            'Company/'.$_companyID.'/CompanyAdd2' => $_companyAddress2,
            'Company/'.$_companyID.'/CompanyAdd3' => $_companyAddress3,
            'Company/'.$_companyID.'/CompanyPhone' => $_companyPhoneNumber,
            'Company/'.$_companyID.'/CompanyType' => $_companyType,
            'Company/'.$_companyID.'/PayInfoBillingAddress1' => $_PayInfoBillingAddress1,
            'Company/'.$_companyID.'/PayInfoBillingAddress2' => $_PayInfoBillingAddress2,
            'Company/'.$_companyID.'/PayInfoBillingCity' => $_PayInfoBillingCity,
            'Company/'.$_companyID.'/PayInfoBillingST' => $_PayInfoBillingST,
            'Company/'.$_companyID.'/PayInfoBillingZip' => $_PayInfoBillingZip,
            'Company/'.$_companyID.'/PayInfoCCExpMon' => $_PayInfoCCExpMon,
            'Company/'.$_companyID.'/PayInfoCCExpYr' => $_PayInfoCCExpYr,
            'Company/'.$_companyID.'/PayInfoCCNum' => $_PayInfoCCNum,
            'Company/'.$_companyID.'/PayInfoCCSecCode' => $_PayInfoCCSecCode,
            'Company/'.$_companyID.'/PayInfoName' => $_PayInfoName,
            'Company/'.$_companyID.'/PrimaryFName' => $_PrimaryFName,
            'Company/'.$_companyID.'/PrimaryLName' => $_PrimaryLName,
            'Company/'.$_companyID.'/InsLiabilityAgencyName' => $_InsLiabilityAgencyName,
            'Company/'.$_companyID.'/InsLiabilityAgtName' => $_InsLiabilityAgtName,
            'Company/'.$_companyID.'/InsLiabilityAgtNum' => $_InsLiabilityAgtNum,
            'Company/'.$_companyID.'/InsLiabilityPolNum' => $_InsLiabilityPolNum,
            'Company/'.$_companyID.'/Status_Rating' => $_Status_Rating,
            'Company/'.$_companyID.'/InBusinessSince' => $_businessSince,
            'Company/'.$_companyID.'/LicExpiration' => $_expirationDate,
            'Company/'.$_companyID.'/Verified' => $_verifiedCompany,
        ]; 
        $_result=$this->_userModel->updateArray($_array_update);
        /*$this->_userModel->updateContractor($_companyID.'/CompanyName',$_compamnyName);
        $this->_userModel->updateContractor($_companyID.'/PrimaryFName',$_firstCompanyName);
        $this->_userModel->updateContractor($_companyID.'/PrimaryLName',$_lastCompanyName);
        $this->_userModel->updateContractor($_companyID.'/CompanyAdd1',$_companyAddress1);
        $this->_userModel->updateContractor($_companyID.'/CompanyAdd2',$_companyAddress2);
        $this->_userModel->updateContractor($_companyID.'/CompanyAdd3',$_companyAddress3);
        $this->_userModel->updateContractor($_companyID.'/CompanyPhone',$_companyPhoneNumber);
        $this->_userModel->updateContractor($_companyID.'/CompanyType',$_companyType);
        $this->_userModel->updateContractor($_companyID.'/PayInfoBillingAddress1',$_PayInfoBillingAddress1);
        $this->_userModel->updateContractor($_companyID.'/PayInfoBillingAddress2',$_PayInfoBillingAddress2);
        $this->_userModel->updateContractor($_companyID.'/PayInfoBillingCity',$_PayInfoBillingCity);
        $this->_userModel->updateContractor($_companyID.'/PayInfoBillingST',$_PayInfoBillingST);
        $this->_userModel->updateContractor($_companyID.'/PayInfoBillingZip',$_PayInfoBillingZip);
        $this->_userModel->updateContractor($_companyID.'/PayInfoCCExpMon',$_PayInfoCCExpMon);
        $this->_userModel->updateContractor($_companyID.'/PayInfoCCExpYr',$_PayInfoCCExpYr);
        $this->_userModel->updateContractor($_companyID.'/PayInfoCCNum',$_PayInfoCCNum);
        $this->_userModel->updateContractor($_companyID.'/PayInfoCCSecCode',$_PayInfoCCSecCode);
        $this->_userModel->updateContractor($_companyID.'/PayInfoName',$_PayInfoName);
        $this->_userModel->updateContractor($_companyID.'/PrimaryFName',$_PrimaryFName);
        $this->_userModel->updateContractor($_companyID.'/PrimaryLName',$_PrimaryLName);
        $this->_userModel->updateContractor($_companyID.'/InsLiabilityAgencyName',$_InsLiabilityAgencyName);
        $this->_userModel->updateContractor($_companyID.'/InsLiabilityAgtName',$_InsLiabilityAgtName);
        $this->_userModel->updateContractor($_companyID.'/InsLiabilityAgtNum',$_InsLiabilityAgtNum);
        $this->_userModel->updateContractor($_companyID.'/InsLiabilityPolNum',$_InsLiabilityPolNum);
        $this->_userModel->updateContractor($_companyID.'/Status_Rating',$_Status_Rating);*/

        if ($_result==true){
            $_actual_status=$this->_userModel->getNode("Company/".$_companyID."/CompanyStatus");
            if(strcmp($_actual_status,"Inactive")==0){
                $this->_userModel->updateContractor($_companyID.'/CompanyStatus',"Validating");
                $_aditional_message="<br>,Now that all the fields are filled, the company passes to RoofServiceNow validation";
            }
        }else{
            $this->_userModel->updateContractor($_companyID.'/CompanyStatus',"Inactive");
        }
        return "The company identify by ".$_companyID." was updated corretly".$_aditional_message;

    }

    public function updateInfoCompanyStripe($_companyID,$_compamnylegal_entity_first_name,$_compamnylegal_entity_last_name,
                                            $_compamnylegal_entity_dob,$_compamnylegal_entity_type,
                                            $_compamnylegal_entity_State,$_compamnylegal_entity_City,
                                            $_compamnylegal_entity_Zipcode,$_compamnylegal_entity_Address,
                                            $_compamnylegal_entity_last4,$_compamnylegal_entity_personal_id,$path_file,
                                            $_compamnylegal_entity_business_name,$_compamnylegal_entity_business_tax_id){
        $_account_id="";
        $_company_data=$this->getCompanyById($_companyID);
        if($_company_data==null){
            return "Fail to update info company for stripe, company not found [$_companyID]";
        }else{
            if(isset($_company_data['stripeAccount']) and !empty($_company_data['stripeAccount'])){
                $_account_id=$_company_data['stripeAccount'];
            }else{
                $result=$this->createAccount($_companyID,$_company_data['CompanyEmail']);
                if(is_object($result) or is_array($result)){
                    $_account_id=$result['id'];
                }
                
            }
            if(!empty($_account_id)){
                $_result=$this->updateAccount($_account_id,
                                            $_compamnylegal_entity_dob,$_compamnylegal_entity_first_name,$_compamnylegal_entity_last_name,
                                            $_compamnylegal_entity_type,$_compamnylegal_entity_City,$_compamnylegal_entity_Address,$_compamnylegal_entity_Zipcode,
                                            $_compamnylegal_entity_State,$_compamnylegal_entity_last4,$_compamnylegal_entity_personal_id,$path_file,
                                            $_compamnylegal_entity_business_name,$_compamnylegal_entity_business_tax_id);
            }
            

        }
        return $_result;
    }

    public function updateCompanyFields($companyID,$arrayFields){
    
        $this->_userModel=new userModel();
    
        for($n=0;$n<count($arrayFields);$n+=2){
            if(strcmp($arrayFields[$n],"StripeID")==0){
                $stripeID=$arrayFields[$n+1];
            }
            if(strcmp($arrayFields[$n],"amount")==0){
                $amount=$arrayFields[$n+1];
            }
            if(strcmp($arrayFields[$n],"PaymentType")==0){
                $paymentType=$arrayFields[$n+1];
            }
            if(strcmp($arrayFields[$n],"StripeID")!=0 and strcmp($arrayFields[$n],"amount")!=0 and strcmp($arrayFields[$n],"PaymentType")!=0){
                $_result=$this->_userModel->updateCompany($companyID.'/'.$arrayFields[$n],$arrayFields[$n+1]);
            }
        }    

        if(!empty($paymentType)){
            $_objPDF=new pdfController();
            $_result_invoice=$_objPDF->paymentConfirmation3($companyID,null,$amount,$stripeID,$paymentType);
        }
        return $_result;
    }

    public function updateCustomer($_customerID,$_arrayCustomer){

        
        $this->_userModel=new userModel();                                        
        $this->_userModel->updateCustomer($_customerID.'/Address',$_arrayCustomer['customerAddress']);
        $this->_userModel->updateCustomer($_customerID.'/City',$_arrayCustomer['customerCity']);
        $this->_userModel->updateCustomer($_customerID.'/Email',$_arrayCustomer['emailValidation']);
        $this->_userModel->updateCustomer($_customerID.'/Fname',$_arrayCustomer['firstCustomerName']);
        $this->_userModel->updateCustomer($_customerID.'/Lname',$_arrayCustomer['lastCustomerName']);
        $this->_userModel->updateCustomer($_customerID.'/Phone',$_arrayCustomer['customerPhoneNumber']);
        $this->_userModel->updateCustomer($_customerID.'/State',$_arrayCustomer['customerState']);
        $this->_userModel->updateCustomer($_customerID.'/ZIP',$_arrayCustomer['customerZipCode']);
        $this->_userModel->updateCustomer($_customerID.'/Timestamp',date("m-d-Y H:i:s"));

        return "The customer identify by ".$_customerID." was updated corretly";
    }
    public function updateCustomerByField($_customerID,$field,$value){
        $this->_userModel=new userModel();      
        $this->_userModel->updateCustomer($_customerID.'/'.$field,$value);                                  
        return "The customer identify by ".$_customerID." was updated corretly";
    }


    public function insertUserDatabase($mail,$number,$name,$url,$password,$profile){
        
        //$password = rand(1000,5000);
        //$password = "pass12345";
        //echo "password:".$password;
        $number=str_replace("+1","",$number);
        $userProperties = [
            'email' => $mail,
            'emailVerified' => false,
            'phoneNumber' => '+1'.$number,
            'password' => $password,
            'displayName' => $name,
            'photoUrl' => $url,
            'disabled' => false,
        ];
        
        $this->_userModel=new userModel();
        $_user_created=$this->_userModel->createUser($userProperties,$profile);  
        //echo $_user_created;      
        return $_user_created;

    }

    public function logout(){
        $this->cleanVariables();
        header('Location: index.php');

    }

    public function cleanVariables(){
        unset ($_SESSION['loggedin']);
        unset ($_SESSION['username']);
        unset ($_SESSION['start']);
        unset ($_SESSION['expire']);
        unset ($_SESSION['email']);
        unset ($_SESSION['profile']);
        //session_destroy();
    }

    public function getCustomer($user){
        $this->_userModel=new userModel();
        return $this->_userModel->getCustomer($user);  
    }
    public function getCompanyE($user){
        $this->_userModel=new userModel();
        return $this->_userModel->getCompany($user);  
    }
    public function getCustomerK($user){
        $this->_userModel=new userModel();
        return $this->_userModel->getCustomerKey($user);  
    }

    public function getCustomerKById($customerID){
        $this->_userModel=new userModel();
        return $this->_userModel->getCustomerKeyById($customerID);  
    }

    public function getCustomerById($customerId){
        $this->_userModel=new userModel();
        return $this->_userModel->getCustomerById($customerId);
    }

    public function getContractorById($contractorID){
        $this->_userModel=new userModel();
        return $this->_userModel->getContractorById($contractorID);
    }

    public function getCompanyById($companyID){
        $this->_userModel=new userModel();
        return $this->_userModel->getCompanyByID($companyID);
    }

    public function fillInformationMenu(){
        $_information=new customerFAQ();
        $_array=$_information->getArrayOptions();
        $_output_html="";

       
        foreach($_array as $key => $item){
            $_head_box='<div class="modal fade" id="'.$item.'" role="dialog">
            <div class="modal-dialog modal-dialog-centered"> 
            <!-- Modal content--> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <button type="button" class="close" data-dismiss="modal">&times;</button>';
                    
            $_foot_box='<div class="modal-footer" id="buttonPayment"> 
                            <button type="button" class="btn btn-default" id="buttonCancel'.$item.'" data-dismiss="modal">Close</button> 
                        </div> 
                    </div> 
                </div>
            </div>';
            $_output_html.=$_head_box.'<h4 class="modal-title" id="headerTextPayment">'.constant("customerFAQ::$item").'</h4> 
                    </div> 
                    <div class="modal-body" id="textPayment"> 
                        <p >'.call_user_func( array( "customerFAQ", $item ) ).'</p> 
                    </div>'.$_foot_box;
            
        }
        return $_output_html;
    }


    public function getItemMenu(){
        $_information=new customerFAQ();
        $_array=$_information->getArrayOptions();
        $_output_menu="";
        foreach($_array as $key => $item){
            $_output_menu.='<li><a href="#'.$item.'" data-toggle="modal">'.constant("customerFAQ::$item").'</a></li>';
        }
        
        return $_output_menu;
    }

    public function getItemMenuURLS($city){
        $_information=new usefullURLS();
        $_array=$_information->getArrayOptions($city);
        $_output_menu="";
        foreach($_array as $key => $item){
            $_output_menu.='<li><a href="'.call_user_func( array( "usefullURLS", $item ) ).'" target="_blank">'.constant("usefullURLS::$item").'</a></li>';
        }
        
        return $_output_menu;
    }

  
    
    
    public function welcomeMail($_customerArray,$_validation_code,$_userData){
        if(strcmp($_SERVER['HTTP_HOST'],'localhost')==0){
            $_dir=$_SERVER['REQUEST_URI'];
            $pos1 = strpos($_dir,"/");
            $pos2 = strpos($_dir,"/", $pos1 + 1);
            //echo "<br>hola:".substr($_dir,$pos1+1,$pos2-1);
            $_path2="/".substr($_dir,$pos1+1,$pos2-1);
            $_path1="http://" . $_SERVER['HTTP_HOST'].$_path2;
        }else{
            $_path1="http://" . $_SERVER['HTTP_HOST'];
        }

        $_customerName="";
        if(isset($_customerArray['firstCustomerName'])){
            $_customerName=$_customerArray['firstCustomerName'];
        }else{
            $_customerName=$_customerArray['Fname'].' '.$_customerArray['Lname'];
        }
        $_message='
        <table>
            <tr><td>Dear '.$_customerName.'</td><td>Date:'.date('m-d-Y').'</td></tr>
            <tr><td colspan="2">Thank you for registering at RoofServiceNow.com. Please take just one more step and verify your email address by clicking on the link below (or copy and paste the URL into your browser):</td><tr>
            <tr><td colspan="2"><a target="_blank" href="'.$_path1.'/vc/validateCode.php?u='.$_userData->uid.'&t=c&verify='.$_validation_code.'">'.$_path1.'/vc/validateCode.php?u='.$_userData->uid.'&t=c&verify='.$_validation_code.'</td></tr>
            <tr><td colspan="2"><b>Your verification code is:</b>'.$_validation_code.'</td></tr>
            <tr><td colspan="2">If you have any questions about our website, please don\'t hesitate to contact us.</td></tr>
            <tr><td colspan="2"><img src="cid:logoimg" /></td></tr>
            <tr><td colspan="2">RoofServiceNow LLC | Site : www.roofservicenow.com | RoofServiceNow © 2017 | info@roofservicenow.com</td></tr>
        </table>
        ';
        return $_message;
    }

    public function welcomeMailCompany($_companyArray,$_validation_code,$_userData){
        if(strcmp($_SERVER['HTTP_HOST'],'localhost')==0){
            $_dir=$_SERVER['REQUEST_URI'];
            $pos1 = strpos($_dir,"/");
            $pos2 = strpos($_dir,"/", $pos1 + 1);
            //echo "<br>hola:".substr($_dir,$pos1+1,$pos2-1);
            $_path2="/".substr($_dir,$pos1+1,$pos2-1);
            $_path1="http://" . $_SERVER['HTTP_HOST'].$_path2.'/src';
            echo "Entro opcion localhost";
        }else{
            $_path1="http://" . $_SERVER['HTTP_HOST'];
            echo "Entro opcion otra";
        }
        $_message='
        <table>
            <tr><td>Dear '.$_companyArray['CompanyName'].'</td><td>Date:'.date('m-d-Y').'</td></tr>
            <tr><td colspan="2">Thank you for registering at†RoofServiceNow.com. Please take just one more step and verify your email address by clicking on the link below (or copy and paste the URL into your browser):</td><tr>
            <tr><td colspan="2"><a target="_blank" href="'.$_path1.'/vc/validateCode.php?u='.$_userData->uid.'&t=co&verify='.$_validation_code.'">'.$_path1.'/vc/validateCode.php?u='.$_userData->uid.'&t=co&verify='.$_validation_code.'</td></tr>
            <tr><td colspan="2"><b>Your verification code is:</b>'.$_validation_code.'</td></tr>
            <tr><td colspan="2">If you have any questions about our website, please don\'t hesitate to contact us.</td></tr>
            <tr><td colspan="2"><img src="cid:logoimg" /></td></tr>
            <tr><td colspan="2">RoofServiceNow LLC | Site : www.roofservicenow.com | RoofServiceNow © 2017 | info@roofservicenow.com</td></tr>
        </table>
        ';
        return $_message;
    }

    public function resetMail($_userArray,$_validation_code,$_userData){
        $_userName="";
        $_userType="";
        if(strcmp($_SERVER['HTTP_HOST'],'localhost')==0){
            $_dir=$_SERVER['REQUEST_URI'];
            $pos1 = strpos($_dir,"/");
            $pos2 = strpos($_dir,"/", $pos1 + 1);
            //echo "<br>hola:".substr($_dir,$pos1+1,$pos2-1);
            $_path2="/".substr($_dir,$pos1+1,$pos2-1);
            $_path1="http://" . $_SERVER['HTTP_HOST'].$_path2;
        }else{
            $_path1="http://" . $_SERVER['HTTP_HOST'];
        }
        if(isset($_userArray['Fname'])){
            $_userName=$_userArray['Fname'];
            $_userType="c";
        }else if(isset($_userArray['CompanyName'])){
            $_userName=$_userArray['CompanyName'];
            $_userType="co";
        }
        $_message='
        <table>
            <tr><td>Dear '.$_userName.'</td><td>Date:'.date('m-d-Y').'</td></tr>
            <tr><td colspan="2">We received a request to reset the password associated with this e-mail address. If you made this request, please follow the instructions below.</td><tr>
            <tr><td colspan="2">Click the link below to reset your password:</td><tr>
            <tr><td colspan="2"><a target="_blank" href="'.$_path1.'/index.php?controller=user&accion=changePasswordS&u='.$_userData->uid.'&t='.$_userType.'&verify='.$_validation_code.'">'.$_path1.'/index.php?controller=user&accion=changePasswordS&u='.$_userData->uid.'&t='.$_userType.'&verify='.$_validation_code.'</td></tr>
            <tr><td colspan="2"><b>Your verification code is:</b>'.$_validation_code.'</td></tr>
            <tr><td colspan="2">If you have any questions about our website, please don\'t hesitate to contact us.</td></tr>
            <tr><td colspan="2"><img src="cid:logoimg" /></td></tr>
            <tr><td colspan="2">RoofServiceNow LLC | Site : www.roofservicenow.com | RoofServiceNow © 2017 | info@roofservicenow.com</td></tr>
        </table>
        ';
        return $_message;
    }

    public function messageValidateUser($message,$icon_message,$table){
        $_path_extra="";
        switch($table){
            case "company":
                $_path_extra="?controller=user&accion=dashboardCompany";
                break;
            case "Customers":
                $_path_extra="?controller=user&accion=dashboardCustomer";
                break;
            case "Contractors":
                $_path_extra="?controller=user&accion=dashboardCompany";
                break;
        }
        if(strcmp($_SERVER['HTTP_HOST'],'localhost')==0){
            $_dir=$_SERVER['REQUEST_URI'];
            $pos1 = strpos($_dir,"/");
            $pos2 = strpos($_dir,"/", $pos1 + 1);
            //echo "<br>hola:".substr($_dir,$pos1+1,$pos2-1);
            $_path2="/".substr($_dir,$pos1+1,$pos2-1);
            $_path1="http://" . $_SERVER['HTTP_HOST'].$_path2."/src/".$_path_extra;
        }else{
            $_path1="http://" . $_SERVER['HTTP_HOST'].$_path_extra;
        }

        return '<!-- Redirection Counter -->
        <script type="text/javascript">
          var count = 5; // Timer
          var redirect = "'.$_path1.'"; // Target URL
        
          function countDown() {
            var timer = document.getElementById("timer"); // Timer ID
            if (count > 0) {
              count--;
              timer.innerHTML = "This page will redirect in " + count + " seconds."; // Timer Message
              setTimeout("countDown()", 1000);
            } else {
              window.location.href = redirect;
            }
          }
        </script>
        
        <div id="master-wrap">
          <div id="logo-box">
        
            <div class="animated fast fadeInUp">
              <div class="icon"></div>
              <h1>Thank you for register in RoofServiceNow</h1>
            </div>
        
            <div class="notice animated fadeInUp '.$icon_message.'">
              <p class="lead">'.$message.'</p>
              
            </div>
        
            <div class="footer animated slow fadeInUp">
              <p id="timer">
                <script type="text/javascript">
                  countDown();
                </script>
              </p>
              <p class="copyright">&copy; RoofServiceNow.com</p>
            </div>
        
          </div>
          <!-- /#logo-box -->
        </div>
        <!-- /#master-wrap -->';
    }

    public function resetPassword($table,$user){
        $message="";
        $_userMail="";
        $this->_userModel=new userModel();
        $hashPassword = md5( rand(0,1000) );
        $_result=$this->_userModel->changeUserPassword($user['uid'],$hashPassword,$table);
        //$_user_data=validateCustomerByID($user['uid']);
        if(is_array($_result) or gettype($_result)=="object" ){
            $message="Password changed \n";
            $properties = [
                'disabled' => true,
                'photoURL' => $hashPassword
            ];
            $_result_update=$this->_userModel->updateUserCustomer($user['uid'],$properties,$table);
            if(is_array($_result) or gettype($_result)=="object" ){
                $message.="User updated \n";
            }else{
                $message.=$_result_update;
            }
            if(isset($user['Email'])){
                $_userMail=$user['Email'];
            }else if(isset($user['CompanyEmail'])){
                $_userMail=$user['CompanyEmail'];
            }
            $_mail_body=$this->resetMail($user,$hashPassword,$_result);            
            $this->_sendMail=new emailController();
            $_mail_response=$this->_sendMail->sendMailSMTP($_userMail,"Reset Password",$_mail_body,"",$_SESSION['image_path']."logo_s.png");
            $message.= $_mail_response;
            if(strpos($message,"Error")>-1){
            }else{
                $message.="\n Please check your mail to get instruccions to recover your password.";
            }
        }else{
            $message.="Error, an error occurred when changing the password";
        }
        return $message;
    }

    public function changePassword($table,$userId,$newPassword){
        if(strcmp($table,"customer")==0){
            $_extra_path="?controller=user&accion=dashboardCustomer";
        }else if(strcmp($table,"company")==0){
            $_extra_path="?controller=user&accion=dashboardCompany";
        }
        if(strcmp($_SERVER['HTTP_HOST'],'localhost')==0){
            $_dir=$_SERVER['REQUEST_URI'];
            $pos1 = strpos($_dir,"/");
            $pos2 = strpos($_dir,"/", $pos1 + 1);
            //echo "<br>hola:".substr($_dir,$pos1+1,$pos2-1);
            $_path2="/".substr($_dir,$pos1+1,$pos2-1);
            $_path1="http://" . $_SERVER['HTTP_HOST'].$_path2;
        }else{
            $_path1="http://" . $_SERVER['HTTP_HOST'];
        }

        $message="";
        $this->_userModel=new userModel();
        $_result=$this->_userModel->changeUserPassword($userId,$newPassword,$table);
        if(is_array($_result) or gettype($_result)=="object" ){
            $message="Password changed \n";
            $properties = [
                'disabled' => false,
                'photoURL' => ''
            ];
            $_result_update=$this->_userModel->updateUserCustomer($userId,$properties,$table);
            if(is_array($_result) or gettype($_result)=="object" ){
                $message.="User updated \n";
                $message=$_path1;
            }else{
                $message.=$_result_update;
            }
        }else{
            $message.="Error, an error occurred when changing the password the result".$_result;
        }
        return $message;
    }

    public function updateCustomerLastId($customerId){
        $this->_userModel=new userModel();
        $this->_userModel->updateCustomerLastId("$customerId");
    }
    
    public function getNode($node){
        $this->_userModel=new userModel();
        return $this->_userModel->getNode($node);
    }

    public function validateAllFieldsCompany($_companyID,$_compamnyName,$_firstCompanyName,$_lastCompanyName,
    $_companyAddress1,$_companyAddress2,$_companyAddress3,$_companyPhoneNumber,
    $_companyType,$_PayInfoBillingAddress1,$_PayInfoBillingAddress2,$_PayInfoBillingCity,
    $_PayInfoBillingST,$_PayInfoBillingZip,$_PayInfoCCExpMon,$_PayInfoCCExpYr,
    $_PayInfoCCNum,$_PayInfoCCSecCode,$_PayInfoName,$_PrimaryFName,
    $_PrimaryLName,$_InsLiabilityAgencyName,$_InsLiabilityAgtName,$_InsLiabilityAgtNum,
    $_InsLiabilityPolNum,$_Status_Rating){
        $_flag_fill=true;

        if (empty($_companyID)){$_flag_fill=false;}
        if (empty($_compamnyName)){$_flag_fill=false;}
        if (empty($_firstCompanyName)){$_flag_fill=false;}
        if (empty($_lastCompanyName)){$_flag_fill=false;}
        if (empty($_companyAddress1)){$_flag_fill=false;}
        if (empty($_companyAddress2)){$_flag_fill=false;}
        if (empty($_companyAddress3)){$_flag_fill=false;}
        if (empty($_companyPhoneNumber)){$_flag_fill=false;}
        if (empty($_PayInfoBillingAddress1)){$_flag_fill=false;}
        if (empty($_PayInfoBillingAddress2)){$_flag_fill=false;}
        if (empty($_PayInfoBillingCity)){$_flag_fill=false;}
        if (empty($_PayInfoBillingST)){$_flag_fill=false;}
        if (empty($_PayInfoBillingZip)){$_flag_fill=false;}
        if (empty($_PayInfoCCExpMon)){$_flag_fill=false;}
        if (empty($_PayInfoCCExpYr)){$_flag_fill=false;}
        if (empty($_PayInfoCCNum)){$_flag_fill=false;}
        if (empty($_PayInfoCCSecCode)){$_flag_fill=false;}
        if (empty($_PayInfoName)){$_flag_fill=false;}
        if (empty($_PrimaryFName)){$_flag_fill=false;}
        if (empty($_PrimaryLName)){$_flag_fill=false;}
        if (empty($_InsLiabilityAgencyName)){$_flag_fill=false;}
        if (empty($_InsLiabilityAgtName)){$_flag_fill=false;}
        if (empty($_InsLiabilityAgtNum)){$_flag_fill=false;}
        if (empty($_InsLiabilityPolNum)){$_flag_fill=false;}
        if (empty($_Status_Rating)){$_flag_fill=false;}
        
        return $_flag_fill;



    }
    
    public function disableCompany($_companyID){
        $this->_userModel=new userModel();
        $_result=$this->_userModel->updateContractor($_companyID.'/CompanyStatus','Inactive');
        if(is_bool($_result) === true){
            return "The company identify by ".$_companyID." was updated corretly";
        }else{
            return "Error updating ".$_companyID."";
        }
        
    }

    public function enableCompany($_companyID){
        $_message="";
        $_flag=false;
        $this->_userModel=new userModel();
        $_result=$this->_userModel->updateContractor($_companyID.'/CompanyStatus','Active');

        if(is_bool($_result) === true){
            return "The company identify by ".$_companyID." can`t be updated correctly, $_result";
        }else{
            return "Error updating ".$_companyID."";
        }
    }

    public function invalidateCompany($_companyID){
        $this->_userModel=new userModel();
        $_result=$this->_userModel->updateContractor($_companyID.'/Verified','0');
        if(is_bool($_result) === true){
            return "The company identify by ".$_companyID." was updated corretly";
        }else{
            return "Error updating ".$_companyID."";
        }
        
    }

    public function validateCompany($_companyID){
        $_message="";
        $_flag=false;
        $this->_userModel=new userModel();
        $_result=$this->_userModel->updateContractor($_companyID.'/Verified','1');

        if(is_bool($_result) === true){
            return "The company identify by ".$_companyID."was  updated correctly, $_result";
        }else{
            return "Error updating ".$_companyID."";
        }
    }

    public function enableCustomer($_customerID){
        $_msg="";
        $_customer_data=$this->getCustomerById($_customerID);
        //print_r($_customer_data);
        if($this->is_valid_email($_customer_data['Email'])==false){
            $_msg="The email is incorrect, please review \n";
        }
        if($this->is_valid_phone($_customer_data['Phone'])==false){
            $_msg="The phone number is incorrect, please review \n";
        }
        if(!empty($_msg)){
            return "Error ".$_msg;
        }else{
            $hashActivationCode = md5( rand(0,1000) );
            $_responseU=$this->insertUserDatabase($_customer_data['Email'],$_customer_data['Phone'],$_customer_data['Fname'].' '.$_customer_data['Lname'],$hashActivationCode,'123456','customer');
            if(gettype($_responseU)=="object"){
                $_uid_user=$_responseU->uid;
            }else{
                $_uid_user="undefined";
            }
            if(strcmp($_uid_user,"undefined")==0){
                return "Error ".$_responseU;
            }else{
                $this->_userModel=new userModel();
                $this->updateCustomerByField($_customer_data['FBID'],'uid',$_uid_user);
                $_mail_body=$this->welcomeMail($_customer_data,$hashActivationCode,$_responseU);
            
                $this->_sendMail=new emailController();
                $_mail_response=$this->_sendMail->sendMailSMTP($_customer_data['Email'],"Email Verification",$_mail_body,"",$_SESSION['image_path']."logo_s.png");
                if($_mail_response==false){
                    return "Error ".$this->_sendMail->getMessageError();
                }else{
                    return "OK ".$_mail_response."<br>".$_uid_user;
                }
            }
        }
        
    }

    public function disableCustomer($_customerID){
        $_customer_data=$this->getCustomerById($_customerID);
        if(strcmp($_customer_data['uid'],"undefined")==0){
            $message="User not found";
        }else{
            $properties = [
                'disabled' => true
            ];
            $_result_update=$this->_userModel->updateUserCustomer($_customer_data['uid'],$properties,"customer");
            if(is_array($_result) or gettype($_result)=="object" ){
                $message.="User disabled \n";
            }else{
                $message.=$_result_update;
            }
        }
        return $message;
    }

    function is_valid_email($str)
    {
        return (false !== strpos($str, "@") && false !== strpos($str, "."));
    }

    function is_valid_phone($str){
        if(strlen($str)!=12){
            return false;
        }else{
            return true;
        }
    }
    public function showMessage(){
        require_once("vista/head.php");
		require_once("vista/message_process.php");
		require_once("vista/footer.php");
    }

    public function showCalendar(){
        require_once("vista/head.php");
        require_once("vista/test_calendar.php");
        require_once("vista/footer.php");
    }

    public function createAccount($_companyID,$email){
        $_objPay=new payingController();
        $_result=$_objPay->createAccount($email);

        if(is_array($_result) or gettype($_result)=="object" ){
            $this->_userModel=new userModel();                                 
            
            $_array_update=[
                'Company/'.$_companyID.'/stripeAccount' => $_result['id'],
                'Company/'.$_companyID.'/stripePublicKey' => $_result->keys->secret,
                'Company/'.$_companyID.'/stripeSecretKey' => $_result->keys->publishable,
            ];
            $this->_userModel->updateArray($_array_update);
            return $_result;
        }else{
            return $_result;
        }
    }

    public function getAccount($account){
        $_objPay=new payingController();
        return $_objPay->getAccount($account);
    }

    public function getBalanceAccount($account){
        $_objPay=new payingController();
        return $_objPay->get_balance_account($account);
    }

    public function get_transaction_account($account,$secretKey){
        $_objPay=new payingController();
        return $_objPay->get_transaction_account($account,$secretKey);
    }

    public function get_transfer_account($account){
        $_objPay=new payingController();
        return $_objPay->get_transfer_account($account);
    }

    public function get_payout_account($account,$secretKey){
        $_objPay=new payingController();
        return $_objPay->get_payout_account($account,$secretKey);
    }

    public function getValidateAccount($account){
        $_objPay=new payingController();
        return $_objPay->getValidateAccount($account);
    }

    public function updateAccount($stripeID,
                                    $birth_day,$first_name,$last_name,$type,$city,$line1,$zipcode,$state,$last4,$personalid,
                                    $path_file,$business_name,$business_tax_id){
        $_objPay=new payingController();
        $_result=$_objPay->updateAccount($stripeID,$birth_day,$first_name,$last_name,$type,$city,$line1,$zipcode,$state,$last4,$personalid,$path_file,$business_name,$business_tax_id);
        return $_result;
    }

    public function create_bank_account($routing_number,$account_number,$account_holder_name,$account_holder_type){
        $_objPay=new payingController();
        return $_objPay->create_bank_account($routing_number,$account_number,$account_holder_name,$account_holder_type);
    }

    public function upload_file($file_name){
        $_objPay=new payingController();
        return $_objPay->update_file_stripe($file_name);
    }

    function get_token_bank_account($stripeID){
        $_objPay=new payingController();
        return $_objPay->get_token_bank_account($stripeID);
    }

    function get_bank_for_account($stripeID){
        $_objPay=new payingController();
        return $_objPay->get_token_bank_account($stripeID);
    }
    
    
}
?>
