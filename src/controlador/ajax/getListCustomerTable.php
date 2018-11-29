<?php

if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");
require_once($_SESSION['application_path']."/controlador/orderController.php");

$_field="";
$_value="";
if(isset($_POST['field'])){
    $_field=$_POST['field'];
}
if(isset($_POST['value'])){
    $_value=$_POST['value'];
}

$_contractorController=new userController();
$_array_customer=$_contractorController->getListData('Customers',$_field,$_value);
//echo "Field ".$_field." Value ".$_value;
//print_r($_array_customer);
//return;
$_string="";
    foreach ($_array_customer as $key => $customer) {
        $_customer_id = isset($customer['CustomerID']) ? $customer['CustomerID'] : '';
        $_Fname = isset($customer['Fname']) ? $customer['Fname'] : ' ';
        $_Lname =isset($customer['Lname']) ? $customer['Lname'] : ' ';
        $_Address =isset($customer['Address']) ? $customer['Address'] : ' ';
        $_City = isset($customer['City']) ? $customer['City'] : '';
        $_State = isset($customer['State']) ? $customer['State'] : '';
        $_ZIP =isset($customer['ZIP']) ? $customer['ZIP'] : '';
        $_Email =isset($customer['Email']) ? $customer['Email'] : '';
        $_Phone =isset($customer['Phone']) ? $customer['Phone'] : '';

        $_Phone=str_replace("+1","",$_Phone);
        
        $_actions='<a class="btn-primary btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Edit Customer Info" '.
            'href="#myRegisterUpdateCustomerCompany" '.
            'onClick="getCustomerInfoTable('.$customer['CustomerID'].')"> ' .
            '<span class="glyphicon glyphicon-pencil"></span>'.
        '</a>';
        if(strcmp($customer['uid'],"undefined")==0){
            $_actions.='<a href="#" class="inactivate-contractor-button btn-success btn-sm"  data-toggle="tooltip" title="Active Customer" ' .
            'id="inactivate-customer-button" name="inactivate-customer-button"  ' .
            'data-toggle1="tooltip" onclick="disableEnableCustomer('.$customer['CustomerID'].',\'Active\')"> ' .
            '<span class="glyphicon glyphicon-ok"></span></a>';
            
        } else{
            $_actions.='<a href="#" class="inactivate-contractor-button btn-danger btn-sm"  data-toggle1="tooltip"  title="Inactive Customer" ' .
             'id="inactivate-customer-button" name="inactivate-customer-button" ' .
             'data-toggle="tooltip" onclick="disableEnableCustomer('.$customer['CustomerID'].',\'Inactive\')"> ' .
             '<span class="glyphicon glyphicon-trash"></span></a>';
        }
        $_string.="<tr>".
                    "<td>".$_customer_id."</td>".
                    "<td>".$_Fname." ".$_Lname."</td>".
                    "<td>".$_Address."</td>".
                    "<td>".$_City."</td>".
					"<td>".$_State."</td>".
					"<td>".$_ZIP."</td>".
                    "<td>".$_Email."</td>".
                    "<td>".$_Phone."</td>".
                    "<td>".$_actions."</td>".
                "</tr>";
		
    }
    echo $_string;
?>