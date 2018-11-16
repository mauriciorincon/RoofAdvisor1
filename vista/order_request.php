<div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:1200px" role="document">
    <div class="modal-content logmodal">
      <div class="modal-header mheadr">
        <h3 class="modal-title" id="wizlogin">Please Enter Your Information To Register</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
	  <div class="modal-body" style="height:175px;">
				<div class="list-group">
						<div  class="list-group-item login-list1">
								<div class="d-flex w-100 ">
										<div class="form-row" id="step6RegisterCustomerOrder">
											<div class="form-group col-md-4">
												<label class="control-label">First Name</label>
												<input  maxlength="100" type="text" required="required" class="colorStandarInpur"  placeholder="Enter Last Name" id="firstCustomerName" name="firstCustomerName"  />
												
											</div>
											<div class="form-group col-md-4">
												<label class="control-label">Last Name</label>
												<input  maxlength="100" type="text" required="required" class="colorStandarInpur"  placeholder="Enter Last Name" id="lastCustomerName" name="lastCustomerName"  />
												
											</div>
											<div class="form-group col-md-4">
												<label class="control-label ">Email</label>
												<input maxlength=""  type="text" required="required" class="colorStandarInpur"  placeholder="Enter Email" id="emailValidation" name="emailValidation" onfocusout="validateEmail('customer')"/>
												<small  class="form-text text-muted" id="answerEmailValidate" name="answerEmailValidate">Answer</small>
											</div>
											<div class="form-group col-md-4">
												<label class="control-label ">Password</label>
												<input maxlength=""  type="password" required="required" class="colorStandarInpur"  data-minlength="6" placeholder="Password" id="inputPassword" name="inputPassword" onblur="validInputPassword()"  />
												<small  class="form-text text-muted" id="answerPasswordValidateStep6" name="answerPasswordValidateStep6">Minimum of 6 characters</small>
											</div>
											<div class="form-group col-md-4">
												<label class="control-label ">Confirm Password</label>
												<input maxlength=""  type="password" required="required" class="colorStandarInpur"  data-minlength="6" placeholder="Confirm Password" id="inputPasswordConfirm" name="inputPasswordConfirm" onblur="validInputRePassword()" />
												<small  class="form-text text-muted" id="answerRePasswordValidateStep6" name="answerRePasswordValidateStep6">Minimum of 6 characters</small>
											</div>
											<!--<div class="form-group col-md-4">
												<label class="control-label">Address</label>
												<input maxlength="100" type="text" required="required" class="colorStandarInpur"  placeholder="Enter address" id="customerAddress" name="customerAddress" />
												<small  class="form-text text-muted" id="answerRePasswordValidateStep6" name="answerRePasswordValidateStep6">Minimum of 6 characters</small>
											</div>
											<div class="form-group col-md-4">
												<label class="control-label">City</label>
												<input maxlength="100" type="text" required="required" class="colorStandarInpur" placeholder="Enter city" id="customerCity" name="customerCity" />
												
											</div>
											
											<div class="form-group col-md-4">
												<label class="control-label">Zip code</label>
												<input maxlength="5" type="text" required="required" class="colorStandarInpur"  placeholder="Enter zip code" id="customerZipCode" name="customerZipCode" />
												
											</div>-->
											<div class="form-group col-md-4">
												<label class="control-label">Phone number</label>
												<input maxlength="10" type="text" required="required" class="colorStandarInpur"  placeholder="Enter phone number" id="customerPhoneNumber" name="customerPhoneNumber"  />
												
											</div>
											<!--<div class="form-group col-md-4">
												<label class="control-label">State</label>
												<select id="customerState" name="customerState" required="required" class="form-control" placeholder="Select state">
													<?php foreach ($_array_state as $key => $value1) { ?>
															<option value="<?php echo $value1 ?>"><?php echo $value1 ?></option>
													<?php } ?>
												</select>

											</div>-->
										</div>
								</div>
						</div>
				</div>
		</div>
		<!--<center><button style="float:right;margin-top:5px;" type="button" class="btn-lg btn-primary" data-dismiss="modal">Register</button></center>-->
      <div class="modal-footer" style="border-top:0;">
	  		<center><button class=" btn-primary  btn-lg nextBtnOrder" type="button" id="buttonLoginCustomer1" onclick="saveCustomerData('Order')">Register</button></center>
        
      </div>
    </div>
  </div>
</div>

