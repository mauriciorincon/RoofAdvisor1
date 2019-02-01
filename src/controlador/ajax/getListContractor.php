<?php
	if(!isset($_SESSION)) { 
		session_start(); 
	} 
	require_once($_SESSION['application_path']."/controlador/userController.php");
	require_once($_SESSION['application_path']."/controlador/orderController.php");
	require_once($_SESSION['application_path']."/controlador/ratingController.php");

	$_outputType=$_POST['typeOutput'];
    $_contractorController=new userController();
    $_array_company=$_contractorController->getListCompany("CompanyStatus","Active");

	$_orderController=new orderController();
	$_ratingController=new ratingController();

	uasort($_array_company, function($a, $b) {
		return strcmp($b['CompanyRating'], $a['CompanyRating']);
	});

	//print_r($_array_company);
	$_string="";
	if(strcmp($_outputType,'list')==0){
		foreach ($_array_company as $key => $company) {

			if(strcmp($company['CompanyStatus'],'Active')==0){
				$_count_rating = isset($company['CompanyRating']) ? $company['CompanyRating'] : 0;
				
				$_company_name = isset($company['CompanyName']) ? $company['CompanyName'] : '';
				$_company_first_name = isset($company['PrimaryFName']) ? $company['PrimaryFName'] : '';
				$_company_last_name = isset($company['PrimaryLName']) ? $company['PrimaryLName'] : '';
				
				$_id_company="'".$company['CompanyID']."','company'";
				$_porcent=intval($_count_rating)*9;

				$_countReview=$_ratingController->getCountRating("IdCompany",$company['CompanyID']);

				if($_count_rating>0){
				$_string.='<a href="#" class="list-group-item " name="linkCompany">
					<span class="glyphicon glyphicon-wrench"></span><input type="hidden" value="'.$company['CompanyID'].'" name="idContractor"> <span name="companyName">'.$_company_name.'</span><span class="badge badge-primary" style="background:black;" onclick="showRatings('.$_id_company.',)">'.' Reviews :  '.$_countReview.'   Rating : '.$_count_rating.'</span>
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
	}else if(strcmp($_outputType,'select')==0){
		foreach ($_array_company as $key => $company) {
			$_company_name = isset($company['CompanyName']) ? $company['CompanyName'] : '';
			$_company_first_name = isset($company['PrimaryFName']) ? $company['PrimaryFName'] : '';
			$_company_last_name = isset($company['PrimaryLName']) ? $company['PrimaryLName'] : '';
			
			$_id_company="'".$company['CompanyID']."','company'";
			$_string.='<option value='.$company['CompanyID'].'>'.$_company_name."</option>";
		}
	}
    echo $_string;
?>