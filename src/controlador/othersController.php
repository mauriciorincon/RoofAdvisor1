<?php

if(!isset($_SESSION)) { 
    session_start(); 
} 

require_once($_SESSION['application_path']."/modelo/others.class.php");

class othersController{

    private $_othersModel=null;

    function __construct()
	{		
    }

    public function verifyZipCode($_zipCode){
        $this->_othersModel=new othersModel();
        $_result=$this->_othersModel->validateZipCode($_zipCode);
        return $_result;
    }

    public function setInvoicePath($firebaseOrderID,$orderId,$transNum,$pathInvoice){
        $this->_othersModel=new othersModel();
        $_result=$this->_othersModel->setInvoicePath($firebaseOrderID,$orderId,$transNum,$pathInvoice);
        return $_result;

    }

    public function getParameterValue($table){
        $this->_othersModel=new othersModel();
        $_result=$this->_othersModel->getParameterValue($table);
        return $_result;
    }

    public function updateParameterValue($table,$field,$value){
        $this->_othersModel=new othersModel();
        $_result=$this->_othersModel->updateParameterValue($table,$field,$value);
        return $_result;

    }
}
?>