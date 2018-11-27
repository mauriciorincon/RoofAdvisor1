<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    }
    require_once($_SESSION['application_path']."/controlador/orderController.php");

    $_path_report=$_SESSION['report_path'];  
    $_orderID=$_POST['orderID'];
    $_filename=$_POST['file_name'];
    
    

    $upload_folder =$_path_report;

    
    $file_name = $_orderID."_".$_filename.".pdf";

    $_path=$_SESSION['report_path'].$file_name;
    $_path2="";
    
    if(strcmp($_SERVER['HTTP_HOST'],'localhost')==0){
        $_dir=$_SERVER['REQUEST_URI'];
        $pos1 = strpos($_dir,"/");
        $pos2 = strpos($_dir,"/", $pos1 + 1);
        //echo "<br>hola:".substr($_dir,$pos1+1,$pos2-1);
        $_path2="/".substr($_dir,$pos1+1,$pos2-1);
        $_path1="http://" . $_SERVER['HTTP_HOST'].$_path2.$_path;
    }else{
        $_path1="http://" . $_SERVER['HTTP_HOST'].$_path;
    }
    

    $file_type = $_FILES['file']['type'];
    $file_size = $_FILES['file']['size'];
    $tmp_file = $_FILES['file']['tmp_name'];

    $archivador = $upload_folder . $file_name;

    if (!move_uploaded_file($tmp_file, $archivador)) {
        $return = Array('ok' => "FALSE", 'msg' => "An error occurred when uploading the file. It could not be saved.", 'status' => 'error');
    }else{
        $_orderController = new orderController();
        $_result=$_orderController->insertOrderFile($_orderID,$_path2.$_path);
        $_order_data=$_orderController->getOrder('FBID',$_orderID);
        if($_order_data['Status']=='K' and $_order_data['RequestType']=='P'){
            $_updateFields="Status,M";
            $_arrayFields=explode(",",$_updateFields);
            $_orderController->updateOrder($_orderID,$_arrayFields);
        }
        $return = Array('ok'=>"TRUE",'msg' => "The file was uploaded correctly. name [".$_POST['file_name'].".pdf]");
    }

    echo json_encode($return);
?>