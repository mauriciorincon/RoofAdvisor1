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
        //echo "realizo la consulta:".$field." ".$value;
        //exit();
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

    function getOrderByID($orderID){
        $result=$this->getDataTable('Orders/'.$orderID);
        if(is_array($result)){
            return $result;
        }else{
            return null;
        }   
    }

    function insertOrder($id_order,$dataOrder){
        $result=$this->insertDataTable("Orders",$id_order,$dataOrder,true); 
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
        return $this->updateDataTable("Orders",$nodeName,$data); 
    }

    public function getLastOrderNumber($table,$field){
        $result=$this->getLastNodeTable($table,$field);
        if(is_array($result)){
            return $result[$field];
        }else{
            return null;
        }
    }

    public function getLasOrderNumberParameter($node){
            $result=$this->getDataTable($node);
            return $result;
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

    public function updateOrderLastId($orderID){
        $this->updateDataTable("Parameters","LastOrderID",$orderID);
    }

    public function getOrderInvoices($orderID){
        $result=$this->getDataTable('Invoice/'.$orderID);
        if(is_array($result)){
            return $result;
        }else{
            return null;
        }  
    }

    public function getOrderCommentaries($orderID){
        $result=$this->getDataTable('Comment/'.$orderID);
        if(is_array($result)){
            return $result;
        }else{
            return null;
        }  
    }

    public function insertOrderCommentary($orderID,$commentary){
        
        $result=$this->insertDataTableT("Comment/".$orderID,$commentary);
        
        return $result;
    }

    public function getOrderFilesInfo($orderID){
        $result=$this->getDataTable('roofreportfiles/'.$orderID);
        if(is_array($result)){
            return $result;
        }else{
            return null;
        }  
    }

    public function insertOrderFile($orderID,$file_data){
        $result=$this->insertDataTableT("roofreportfiles/".$orderID,$file_data);
        
        return $result;
    }
 

}
?>