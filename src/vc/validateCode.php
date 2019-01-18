<?php

    if (session_status() == PHP_SESSION_NONE) {
        session_start(); 
        require '../conf.php';
    } 


    //if(!isset($_SESSION['application_path'])){
    $_SESSION['application_path']=$_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF']);
    $_pos=strrpos($_SESSION['application_path'],"/");
    //echo "Pos=".$_pos;
    if($_pos===false){
    
    }else{
        $_SESSION['application_path']=substr($_SESSION['application_path'],0,$_pos);
    }
        //echo $_SESSION['aplication_path']=$_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF']);
    //}
    if(strcmp($_SERVER['HTTP_HOST'],'localhost')==0){
        $_dir=$_SERVER['REQUEST_URI'];
        $pos1 = strpos($_dir,"/");
        $pos2 = strpos($_dir,"/", $pos1 + 1);
        //echo "<br>hola:".substr($_dir,$pos1+1,$pos2-1);
        $_path2="/".substr($_dir,$pos1+1,$pos2-1);
        $_path1="http://" . $_SERVER['HTTP_HOST'].$_path2."/src";
    }else{
        $_path1="http://" . $_SERVER['HTTP_HOST'];
    }

    echo '<link rel="stylesheet" href="'.$_path1.'/vista/css/varios.css">';
    echo '<link rel="stylesheet" href="'.$_path1.'/vista/css/countdown.css">';
    require_once($_SESSION['application_path']."/controlador/userController.php");

    $code = $_GET['verify'];
    $table = $_GET['t'];
    $email = $_GET['u'];
    /*echo $code;
    echo $table;
    echo $email;
    return;*/
    if(strcmp($table,"c")==0){
        $table="Customers";
    }else if(strcmp($table,"co")==0){
        $table="Company";
    }else if(strcmp($table,"con")==0){
        $table="Contractors";
    }
    $_userController=new userController();
    $_result=$_userController->validateCode($email,$code,$table);

    echo $_result;
    

?>