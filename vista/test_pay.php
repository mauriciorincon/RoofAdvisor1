<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    //require_once($_SESSION['application_path']."/controlador/calendarController.php");
    require_once($_SESSION['application_path']."/controlador/payingController.php");
    //require_once($_SESSION['application_path']."/controlador/userController.php");
    //require_once($_SESSION['application_path']."/modelo/user.class.php");

    $_objPay=new payingController();

    $_objPay->showPayingWindow1();

    //$_userModel=new userModel();
    //$_lastCustomerID=$_userModel->getLastNodeCustomer("Customers","CustomerID");
    //echo $_lastCustomerID;*/

    //$_oCalendar=new calendar();

    //$_result=$_oCalendar->getEvents('07','2018');
    //print_r($_result);

    

?>
<form action="http://localhost/RoofAdvisor1/index.php?controller=paying&accion=setPaying" method="post">
    Parametros;<input type="text" id="param" name="param" value='{ "stripeToken" : "xxxxiiiissss","stripeEmail":"mauricio.rincon@gmail.com","totalAmount":"50" }'/>
    <input type="submit" value="enviar pago" />
</form>