<?php
require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/modelo/conection.php");

class userModel extends connection{

    

    function __construct(){
        parent::__construct();
    }

    public function validateCustomer($user,$pass){
        $result=$this->getQueryEqual('Customers','Email',$user);
        
        if(is_array($result)){
    
            if(strcmp($result['CustomerID'],$pass)==0){
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function validateCompany($user,$pass){
       
        $result=$this->getQueryEqual('Company','CompanyEmail',$user);
        
        if(is_array($result)){
            if(strcmp($result['CompanyID'],$pass)==0){
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    public function validateEmail($table,$email){
        if(strcmp($table,'company')==0){
            $result=$this->getQueryEqual('Company','CompanyEmail',$email);
        }else if(strcmp($table,'customer')==0){
            $result=$this->getQueryEqual('Customers','Email',$email);
        }
        if(is_array($result)){
            return true;
        }else{
            return false;
        }
    }

    public function getLastNodeCompany($table,$field){
        $result=$this->getLastNodeTable($table);
        if(is_array($result)){
            return $result[$field];
        }else{
            return null;
        }
    }

    public function getLastNodeCustomer($table,$field){
        $result=$this->getLastNodeTable($table);
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

    public function getListCompany($table){
        $result=$this->getDataTable($table);
        return $result;
    }
}
?>