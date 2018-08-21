<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 


require_once($_SESSION['application_path']."/modelo/rating.class.php");
require_once($_SESSION['application_path']."/controlador/orderController.php");

class ratingController{

    private $_ratingModel=null;
    

    function __construct()
	{		
    }

    public function getCountRating($field,$value){
        $this->_ratingModel=new ratingModel();
        $_count=$this->_ratingModel->getCountRating($field,$value);
        return $_count;
    }

    public function getRatingsContractor($value){
        $this->_ratingModel=new ratingModel();
        $_ratings=$this->_ratingModel->getRating("IdContractor",$value);
        return $_ratings;
    }

    public function getRatingsByCompany($value){
        $this->_ratingModel=new ratingModel();
        $_ratings=$this->_ratingModel->getRating("IdCompany",$value);
        return $_ratings;
    }

    public function getRatingByOrder($value){
        $this->_ratingModel=new ratingModel();
        $_ratings=$this->_ratingModel->getRating("IdOrder",$value);
        return $_ratings;
    }

    public function insertRating($arrayRating){
        $this->_ratingModel=new ratingModel();
        $_order_controler= new orderController();
        
        $_order=$_order_controler->getOrderByID($arrayRating['orderID']);


        $Rating = array(
            "Comments" => $arrayRating['Comments'],
            "IdCompany" => $_order['CompanyID'],
            "IdContractor" => $_order['ContractorID'],
            "IdCustomer" => $_order['CustomerID'],
            "IdOrder" => $arrayRating['orderID'],
            "RatingCompany" => $arrayRating['RatingCompany'],
            "RatingContractor" => $arrayRating['RatingContractor'],
            "Recommended" => $arrayRating['Recommended'],
        );
        $_result=$this->_ratingModel->insertRating("FBID",$Rating);
        
        
        if(strpos($_result,'Error')>-1){
            return null;
        }else{
            
        }
        return $_result;
    }

}

?>
