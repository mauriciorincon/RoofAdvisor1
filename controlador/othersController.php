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
}
?>