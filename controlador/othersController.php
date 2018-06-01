<?php

if(!isset($_SESSION)) { 
    session_start(); 
} 

class othersController{

    private $_othersModel=null;

    function __construct()
	{		
    }

    public function verifyZipCode($_zipCode){
        $_othersModel=new othersModel();
        $_result=$this->othersModel->validateZipCode($_zipCode);
        return $_result;
    }
}
?>