<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    require_once($_SESSION['application_path']."/controlador/emailController.php");

    $name=$_POST['name'];
    $email=$_POST['email'];
    $subject=$_POST['subject'];
    $message=$_POST['message'];


        $_objMail=new emailController();

        $_result=$_objMail->sendMail3($subject,"<p>This is this regarding the following matter: </br>'".$message."'</br></br>This message was sent from : '".$name."' and can be reached at '".$email."'</p>");
        if(is_bool($_result)){
            echo "Error, ".$_objMail->getMessageError();
        }else{
            echo $_result." to mail [".$_customer['Email']."]";
        }


?>
