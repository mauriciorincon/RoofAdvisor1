<?php
	if(!isset($_SESSION)) { 
		session_start(); 
	} 
	require_once($_SESSION['application_path']."/controlador/userController.php");
	require_once($_SESSION['application_path']."/controlador/orderController.php");

    $_contractorController=new userController();
    $_array_company=$_contractorController->getListCompany();

	$_orderController=new orderController();

	//print_r($_array_company);
    $_string="";
    foreach ($_array_company as $key => $company) {

		if(strcmp($company['CompanyStatus'],'Active')==0){
			$_count_rating = isset($company['CompanyRating']) ? $company['CompanyRating'] : 0;
			
			$_company_name = isset($company['CompanyName']) ? $company['CompanyName'] : '';
			$_company_first_name = isset($company['PrimaryFName']) ? $company['PrimaryFName'] : '';
			$_company_last_name = isset($company['PrimaryLName']) ? $company['PrimaryLName'] : '';
			
			$_id_company="'".$company['CompanyID']."','company'";
			$_porcent=intval($_count_rating)*9;

			if($_count_rating>0){
			$_string.='<a href="#" class="list-group-item " name="linkCompany">
				<span class="glyphicon glyphicon-wrench"></span><input type="hidden" value="'.$company['CompanyID'].'" name="idContractor"> <span name="companyName">'.$_company_name.'</span><span class="badge badge-primary" style="background:green;" onclick="showRatings('.$_id_company.',)">'.$_count_rating.'</span>
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1">'.$_company_first_name.' '.$_company_last_name.'</h5>
					Rating: <small>'.$company['CompanyRating'].'</small>
					<div class="star-rating">
						<div class="back-stars">
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
						</div>
						<div class="front-stars" style="width: '.$_porcent.'%">
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star"  aria-hidden="true"></i>
						</div>
					</div>
				</div>
				</a>';
			}
		}
    }
    echo $_string;
?>