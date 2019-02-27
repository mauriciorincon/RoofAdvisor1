<?php

    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    require_once($_SESSION['application_path']."/controlador/userController.php");



    $value = $_POST['value'];
    $table = $_POST['t'];
    $email = $_POST['u'];
    $type = $_POST['type'];

    $_userController = new userController();
    switch($table){
        case 'c':
            $table = "customer";
            $user=$_userController->getCustomer($email);
            break;
        case 'co':
            $table = "company";
            $user=$_userController->getCompanyE($email);
            break;
    }

    if(strcmp($type,"phone")==0){
        $value="+1".$value;
    }
    $_result = $_userController->updateUserPorperty($user['uid'],$table,$type,$value);
    if(is_object($_result) or is_array($_result)){
        $_message = "The $type was changed correctly.";
    }else{
        $_message = "Error, $_result";
    }
    $_message=array(
        'title'=>"Change phone/email",
        'subtitle'=>'',
        'content'=>$_message,
        'button' =>'',
        'extra' =>'',
    );
    print_r(json_encode($_message));
?>