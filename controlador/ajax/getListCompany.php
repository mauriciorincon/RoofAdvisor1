<?php

if(!isset($_SESSION)) { 
    session_start(); 
} 
require_once($_SESSION['application_path']."/controlador/userController.php");
require_once($_SESSION['application_path']."/controlador/orderController.php");

$_contractorController=new userController();
$_array_company=$_contractorController->getListCompany();

//print_r($_array_company);
$_orderController=new orderController();

$_string="";
    foreach ($_array_company as $key => $company) {

        $_string.="<tr>".
                    "<td>".$company['ComapnyLicNum']."</td>".
                    "<td>".$company['CompanyAdd1']." ".$company['CompanyAdd2']." ".$company['CompanyAdd3']."</td>".
                    "<td>".$company['CompanyEmail']."</td>".
                    "<td>".$company['CompanyID']."</td>".
					"<td>".$company['CompanyName']."</td>".
					"<td>".$company['CompanyPhone']."</td>".
					"<td>".$company['CompanyStatus']."</td>".
                    '<td>
                    <a class="btn-info btn-sm" data-toggle="modal"  
                                            href="#myModalProfile" 
                                            onClick="getDataCompany('."'".$company['CompanyID']."'".')"> 
                                            <span class="glyphicon glyphicon-pencil"></span></a>';
                    if(strcmp($company['CompanyStatus'],"Active")==0){
                        $_string.=' <a class="btn-danger btn-sm" data-toggle="modal"  
                        href="#myModal2" 
                        onClick=""> 
                        <span class="glyphicon glyphicon-remove"></span>
                    </a>';
                    }else{
                        $_string.=' <a class="btn-success btn-sm" data-toggle="modal"  
                        href="#myModal2" 
                        onClick=""> 
                        <span class="glyphicon glyphicon-ok"></span>
                    </a>';
                    }
                    $_string.=' <a class="btn-warning btn-sm" data-toggle="modal"  
                        href="#myModalDrivers" 
                        onClick="getListDrivers('."'".$company['CompanyID']."'".')"> 
                        <span class="glyphicon glyphicon-object-align-horizontal"></span>
                        </a>';
                    $_string.='</td>'.
                "</tr>";
		
    }
    echo $_string;
?>