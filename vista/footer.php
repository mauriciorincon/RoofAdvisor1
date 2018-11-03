<div id="loading"></div>

 <!-- Message Area-->
<div class="modal fade" id="myMensaje" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Login</h4>
      </div>
      <div class="modal-body">
        <?php
        if(isset($_GET['aditionalMessage'])){
          echo $_GET['aditionalMessage'];
        }
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- END Message Area-->

<!--  blog-area end  -->		
		<!-- footer-area start -->
		<footer class="footer-bg">
			<div class="footer-top pt-20 pb-10">
				<div class="container">
					<div class="row">
						<div class="col-lg-3 col-md-3  col-sm-6 mb-20">
							<div class="footer-widget">
								<div class="footer-logo">
								   <img src="img/logo-white.png" alt="" />
								</div>
								<p>Roof Service Now takes the stress out of finding, selecting, and paying for a roofing contractor</p>
								<ul class="widget-contact">
									<li>
										<i class="fa fa-map-marker"></i>
										<span>30 NEWBURY ST,BOSTON, MA.</span>
									</li>
									<li>
										<i class="fa fa-phone"></i>
										<span>Telephone : (888) 400 5996</span>
									</li>
									<li>
										<i class="fa fa-envelope-o"></i>
										<span><a href="mailto:info@roofservicenow.com">info@roofservicenow.com</a> </span>
									</li>
									<li>
										<i class="fa fa-globe"></i>
										<span><a href='http://www.roofservicenow.com'>www.roofservicenow.com</span>
									</li>
									
								</ul>
						    </div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-6 mb-20">
							<div class="footer-widget">
								<h3 class="widget-title">Custom Feature</h3>
								<ul class="footer-menu">
									<li><a href="#">home</a></li>
									<li><a href="#">about us</a></li>
									<li><a href="#">service</a></li>
									<li><a href="#">download</a></li>
									<li><a href="#">FAQ</a></li>
									<li><a href="#">contact us</a></li>
								</ul>
							</div>
						</div>	
						<div class="col-lg-3 col-md-3 col-sm-6 mb-20" style="display:none;">
							<div class="footer-widget">
								<h3 class="widget-title">latest post</h3>
								<div class="blog-post">
									<ul>
										<li>
											<div class="blog-post-img">
												<a href="#"><img src="img/footer/1.jpg" alt="" /></a>
											</div>
											<div class="blog-text">
												<h4><a href="#">Swedish Mega Project</a></h4>
												<span><i class="fa fa-calendar"></i>02 July 2016</span>
											</div>
										</li>
										<li>
											<div class="blog-post-img">
												<a href="#"><img src="img/footer/2.jpg" alt="" /></a>
											</div>
											<div class="blog-text">
												<h4><a href="#">Pellentesque lacus</a></h4>
												<span><i class="fa fa-calendar"></i>02 July 2016</span>
											</div>
										</li>
										<li>
											<div class="blog-post-img">
												<a href="#"><img src="img/footer/3.jpg" alt="" /></a>
											</div>
											<div class="blog-text">
												<h4><a href="#">Cras ornare arcu</a></h4>
												<span><i class="fa fa-calendar"></i>02 July 2016</span>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>		
						<div class="col-lg-3 col-md-3 col-sm-6 mb-20">
							<div class="footer-widget">
								<h3 class="widget-title">FEEDBACK</h3>
								<p>Please provide your comments or feedback</p>
								<div class="footer-form">
									<form action="#">
									  <input type="text" placeholder="Type your E-mail address..." />
									  <textarea name="message" placeholder="Write here..."></textarea>
									  <button>send</button>
									</form>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
			<div class="copyright-area">
				<div class="container">
					<div class="copyright-text text-center">
						<p>Copyright © roofservicenow 2018. All rights reserved. Created by <a href="http://www.viaplix.com/">Viaplix</a></p>
						<p><a href='?controller=termsconditions&accion=showinfo'>Legal</a> | <a href='?controller=termsconditions&accion=privacyinfo'>Privacy Center</a></p>
					</div>
				</div>
			</div>
		</footer>
		<!-- footer-area end -->
		<!-- all js here -->
		
		<script src="vista/js/jquery-3.3.1.js"></script>
				
				<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
				
				<script src="js/bootstrap.min.js"></script>
				<script src="js/owl.carousel.min.js"></script>
				<script src="js/jquery.counterup.min.js"></script>
				<script src="js/jquery.scrollUp.min.js"></script>
				<script src="js/jquery.meanmenu.js"></script>
				
		
		<script src="js/waypoints.min.js"></script>
		<script src="js/wow.min.js"></script>
        <script src="js/plugins.js"></script>
		<script src="js/main.js"></script>
		
		
		<script src="vista/js/jquery.dataTables.min.js"></script>
		<script src="vista/js/dataTables.bootstrap.min.js"></script>
		
		<script src="vista/js/mdtimepicker.js"></script>
                <script src="vendor/sweetalert2/dist/sweetalert2.min.js"></script>
	                        <script src="js/lity.min.js"></script>
                <script src="js/all.js"></script>
	
					<!--<script src="js/vendor/jquery-1.12.0.min.js"></script>-->

				
				<link rel="stylesheet" href="vista/css/dataTables.bootstrap.min.css">

<script src="vista/js/varios.js"></script>
<script src="vista/timepicker/src/wickedpicker.js"></script>



<?php
        if(isset($_GET['aditionalMessage'])){?>
            <script type="text/javascript">
            $(document).ready(function(){$("#myMensaje").modal("show"); });
            </script>    
    <?php
        }  
    ?>
</div>    
</body>
</html>
