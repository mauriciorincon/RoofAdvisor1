<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
    echo "http://" . $_SERVER['HTTP_HOST']."<br>";
    echo $_SERVER['REQUEST_URI']."<br><br>";
    

    //require_once($_SESSION['application_path']."/controlador/calendarController.php");
    require_once($_SESSION['application_path']."/controlador/payingController.php");
    require_once($_SESSION['application_path']."/controlador/emailController.php");
    require_once($_SESSION['application_path']."/controlador/pdfController.php");
    require_once($_SESSION['application_path']."/controlador/orderController.php");
    require_once($_SESSION['application_path']."/modelo/order.class.php");
    require_once($_SESSION['application_path']."/modelo/user.class.php");
    require_once($_SESSION['application_path']."/vista/customerFAQ.php");


    require_once($_SESSION['application_path']."/controlador/userController.php");
    echo $_SESSION['application_path']."declare user controller";
    //require_once($_SESSION['application_path']."/modelo/user.class.php");

    //$_objPay=new payingController();

    //$_objPay->showPayingWindow1();

    //$_userModel=new userModel();
    //$_lastCustomerID=$_userModel->getLastNodeCustomer("Customers","CustomerID");
    //echo $_lastCustomerID;*/

    //$_oCalendar=new calendar();

    //$_result=$_oCalendar->getEvents('07','2018');
    //print_r($_result);

    
    
    //$_objPDF=new pdfController();
    //$_objPDF->paymentConfirmation1("313",null,100);
    
    
    //$_orderModel=new orderModel();
    //$_lastOrderNumber=$_orderModel->getLasOrderNumberParameter("Parameters/LastOrderID");
    //echo "Order id: ".$_lastOrderNumber;

    //Send Mail
    //$_objMail=new emailController();


    //$_result=$_objMail->sendMailSMTP();
    //if(is_bool($_result)){
    //   echo $_objMail->getMessageError();
    //}else{
    //    echo $_result;
    //}
    /*$_information=new customerFAQ();
        $_array=$_information->getArrayOptions();
        $_output_html="";
        foreach($_array as $key => $item){
            echo $item;
            $_output_html.=call_user_func( array( "customerFAQ", $item ) );
        }
        echo $_output_html."<br><br>";
        

        echo $_information::number_1;
        echo $_information::number_2;
        echo $_information::number_3;
        echo $_information::number_4;*/

        $_userModel=new userModel();
        $_result=$_userModel->validateCompany('support@roofservicenow.com','123456');

        $properties = [
            'emailVerified' => true,
            'disabled' => false,
            'photoURL' => ''
        ];
        $_result_update=$_userModel->updateUserCustomer($_result->uid,$properties,'company');



?>
<div class="votable hide">
						<i class="fa fa-3x fa-star-o" data-vote-type="1"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="2"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="3"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="4"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="5"></i>
						
					</div>
					<div class="voted">
						<i class="fa fa-3x fa-star-o" data-vote-type="1"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="2"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="3"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="4"></i>
						<i class="fa fa-3x fa-star-o" data-vote-type="5"></i>
						
					</div>
					<i><label id="ratingCompany">Rating: 0</label></i>
<form action="http://localhost/RoofAdvisor1/index.php?controller=paying&accion=setPaying" method="post">
    Parametros;<input type="text" id="param" name="param" value='{ "stripeToken" : "xxxxiiiissss","stripeEmail":"mauricio.rincon@gmail.com","totalAmount":"50" }'/>
    <input type="submit" value="enviar pago" />
</form>