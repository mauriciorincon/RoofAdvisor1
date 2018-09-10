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
        <title>RoofServiceNow</title>
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
                <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>		
		<link rel="stylesheet" href="vista/css/mdtimepicker.css" >
		<link rel="stylesheet" href="vista/css/segmented-controls.css" >
		<link rel="stylesheet" href="vista/css/segmented-controls.scss" >

		
		<script src="js/vendor/modernizr-2.8.3.min.js"></script>
		<script src="js/fontawesome.min.js"></script>
		<script src="https://checkout.stripe.com/checkout.js"></script>
		
		<style>
.checked {
    color: orange;
}
</style>
		
    </head>
    <body>
    <div class="">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
		<!-- header-area start-->
		<header>
			<div class="header-top-area dolph1">
				<div class="container">
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-7 col-xs-12">
							<div class="call-to-action">
								<div class="email-address">
									<span class="email"><i class="fa fa-envelope"></i>Email: support@roofservicenow.com</span>
									<span class="phone"><i class="fa fa-phone"></i>Phone: +1 (877) 529 5995</span>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-2 col-xs-12">
							<div id ="socico" class="social-icon text-right">
								<a href="#"><i class="fa fa-facebook"></i></a>
								<a href="#"><i class="fa fa-linkedin"></i></a>
								<a href="#"><i class="fa fa-twitter"></i></a>
								<a href="#"><i class="fa fa-behance"></i></a>
								<a href="#"><i class="fa fa-pinterest"></i></a>
								<a href="#"><i class="fa fa-tumblr"></i></a>	
							</div>
							
							</div>
						
					</div>
				</div>					
						</div>
			<div class="header-bottom-area">
                          	<div class="container">
					<div class="row">
						<div class="col-lg-3 col-md-2 col-sm-2">
							<div id="logoimg" class="logo">
								<a href="index.php"><img id="logo-site" src="img/logo.png" alt="" /></a>
							</div>
						</div>
						<div class="col-lg-9 col-md-10 col-sm-10">
                                                    <img id="menu-head" src="img/menu-header.png">
							<div class="main-menu text-right hidden-xs">
								<nav id="navtxt">
									<ul>
										<li class="active"><a href="index.php">HOME&nbsp;&nbsp;</a></li>
										<li><a href="?controller=aboutus&accion=showinfo">ABOUT US&nbsp;&nbsp;</a></li>
										<li><a href="?controller=services&accion=showinfo">SERVICE&nbsp;&nbsp;</a></li>
										<li><a href="?controller=faq&accion=showinfo">FAQ&nbsp;&nbsp;</a></li>
										<li><a href="?controller=download&accion=showinfo">DOWNLOAD&nbsp;&nbsp;</a></li>
										<li><a href="?controller=contact&accion=showinfo">CONTACT</a></li>
									</ul>
					  			</nav>
							<ul class="nav navbar-nav navbar-right">
                                <li class="dropdown">
                                    <!--<img id="login-img" src="img/login.png">-->
                                    <a id="login-txt" href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-user"></i> &nbsp;&nbsp;
                                    <span id="labelUserLoggedIn" name="labelUserLoggedIn"><?php if(isset($_SESSION['username'])){
                                        echo $_SESSION['username'];
                                                } else{
                                                echo "Log In";
                                                                }?></span>
                                                                <b class="caret"></b></a>
                                                                <ul id="logindrop" class="dropdown-menu">
                                                                        <li><a href="?controller=user&accion=dashboardCustomer">Customer Area</a></li>
                                                                        <li><a href="?controller=user&accion=showLoginContractor">Company Area</a></li>
                                                                        <li class="divider"></li>
                                                                        <li><a href="?controller=user&accion=logout">Log Out</a></li>
                                                                </ul>
                                                        </li>
                                                </ul>				
							</div>
						</div>
						<div class="mobile-menu-area visible-xs ">
							<div class="col-md-12">
								<div class="mobile-menu">
									<nav id="mobile-menu">
										<ul>
										<li class="active"><a href="index.php">HOME <i class="fa fa-angle-down"></i></a></li>
										<li><a href="?controller=aboutus&accion=showinfo">ABOUT US</a></li>
										<li><a href="?controller=services&accion=showinfo">SERVICE</a></li>
										<li><a href="?controller=faq&accion=showinfo">FAQ</a></li>
										<li><a href="?controller=download&accion=showinfo">DOWNLOAD</a></li>
										<li><a href="?controller=contact&accion=showinfo">CONTACT</a></li>
										<li class="active"><a href="#">Log In <i class="fa fa-angle-down"></i></a>
											<li class="active"><a href="#">Log In <i class="fa fa-angle-down"></i></a>
												<ul>
													<li><a href="?controller=user&accion=dashboardCustomer">Customer Area</a></li>
													<li><a href="?controller=user&accion=dashboardCompany">Company Area</a></li>
												</ul>
										</li>
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

										
