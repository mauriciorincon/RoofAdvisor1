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

    $_result = $_userController->updateUserPorperty($email,$table,$field,$value);
    $_message=array(
        'title'=>"Change phone/email",
        'subtitle'=>'',
        'content'=>$_result,
        'button' =>'',
        'extra' =>'',
    );
    print_r(json_encode($_message));

?>