<!--<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content logmodal">
      <div class="modal-header mheadr">
        <h3 class="modal-title" id="wizlogin">MEMBER LOGIN</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     <div style="margin-left:30px;margin-top:30px;margin-bottom:-15px;">
       <span class="glyphicon glyphicon-info-sign"></span>&nbsp;Info</br></br>
       <span ><b>One more step, we need to verify your identity, please login or register</b></span><br><br>
      </div>     
 		<div class="modal-body" style="height:175px;">
				<div class="list-group">
						<div  class="list-group-item login-list1">
								<div class="d-flex w-100 justify-content-between">
										<div class="form-group">
												<label class="loglable" style="display: inline-block;margin-left:73px;"><i class="fa fa-user" aria-hidden="true" style="color:#fa511a"></i></label>
												<input style="width:60%;color:#646363;" type="text" placeholder="Username" required="true" id="userClientOrder" name="userClientOrder" /><span class="required">&nbsp;&nbsp;*</span>
										</div>
										<div class="form-group">
												<label class="loglable" style="display: inline-block;margin-left: 73px;padding:3.1px 10px 3.1px 10px;" ><i class="fa fa-key" aria-hidden="true" style="color:#fa511a"></i></label>
												<input style="width:60%;color:#646363;" type="password" placeholder="password" required="true" id="passwordClientOrder" name="passwordClientOrder"/><span class="required">&nbsp;&nbsp;*</span>
										</div>
										<div style="display:inline-block;text-align:left !important; position:absolute;left:200px;margin-top:-6px;">
											<a style="color:#fff;" href="index.php?controller=user&accion=resetPasswordCustomer">Forgot password?</a>
										</div>
										<br><br><br>
										<label style="display:none" id="answerValidateUserOrder" name="answerValidateUserOrder">Answer</label>
								</div>
						</div>
				<button class="btn btn-primary prevBtnOrder pull-left" type="button">Previous</button>
				<button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
				</div>
		</div>
      <div class="modal-footer">
        <button style="float:right;margin-top:5px;" type="button" class="btn-lg btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#register-modal">Register</button>
       <button  style="margin-top:5px;margin-right:8px;" class=" btn btn-lg nextBtnOrder pull-right" type="button" id="buttonLoginCustomer">Login</button>
      </div>
    </div>
  </div>
</div>-->

<div id="welcome-txt">
    <span>
    Need a <strong>Roofer?</strong> Fast<strong style="color:#fa511a;"> same day</strong> service!
    </span>
    </div>
