
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
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>
<!-- END Message Area-->

<!--  blog-area end  -->		
		<!-- footer-area start -->
		<footer class="footer-bg">
			<div class="footer-top pt-80 pb-60">
				<div class="container">
					<div class="row">
						<div class="col-lg-3 col-md-3  col-sm-6 mb-20">
							<div class="footer-widget">
								<div class="footer-logo">
								   <img src="img/logo1.png" alt="" />
								</div>
								<p>Lorem ipsum dolor sit amet, consetur acing elit, sed do eiusmod tempor</p>
								<ul class="widget-contact">
									<li>
										<i class="fa fa-map-marker"></i>
										<span>8901 Marmora Raod,
                                              Glasgow, D04 89GR</span>
									</li>
									<li>
										<i class="fa fa-phone"></i>
										<span>Telephone : (801) 2223 3337
                                              Telephone : (801) 4256 9658</span>
									</li>
									<li>
										<i class="fa fa-globe"></i>
										<span>Infor@bootexperts.com
                                              Web : www.hexapro.com</span>
									</li>
								</ul>
						    </div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-6 mb-20">
							<div class="footer-widget">
								<h3 class="widget-title">Custom Feature</h3>
								<ul class="footer-menu">
									<li><a href="#">home</a></li>
									<li><a href="#">service</a></li>
									<li><a href="#">about us</a></li>
									<li><a href="#">portfolio</a></li>
									<li><a href="#">blog</a></li>
									<li><a href="#">contact us</a></li>
									<li><a href="#">blog left sidebar</a></li>
									<li><a href="#">blog right sidebar</a></li>
								</ul>
							</div>
						</div>	
						<div class="col-lg-3 col-md-3 col-sm-6 mb-20">
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
								<h3 class="widget-title">CONTACT</h3>
								<p>Lorem ipsum dolor sit amet, consetur acing elit, sed do eiusmod tempor</p>
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
						<p>Copyright © SHIELD 2017. All rights reserved. Created by <a href="https://devitems.com/">Devitems</a></p>
					</div>
				</div>
			</div>
		</footer>
		<!-- footer-area end -->
		<!-- all js here -->
        <script src="js/vendor/jquery-1.12.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/owl.carousel.min.js"></script>
		<script src="js/jquery.counterup.min.js"></script>
		<script src="js/jquery.scrollUp.min.js"></script>
		<script src="js/jquery.meanmenu.js"></script>
		<script src="js/waypoints.min.js"></script>
		<script src="js/wow.min.js"></script>
        <script src="js/plugins.js"></script>
		<script src="js/main.js"></script>
		<script src="vista/js/varios.js"></script>
		
<script type="text/javascript">
$(document).ready(function () {

var navListItems = $('div.setup-panel div a'),
    allWells = $('.setup-content'),
    allNextBtn = $('.nextBtn');
	allPrevBtn = $('.prevBtn');

allWells.hide();

navListItems.click(function (e) {
    e.preventDefault();
    var $target = $($(this).attr('href')),
        $item = $(this);

	//console.log("entro a clic");
    if (!$item.hasClass('disabled')) {
		 console.log("no tiene desabilitado");
        navListItems.removeClass('btn-success').addClass('btn-default');
        $item.addClass('btn-success');
		
		
        allWells.hide();
        $target.show();
        $target.find('input:eq(0)').focus();
    }
});

allNextBtn.click(function () {
    var curStep = $(this).closest(".setup-content"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
        curInputs = curStep.find("input[type='text'],input[type='url']"),
        isValid = true;

	$(".form-group").removeClass("has-error");
	
    for (var i = 0; i < curInputs.length; i++) {
        if (!curInputs[i].validity.valid) {
            isValid = false;
            $(curInputs[i]).closest(".form-group").addClass("has-error");
        }
	}
	//if (curStepBtn=="step-1"){
	//	isValid=validateEmail();
	//}

	if (curStepBtn=="step-2" && isValid==true ){
		saveContractorData();
	}

	if (curStepBtn=="step-3" && isValid==true ){
		//isValid=false;
		isValid=validateCodeEmail('Company');
	}

	if(curStepBtn!="step-3"){
		if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
	}
});

allPrevBtn.click(function () {
	
    var curStep = $(this).closest(".setup-content"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a"),
		curStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().children("a"),
        curInputs = curStep.find("input[type='text'],input[type='url']"),
        isValid = true;

	
	//for (var x in curStepWizard){
	//	console.log(curStepWizard[x]);
	//}
	
    $(".form-group").removeClass("has-error");
    /*for (var i = 0; i < curInputs.length; i++) {
        if (!curInputs[i].validity.valid) {
            isValid = false;
            $(curInputs[i]).closest(".form-group").addClass("has-error");
        }
    }*/
	

    if (isValid) {
	
		nextStepWizard.removeAttr('disabled').trigger('click');
		curStepWizard.attr('disabled', 'disabled');
	
	}
});

$('div.setup-panel div a.btn-success').trigger('click');
});

</script>
<?php
        if(isset($_GET['aditionalMessage'])){?>
            <script type="text/javascript">
            $(document).ready(function(){$("#myMensaje").modal("show"); });
            </script>    
    <?php
        }  
    ?>
    </body>
</html>
