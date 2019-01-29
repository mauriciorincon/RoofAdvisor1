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
        $_lic_num = isset($company['ComapnyLicNum']) ? $company['ComapnyLicNum'] : '';
        $_address= isset($company['CompanyAdd1']) ? $company['CompanyAdd1'] : ' ';
        $_address2 =isset($company['CompanyAdd2']) ? $company['CompanyAdd2'] : ' ';
        $_address3 =isset($company['CompanyAdd3']) ? $company['CompanyAdd3'] : ' ';
        $_mail = isset($company['CompanyEmail']) ? $company['CompanyEmail'] : '';
        $_name = isset($company['CompanyName']) ? $company['CompanyName'] : '';
        $_phone =isset($company['CompanyPhone']) ? $company['CompanyPhone'] : '';

        if(strcmp($company['CompanyStatus'],"Inactive")==0){
            $_icon="alert-danger";
        }elseif(strcmp($company['CompanyStatus'],"Validating")==0){
            $_icon="alert-warning";
        }else{
            $_icon="alert-success";
        }
        $_status='<div class="alert '.$_icon.'">'.$company['CompanyStatus'].'</div>';
        $_string.="<tr>".
                    "<td>".$company['CompanyID']."</td>".
                    "<td>".$_lic_num."</td>".
                    "<td>".$_address.' '.$_address2.' '.$_address3."</td>".
                    "<td>".$_mail."</td>".
					"<td>".$_name."</td>".
					"<td>".$_phone."</td>".
					"<td>".$_status."</td>".
                    '<td>
                    <a class="btn-info btn-sm" data-toggle="modal"   data-toggle1="tooltip"  title="Detail Company"
                                            href="#myModalCompanyProfile" 
                                            onClick="getDataCompany('."'".$company['CompanyID']."'".')"> 
                                            <span class="glyphicon glyphicon-pencil"></span></a>';
                    if(strcmp($company['CompanyStatus'],"Active")==0){
                        $_string.=' <a class="btn-danger btn-sm" data-toggle="modal"  
                        href=""  data-toggle1="tooltip"  title="Inactive Company"
                        onClick="disableEnableCompany(\''.$company['CompanyID'].'\',\'Inactive\')"> 
                        <span class="glyphicon glyphicon-remove"></span>
                    </a>';
                    }elseif(strcmp($company['CompanyStatus'],"Inactive")==0){
                        $_string.=' <a class="btn-default btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Active Company"
                        href="" 
                        onClick="alert(\'the company has not yet completed the information\')"> 
                        <span class="glyphicon glyphicon-ok"></span>
                    </a>';
                    
                    }else{
                        $_string.=' <a class="btn-success btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Active Company"
                        href="" 
                        onClick="disableEnableCompany(\''.$company['CompanyID'].'\',\'Active\')"> 
                        <span class="glyphicon glyphicon-ok"></span>
                    </a>';
                    }
                    $_string.=' <a class="btn-warning btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Employee Info"
                        href="#myModalDrivers" 
                        onClick="getListDrivers('."'".$company['CompanyID']."'".')"> 
                        <span class="glyphicon glyphicon-object-align-horizontal"></span>
                        </a>';
                    $_string.=' <a class="btn-primary btn-sm" data-toggle="modal"  data-toggle1="tooltip"  title="Post Card"
                        href="#myModalPostAdmin" 
                        onClick="showPostCardInfo('."'".$company['CompanyID']."'".')"> 
                        <span class="glyphicon glyphicon glyphicon-envelope"></span>
                        </a>';
                    $_string.='</td>'.
                "</tr>";
		
    }
    echo $_string;
?>