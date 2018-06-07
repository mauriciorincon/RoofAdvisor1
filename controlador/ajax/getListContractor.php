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
		//print_r($company);
		$_count_rating=$_orderController->getCountRating("IdContractor",$company['ContractorID']);
		$_id_company="'".$company['ContractorID']."'";
		$_porcent=$company['ContRating']*9;
		$_string.='<a href="#" class="list-group-item " name="linkCompany">
		
		<span class="glyphicon glyphicon-wrench"></span><input type="hidden" value="'.$company['ContractorID'].'" name="idContractor"> <span name="companyName">'.$company['CompanyName'].'</span><span class="badge badge-primary" style="background:green;" onclick="showRatings('.$_id_company.')">'.$_count_rating.'</span>
		<div class="d-flex w-100 justify-content-between">
			<h5 class="mb-1">'.$company['ContNameFirst'].' '.$company['ContNameLast'].'</h5>
			Rating: <small>'.$company['ContRating'].'</small>
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
    echo $_string;
?>