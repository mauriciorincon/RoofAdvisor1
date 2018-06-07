<?php
    require_once($_SESSION['application_path']."/controlador/orderController.php");
    require_once($_SESSION['application_path']."/controlador/userController.php");

    $_orderController=new orderController();
    $_id_contractor=$_POST['id_contractor'];
    $_listRating=$_orderController->getRatingsContractor($_id_contractor);

    $_customerController=new userController();

    $_string="";
    foreach ($_listRating as $key => $rating) {
		//print_r($company);
		$_customerName=$_customerController->getCustomerById($rating['IdCustomer']);
		
        $_porcentCompany=$rating['RatingCompany']*9;
        $_porcentContractor=$rating['RatingContractor']*9;
		$_string.='<a href="#" class="list-group-item " name="linkCompany">
		
        <span class="glyphicon glyphicon-comment"></span><span name="customerId"><b>'.$_customerName['Fname'].' '.$_customerName['Lname'].': </b></span>
        <span>'.$rating['Comments'].'</span>
		<div class="d-flex w-100 justify-content-between">
			<h5 class="mb-1">'.$company['ContNameFirst'].' '.$company['ContNameLast'].'</h5>
            Rating Company: <small>'.$rating['RatingCompany'].'</small>
			<div class="star-rating">
				<div class="back-stars">
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
				</div>
				<div class="front-stars" style="width: '.$_porcentCompany.'%">
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star"  aria-hidden="true"></i>
				</div>
            </div>
            Rating Contractor: <small>'.$rating['RatingContractor'].'</small>
            <div class="star-rating">
				<div class="back-stars">
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
					<i class="fa fa-star" aria-hidden="true"></i>
				</div>
				<div class="front-stars" style="width: '.$_porcentContractor.'%">
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

    //print_r($_listRating);
?>