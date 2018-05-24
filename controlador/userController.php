<?php
if(!isset($_SESSION)) { 
        session_start(); 
} 


require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/modelo/user.class.php");
require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/controlador/sendMail.php");

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
    private $_sendMail=null;
    private $_user="";
    private $_pass="";

    function __construct()
	{		
    }
    
    public function showLoginContractor(){
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
        require_once("vista/head.php");
        require_once("vista/register_customer.php");
        require_once("vista/footer.php");
    }

    public function loginCustomer(){
        $this->_user=$_POST['userClient'];
        $this->_pass=$_POST['passwordClient'];

        $this->_userModel=new userModel();
        $_result=$this->_userModel->validateCustomer($this->_user,$this->_pass);
        
        if($_result==true){
            $this->dashboardCustomer($this->_user);
            //Header("Location: ?aditionalMessage=Welcome to the aplication&controller=user&accion=showLoginClient");
        }elseif($_result==false){
            //echo "datos no validos";
            Header("Location: ?aditionalMessage=User or password are wrong, please try again&controller=user&accion=showLoginClient");
            //Header("Location: index.php?controller=user&accion=showLoginClient");
        }
    }

    public function loginContractor(){
        $this->_user=$_POST['userContractor'];
        $this->_pass=$_POST['passwordContractor'];
        $this->_userModel=new userModel();
        $_result=$this->_userModel->validateCompany($this->_user,$this->_pass);
        //return;
        if($_result==true){
            $this->dashboardCompany($this->_user);

            //Header("Location: ?aditionalMessage=Welcome to the aplication&controller=user&accion=showLoginContractor");
        }elseif($_result==false){
            //echo "datos no validos";
            Header("Location: ?aditionalMessage=User or password are wrong, please try again&controller=user&accion=showLoginContractor");
            //Header("Location: index.php?controller=user&accion=showLoginClient");
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
        echo "last node company:".$_lastCompanyID;
        if (is_null($_lastCompanyID)){
            $_newCompanyId="CO000001";
        }else{
            $_tmp=substr($_lastCompanyID,2);
            $_tmp=intval($_tmp)+1;
            $_newCompanyId="CO".str_pad($_tmp, 6, "0", STR_PAD_LEFT);
        }
        $hashActivationCode = md5( rand(0,1000) );
        $password = rand(1000,5000);

        $Company = array(
                "ComapnyLicNum" => "$hashActivationCode",
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
                "Status_Rating" => ""
        );
        $this->_userModel->insertContractor($_newCompanyId,$Company);
        //$this->_sendMail=new emailController();
        //$this->_sendMail->sendMail($arrayContractor['emailValidation'],$hashActivationCode);
        //$_response=$this->insertUserDatabase($arrayContractor['emailValidation'],$arrayContractor['phoneContactCompany'],$arrayContractor['companyName'],'');
        $_response="";
        return $_newCompanyId."|".$_response;
        
    }

    public function getListCompany(){
        $this->_userModel=new userModel();
        $_result=$this->_userModel->getListCompany('Company');
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
        $hashActivationCode = md5( rand(0,1000) );
        $password = rand(1000,5000);
        $Customer = array(
            "Address" =>  $arrayCustomer['customerAddress'],
            "City" =>  $arrayCustomer['customerCity'],
            "CustomerID" =>  "$_lastCustomerID",
            "Email" =>  $arrayCustomer['emailValidation'],
            "FBID" =>  "",
            "Fname" =>  $arrayCustomer['firstCustomerName'],
            "Lname" =>  $arrayCustomer['lastCustomerName'],
            "Phone" =>  $arrayCustomer['customerPhoneNumber'],
            "State" =>  $arrayCustomer['customerState'],
            "Timestamp" =>  date("Y-m-d H:i:s"),
            "ZIP" =>  $arrayCustomer['customerZipCode'],
        );
        $this->_userModel->insertCustomer($hashActivationCode,$Customer);
        $this->_sendMail=new emailController();
        $this->_sendMail->sendMail($arrayCustomer['emailValidation'],$hashActivationCode);
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

    public function dashboardCustomer($_id_customer){

        $_userMail=$_id_customer;
        $this->_userModel=new userModel();

        $_actual_customer=$this->_userModel->getCustomer($_userMail);
        
        $_array_customer_to_show=$this->_userModel->getOrdersCustomer($_actual_customer['CustomerID']);
        
        require_once("vista/head.php");
		require_once("vista/dashboard_customer.php");
		require_once("vista/footer.php");
    }
    
    public function dashboardCompany($_id_company){
        $_userMail=$_id_company;
        $this->_userModel=new userModel();

        $_actual_company=$this->_userModel->getCompany($_userMail);

        $_array_contractors_to_show=$this->_userModel->getContractorsCompany($_actual_company['CompanyID']);
        
        $_array_orders_to_show=array();
        
        //print_r($_array_orders);
        foreach ($_array_contractors_to_show as $key => $contractor) {
            //echo $contractor['ContractorID']."<br>";
            $_array_orders=$this->_userModel->getOrdersDriver($contractor['ContractorID']);
            foreach($_array_orders as $data => $order){
                array_push($_array_orders_to_show,$order);   
            }
            //print_r($_array_orders);
            
        }    
        //print_r($_array_orders_to_show);
        
        require_once("vista/head.php");
		require_once("vista/dashboard_company.php");
		require_once("vista/footer.php");

    }
    
    public function updateCompany($_companyID,$_compamnyName,$_firstCompanyName,$_lastCustomerName,
                                    $_companyAddress1,$_companyAddress2,$_companyAddress3,$_companyPhoneNumber,
                                    $_companyType){
        
        $this->_userModel=new userModel();                                        
        $this->_userModel->updateContractor($_companyID.'/CompanyName',$_compamnyName);
        $this->_userModel->updateContractor($_companyID.'/PrimaryFName',$_firstCompanyName);
        $this->_userModel->updateContractor($_companyID.'/PrimaryLName',$_lastCustomerName);
        $this->_userModel->updateContractor($_companyID.'/CompanyAdd1',$_companyAddress1);
        $this->_userModel->updateContractor($_companyID.'/CompanyAdd2',$_companyAddress2);
        $this->_userModel->updateContractor($_companyID.'/CompanyAdd3',$_companyAddress3);
        $this->_userModel->updateContractor($_companyID.'/CompanyPhone',$_companyPhoneNumber);
        $this->_userModel->updateContractor($_companyID.'/CompanyType',$_companyType);

        return "The contractor identify by ".$_companyID." was updated corretly";

    }

    public function insertUserDatabase($mail,$number,$name,$url){
        $password = rand(1000,5000);
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
        $_user_created=$this->_userModel->$createUser($userProperties);
        
        return $password;

    }
}
?>