<?php
if(!isset($_SESSION)) { 
    session_start(); 
} 

require_once($_SESSION['application_path']."/controlador/ratingController.php");



$_array=array(
    "Comments"=>$_POST['Observation'],
    "orderID"=>$_POST['orderID'],
    "RatingCompany"=>$_POST['RatingCompany'],
    "RatingContractor"=>$_POST['RatingContractor'],
    "Recommended"=>$_POST['Recommended'],
);

$_ratingController=new ratingController();
$_id_rating=$_ratingController->insertRating($_array);
if (is_null($_id_rating)){
    echo "Error, an error ocurred traing to save rating, try again";
}else{
    if(strpos($_id_rating,'Error')>-1){
        return   $_id_rating;  
    }else{
        echo "Continue, Rating was register correctly";
    }
    
}


?>