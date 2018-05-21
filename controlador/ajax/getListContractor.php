<?php
    require_once("../userController.php");

    $_contractorController=new userController();
    $_array_company=$_contractorController->getListCompany();

    
    foreach ($_array_company as $key => $company) {
        $_string.='<a href="#" class="list-group-item " name="linkCompany">
						<span class="glyphicon glyphicon-wrench"></span><span name="companyName">'.$company['CompanyName'].'</span><span class="badge">1</span>
						<div class="d-flex w-100 justify-content-between">
							<h5 class="mb-1">'.$company['PrimaryFName'].' '.$company['PrimaryLName'].'</h5>
							<small>3 days ago</small><br>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star"></span>
							<span class="fa fa-star"></span>
							
						</div>
						
					</a>';
    }
    echo $_string;
?>