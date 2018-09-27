<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    }
    $_path_report=$_SESSION['application_path'].'/roofreport';  
    $return = Array('ok'=>TRUE);

    $upload_folder =$_path_report;

    $nombre_archivo = $_FILES['archivo']['name'];

    $tipo_archivo = $_FILES['archivo']['type'];

    $tamano_archivo = $_FILES['archivo']['size'];

    $tmp_archivo = $_FILES['archivo']['tmp_name'];

    $archivador = $upload_folder . '/'. $nombre_archivo;

    if (!move_uploaded_file($tmp_archivo, $archivador)) {
        $return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => 'error');
    }
    echo json_encode($return);
?>