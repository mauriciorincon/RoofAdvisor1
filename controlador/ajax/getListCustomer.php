<?php
	if(!isset($_SESSION)) { 
		session_start(); 
	} 
	require_once($_SESSION['application_path']."/controlador/userController.php");
	require_once($_SESSION['application_path']."/controlador/orderController.php");
	

    $_contractorController=new userController();
    $_array_customer=$_contractorController->getListData('Customers',"","");


    $_string="";
    foreach ($_array_customer as $key => $customer) {
            $_customerName=$customer['Fname'].' '.$customer['Lname'];
			$_string.='<a href="#" class="list-group-item " name="linkCustomer">
				<span class="glyphicon glyphicon-wrench"></span><input type="hidden" value="'.$customer['CustomerID'].'" name="idCustomer"> <span name="customerName">'.$$_customerName.'</span><span class="badge badge-primary" style="background:black;" onclick="showRatings('.$_id_company.',)"></span>
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1">'.$_customerName.'</h5>
				</div>
				</a>';
			}
    echo $_string;
?>