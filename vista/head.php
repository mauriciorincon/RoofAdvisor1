<!doctype html>
<?php
if(!isset($_SESSION)) { 
        session_start(); 
} 
?>

<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>RoofAdviorZ</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon -->
		<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
		<!-- all css here -->
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
        <link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" href="css/owl.carousel.css">
		<link rel="stylesheet" href="css/meanmenu.css">
		<link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/icofont.css">
        <link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="css/responsive.css">
		<link rel="stylesheet" href="vista/css/step_by_step.css">
		<link rel="stylesheet" href="vista/css/varios.css">
		<link rel="stylesheet" href="vista/css/calendar.css">
		<link rel="stylesheet" href="vista/css/simple-sidebar.css" >
		<link rel="stylesheet" href="vista/css/menu_slide.css" >
		<link rel="stylesheet" href="vista/css/mdtimepicker.css" >

		
		
		
		<script src="js/vendor/modernizr-2.8.3.min.js"></script>
		<script src="https://use.fontawesome.com/f4e64b7c17.js"></script>
		<script src="https://checkout.stripe.com/checkout.js"></script>
		
		<style>
.checked {
    color: orange;
}
</style>
		
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
		<!-- header-area start-->
		<header>
			<div class="header-top-area bg-sky">
				<div class="container">
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-7 col-xs-12">
							<div class="call-to-action">
								<div class="email-address">
									<span class="email"><i class="fa fa-envelope"></i>Email: suppot@roofadvisorz.com</span>
									<span class="phone"><i class="fa fa-phone"></i>Phone: (+123) 123 321 345</span>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-2 col-xs-12">
							<div class="social-icon text-right">
								<a href="#"><i class="fa fa-facebook"></i></a>
								<a href="#"><i class="fa fa-linkedin"></i></a>
								<a href="#"><i class="fa fa-twitter"></i></a>
								<a href="#"><i class="fa fa-behance"></i></a>
								<a href="#"><i class="fa fa-pinterest"></i></a>
								<a href="#"><i class="fa fa-tumblr"></i></a>	
							</div>
							
						</div>
						<ul class="nav navbar-nav navbar-right">
							<li class="dropdown">
								<a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-user"></i> &nbsp;&nbsp;
								<span id="labelUserLoggedIn" name="labelUserLoggedIn"><?php if(isset($_SESSION['username'])){
									echo $_SESSION['username'];
								} else{
									echo "Login In";
								}?></span>
								<b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="?controller=user&accion=dashboardCustomer">Customer Area</a></li>
									<li><a href="?controller=user&accion=dashboardCompany">Company Area</a></li>
									<li class="divider"></li>
									<li><a href="?controller=user&accion=logout">Logout</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="header-bottom-area">
				<div class="container">
					<div class="row">
						<div class="col-lg-3 col-md-2 col-sm-2">
							<div class="logo">
								<a href="index.php"><img src="img/logo.png" alt="" /></a>
							</div>
						</div>
						<div class="col-lg-9 col-md-10 col-sm-10">
							<div class="main-menu text-right hidden-xs">
								<nav>
									<ul>
										<li class="active"><a href="index.php">HOME <i class="fa fa-angle-down"></i></a>
											
										</li>
										
										<li><a href="?controller=aboutus&accion=showinfo">ABOUT US</a></li>
										<li><a href="">PORTFOLIO</a></li>
										<li><a href="">BLOG <i class="fa fa-angle-down"></i></a>
											<ul>
												<li><a href="">Blog left Sidebar</a></li>
												<li><a href="">Blog right Sidebar</a></li>
												<li><a href="">blog details</a></li>
											</ul>
										</li>
										<li class="active"><a href="#">Login <i class="fa fa-angle-down"></i></a>
												<ul>
													<li><a href="?controller=user&accion=dashboardCustomer">Customer Area</a></li>
													<li><a href="?controller=user&accion=dashboardCompany">Company Area</a></li>
												</ul>
											</li>
										<li><a href="?controller=services&accion=showinfo">SERVICE</a></li>
										<li><a href="?controller=download&accion=showinfo">DOWNLOAD</a></li>
										<li><a href="?controller=contact&accion=showinfo">CONTACT1</a></li>
										<div class="bs-example">
									
									</ul>
								</nav>
								
							</div>
						</div>
						<div class="mobile-menu-area visible-xs ">
							<div class="col-md-12">
								<div class="mobile-menu">
									<nav id="mobile-menu">
										<ul>
											<li class="active"><a href="index.php">HOME <i class="fa fa-angle-down"></i></a>
												<ul>
													<li><a href="index-2.html">Home 2</a></li>
													<li><a href="index-3.html">Home 3</a></li>
												</ul>
											</li>
											<li class="active"><a href="#">Login <i class="fa fa-angle-down"></i></a>
												<ul>
													<li><a href="?controller=user&accion=dashboardCustomer">Customer Area</a></li>
													<li><a href="?controller=user&accion=dashboardCompany">Company Area</a></li>
												</ul>
											</li>
											<li><a href="about.html">ABOUT US</a></li>
											<li><a href="">PORTFOLIO</a></li>
											<li><a href="">BLOG <i class="fa fa-angle-down"></i></a>
												<ul>
													<li><a href="#">Blog left Sidebar</a></li>
													<li><a href="#">Blog right Sidebar</a></li>
													<li><a href="#">blog details</a></li>
												</ul>
											</li>
											<li><a href="?controller=services&accion=showinfo">SERVICE</a></li>
											<li><a href="?controller=download&accion=showinfo">DOWNLOAD</a></li>
											<li><a href="?controller=contact&accion=showinfo">CONTACT1</a></li>
										</ul>
									</nav>
								</div>
							</div>
						</div>	
					</div>
                </div>					
            </div>
        </header>
		<!-- header-area end-->	