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
		
		<script type="text/javascript">
      	// Notice how this gets configured before we load Font Awesome
      	window.FontAwesomeConfig = { autoReplaceSvg: false }
    	</script>
        <!-- Favicon -->
		<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
		<!-- all css here -->
		<script type="text/javascript">
      	// Notice how this gets configured before we load Font Awesome
      	window.FontAwesomeConfig = { autoReplaceSvg: false }
    	</script>
		<link rel="stylesheet" href="css/jquery-ui.css" />
		
		
        <link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="css/owl.carousel.css">
		<link rel="stylesheet" href="css/meanmenu.css">
		<link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="css/responsive.css">
		<link rel="stylesheet" href="vista/css/step_by_step.css">
		<link rel="stylesheet" href="vista/css/varios.css">
		<link rel="stylesheet" href="vista/css/calendar.css">
		<link rel="stylesheet" href="vista/css/simple-sidebar.css" >
		<link rel="stylesheet" href="vista/css/menu_slide.css" >
		<link rel="stylesheet" href="vista/css/segmented-controls.css">
		<link rel="stylesheet" href="vista/css/mdtimepicker.css">
		<!--<link rel="stylesheet" href="vista/css/fontawesome.css">
		<link rel="stylesheet" href="vista/css/font-awesome.min.css">-->
		
		<link rel="stylesheet" href="vista/css/slick.css">
		<link rel="stylesheet" href="vista/css/slick-theme.css">
		<link rel="stylesheet" href="vista/css/fullcalendar.css">
		
		<link rel="stylesheet" href="vista/timepicker/stylesheets/wickedpicker.css">
        <link href='vista/css/poppins.css' rel='stylesheet'>		
		<link href='static/vendor/sweetalert2/sweetalert2.min.css' rel='stylesheet'>	
		

		<link rel="stylesheet" href="css/lity.min.css">
				
				
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

      
		<link rel="stylesheet" href="vista/css/smart_wizard.css">
		<link rel="stylesheet" href="vista/css/smart_wizard_theme_dots.css">
		<link rel="stylesheet" href="vista/css/mobmenu.css">

             
		<script src="vista/js/jquery-3.3.1.js"></script>
		<script src="vista/js/stripe.checkout.js"></script>
		<script src="vista/js/orders.js"></script>

<style>
.checked {
    color: orange;
}
</style>

	<!-- Global site tag (gtag.js) - Google Analytics -->

<script>


	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'UA-126810340-1');
	


