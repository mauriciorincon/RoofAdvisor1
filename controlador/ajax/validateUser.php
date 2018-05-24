<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/controlador/userController.php");
    //require_once("../../modelo/user.class.php");
    //Variable de búsqueda
    $emailSearch = $_POST['userClientOrder'];
    $tableSearch = $_POST['passwordClientOrder'];
    
    
    $_userController=new userController();
    $_result=$_userController->loginCustomerOrden($emailSearch,$tableSearch);

    return $_result;
?>