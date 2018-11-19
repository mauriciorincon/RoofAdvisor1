<?php

    if(!isset($_SESSION)) { 
      session_start(); 
    } 
    require_once($_SESSION['application_path']."/controlador/othersController.php");
    $_zipcode=$_POST['zipcode'];
    
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$_zipcode&key=AIzaSyBHuYRyZsgIxxVSt3Ec84jbBcSDk8OdloA";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);  
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 3);     
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $html = curl_exec($ch);
    curl_close($ch);

    $_info = json_decode($html, true);
    //print_r($_info);
    if(strcmp($_info['status'],'ZERO_RESULTS')==0){
      $city = "";
      $state = "";
    }else{
      $city = $_info['results'][0]['address_components'][1]['long_name'];
      $state=$_info['results'][0]['address_components'][3]['long_name'];
    }
    
    
    
    if(empty($city)){
      $_othersController=new othersController();
        $_result=$_othersController->verifyZipCode($_zipcode);
        echo "Error the zipcode is not asigned, try again - ".$_zipcode;
    }else{
        $_othersController=new othersController();
        $_result=$_othersController->verifyZipCode($_zipcode);
        if(is_null($_result)){
          echo "Sorry, we do not have the service in your area (".$city." - ".$state." - ".$_zipcode.")";
        }else{
          echo $city." - ".$state." - ".$_zipcode;
        }
    }
    
?>
