<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    require_once($_SESSION['application_path']."/controlador/emailController.php");
    require_once($_SESSION['application_path']."/controlador/orderController.php");
    require_once($_SESSION['application_path']."/controlador/userController.php");

    $_orderID=$_POST['orderID'];
    $_file_path=$_SESSION['application_path'].'/invoice/invoice_'.$_orderID.'.pdf';
    
    if(file_exists($_file_path)){

        $_orderController=new orderController();
        $_order=$_orderController->getOrder("OrderNumber",$_orderID);

        if(is_null($_order)){
            echo "The order number no exists [".$_orderID."]";
            return;
        }

        $_companyCustomerController=new userController();
        $_customer=$_companyCustomerController->getCustomerById($_order['CustomerID']);
        if(is_null($_customer)){
            echo "The customer no exists";
            return;
        }

        $_objMail=new emailController();

        $_result=$_objMail->sendMail2($_customer['Email'],"<p>Hello, this is the <b>invoice</b></p>",$_SESSION['application_path'].'/invoice/invoice_'.$_orderID.'.pdf');
        if(is_bool($_result)){
            echo "Error, ".$_objMail->getMessageError();
        }else{
            echo $_result." to mail [".$_customer['Email']."]";
        }
    }else{
        echo "Error, the invoice is not generated yet, please generate it first.";
    } 
    
    
?>