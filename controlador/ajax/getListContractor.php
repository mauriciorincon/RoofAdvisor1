<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/RoofAdvisor/controlador/userController.php");

    $_contractorController=new userController();
    $_array_company=$_contractorController->getListCompany();

	//print_r($_array_company);
    $_string="";
    foreach ($_array_company as $key => $company) {
		//print_r($company);
        $_string.='<a href="#" class="list-group-item " name="linkCompany">
						<span class="glyphicon glyphicon-wrench"></span><input type="hidden" value="'.$company['ContractorID'].'" name="idContractor"> <span name="companyName">'.$company['CompanyName'].'</span><span class="badge">1</span>
						<div class="d-flex w-100 justify-content-between">
							<h5 class="mb-1">'.$company['ContNameFirst'].' '.$company['ContNameLast'].'</h5>
							Rating: <small>'.$company['ContRating'].'</small><br>
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