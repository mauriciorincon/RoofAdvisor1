<?php
    require_once("../userController.php");

    $email = $_POST['emailValidation'];
    $code = $_POST['codeValidateField'];

    $_userController=new userController();
    $_result=$_userController->validateCode($email,$code);

    echo $_result;
    

?>