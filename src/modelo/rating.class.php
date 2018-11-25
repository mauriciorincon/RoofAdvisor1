<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

require_once($_SESSION['application_path']."/modelo/conection.php");
//require $_SESSION['application_path'].'/vendor/autoload.php';
require $_SESSION['library_path_autoload'];




class ratingModel  extends connection{

    function __construct(){
        parent::__construct();
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

    function insertRating($id_rating,$dataRating){
        $result=$this->insertDataTable("Rating",$id_rating,$dataRating,true); 
        return $result;
    }

}

?>