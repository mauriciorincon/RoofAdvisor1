<?php
require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/modelo/conection.php");

class othersModel extends connection{

    function __construct(){
        parent::__construct();
    }

    public function validateZipCode($_zipCode){
        $_result=$this->getQueryEqualValue('Parameters/validZIPCodes',$_zipCode);
        return $_result;
    }
}
?>