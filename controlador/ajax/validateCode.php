<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/controlador/userController.php");

    $email = $_POST['emailValidation'];
    $code = $_POST['codeValidateField'];
    $table = $_POST['table'];

    $_userController=new userController();
    $_result=$_userController->validateCode($email,$code,$table);

    echo $_result;
    

?>