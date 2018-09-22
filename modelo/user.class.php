<?php
require_once($_SESSION['application_path']."/modelo/conection.php");

class userModel extends connection{

    

    function __construct(){
        parent::__construct();
    }

    public function updateUserCustomer($userId,$userProperties,$profile){
        $result=$this->updateUser($userId,$userProperties,$profile);
        return $result;
    }

    public function changeUserPassword($_userId,$_password,$_profile){
        return $this->changeUserPass($_userId,$_password,$_profile);
    }
    public function validateCustomer($user,$pass){
        $result=$this->validateUser($user,$pass,'customer');
        if(is_array($result) or gettype($result)=="object" ){
            return $result;
        }else{
            return "Error ".$result;
        }
        return "Error";
    }

    public function validateCustomerByID($userId){
        $result=$this->validateUserByID($userId,'customer');
        if(is_array($result) or gettype($result)=="object" ){
            return $result;
        }else{
            return "Error ".$result;
        }
        return "Error";
    }

    public function validateCompanyByID($userId){
        $result=$this->validateUserByID($userId,'company');
        if(is_array($result) or gettype($result)=="object" ){
            return $result;
        }else{
            return "Error ".$result;
        }
        return "Error";
    }

    public function validateCompany($user,$pass){
       //echo "modelo company";
        $result=$this->validateUser($user,$pass,'company');
        
        if(is_array($result) or gettype($result)=="object" ){
            return $result;
        }else{
            return "Error ".$result;
        }
        return "Error";
    }

    public function validateEmail($table,$email){
        if(strcmp($table,'company')==0){
            $result=$this->getQueryEqual('Company','CompanyEmail',$email);
        }else if(strcmp($table,'customer')==0){
            $result=$this->getQueryEqual('Customers','Email',$email);
        }else if(strcmp($table,'Contractors')==0){
            $result=$this->getQueryEqual('Contractors','ContEmail',$email);
        }
        //print_r($result);
        if(is_array($result)){
            return true;
        }else{
            return false;
        }
    }

    public function getLastNodeCompany($table,$field){
        $result=$this->getLastNodeTable($table,$field);
        if(is_array($result)){
            return $result[$field];
        }else{
            return null;
        }
    }

    public function getLastNodeCustomer($table,$field){
        $result=$this->getLastNodeTable($table,$field);
        if(is_array($result)){
            return $result[$field];
        }else{
            return null;
        }
    }

    public function getLasCustomerNumberParameter($node){
        $result=$this->getDataTable($node);
        return $result;
    }

    public function insertContractor($id_contracto,$dataContrator){
        return $this->insertDataTable("Company",$id_contracto,$dataContrator,false); 
    }

    public function insertCustomer($id_customer,$dataCustomer){
        return $this->insertDataTable("Customers",$id_customer,$dataCustomer,true); 
    }

    public function updateContractor($nodeName,$data){
        return $this->updateDataTable("Company",$nodeName,$data); 
    }

    public function updateCustomer($nodeName,$data){
        $this->updateDataTable("Customers",$nodeName,$data); 
    }


    public function getCompany($user){
        $result=$this->getQueryEqual('Company','CompanyEmail',$user);
        return $result;
    }

    public function getCompanyByID($companyID){
        $result=$this->getQueryEqual('Company','CompanyID',$companyID);
        return $result;
    }

    public function getCustomer($user){
        $result=$this->getQueryEqual('Customers','Email',$user);
        return $result;
    }

    public function getCustomerById($customerID){
        $result=$this->getQueryEqual('Customers','CustomerID',$customerID);
        return $result;
    }

    public function getContractor($user){
        $result=$this->getQueryEqual('Contractors','ContEmail',$user);
        return $result;
    }

    public function getContractorById($customerID){
        $result=$this->getQueryEqual('Contractors','ContractorID',$customerID);
        return $result;
    }

    public function getCustomerKey($user){
        $result=$this->getQueryEqualKey('Customers','Email',$user);
        return $result;
    }

    public function getListCompany($table,$field,$searchValue){
        if(empty($field)){
            $result=$this->getDataTable($table);    
        }else{
            $result=$this->getQueryEqualM($table,$field,$searchValue);
        }
        
        return $result;
    }

    public function getOrdersCustomer($idCustomer){
        $result=$this->getQueryEqualM('Orders','CustomerID',$idCustomer);
        return $result;
    }

    public function getOrdersDriver($idContractor){
        $result=$this->getQueryEqualM('Orders','ContractorID',$idContractor);
        return $result;
    }

    public function getContractorsCompany($idCompany){
        $result=$this->getQueryEqualM('Contractors','CompanyID',$idCompany);
        
        return $result;
    }

    public function createUser($_properties,$_profile){
        return $this->createUserDatabse($_properties,$_profile);

    }

    public function getKeyNode($table){
        return $this->getKey($table);
    }

    public function getNode($table){
        $result=$this->getDataTable($table);
        return $result;
    }

    public function updateCustomerLastId($customerID){
        $this->updateDataTable("Parameters","LastCustomerID",$customerID);
    }
}
?>