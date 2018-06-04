<?php
require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/modelo/conection.php");

class userModel extends connection{

    

    function __construct(){
        parent::__construct();
    }

    public function validateCustomer($user,$pass){
        $result=$this->validateUser($user,$pass);
        if(is_array($result) or gettype($result)=="object" ){
            return $result;
        }else{
            return "Error ".$result;
        }
        return "Error";
    }

    public function validateCompany($user,$pass){
       
        $result=$this->validateUser($user,$pass);
        
        if(is_array($result) or gettype($result)=="object" ){
            return $result;
        }else{
            return false;
        }
        return false;
    }

    public function validateEmail($table,$email){
        if(strcmp($table,'company')==0){
            $result=$this->getQueryEqual('Company','CompanyEmail',$email);
        }else if(strcmp($table,'customer')==0){
            $result=$this->getQueryEqual('Customers','Email',$email);
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

    public function insertContractor($id_contracto,$dataContrator){
        $this->insertDataTable("Company",$id_contracto,$dataContrator); 
    }

    public function insertCustomer($id_customer,$dataCustomer){
        $this->insertDataTable("Customers",$id_customer,$dataCustomer); 
    }

    public function updateContractor($nodeName,$data){
        $this->updateDataTable("Company",$nodeName,$data); 
    }

    public function getCompany($user){
        $result=$this->getQueryEqual('Company','CompanyEmail',$user);
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

    public function getCustomerKey($user){
        $result=$this->getQueryEqualKey('Customers','Email',$user);
        return $result;
    }

    public function getListCompany($table){
        $result=$this->getDataTable($table);
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

    public function createUser($_properties){
        return $this->createUserDatabse($_properties);

    }
}
?>