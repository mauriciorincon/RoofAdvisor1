<?php

    if(!isset($_SESSION)) { 
      session_start(); 
    } 
    require_once($_SESSION['application_path']."/controlador/othersController.php");
    $_zipcode=$_POST['zipcode'];
    //Function to retrieve the contents of a webpage and put it into $pgdata
    $pgdata =""; //initialize $pgdata
    // Open the url based on the user input and put the data into $fd:
    $fd = fopen("http://zipinfo.com/cgi-local/zipsrch.exe?zip=$_zipcode","r"); 
    while(!feof($fd)) {//while loop to keep reading data into $pgdata till its all gone
      $pgdata .= fread($fd, 1024); //read 1024 bytes at a time
    }
    fclose($fd); //close the connection
    if (preg_match("/is not currently assigned/", $pgdata)) {
      $city = "N/A";
      $state = "N/A";
    } else {
      $citystart = strpos($pgdata, "Code</th></tr><tr><td align=center>");
      $citystart = $citystart + 35;
      $pgdata    = substr($pgdata, $citystart);
      $cityend   = strpos($pgdata, "</font></td><td align=center>");
      $city      = substr($pgdata, 0, $cityend);
    
      $statestart = strpos($pgdata, "</font></td><td align=center>");
      $statestart = $statestart + 29;
      $pgdata     = substr($pgdata, $statestart);
      $stateend   = strpos($pgdata, "</font></td><td align=center>");
      $state      = substr($pgdata, 0, $stateend);
    }
    //$zipinfo['zip']   = $zip;
    //$zipinfo['city']  = $city;
    //$zipinfo['state'] = $state;
    //Need to fix not pulling city or state for now hard coded.
    $city='Miami';    
    $state='FL'; 
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
