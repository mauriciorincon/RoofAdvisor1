<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    require_once($_SESSION['application_path']."/controlador/emailController.php");

    $name=$_POST['name'];
    $email=$_POST['email'];
    $subject=$_POST['subject'];
    $message=$_POST['message'];



$mailController = new emailController();

        $result_mail=$mailController->sendMailSMTP("mhernandez@viaplix.com",$subject,"<p>This is this regarding the following matter: </br>'".$message."'</br></br>This message was sent from : '".$name."' and can be reached at '".$email."'</p>","");
        if($result_mail==false){
            return $mailController->getMessageError();
        }else{
            return true;
        }


?>
