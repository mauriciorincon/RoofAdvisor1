<?php
if(!isset($_SESSION)) { 
    session_start(); 
  } 
  require_once($_SESSION['application_path']."/controlador/othersController.php");

  $_otherController = new othersController();

  $_table=$_POST['table'];
  $_field=$_POST['field'];

  $result = $_otherController->getParameterValue($_table."/".$_field);
  echo $result;
?>