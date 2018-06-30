<?php

if(!isset($_SESSION)) { 
    session_start(); 
}
require_once($_SESSION['application_path']."/modelo/conection.php");

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
        //echo "resultado";
        //print_r($result);
        if(is_array($result)){
            
            return $result;
        }else{
            return null;
        }
    }

    function getOrdersAll(){
        $result=$this->getDataTable('Orders');
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

    public function getRating($field,$value){
        $result=$this->getQueryEqualM('Rating',$field,$value);
        if(is_array($result)){
            return $result;
        }else{
            return null;
        }
    }

    public function getCountRating($field,$value){
        $result=$this->getCount('Rating',$field,$value);
        return $result;
    }
 
}
?>