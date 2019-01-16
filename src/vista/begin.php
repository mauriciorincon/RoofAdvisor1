<!-- slider-area start -->

<script>
				function initialization(){
					
					initMap1();
				}
</script>
<!-- Dashboard New Order -->

<?php 
	require_once($_SESSION['application_path']."/controlador/othersController.php");

	$_otherModel=new othersController();
	$_array_state=$_otherModel->getParameterValue('Parameters/state');
	include_once('vista/order_request.php');
	//echo $order_request
?>

<script>var userProfileLogin=''; </script>;

<!-- Detail for roofservicenow -->
<div id='srvapp1' class="">
<div id='srvapps'>
<!--<div id='srvmapp1'>
<img src='img/roof-build.jpg'>
</div>-->
<div class="txtcentr1">
<span class="mobiletxthd1" style="font-size:34px;"> <strong><span class="hdtxtorng1">Emergency</span> Roof Repair? </br>Schedule an <span class="hdtxtorng1" >Appointment?</span> </br>Need a <span class="hdtxtorng1">Roof Report</span>?</br>New or Reroof <span class="hdtxtorng1">Estimates</span>?</strong> </span>
</div>
</br></br>
<div class="infdivtxt1  container">
<p class='srvappph1'>
This is a same day, on-demand service for hiring pre-screened service professionals to fix your leaky roof before the damage is done. On the phone or computer you can:
</p>
<ul id="rhlist">
  <li>Track the contractor’s arrival to your home via GPS tracking</li>
  <li>Receive and approve the electronic estimate prior to start of work</li>
  <li>Get before and after pictures of the repair</li>
  <li>Easy, secure online payment when the work is complete and invoice sent to your email</li>
</ul>
</br>
<ul class='srvappph1'>
<li id="easyli">RoofServiceNow is an easy, fast, and effective way to get a leaky roof repaired right away without even being at home. It’s that easy!</li>
</br>
<li id="calendarli">Not an emergency roof repair and want to schedule a repair or estimate? <strong style='color:#fa511a'>No problem!</strong> Just answer 5 questions and a pre-screened service professional will confirm your order for an appointment. </li>
</br>
<li id="reportli">Need a roof report? RoofServiceNow can provide in a couple of hours a detailed roof report for only $29. We create accurate aerial roof measurements and diagrams you can use to estimate material cost to replace your roof. <a href=<?php echo $_SESSION['rsn_documents_path']."SampleReport.pdf"; ?> style="color: #fa511a;" target="_blank" >See sample</a></li>
</br>
</ul>
</br>
</div>
</div>
</div>
<div>
<img  id="hworks" src="img/howitworks.png">
</div>
<div id="hworks-mobile" style="display:none;" class="hworkm1">
<div  style="margin-bottom:20px;">
 <span class="mobiletxthd1 hdworkshd1">
  <strong style="color:#007e8e;font-size: 35px;">How It Works?</strong>
 </span>
</div>

<div id="TrackScrollProgress"  >
  <div class="pt-section" data-name="Section One" id="ptsection-one">
    <div class="hworkslist1">
      <i id="mobservice1" style="margin-left: 26px !important;"class="fas fa-clipboard-list fa-3x mobicworks1"></i> <span class="hworkspan"> Step 1 | <strong class="hworkstrong">Service</strong></span>
      <ul>
       <li>Emergency Repair</li>
       <li>Roof Report</li>
      </ul>
    </div>
  </div>
  <div class="pt-section" data-name="Section Two" id="ptsection-two">
<div class="hworkslist1">
     <i id="mobhandshake1" class="far fa-handshake fa-3x mobicworks1"></i>  <span class="hworkspan"> Step 2 | <strong class="hworkstrong">Interaction</strong></span>
      <ul>
       <li>Contractor arrives, provides</li>
       <li>you with an estimate prior.</li>
      </ul>
    </div>
  </div>
 <div class="pt-section" data-name="Section Three" id="ptsection-three">   
 <div class="hworkslist1">
       <i id="mobtools1" class="fas fa-hammer fa-3x mobicworks1"></i><span class="hworkspan"> Step 3 | <strong class="hworkstrong">Repair</strong></span>
      <ul>
       <li>The contractor works &</li>
       <li>Repairs your leak.</li>
      </ul>
    </div>
  </div>
   <div class="pt-section" data-name="Section Four" id="ptsection-four">  	 
