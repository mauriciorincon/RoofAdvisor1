<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/modelo/conection.php");

class othersModel extends connection{

    function __construct(){
        parent::__construct();
    }

    public function validateZipCode($_zipCode){
        $_result=$this->getQueryListEqualValue('Parameters/validZIPCodes',$_zipCode);
        return $_result;
    }

    public function getEventsByDate($startYear,$startMonth,$finishYear,$finishMonth){
        
        $_result=$this->getDataByDate("Orders","SchDate",$startYear,$startMonth,$finishYear,$finishMonth);
        return $_result;
    }
}
?>