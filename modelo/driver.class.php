<?php
require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/modelo/conection.php");

class driverModel extends connection{

    function __construct(){
        parent::__construct();
    }

    function getDriver($firstName,$lastName){
        $result=$this->getQueryEqual2('Company','ContNameFirst',$firstName,'ContNameLast',$lastName);
        if(is_array($result)){
            return $result;
        }else{
            return null;
        }
    }

    function insertDriver($id_driver,$dataDriver){
        $this->insertDataTable("Contractors",$id_driver,$dataDriver); 
    }

    public function getLastNodeDriver($table,$field){
        $result=$this->getLastNodeTable($table,$field);
        if(is_array($result)){
            return $result[$field];
        }else{
            return null;
        }
    }

    public function updateDriver($nodeName,$data){
        $this->updateDataTable("Contractors",$nodeName,$data); 
    }

    public function getDrivers($table){
        return $this->getDataTable($table);
    }
}
?>