</script>
    </head>
    <body>
    <div id="loading5">
   <img id="loading-txt" src="img/pre-load-1.png" alt="This is taking quite some time isn't it?" />
  <img id="loading-image" src="img/load1.gif" alt="Don't worry we can wait, we are here to help!" />
    <img id="loading-txt-2" src="img/pre-load-2.png" alt="Feel at rest know we've got your back." />
  </div>
    <div  >
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
		<!-- header-area start-->
		<header>
			<div class="header-top-area dolph1">
				<div class="container headcont1">
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-7 col-xs-12">
							<div class="call-to-action">
								<div class="email-address">
									<span class="email" style="display:none"><i class="fa fa-envelope"></i>Email: support@roofservicenow.com</span>
									<span class="phone" style="display:none"><i class="fa fa-phone"></i>Phone: +1 (877) 529 5995</span>
								</div>
							</div>
						</div>
						<div id="soctop1" class="col-lg-4 col-md-4 col-sm-2 col-xs-12">
							
							
							<div id ="socico" class="social-icon text-right">
								<a href="https://www.facebook.com/"><i class="fab fa-facebook-square"></i></a>
								<a href="https://www.linkedin.com/company/viaplix.com"><i class="fab fa-linkedin"></i></a>
								<a href="https://twitter.com/roofservicenow"><i class="fab fa-twitter-square"></i></a>
								<a href="https://www.instagram.com/roofservicenow/?utm_source=ig_profile_share&igshid=jgt3twpfxve7"><i class="fab fa-instagram"></i></a>
							</div>
							
							</div>
						
					</div>
				</div>					
						</div>
			<div class="header-bottom-area">
                          	<div class="container headcont1">
					<div class="row">
						<div class="col-lg-3 col-md-2 col-sm-2">
							<div id="logoimg" class="logo">
								<a href="index.php"><img id="logo-site" src="img/logo.png" alt="" /></a>
							</div>
						</div>
						<div class="col-lg-9 col-md-10 col-sm-10" style="margin-bottom:2%;">
                                                    <img id="menu-head" src="img/menu-header.png">
							<div class="main-menu text-right hidden-xs">
								<nav id="navtxt">
									<ul>
										<li class="active"><a href="index.php">HOME&nbsp;&nbsp;</a></li>
										<li><a href="?controller=services&accion=showinfo">SERVICE&nbsp;&nbsp;</a></li>
										<li><a href="?controller=aboutus&accion=showinfo">CUSTOMERS&nbsp;&nbsp;</a></li>
                                                                                <li><a href="?controller=faq&accion=showinfo">PROS&nbsp;&nbsp;</a></li>
										<li><a href="?controller=download&accion=showinfo">DOWNLOAD&nbsp;&nbsp;</a></li>
										<li><a href="?controller=contact&accion=showinfo">CONTACT</a></li>
									</ul>
								<ul class="nav navbar-nav navbar-right">
                                	<li class="dropdown">
                                    <!--<img id="login-img" src="img/login.png">-->
                                    <a id="login-txt" href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-user"></i> &nbsp;&nbsp;
										<span id="labelUserLoggedIn" name="labelUserLoggedIn">
											<?php if(isset($_SESSION['username'])){
													echo $_SESSION['username'];
													} else{
													echo "Log In";
											}?>
										</span>
                                                <b class="caret"></b></a>
                                        	<ul id="logindrop" class="dropdown-menu">
                                                                        <li><a href="?controller=user&accion=dashboardCustomer">Homeowner</a></li>
																		<?php if(isset($_SESSION['username'])){
																			if(strcmp($_SESSION['profile'],'customer')==0){
																				echo '<li><a href="?controller=user&accion=dashboardCustomer">Orders</a></li>';
																			}elseif(strcmp($_SESSION['profile'],'company')==0){
																				echo '<li><a href="?controller=user&accion=dashboardCompany">Orders</a></li>';
																			}else{
																				echo '<li><a href="?controller=user&accion=dashboardAdmin">Orders</a></li>';
																			}
																			
																		} ?>
                                                                        <li><a href="?controller=user&accion=dashboardCompany">ContractPro</a></li>
																		<li class="divider"></li>
																		<?php if(isset($_SESSION['username'])){

																			echo '<li><a href="?controller=user&accion=logout">Log Out</a></li>';

                                                } ?>
                                                                        
                                            </ul>
                                    </li>
                                 </ul>		</nav>	
	                     						</div>
			 			</div>
                  
                                      <div id='mobslider'>
                                       <div id='mobgreet'>
                                         <span id="labelUserLoggedIn" name="labelUserLoggedIn">
                                                                                        <?php if(isset($_SESSION['username'])){
                                                                                                        echo $_SESSION['username'];
                                                                                                        } else{
                                                                                                        echo "Welcome!";
                                                                                        }?>
                                                                                </span>

                                            </div>
                                        <nav id="mobnavtxt">
                                                                        <ul>
                                                                                <li class="active"><a href="index.php">HOME&nbsp;&nbsp;</a></li>
                                                                                <li><a href="?controller=aboutus&accion=showinfo">ABOUT US&nbsp;&nbsp;</a></li>
                                                                                <li><a href="?controller=services&accion=showinfo">SERVICE&nbsp;&nbsp;</a></li>
                                                                                <li><a href="?controller=faq&accion=showinfo">FAQ&nbsp;&nbsp;</a></li>
                                                                                <li><a href="?controller=download&accion=showinfo">DOWNLOAD&nbsp;&nbsp;</a></li>
                                                                                <li><a href="?controller=contact&accion=showinfo">CONTACT</a></li>
                                                                        </ul></nav><nav id="mobnavtxt2">
                                                                <ul id="moblogin1" class="nav navbar-nav">
                                        <li class="dropdown">
                                      <span class="mobline"></span>
                                    <!--<img id="login-img" src="img/login.png">-->
                                    <a id="moblogin-txt" href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-user"></i> &nbsp;&nbsp;
                                                                                <span id="labelUserLoggedIn" name="labelUserLoggedIn">
                                                                                        <?php if(isset($_SESSION['username'])){
                                                                                                        echo "<a href='?controller=user&accion=logout'>Log Out</a>";
                                                                                                        } else{
                                                                                                        echo "Log In";
                                                                                        }?>
                                                                                </span>
                                                <b class="caret"></b></a>
                                                <ul id="logindrop" class="dropdown-menu">
                                                                        <li><a href="?controller=user&accion=dashboardCustomer">Homeowner</a></li>
                                                                        <li class="divider"></li> 
                                                                        <li><a href="?controller=user&accion=dashboardCompany">ContractPro</a></li>
                                                                                                                                                <li class="divider"></li>
                                                                                                                                                <?php if(isset($_SESSION['username'])){
                                                                                                                                                        echo '<li><a href="?controller=user&accion=logout">Log Out</a></li>';
                                                } ?>

                                            </ul>
                                    </li>
                                 </ul>          </nav>

                                      </div>
                                   <div id="mobtrigger"><i class="fas fa-bars fa-2x"></i> </div>
                   </div>
                </div>					
            
        </div>
        </header>
		<!-- header-area end-->	

										
