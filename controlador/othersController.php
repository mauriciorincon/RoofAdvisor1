<?php

if(!isset($_SESSION)) { 
    session_start(); 
} 

require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/modelo/others.class.php");

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
}
?>