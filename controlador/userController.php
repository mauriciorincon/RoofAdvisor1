<?php
if(!isset($_SESSION)) { 
        session_start(); 
} 


require_once($_SESSION['application_path']."/modelo/user.class.php");
require_once($_SESSION['application_path']."/controlador/emailController.php");
require_once($_SESSION['application_path']."/controlador/calendarController.php");
require_once($_SESSION['application_path']."/controlador/orderController.php");
require_once($_SESSION['application_path']."/vista/customerFAQ.php");


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
    private $_sendMail=null;
    private $_user="";
    private $_pass="";

    function __construct()
	{		
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
                Header("Location: ?aditionalMessage=User or password are wrong, please try again $_result&controller=user&accion=showLoginClient");
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
            return "Error, User or password are wrong, please try again ($_result)";
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
                        $_SESSION['username'] = $_result->displayName;
                        $_SESSION['start'] = time();
                        $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
                        $_SESSION['email'] = $_result->email;
                        $_SESSION['profile'] = 'company';
                        $this->dashboardCompany($this->_user);

                        return "Welcome Mr/Mrs <b>[".$_SESSION['username']."]</b>, please press finish button to save the order.";
                    }else{
                        return "Error, please comunicate with RoofServiceNow for help";
                    }
                }else{
                    Header("Location: ?aditionalMessage=It seems that your acount is not validate, please check your email&controller=user&accion=showLoginContractor");
                }
            }elseif(is_string($_result)){
                Header("Location: ?aditionalMessage=User or password are wrong, please try again $_result&controller=user&accion=showLoginContractor");
            }
        }
        

    }

    public function registerContractor(){

    }

    public function validateEmail($table,$email){
        $this->_userModel=new userModel();
        $_result=$this->_userModel->validateEmail($table,$email);
        return $_result;
    }

    public function insertContractor($arrayContractor){
        

        $this->_userModel=new userModel();
        $_lastCompanyID=$this->_userModel->getLastNodeCompany("Company","CompanyID");
        //echo "last node company:".$_lastCompanyID;
        if (is_null($_lastCompanyID)){
            $_newCompanyId="CO000001";
        }else{
            $_tmp=substr($_lastCompanyID,2);
            $_tmp=intval($_tmp)+1;
            $_newCompanyId="CO".str_pad($_tmp, 6, "0", STR_PAD_LEFT);
        }
        $hashActivationCode = md5( rand(0,1000) );
        $password = rand(1000,5000);

        $_response=$this->insertUserDatabase($arrayContractor['emailValidation'],$arrayContractor['phoneContactCompany'],$arrayContractor['companyName'],'',$arrayContractor['password'],'company');
        if(is_array($_response) or gettype($_response)=="object"){
            $Company = array(
                    "ComapnyLicNum" => "",
                    "CompanyAdd1" => "",
                    "CompanyAdd2" => "",
                    "CompanyAdd3" => "",
                    "CompanyEmail" => $arrayContractor['emailValidation'],
                    "CompanyID" => "$_newCompanyId",
                    "CompanyName" => $arrayContractor['companyName'],
                    "CompanyPhone" => $arrayContractor['phoneContactCompany'],
                    "CompanyRating" => "",
                    "CompanyStatus" => "Validating",
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
                    "Status_Rating" => "5.0"
            );
            $this->_userModel->insertContractor($_newCompanyId,$Company);
            return $_newCompanyId;
        }else{
            return "Error".$_response;
        }
        
    }

    public function getListCompany($field="",$value=""){
        $this->_userModel=new userModel();
        $_result=$this->_userModel->getListCompany('Company',$field,$value);
        return $_result;
    }

    public function insertCustomer($arrayCustomer){
        $this->_userModel=new userModel();
        $_lastCustomerID=$this->_userModel->getLastNodeCustomer("Customers","CustomerID");
        if (is_null($_lastCustomerID)){
            $_lastCustomerID=1;
        }else{
            $_lastCustomerID+=1;
        }
        $_response=$this->insertUserDatabase($arrayCustomer['emailValidation'],$arrayCustomer['customerPhoneNumber'],$arrayCustomer['firstCustomerName'].' '.$arrayCustomer['lastCustomerName'],'',$arrayCustomer['password'],'customer');
        //$hashActivationCode = $this->_userModel->getKeyNode('Customers');
        //return $hashActivationCode;

        if(is_array($_response) or gettype($_response)=="object"){
            
            //$hashActivationCode = $this->_userModel->getKeyNode('Customers');
            $hashActivationCode = 'FBID';
            $Customer = array(
                "Address" =>  $arrayCustomer['customerAddress'],
                "City" =>  $arrayCustomer['customerCity'],
                "CustomerID" =>  $_lastCustomerID,
                "Email" =>  $arrayCustomer['emailValidation'],
                "FBID" =>  '',
                "Fname" =>  $arrayCustomer['firstCustomerName'],
                "Lname" =>  $arrayCustomer['lastCustomerName'],
                "Phone" =>  $arrayCustomer['customerPhoneNumber'],
                "State" =>  $arrayCustomer['customerState'],
                "Timestamp" =>  date("m-d-Y H:i:s"),
                "ZIP" =>  $arrayCustomer['customerZipCode'],
            );
            $_response=$this->_userModel->insertCustomer($hashActivationCode,$Customer);
            $hashActivationCode = md5( rand(0,1000) );
            $_mail_body=$this->welcomeMail($arrayCustomer,$hashActivationCode);
            
            $this->_sendMail=new emailController();
            $_mail_response=$this->_sendMail->sendMailSMTP($arrayCustomer['emailValidation'],"Email Verification",$_mail_body,"",$_SESSION['application_path']."/img/logo.png");
            if($_mail_response==false){
                return "Error ".$_response."<br>".$this->_sendMail->getMessageError();
            }else{
                //return "OK ".$_response."<br>".$_mail_response;
            }
        }else{
            return "Error".$_response;
        } 
        return $_lastCustomerID;
        

    }



    public function validateCode($user,$code,$table){
        if(strcmp($table,'Company')==0){
            $this->_userModel=new userModel();
            $_customer=$this->_userModel->getCompany($user);
            if(is_array($_customer)){
                //print_r($_customer);
                if(strcmp($_customer['ComapnyLicNum'],$code)==0){
                    $this->_userModel->updateContractor($_customer['CompanyID'].'/ComapnyLicNum','');
                    $this->_userModel->updateContractor($_customer['CompanyID'].'/CompanyStatus','Active');
                    return "The code is correct";
                }else{
                    return "Error, the code is incorrect";    
                }
            }else{
                
                return "Error, the user was no found";
            }
        }else if(strcmp($table,'Customers')==0){
            $this->_userModel=new userModel();
            $_customer=$this->_userModel->getCustomer($user);
            if(is_array($_customer)){
                //print_r($_customer);
                //if(strcmp($_customer['ComapnyLicNum'],$code)==0){
                    //$this->_userModel->updateContractor($_customer['CompanyID'].'/ComapnyLicNum','');
                    //$this->_userModel->updateContractor($_customer['CompanyID'].'/CompanyStatus','Active');
                    return "The code is correct";
                //}else{
                //    return "Error, the code is incorrect";    
                //}
            }else{
                
                return "Error, the user was no found";
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

            

            //print_r($_array_customer_to_show);
            $this->_userModel=new userModel();
            $_array_state=$this->_userModel->getNode('Parameters/state');

            $_menu_item=$this->getItemMenu();
            $_divs_info=$this->fillInformationMenu();
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
            
            $_array_orders_to_show=array();

            
            $_orderController=new orderController();
            $_array_orders_to_show=$_orderController->getOrderByCompany($_actual_company['CompanyID']);

            $_array_orders_without_comapny=$_orderController->getOrderByCompany("");
            foreach($_array_orders_without_comapny as $key => $order){
                array_push($_array_orders_to_show,$order);
            }
            
            
            
            require_once("vista/head.php");
            require_once("vista/dashboard_company.php");
            require_once("vista/footer.php");
        }else{
            $this->showLoginContractor();
        }
    }

    public function dashboardAdmin(){

        $this->_userModel=new userModel();

        $_array_orders_to_show=array();
        $_orderController=new orderController();
        $_array_orders_to_show=$_orderController->getOrdersAll();
        
        require_once("vista/head.php");
        require_once("vista/dashboard_admin.php");
        require_once("vista/footer.php");


    }
    
    public function updateCompany($_companyID,$_compamnyName,$_firstCompanyName,$_lastCompanyName,
                                    $_companyAddress1,$_companyAddress2,$_companyAddress3,$_companyPhoneNumber,
                                    $_companyType,$_PayInfoBillingAddress1,$_PayInfoBillingAddress2,$_PayInfoBillingCity,
                                    $_PayInfoBillingST,$_PayInfoBillingZip,$_PayInfoCCExpMon,$_PayInfoCCExpYr,
                                    $_PayInfoCCNum,$_PayInfoCCSecCode,$_PayInfoName,$_PrimaryFName,
                                    $_PrimaryLName,$_InsLiabilityAgencyName,$_InsLiabilityAgtName,$_InsLiabilityAgtNum,
                                    $_InsLiabilityPolNum,$_Status_Rating){
        
        $this->_userModel=new userModel();                                        
        $this->_userModel->updateContractor($_companyID.'/CompanyName',$_compamnyName);
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
        $this->_userModel->updateContractor($_companyID.'/Status_Rating',$_Status_Rating);



        return "The contractor identify by ".$_companyID." was updated corretly";

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

    public function insertUserDatabase($mail,$number,$name,$url,$password,$profile){
        //$password = rand(1000,5000);
        //$password = "pass12345";
        //echo "password:".$password;
        $userProperties = [
            'email' => $mail,
            'emailVerified' => false,
            'phoneNumber' => $number,
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
    public function getCustomerK($user){
        $this->_userModel=new userModel();
        return $this->_userModel->getCustomerKey($user);  
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
    
    public function welcomeMail($_customerArray,$_validation_code){
        $_message='
        <table>
            <tr><td>Dear '.$_customerArray['firstCustomerName'].'</td><td>Date:'.date('m-d-Y').'</td></tr>
            <tr><td colspan="2">Thank you for registering at roofservicenow.com. Please take just one more step and verify your email address by clicking on the link below (or copy and paste the URL into your browser):</td><tr>
            <tr><td colspan="2"><a target="_blank" href="http://www.roofservicenow.com/vc/validateCode.php?t=c&verify='.$_validation_code.'">http://www.roofservicenow.com/vc/validateCode.php?t=c&verify='.$_validation_code.'</td></tr>
            <tr><td colspan="2">Is your verification link not working? You can copy and paste this verification code as well.</td></tr>
            <tr><td colspan="2"><b>Your verification code is:</b>'.$_validation_code.'</td></tr>
            <tr><td colspan="2">If you have any questions about our website, please don\'t hesitate to contact us.</td></tr>
            <tr><td colspan="2"><img src="cid:logoimg" /></td></tr>
            <tr><td colspan="2">Viaplix LLC | Site : ww.viaplix.com | Viaplix © 2017 | info@viaplix.com</td></tr>
        </table>
        ';
        return $_message;
    }
}
?>