<div id="appwiz" class="container">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panelOrder">
            <div class="stepwizard-step col-xs-1" > 
                <a href="#step-1"  type="button" class="btn btn-success btn-circle invisible" >1</a>
                <p class="invisible"><small>Z Code</small></p>
            </div>
            <div class="stepwizard-step col-xs-1"> 
                <a href="#step-2"  type="button" class="btn btn-default btn-circle invisible" disabled="disabled" >2</a>
                <p class="invisible"><small> Order </small></p>
			</div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-10"  type="button" class="btn btn-default btn-circle invisible" disabled="disabled" >2.1</a>
                <p class="invisible"><small>Question?</small></p>
			</div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-3"  type="button" class="btn btn-default btn-circle invisible" disabled="disabled" >3</a>
                <p class="invisible"><small>Address</small></p>
            </div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-4"  type="button" class="btn btn-default btn-circle invisible" disabled="disabled" >4</a>
                <p class="invisible"><small>Time</small></p>
            </div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-5"  type="button" class="btn btn-default btn-circle invisible" disabled="disabled" >5</a>
                <p class="invisible"><small>Professional</small></p>
            </div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-6"  type="button" class="btn btn-default btn-circle invisible" disabled="disabled" >6</a>
                <p class="invisible"><small>Review</small></p>
            </div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-7"  type="button" class="btn btn-default btn-circle invisible" disabled="disabled" >7</a>
                <p class="invisible"><small>Validation</small></p>
			</div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-8"  type="button" class="btn btn-default btn-circle invisible" disabled="disabled" >8</a>
                <p class="invisible"><small>Complete</small></p>
            </div>
        </div>
    </div>
    <div id="appfrm1" align="center">
    <form role="form" align="left" style="background-image: url('img/roof.home.wiz.bg.png'); width: 80%; height: 800px; background-size: 100% 100%;">
     <div id="step1contain">
        <div class="panel panel-primary setup-contentOrder panel-mv1" id="step-1">
            <div id="zip-panel-heading" class="panel-heading wizhead">
                 <h3 class="panel-title">Start Here</h3>
            </div>
            <div class="panel-body pbody-white">
                <div class="form-group">
                    <label class="control-label text-center h1"><big>ZIP CODE</big></label>
                    <input maxlength="100" type="text" required="required" class="form-control input-lg" placeholder="Enter your zip code" id="zipCodeBegin" name="zipCodeBegin" />
					<label class="control-label text-center h1" id="answerZipCode"><big></big></label>
                </div>
                
                <button class="btn btn-primary nextBtnOrder pull-right" type="button" id="firstNextBegin" name="firstNextBegin">Next</button>
                
            </div>
        </div>
    </div>
    <button class="btnvid1" disabled><a style="color:#fff;font-size:18px;" href="video/roofpromo.mp4" data-lity><i style="margin-right:10px;" class="fas fa-play"></i>WATCH THE VIDEO</a></button>
         <div  class="panel panel-primary setup-contentOrder panel-mv1" id="step-2">
            <div class="panel-heading">
                 <h3 class="panel-title wizhead"><font size="5"><strong>Select Service</strong></font> </h3>
            </div>
            <div class="panel-body" align="left">
				<div class="list-group-item ">
				<font size="5">&#9312;</font><font size="5"><strong>What type of service?</strong></font>
				</div>
				<div class="list-group" id="step2OtypeService">
				<a href="#" class="list-group-item " name="linkServiceType">
					<input type="hidden" value="emergency" name="typeServiceOrder">
						<table>
							<tr>
								<td style="padding: 12px 12px 12px 12px;">
									<button class=" btn-primary   btn-lg" type="button" style="width:160px">Emergency Repair</button>
								</td>
								<td style="padding: 12px 12px 12px 12px;">
								<h4>An emergency repair is a same day service. The first available rated service pro will choose your repair order and provide you with an ETA of when they will arrive at the repair location.  You will be able to review their ratings, communicate, send them pictures, and track their location. An estimate for your approval will be provided prior to start of work. </h4>
								</td>
							</tr>
						</table>
						<div class="d-flex w-100 justify-content-between">
						
						<span></span>
							
						</div>
					</a>

					<a href="#" class="list-group-item" name="linkServiceType">
						<input type="hidden" value="schedule" name="typeServiceOrder">
						<table>
							<tr>
								<td style="padding: 12px 12px 12px 12px;">
									<button class=" btn-success   btn-lg" type="button" style="width:160px">Schedule Repair</button>
								</td>
								<td style="padding: 12px 12px 12px 12px;">
								<h4>A scheduled repair is scheduled a week in advance. You will be able to choose the service pro or allow the first available rated service pro will choose your repair order.</h4>
								</td>
							</tr>
						</table>
						<div class="d-flex w-100 justify-content-between">
						
						<span></span>
							
						</div>
					</a>

					<a href="#" class="list-group-item" name="linkServiceType">
						<input type="hidden" value="roofreport" name="typeServiceOrder">
						<table>
							<tr>
								<td style="padding: 12px 12px 12px 12px;">
									<button class=" btn-primary   btn-lg" type="button" style="width:160px">Order Roof Report</button>
								</td>
								<td style="padding: 12px 12px 12px 12px;">
								<h4>Get a detailed roof report for $29 within 2 hours. We create accurate aerial roof measurements and diagrams you can use to estimates material cost to replace your roof. If we cannot create the roof report for you due to aerial obstructions or roof complexity, we will refund your money guaranteed.</h4>
								</td>
							</tr>
						</table>
						<div class="d-flex w-100 justify-content-between">
						
						<span></span>
							
						</div>
					</a>
					
				</div>
					

					
								
				
					
				
				<!--<div class="list-group-item ">
				<font size="5">&#9313;</font> <font size="5"><strong>Best select the type of roofing material on your property?</strong></font>		
				</div>
				<div class="list-group-item ">
						<div class="form-group">
							<div class ="col-md-5">
							</div>
							<div class ="col-md-1">
								<input class="form-check-input" type="radio" name="estep3Option" id="estep3Option1" value="Flat" checked>
							</div>
							<div class="col-md-6"> 
								<label class="form-check-label" for="estep3Option1">
									Flat
								</label>
							</div>
						</div>

						<div class="form-group">
							<div class ="col-md-5">
							</div>
							<div class ="col-md-1">
									<input class="form-check-input" type="radio" name="estep3Option" id="estep3Option2" value="Asphalt">
							</div>
							<div class="col-md-6">
									<label class="form-check-label" for="estep3Option2">
									Asphalt
									</label>
							</div>
							
						</div>

						<div class="form-group">
							<div class ="col-md-5">
							</div>
							<div class ="col-md-1">
									<input class="form-check-input" type="radio" name="estep3Option" id="estep3Option3" value="Wood Shake/Composite">
							</div>
							<div class="col-md-6">
									<label class="form-check-label" for="estep3Option3">
									Wood Shake/Composite
									</label>
							</div>
						
						</div>
						<div class="form-group">
							<div class ="col-md-5">
							</div>
							<div class ="col-md-1">
									<input class="form-check-input" type="radio" name="estep3Option" id="estep3Option4" value="Metal">
							</div>
							<div class="col-md-6">
								<label class="form-check-label" for="estep3Option4">
								Metal
								</label>
							</div>
								
						</div>
						<div class="form-group">
							<div class ="col-md-5">
							</div>
							<div class ="col-md-1">
									<input class="form-check-input" type="radio" name="estep3Option" id="estep3Option5" value="Tile">
							</div>
							<div class="col-md-6">
									<label class="form-check-label" for="estep3Option5">
									Tile
									</label>
							</div>
							
						</div>	
						<div class="form-group">
							<div class ="col-md-5">
							</div>
							<div class ="col-md-1">
									<input class="form-check-input" type="radio" name="estep3Option" id="estep3Option5" value="Do not know">
							</div>
							<div class="col-md-6">
									<label class="form-check-label" for="estep3Option5">
									Do not Know
									</label>
							</div>
						</div>	
						<label>&nbsp;</label>

				</div>
                
				<div class="list-group-item ">
					<font size="5">&#9314;</font> <font size="5"><strong>Are you aware of any leaks or damage to the roof?</strong></font>		
				</div>

				<div class="list-group-item ">
					<div class="form-group">
						<div class ="col-md-5"></div>
						<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep4Option" id="estep4Option1" value="Yes" checked></div>
						<div class="col-md-6"><label class="form-check-label" for="estep4Option1">Yes</label></div>
					</div>

					<div class="form-group">
						<div class ="col-md-5"></div>
						<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep4Option" id="estep4Option2" value="No"></div>
						<div class="col-md-6"><label class="form-check-label" for="estep4Option2">No</label></div>
					</div>
					<label>&nbsp;</label>
				</div>

				<div class="list-group-item ">
				<font size="5">&#9315;</font> <font size="5"><strong>How many stories is your home?</strong></font>
				</div>

				<div class="list-group-item ">
					<div class="form-group">
						<div class ="col-md-5"></div>
						<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep5Option" id="estep5Option1" value="1 story" checked></div>
						<div class="col-md-6"><label class="form-check-label" for="estep5Option1">One</label></div>
					</div>

					<div class="form-group">
						<div class ="col-md-5"></div>
						<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep5Option" id="estep5Option2" value="2 story"></div>
						<div class="col-md-6"><label class="form-check-label" for="estep5Option2">Two</label></div>
					</div>

					<div class="form-group">
						<div class ="col-md-5"></div>
						<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep5Option" id="estep5Option3" value="3 or more"></div>
						<div class="col-md-6"><label class="form-check-label" for="estep5Option3">Three or More</label></div>
					</div>
					<label>&nbsp;</label>
				</div>

				<div class="list-group-item ">
					<font size="5">&#9316;</font> <font size="5"><strong>Are you the owner or authorized to make property changes?</strong></font>		
				</div>

				<div class="list-group-item ">
					<div class="form-group">
						<div class ="col-md-5"></div>
						<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep6Option" id="estep6Option1" value="Yes" checked></div>
						<div class="col-md-6"><label class="form-check-label" for="estep6Option1">Yes</label></div>
					</div>

					<div class="form-group">
						<div class ="col-md-5"></div>
						<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep6Option" id="estep6Option2" value="No"></div>
						<div class="col-md-6"><label class="form-check-label" for="estep6Option2">No</label></div>
					</div>
					<label>&nbsp;</label>
				</div>-->

                <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Previous</button>
            </div>

		</div>

		<div class="panel panel-primary setup-contentOrder panel-mv1" id="step-10" align="left">
			<div class="panel-heading">
                 <h3 class="panel-title wizhead"><font size="5"><strong>Answer Some Questions</strong></font> </h3>
			</div>
			<div class="panel-body">
			<div class="list-group-item scr2fix">
				<font size="5">&#9313;</font> <font size="5"><strong>Best select the type of roofing material on your property?</strong></font>		
				</div>
				<div class="list-group-item scr2fix ">
						<div class="form-group">
						
							<style>
								.segmented-control > label::after {
									background-color: #319DD4;
								}
							</style>
							<div class="segmented-control" style="width: 100%; color: #319DD4">
								<input type="radio" name="estep3Option" data-value="Flat" id="sc-1-1-1" checked>
								<input type="radio" name="estep3Option" data-value="Asphalt" id="sc-1-1-2">
								<input type="radio" name="estep3Option" data-value="Wood Shake/Composite" id="sc-1-1-3" >
								<input type="radio" name="estep3Option" data-value="Metal" id="sc-1-1-4">
								<input type="radio" name="estep3Option" data-value="Tile" id="sc-1-1-5">
								<input type="radio" name="estep3Option" data-value="Do not know" id="sc-1-1-6">
								<label for="sc-1-1-1" data-value="Flat">Flat</label>
								<label for="sc-1-1-2" data-value="Asphalt">Asphalt</label>
								<label for="sc-1-1-3" data-value="Wood Shake/Composite">Wood Shake/Composite</label>
								<label for="sc-1-1-4" data-value="Metal">Metal</label>
								<label for="sc-1-1-5" data-value="Tile">Tile</label>
								<label for="sc-1-1-6" data-value="Do not know">Do not know</label>
							</div>					
						</div>
				</div>
                
				<div class="list-group-item scr2fix">
					<font size="5">&#9314;</font> <font size="5"><strong>Are you aware of any leaks or damage to the roof?</strong></font>		
				</div>

				<div class="list-group-item scr2fix">
					<div class="form-group">
							<div class="segmented-control" style="width: 100%; color: #319DD4">
								<input type="radio" name="estep4Option" data-value="Yes" id="estep4Option1" checked>
								<input type="radio" name="estep4Option" data-value="No" id="estep4Option2">
								
								<label for="estep4Option1" data-value="Yes">Yes</label>
								<label for="estep4Option2" data-value="No">No</label>
								
							</div>

					</div>

				</div>

				<div class="list-group-item scr2fix">
					<font size="5">&#9315;</font> <font size="5"><strong>How many stories is your home?</strong></font>
				</div>

				<div class="list-group-item scr2fix">
					<div class="form-group">
							<div class="segmented-control" style="width: 100%; color: #319DD4">
								<input type="radio" name="estep5Option" data-value="1 Story" id="estep5Option1" checked>
								<input type="radio" name="estep5Option" data-value="2 Story" id="estep5Option2">
								<input type="radio" name="estep5Option" data-value="3 or more" id="estep5Option3" >
								<input type="radio" name="estep5Option" data-value="3 or more" id="estep5Option4">
								
								<label for="estep5Option1" data-value="1 Story">One</label>
								<label for="estep5Option2" data-value="2 Story">Two</label>
								<label for="estep5Option3" data-value="3 or more">Three</label>
								<label for="estep5Option4" data-value="3 or more">More</label>
								
							</div>
						
					</div>
					
				</div>

				<div class="list-group-item scr2fix">
					<font size="5">&#9316;</font> <font size="5"><strong>Are you the owner or authorized to make property changes?</strong></font>		
				</div>

				<div class="list-group-item scr2fix">
					<div class="form-group">
							<div class="segmented-control" style="width: 100%; color: #319DD4">
								<input type="radio" name="estep6Option" data-value="Yes" id="estep6Option1" checked>
								<input type="radio" name="estep6Option" data-value="No" id="estep6Option2">
								
								<label for="estep6Option1" data-value="Yes">Yes</label>
								<label for="estep6Option2" data-value="No">No</label>
								
							</div>
						
					</div>
				</div>

                <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Previous</button>
			</div>
		</div>
		
		<div class="panel panel-primary setup-contentOrder panel-mv1" id="step-3" align="left">
            <div class="panel-heading">
                 <h1 class="panel-title wizhead"><font size="5"><strong>Enter Service Location</strong></font> </h1>
            </div>
            <div class="panel-body">
			<span id="srchinftxt1" class="glyphicon glyphicon-info-sign h1white"></span> <font size="5"><strong class="h1white">Enter the place for the service</strong></font>
					<input type="hidden" id="step5Logintud" name="step5Logintud"/>
					<input type="hidden" id="step5Latitude" name="step5Latitude"/>
					<input type="hidden" id="step5Address" name="step5Address"/>
					<input type="hidden" id="step5ZipCode" name="step5ZipCode"/>
                    <div class="list-group">
							
                       
                                <style>
						/* Set the size of the div element that contains the map */
						#map1 {
							height: 400px;  /* The height is 400 pixels */
							width: 100%;  /* The width is the width of the web page */
						}
						#pac-input {
							background-color: #fff;
							font-family: Roboto;
							font-size: 15px;
							font-weight: 300;
							margin-left: 33%;
							margin-top: 10px;
							padding: 0 11px 0 13px;
							text-overflow: ellipsis;
							width: 400px;
							border-radius: 7px;
							background-color : #7ba8f2;
						}

                        </style>
						
						<input  id="pac-input" class="wizsrch2" type="text" placeholder="Enter a location" >
							<div id="map1"></div>

							<script>
							// This example requires the Places library. Include the libraries=places
							// parameter when you first load the API. For example:
							// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

							var map = null;

							function initMap1() {
								

								map = new google.maps.Map(document.getElementById('map1'), {
								center: {lat: 27.332617, lng: -81.255690},
								zoom: 12,
                                streetViewControl: false,
                                mapTypeControl: false
								});

								////Get lat and long from zipcode
							
								setLocation(map,"")
								/////////////////////////////////////

								var input = /** @type {!HTMLInputElement} */(
									document.getElementById('pac-input'));

								var types = document.getElementById('type-selector');
								map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
								map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

								var autocomplete = new google.maps.places.Autocomplete(input);
								autocomplete.bindTo('bounds', map);

								var infowindow = new google.maps.InfoWindow();
								var marker = new google.maps.Marker({
								map: map,
								anchorPoint: new google.maps.Point(0, -29)
								});

								autocomplete.addListener('place_changed', function() {
									infowindow.close();
									marker.setVisible(false);
									var place = autocomplete.getPlace();
									if (!place.geometry) {
									// User entered the name of a Place that was not suggested and
									// pressed the Enter key, or the Place Details request failed.
									window.alert("No details available for input: '" + place.name + "'");
									return;
									}

									// If the place has a geometry, then present it on a map.
									if (place.geometry.viewport) {
										map.fitBounds(place.geometry.viewport);
									} else {
										map.setCenter(place.geometry.location);
										map.setZoom(17);  // Why 17? Because it looks good.
									}
									marker.setIcon(/** @type {google.maps.Icon} */({
										url: place.icon,
										size: new google.maps.Size(71, 71),
										origin: new google.maps.Point(0, 0),
										anchor: new google.maps.Point(17, 34),
										scaledSize: new google.maps.Size(35, 35)
									}));
									marker.setPosition(place.geometry.location);
									marker.setVisible(true);
									$("#step5Logintud").val(place.geometry.location.lng());
									$("#step5Latitude").val(place.geometry.location.lat());
									
									//console.log(place.geometry.location.lat());
									//console.log(place.geometry.location.lng());
									var address = '';
									if (place.address_components) {
										address = [
										(place.address_components[0] && place.address_components[0].short_name || ''),
										(place.address_components[1] && place.address_components[1].short_name || ''),
										(place.address_components[2] && place.address_components[2].short_name || '')
										].join(' ');
										$('#step5Address').val(address);
										$('#step5ZipCode').val(place.address_components[7].short_name);
									}
									

									infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
									infowindow.open(map, marker);
								});

								// Sets a listener on a radio button to change the filter type on Places
								// Autocomplete.
								/*function setupClickListener(id, types) {
								var radioButton = document.getElementById(id);
								radioButton.addEventListener('click', function() {
									autocomplete.setTypes(types);
								});
								}

								setupClickListener('changetype-all', []);
								setupClickListener('changetype-address', ['address']);
								setupClickListener('changetype-establishment', ['establishment']);
								setupClickListener('changetype-geocode', ['geocode']);*/
							}

							function setLocation(map,zipcode){
								//var address = $('#zipCodeBegin').val();
								var address=zipcode;
								if(address==undefined || address==""){
									address = '02201';
								} 
								console.log("zipcode: "+address);
								geocoder = new google.maps.Geocoder();
								
								geocoder.geocode( { 'address': address}, function(results, status) {
								if (status == 'OK') {
									map.setCenter(results[0].geometry.location);
									var marker = new google.maps.Marker({
										map: map,
										position: results[0].geometry.location
									});
								} else {
									alert('Geocode was not successful for the following reason: ' + status);
								}
								});
							}

							function clearMarkers(map) {
        						map.clearOverlays();
      						}

							</script>
							
						<script async defer
							src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHuYRyZsgIxxVSt3Ec84jbBcSDk8OdloA&libraries=visualization&libraries=places&callback=initialization">
						</script>

						<button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                		<button class="btn btn-primary prevBtnOrder pull-left" type="button">Previous</button>
					</div>
			</div>
		</div>

		<div class="panel panel-primary setup-contentOrder panel-mv1" id="step-4" align="left">
            <div class="panel-heading">
                 <h3 class="panel-title wizhead"><font size="5"><strong>Select a Date & Time for service</strong></font></h3>
            </div>
            <div class="panel-body">
				<div class="row">
                                         <div class="col-sm-12">
                                                <br>
                                                <center><h4 class="h1white"><b>Please Note:&nbsp; Repair service are schedule a week in advance.</b></h4></center>
                                        </div>

					<div class="col-sm-6 inpwiz1">
						<span class="h1white"><h4><b>Select the date of service. </b></h4></span><input type="text" id="step6date" name="step6date" class="datepicker" style="font-size:24px;text-align:center;">
					</div>
					<div class="col-sm-6 inpwiz2">
						<span class="h1white"><h4><b>Select the time of service. </b></h4></span>
						<input type="text" name="step6time" id="step6time" class="timepicker1" style="z-index: 105100;font-size:24px;text-align:center;"/>
						<!--<input type="text" id="step6time" name="step6time" class="timepicker"  style="font-size:24px;text-align:center;" />-->
						
					</div>
					
				</div> 
              <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Previous</button>
            </div>
        </div>

		<div class="panel panel-primary setup-contentOrder panel-mv1" id="step-5" align="left">
            <div class="panel-heading">
                 <h3 class="panel-title wizhead"><font size="5"><strong>Contractor List</strong></font></h3>
            </div>
            <div class="panel-body">
				<div class="form-group">
				
								<!--<label class="control-label" for="exampleRadios5">-->
								<span class="h1white" ><h4><b>These Service Professionals are best suited for your scheduled repair and are all rated 4+ by previous customers.</b> </h4></span>
								<!--</label>-->
								<!--<label class="control-label" for="exampleRadios5">-->
								<h4 class="h1white"><b>You can select one or the first available will respond to your work order?</b></h4>
								<!--</label>-->
							
							
				</div>

				<div class="list-group1" id="step7ListCompany">
					
				</div>
         
                <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Previous</button>
            </div>
        </div>

		<div class="panel panel-primary setup-contentOrder panel-mv1" id="step-6" align="left"> 
            <div class="panel-heading">
                 <h1 class="panel-title wizhead"><font size="5"><strong>Review Your Order Details</strong></font></h1>
            </div>
            <div class="panel-body">
				
				<div class="list-group">
						<a href="#" class="list-group-item ">
							<span class="glyphicon glyphicon-envelope"></span> Details 
							<div class="d-flex w-100 justify-content-between">
								<span ><b>Repair Description: </b></span><span id="step8RepairDescription"></span><br>
								<span ><b>Schedule Date: </b></span><span id="step8Schedule"></span><br>	
								<span ><b>Time: </b></span><span id="step8Time"></span>
							</div>
						</a>
				</div>

				<div class="list-group">
						<a href="#" class="list-group-item ">
							<span class="glyphicon glyphicon-wrench"></span> Contractor 
							<div class="d-flex w-100 justify-content-between">
								<span ><b>Name: </b></span><span id="step8CompanyName"></span><br>
								
							</div>
						</a>
				</div>

				<div class="list-group">
						<a href="#" class="list-group-item ">
							<span class="glyphicon glyphicon-map-marker"></span> Address of service 
							<div class="d-flex w-100 justify-content-between">
								<span ><b>Address: </b></span><span id="step8Address"></span><br>
								<span ><b>ZipCode: </b></span><span id="step8ZipCode"></span><br>
								<!--<span ><b>Latitude: </b></span><span id="step8Latitude"></span><br>
								<span ><b>Longitude: </b></span><span id="step8Longitude"></span><br>-->
								
							</div>
						</a>
				</div>

				<!--<div class="list-group">
						<a href="#" class="list-group-item ">
							<span class="glyphicon glyphicon-info-sign"></span> Rate 
							<div class="d-flex w-100 justify-content-between">
								<span ><b>Prices start from $300-$400 per square and will increase depending on the size, mateiral and time needed to complete the repair.</b></span><span id="step8CompanyName"></span><br>
								
							</div>
						</a>
				</div>-->
                
                <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Previous</button>
            </div>
        </div>

		<div class="panel panel-primary setup-contentOrder panel-mv1" id="step-8">
            <div class="panel-heading">
                 <h3 class="panel-title wizhead">Payment Processing</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">		
						<div class ="col-md-3">&nbsp;
						</div>
						<div class ="col-md-6" id="divEmergencyService">
							<div class="list-group" >
								<a href="#" class="list-group-item ">
									<span class="glyphicon glyphicon-info-sign"></span>Emergency Service 
									<div class="d-flex w-100 justify-content-between">
									<b>Emergency Repair Service Charge of $79 is the initial cost to secure the same day service response from a qualified, pre-screened service professional. If the service professional is unable to provide service within 24 hours from the time you submit payment, we will refund the emergency repair charge.</b>
									</div>
								</a>
							</div>
						</div>
						<div class ="col-md-6" id="divRoofService">
							<div class="list-group">
								<a href="#" class="list-group-item ">
									<span class="glyphicon glyphicon-info-sign"></span>Roof Report 
									<div class="d-flex w-100 justify-content-between">
									<b>Ordering a Roof Report cost $29. We create detailed aerial roof measurements and diagrams that are sent to you via email and can be viewed in our web site. If we cannot create a roof report for you due to obstructions or roof complexity, we will refund your money.</b>
									</div>
								</a>
							</div>
						</div>
						<div class ="col-md-3">&nbsp;
						</div>
					<div class ="col-md-12">
						<label class="control-label text-center h1 h1white"><big>To finish your order, please click on <b>Pay Your Service</b> button to make the charge to your card.</big></label>
						<?php
							if(!isset($_SESSION)) { 
								session_start(); 
							} 
							require_once($_SESSION['application_path']."/controlador/payingController.php");
							
						
							$_objPay=new payingController();
							echo "<center>";
							$_objPay->showPayingWindow1();
							echo "</center>";
						?>
					</div>	
                    
					
					<label class="control-label text-center h1" id="answerZipCode"><big></big></label>
                </div>
				
				<button class="btn btn-primary prevBtnOrder pull-left" type="button">Previous</button>
            </div>
		</div>
		
		<div style="margin-top: -55px;  background-image: url(img/woman-hard-hat.png);    height: 668px;    background-size: contain;    background-repeat: no-repeat;width:70%;    background-color: rgba(29, 29, 29, 0.86);" class="panel panel-primary setup-contentOrder panel-mv1" id="step-7">
			<input type="hidden" id="userLoguedIn" value="false" />
            <div class="panel-heading" style="display:none">
                 <h3 class="panel-title wizhead"><font size="10"><strong>Customer information</strong></font></h3>
            </div>
            <div class="panel-body">
				<div class="row">
             <div class="list-group" style="margin-top: 20%;margin-left: 400px;">
				<div  class="list-group-item login-list1">
						<div class="d-flex w-100 justify-content-between">
							<div class="form-group">
								<label class="loglable" style="display: inline-block;margin-left:73px;"><i class="fa fa-user" aria-hidden="true" style="color:#fa511a"></i></label>
								<input style="width:60%;color:#646363;" type="text" placeholder="Username" required="true" id="userClientOrder" name="userClientOrder" /><span class="required">&nbsp;&nbsp;*</span>
							</div>
							<div class="form-group">
								<label class="loglable" style="display: inline-block;margin-left: 73px;padding:3.1px 10px 3.1px 10px;" ><i class="fa fa-key" aria-hidden="true" style="color:#fa511a"></i></label>
								<input style="width:60%;color:#646363;" type="password" placeholder="password" required="true" id="passwordClientOrder" name="passwordClientOrder"/><span class="required">&nbsp;&nbsp;*</span>
							</div>
							<div style="display:inline-block;text-align:left !important; position:absolute;left:200px;margin-top:-6px;">
								<a style="color:#fff;" href="index.php?controller=user&accion=resetPasswordCustomer">Forgot password?</a>
							</div>
							<br><br><br>
							<label style="display:none" id="answerValidateUserOrder" name="answerValidateUserOrder">Answer</label>
						</div>
				</div>
                <p>
				<table style="border-spacing: 15px;padding: 12px;margin-left: 65px;">
					<tr>
						<td><h1 style="margin-right: 13px;" class="labeltwht">Please</h1></td>
						<td></td>
						<td><a style="margin-right:13px;" class="btn-primary btn-lg" data-toggle="modal" data-toggle1="tooltip"  
							href="#" 
							onClick="login_customer_order_request()" > login</a>
						</td>
						<!--<td><a href="#" onclick="login_customer_order_request()">login</a></td>-->
						<!--<td>&#32;<button class="btn-primary btn-lg" type="button" id="button1" name="button1" onclick="login_customer_order_request()">login</button>&#32;</td>-->
						<td></td>
						<td><h1 style="margin-right: 10px;" class="labeltwht">or</h1></td>
						<!--<td><h1><a href="#register-modal" data-toggle="modal">register</a></h1></td>
						<td><button class="btn-primary btn-lg" type="button" id="button2" name="button2" onclick="login_customer_order_request()">register</button></td>-->
						<td></td>
						<td><a class="btn-primary btn-lg" data-toggle="modal" data-toggle1="tooltip"  
							href="#register-modal" 
							onClick="" > register</a>
						</td>
					</tr>
				</table>
				 </p>
                	<!--<button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>-->
                	<!--<button  style="margin-top:5px;margin-right:8px;" class=" btn btn-lg nextBtnOrder pull-right" type="button" id="buttonLoginCustomer">Login</button>-->
            </div>
				<div style="margin-bottom: 20px;    margin-top: 0px;" class="col-sm-12">
					<div>  
						<br><br>
					</div>	
				</div>
					<button class="btn btn-primary nextBtnCustomer pull-right" type="button" id="lastFinishButtonOrder" name="lastFinishButtonOrder">Finish Order</button>
				</div>
					
						
					</div>
                                       <div id="prebtn1">
					<button class="btn btn-primary prevBtnOrder pull-left prebtn2" type="button">Previous</button>
			               </div>
                                 	</div>
			</div>

		</div>

		
		
    </form>
</div>
</div>
<div class="modal fade" id="myModalRespuesta" role="dialog">
	<div class="modal-dialog modal-dialog-centered"> 
		<!-- Modal content--> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<!--<button type="button" class="close" data-dismiss="modal">&times;</button> -->
				<h4 class="modal-title" id="headerTextAnswerOrder">Modal Header</h4> 
			</div> 
			<div class="modal-body" id="textAnswerOrder"> 
				<p >Some text in the modal.</p> 
			</div> 
			<div class="modal-footer" id="buttonAnswerOrder"> 
				<button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#login-modal">GO!</button> 
			</div> 
		</div> 
	</div>
</div>
