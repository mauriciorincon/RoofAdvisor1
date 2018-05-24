<!-- slider-area start -->
<div class="slider-area">
	
<div class="container">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panelOrder">
            <div class="stepwizard-step col-xs-1"> 
                <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                <p><small>Zip Code</small></p>
            </div>
            <div class="stepwizard-step col-xs-1"> 
                <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                <p><small>What would you like to do?</small></p>
            </div>
            <div class="stepwizard-step col-xs-1"> 
                <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                <p><small>select the type of roofing</small></p>
            </div>
            <div class="stepwizard-step col-xs-1"> 
                <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
                <p><small>aware of any leaks or damage</small></p>
            </div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-5" type="button" class="btn btn-default btn-circle" disabled="disabled">5</a>
                <p><small>stories is your home</small></p>
            </div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-6" type="button" class="btn btn-default btn-circle" disabled="disabled">6</a>
                <p><small>Time</small></p>
            </div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-7" type="button" class="btn btn-default btn-circle" disabled="disabled">7</a>
                <p><small>Professional</small></p>
            </div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-8" type="button" class="btn btn-default btn-circle" disabled="disabled">8</a>
                <p><small>Review</small></p>
            </div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-9" type="button" class="btn btn-default btn-circle" disabled="disabled">9</a>
                <p><small>Validate user</small></p>
            </div>
        </div>
    </div>
    
    <form role="form">
        <div class="panel panel-primary setup-contentOrder" id="step-1">
            <div class="panel-heading">
                 <h3 class="panel-title">ZIP CODE</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label text-center h1"><big>ZIP CODE</big></label>
                    <input maxlength="100" type="text" required="required" class="form-control input-lg" placeholder="Enter your zip code" id="zipCodeBegin" name="zipCodeBegin" />
					<label class="control-label text-center h1" id="answerZipCode"><big></big></label>
                </div>
                
				
               
                <button class="btn btn-primary nextBtnOrder pull-right" type="button" id="firstNextBegin" name="firstNextBegin">Next</button>
                
            </div>
        </div>
        
        <div class="panel panel-primary setup-contentOrder" id="step-2">
            <div class="panel-heading">
                 <h3 class="panel-title">What would you like to do? </h3>
            </div>
            <div class="panel-body">
            
			
				<div class="list-group-item ">
					<span class="glyphicon glyphicon-info-sign"></span> What would you like to do? 
					<div class="d-flex w-100 justify-content-between">
						<span ><b><label class="form-check-label" for="exampleRadios1">Repair existing roof leak (scheduled a week in advance) - S</label></b></span><br><br>
                        <span ><b><label class="form-check-label" for="exampleRadios1">Repair existing roof leak (scheduled a week in advance) - S</label></b></span><br><br>
					</div>
				</div>

				<div class="form-group">
						
						<div class ="col-md-1">
							<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
						</div>
						<div class="col-md-11"> 
							<label class="form-check-label" for="exampleRadios1">Repair existing roof leak (scheduled a week in advance) - S</label>
						</div>
				</div>

				<div class="form-group">
						<div class ="col-md-1">
							<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
						</div>
						<div class="col-md-11">
							<label class="form-check-label" for="exampleRadios2">
							Emergency roof repair leak sameday service (repair today) - E
							</label>
						</div>
				</div>

				<div class="form-group">
					<label class="control-label" id="answerZipCode">S-Scheduled Repair prices start from $300-$400 per square and will increase depending on the size, material and time needed to complete the  scheduled repair.</label>
					<label class="control-label" id="answerZipCode">E-Emergency Repair price includes a $75 Emergency Repair Service Fee, $150 per hour for time plus the materials needed to complete the emergency repair.</label>
				</div>
                
                <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
            </div>

        </div>
        
        <div class="panel panel-primary setup-contentOrder" id="step-3">
            <div class="panel-heading">
                 <h3 class="panel-title">Best select the type of roofing material on your property:</h3>
            </div>
            <div class="panel-body">

				
                <div class="form-group">
					<div class ="col-md-5">
					</div>
					<div class ="col-md-1">
						<input class="form-check-input" type="radio" name="estep3Option" id="estep3Option1" value="Flat, Single Ply" checked>
					</div>
					<div class="col-md-6"> 
						<label class="form-check-label" for="estep3Option1">
							Flat, Single Ply
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
				
                
                <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
            </div>
        </div>
        
        <div class="panel panel-primary setup-contentOrder" id="step-4">
            <div class="panel-heading">
                 <h3 class="panel-title">Are you aware of any leaks or damage to the roof?</h3>
            </div>
            <div class="panel-body">
				<div class="form-group">
					<div class ="col-md-5"></div>
					<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep4Option" id="estep4Option1" value="water" checked></div>
					<div class="col-md-6"><label class="form-check-label" for="estep5Option1">Yes</label></div>
				</div>

				<div class="form-group">
					<div class ="col-md-5"></div>
					<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep4Option" id="estep4Option2" value=""></div>
					<div class="col-md-6"><label class="form-check-label" for="estep5Option2">No</label></div>
				</div>

                
                <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
            </div>
        </div>

		<div class="panel panel-primary setup-contentOrder" id="step-5">
            <div class="panel-heading">
                 <h3 class="panel-title">How many stories is your home?</h3>
            </div>
            <div class="panel-body">
				<div class="form-group">
					<div class ="col-md-5"></div>
					<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep5Option" id="estep5Option1" value="One" checked></div>
					<div class="col-md-6"><label class="form-check-label" for="estep5Option1">One</label></div>
				</div>

				<div class="form-group">
					<div class ="col-md-5"></div>
					<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep5Option" id="estep5Option2" value="Two"></div>
					<div class="col-md-6"><label class="form-check-label" for="estep5Option2">Two</label></div>
				</div>

				<div class="form-group">
					<div class ="col-md-5"></div>
					<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep5Option" id="estep5Option3" value="Three or More"></div>
					<div class="col-md-6"><label class="form-check-label" for="estep5Option3">Three or More</label></div>
				</div>

                
                <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
            </div>
        </div>

		<div class="panel panel-primary setup-contentOrder" id="step-6">
            <div class="panel-heading">
                 <h3 class="panel-title">Select a time for service ....</h3>
            </div>
            <div class="panel-body">
				<div class="form-group">			
				<span ><b>Plese select the date to service: </b></span><input type="date" id="step6date" name="step6date">
				</div>
					
				<div class="form-group">
					<div class="container:'body'">
						<div class="btn-group" role="group" arial-label="Basic example">
							<button type="button" class="btn btn-success" name="step6time" >9:00 AM</button>
							<button type="button" class="btn btn-success" name="step6time">10:00 AM</button>
							<button type="button" class="btn btn-success" name="step6time">11:00 AM</button>
							<button type="button" class="btn btn-success" name="step6time">12:00 AM</button>
							<button type="button" class="btn btn-success" name="step6time">1:00 PM</button>
							<button type="button" class="btn btn-success" name="step6time">2:00 PM</button>
							<button type="button" class="btn btn-success" name="step6time">3:00 PM</button>
							<button type="button" class="btn btn-success" name="step6time">4:00 PM</button>
							<button type="button" class="btn btn-success" name="step6time">5:00 PM</button>
						</div>
					</div>
				</div>
                
                <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
            </div>
        </div>

		<div class="panel panel-primary setup-contentOrder" id="step-7">
            <div class="panel-heading">
                 <h3 class="panel-title">Are you aware of any leaks or damage to the roof?</h3>
            </div>
            <div class="panel-body">
				<div class="form-group">
				
								<label class="control-label" for="exampleRadios5">
								These Service Professionals are best suited for your scheduled repair and are all rated 4+ by previous customers. 
								</label>
								<label class="control-label" for="exampleRadios5">
								You can select one or the first available will respond to your request?
								</label>
							
							
				</div>



				<div class="list-group" id="step7ListCompany">
					
				</div>



				

                
                <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
            </div>
        </div>

		<div class="panel panel-primary setup-contentOrder" id="step-8">
            <div class="panel-heading">
                 <h3 class="panel-title">Review Scheduled Repair Order Details</h3>
            </div>
            <div class="panel-body">
				
				<div class="list-group">
						<a href="#" class="list-group-item ">
							<span class="glyphicon glyphicon-envelope"></span> Details <span class="badge">1</span>
							<div class="d-flex w-100 justify-content-between">
								<span ><b>Repair Description: </b></span><span id="step8RepairDescription"></span><br>
								<span ><b>Schedule Date: </b></span><span id="step8Schedule"></span><br>	
								<span ><b>Time: </b></span><span id="step8Time"></span>
							</div>
						</a>
				</div>

				<div class="list-group">
						<a href="#" class="list-group-item ">
							<span class="glyphicon glyphicon-wrench"></span> Contractor <span class="badge">1</span>
							<div class="d-flex w-100 justify-content-between">
								<span ><b>Name: </b></span><span id="step8CompanyName"></span><br>
								
							</div>
						</a>
				</div>

			

				<div class="list-group">
						<a href="#" class="list-group-item ">
							<span class="glyphicon glyphicon-info-sign"></span> Rate 
							<div class="d-flex w-100 justify-content-between">
								<span ><b>Prices start from $300-$400 per square and will increase depending on the size, mateiral and time needed to complete the repair.</b></span><span id="step8CompanyName"></span><br>
								
							</div>
						</a>
				</div>
                
                <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
            </div>
        </div>

		<div class="panel panel-primary setup-contentOrder" id="step-9">
            <div class="panel-heading">
                 <h3 class="panel-title">Customer information</h3>
            </div>
            <div class="panel-body">
				<div class="row">
					<div class="col-sm-6" >
						<div class="list-group">
							<div class="list-group-item ">
								<span class="glyphicon glyphicon-info-sign"></span> Info 
								<div class="d-flex w-100 justify-content-between">
									<span ><b>Please take just one more step, we need to verify your identity,please login or register</b></span><br><br>
									
								</div>
							</div>

							<div  class="list-group-item ">
								<span class="glyphicon glyphicon-info-sign"></span> Login
								<div class="d-flex w-100 justify-content-between">
									<div class="form-group">
										<label>User Name<span class="required">*</span></label>
										<input type="text" placeholder="" required="true" id="userClient" name="userClient" />
									</div>
									<div class="form-group">
										<label>Password<span class="required">*</span></label>
										<input type="password" placeholder="" required="true" id="passwordClient" name="passwordClient"/>
									</div>
									<button type="submit">Login</button><br><br>
									<a href="#">Forgot password?</a>
									
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="list-group">
							<div class="list-group-item ">
								<span class="glyphicon glyphicon-info-sign"></span> Info 
								<div class="d-flex w-100 justify-content-between">
									<span ><b>If you are not register, please fill the fields below</b></span><br><br>
									
								</div>
							</div>
							<div class="list-group-item ">
								<div class="form-group">
									<label class="control-label">First Name</label>
									<input  type="text" required="required" placeholder="Enter First Name" id="firstCustomerName" name="firstCustomerName"  />
									</div> 
								<div class="form-group">
									<label class="control-label">Last Name</label>
									<input maxlength="100" type="text" required="required"  placeholder="Enter Last Name" id="lastCustomerName" name="lastCustomerName"  />
								</div>  
								<div class="form-group">
									<label class="control-label ">Email</label>
									<input maxlength="100"  type="text" required="required"  placeholder="Enter Email" id="emailValidation" name="emailValidation" onfocusout="validateEmail('customer')"/>
									<label class="control-label" id="answerEmailValidate" name="answerEmailValidate">Answer</label>
								</div> 
								<div class="form-group">
									<label class="control-label">Address</label>
									<input maxlength="100" type="text" required="required"  placeholder="Enter address" id="customerAddress" name="customerAddress" />
								</div>
								<div class="form-group">
									<label class="control-label">City</label>
									<input maxlength="100" type="text" required="required" placeholder="Enter city" id="customerCity" name="customerCity" />
								</div> 
								<div class="form-group">
									<label class="control-label">State</label>
									<input maxlength="100" type="text" required="required"  placeholder="Enter state" id="customerState" name="customerState" />
								</div>
								<div class="form-group">
									<label class="control-label">Zip code</label>
									<input maxlength="100" type="text" required="required"  placeholder="Enter zip code" id="customerZipCode" name="customerZipCode" />
								</div> 
								<div class="form-group">
									<label class="control-label">Phone number</label>
									<input maxlength="100" type="text" required="required"  placeholder="Enter phone number" id="customerPhoneNumber" name="customerPhoneNumber"  />
								</div>  
								<button type="submit">Login</button><br><br>  
							</div>
							<button class="btn btn-primary nextBtnCustomer pull-right" type="button" id="firstNextValidation" name="firstNextValidation">Next</button>
						</div>
            		</div>
					</div>
				</div>
			</div>

		</div>

    </form>
</div>


</div>
<!-- slider-area end -->