<div class="hworkslist1">
       <i id="mobpay1" class="fas fa-credit-card fa-3x mobicworks1"></i><span class="hworkspan"> Step 4 | <strong class="hworkstrong">Payment</strong></span>
      <ul>
       <li>You pay the contractor</li>
       <li>for the work.</li>
      </ul>
    </div>
  </div>
<div class="pt-section" data-name="Section Five" id="ptsection-five">    
<div class="hworkslist1">
       <i id="mobfeedback1" class="fas fa-comments fa-3x mobicworks1"></i><span class="hworkspan"> Step 5 | <strong class="hworkstrong">Feedback</strong></span>
      <ul>
       <li>Write a review please,</li>
       <li>spread the good. <strong style="color:#fa511a">Thanks!</strong></li>
      </ul>
    </div>
  </div>
</div>
</div>
<!--<form role='form'>
 <div id='srvappsrch1'>
   <input maxlength="100" type="text" required="required" class="form-control input-md" placeholder="Enter your phone number" id="PhoneBegin" name="PhoneBegin">
</div>
<div id='srvappsrch2'>
<img src='img/searchbtn.png'>
<span id='srvbtnsrch'>SEARCH</span>
</div>
</form>-->
<div id='cmapp1' class=" bg-flhouse">
<!-- <div id='cmapp3'>
  <img src='img/florida-house.png'>
 </div>-->
        <div id='cmapp2'><img id='cmappimg1' class='imgqut1' src='img/quote.png'></br><span >
This app saved the day and is so easy to use. I had water leaking into the house and needed a roofer asap. With a couples of clicks, the roof contractor was on his way. He provided me with an estimate for the work. I approved it via the app. He was very quick to arrive, very professional and stopped the leak. Great service overall</span></br><img class='imgqut1' style="float:right;" src='img/bquote.png'>
        </div>
      </div>

      

<div id='appdl1' class="container">
       

 <div id='appdl2'>
   <span id='aphtxt1'><strong>Get Our App</strong></span>
   <p id='aphtxt2' align="center">Customers and service professionals stay connected together with our app. Send pictures, receive estimates, see the work status in progress and online secure payment.</p>
   <img id="appphone1" src="img/mobile-new.png">
   <img id="appmob1" src="img/mobile-phone.png"> 
</div>
</div>

<div id='mbldit25' class="container">

 <div id='appdl3' >
  <div class="row"> 
   <div id='appdiv1' class="col-xs-6">
    <span id='appdl3-tx1'>Download</br>for</span>
   </div>
     
   <div id='appmob2' class="col-xs-6">
    <span id='appdl3-tx2'><strong>FREE!</strong></span>
   </div>
  </div> 
 <div>  
  <div class="row mobiletop1 storelogom1">
   <div class="col-md-6">
    <img id='appand1' src='img/PlayStore.png'>
   </div>
   <div class="col-md-6">   
    <img id='appand2' src='img/AppleStore.png'>
   </div>
  </div>
 </div>    
 </div>

</div>
     





</div>






<!-- slider-area end -->



<div class="modal fade" id="myModalRating" role="dialog" style="height: 300px;">
	<div class="modal-dialog modal-dialog-centered" role="document"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal">&times;</button> 
				<h4 class="modal-title" id="headerTextAnswerRating">Modal Header</h4> 
			</div> 
			<div class="modal-body" id="textAnswerRating"> 
				<p >Some text in the modal.</p> 
			</div> 
			<div class="modal-footer" id="buttonrating"> 
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
			</div> 
		</div> 
	</div>
</div>
