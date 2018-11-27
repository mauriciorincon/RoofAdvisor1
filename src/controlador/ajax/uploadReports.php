<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    }
    require_once($_SESSION['application_path']."/controlador/orderController.php");
    require_once($_SESSION['application_path']."/controlador/readXLSXController.php");

    $file_name=$_POST['file_name'];
    if(isset($_POST['orderID'])){
        $_orderID=$_POST['orderID'];
    }
    
    if(isset($_POST['extension'])){
        $_path_report=$_SESSION['temporal_path'];
        $file_name.="_".$_POST['id_parent'].$_POST['extension'];
    }else{
        $_path_report=$_SESSION['report_path'];  
        $file_name = $_orderID."_".$file_name.".pdf";
    }
    

    $upload_folder = $_path_report;

    $_path=$_path_report.$file_name;
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
        if(isset($_POST['orderID'])){
            $_orderController = new orderController();
            $_result=$_orderController->insertOrderFile($_orderID,$_path2.$_path);
            $_order_data=$_orderController->getOrder('FBID',$_orderID);
            if($_order_data['Status']=='K' and $_order_data['RequestType']=='P'){
                $_updateFields="Status,M";
                $_arrayFields=explode(",",$_updateFields);
                $_orderController->updateOrder($_orderID,$_arrayFields);
            }
        }else if(isset($_POST['id_parent'])){
            
            $_readExcel=new read_excel();
            $result=$_readExcel->read_file_excel($archivador);
        }
        $return = Array('ok'=>"TRUE",'msg' => "The file was uploaded correctly. name [".$_POST['file_name']."] $result");
    }

    echo json_encode($return);
?>