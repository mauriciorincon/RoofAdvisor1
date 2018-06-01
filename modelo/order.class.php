<?php
require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/modelo/conection.php");

class orderModel extends connection{

    function __construct(){
        parent::__construct();
    }

    function getOrder($field,$value){
        $result=$this->getQueryEqual('Orders',$field,$value);
        if(is_array($result)){
            return $result;
        }else{
            return null;
        }
    }

    function getOrders($field,$value){
        $result=$this->getQueryEqualM('Orders',$field,$value);
        if(is_array($result)){
            return $result;
        }else{
            return null;
        }
    }

    function insertOrder($id_order,$dataOrder){
        $result=$this->insertDataTable("Orders",$id_order,$dataOrder); 
        return $result;
    }

    public function getLastNodeOrder($table,$field){
        $result=$this->getLastNodeTable($table,$field);
        if(is_array($result)){
            return $result[$field];
        }else{
            return null;
        }
    }

    public function updateOrder($nodeName,$data){
        $this->updateDataTable("Orders",$nodeName,$data); 
    }

    public function getLastOrderNumber($table,$field){
        $result=$this->getLastNodeTable($table,$field);
        if(is_array($result)){
            return $result[$field];
        }else{
            return null;
        }
    }
 
}
?>