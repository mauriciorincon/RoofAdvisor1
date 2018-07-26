
<div class="container">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panelOrder">
            <div class="stepwizard-step col-xs-1" > 
                <a href="#step-1"  type="button" class="btn btn-success btn-circle">1</a>
                <p><small>Enter Zip Code</small></p>
            </div>
            <div class="stepwizard-step col-xs-2"> 
                <a href="#step-2"  type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                <p><small>Create a Work Order</small></p>
			</div>
			<div class="stepwizard-step col-xs-2"> 
                <a href="#step-3"  type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                <p><small>Enter Address</small></p>
            </div>
			<div class="stepwizard-step col-xs-2"> 
                <a href="#step-4"  type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
                <p><small>Select Time</small></p>
            </div>
			<div class="stepwizard-step col-xs-2"> 
                <a href="#step-5"  type="button" class="btn btn-default btn-circle" disabled="disabled">5</a>
                <p><small>Professional</small></p>
            </div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-6"  type="button" class="btn btn-default btn-circle" disabled="disabled">6</a>
                <p><small>Review Order</small></p>
            </div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-7"  type="button" class="btn btn-default btn-circle" disabled="disabled">7</a>
                <p><small>User Validation</small></p>
			</div>
			<div class="stepwizard-step col-xs-1"> 
                <a href="#step-8"  type="button" class="btn btn-default btn-circle" disabled="disabled">8</a>
                <p><small>Paying</small></p>
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
                 <h3 class="panel-title"><font size="10"><strong>Create a work order</strong></font> </h3>
            </div>
            <div class="panel-body">
				<div class="list-group-item ">
					<span class="glyphicon glyphicon-info-sign"></span> <font size="5"><strong>Type of service</strong></font>
				</div>
				<div class="list-group" id="step2OtypeService">
					<a href="#" class="list-group-item active" name="linkServiceType">
						<input type="hidden" value="schedule" name="typeServiceOrder">
						<table>
							<tr>
								<td style="padding: 12px 12px 12px 12px;">
									<button class=" btn-primary   btn-lg" type="button">Schedule Repair</button>
								</td>
								<td style="padding: 12px 12px 12px 12px;">
								A scheduled repair is scheduled a week in advance. You will be able to choose the service pro or allow the first available rated service pro will choose your repair order.
								</td>
							</tr>
						</table>
						<div class="d-flex w-100 justify-content-between">
						
						<span></span>
							
						</div>
					</a>
					<a href="#" class="list-group-item " name="linkServiceType">
					<input type="hidden" value="emergency" name="typeServiceOrder">
						<table>
							<tr>
								<td style="padding: 12px 12px 12px 12px;">
									<button class=" btn-primary   btn-lg" type="button">Emergency Repair</button>
								</td>
								<td style="padding: 12px 12px 12px 12px;">
								An emergency repair is a same day service. The first available rated service pro will choose your repair order and provide you with an ETA of when they will arrive at the repair location.  You will be able to review their ratings, communicate, send them pictures, and track their location. An estimate for your approval will be provided prior to start of work. 
								</td>
							</tr>
						</table>
						<div class="d-flex w-100 justify-content-between">
						
						<span></span>
							
						</div>
					</a>
				</div>
					

					
								
				
					
				
				<div class="list-group-item ">
					<span class="glyphicon glyphicon-info-sign"></span> <font size="5"><strong>Best select the type of roofing material on your property</strong></font>		
				</div>
				<div class="list-group-item ">
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
					<span class="glyphicon glyphicon-info-sign"></span> <font size="5"><strong>Are you aware of any leaks or damage to the roof?</strong></font>		
				</div>

				<div class="list-group-item ">
					<div class="form-group">
						<div class ="col-md-5"></div>
						<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep4Option" id="estep4Option1" value="water" checked></div>
						<div class="col-md-6"><label class="form-check-label" for="estep4Option1">Yes</label></div>
					</div>

					<div class="form-group">
						<div class ="col-md-5"></div>
						<div class ="col-md-1"><input class="form-check-input" type="radio" name="estep4Option" id="estep4Option2" value=""></div>
						<div class="col-md-6"><label class="form-check-label" for="estep4Option2">No</label></div>
					</div>
					<label>&nbsp;</label>
				</div>

				<div class="list-group-item ">
					<span class="glyphicon glyphicon-info-sign"></span> <font size="5"><strong>How many stories is your home?</strong></font>
				</div>

				<div class="list-group-item ">
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
					<label>&nbsp;</label>
				</div>


                <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
            </div>

        </div>
		
		<div class="panel panel-primary setup-contentOrder" id="step-3">
            <div class="panel-heading">
                 <h1 class="panel-title"><font size="10"><strong>Create a work order</strong></font> </h1>
            </div>
            <div class="panel-body">
				<span class="glyphicon glyphicon-info-sign"></span> Select the place for the service
					<input type="hidden" id="step5Logintud" name="step5Logintud"/>
					<input type="hidden" id="step5Latitude" name="step5Latitude"/>
					<input type="hidden" id="step5Address" name="step5Address"/>
					<input type="hidden" id="step5ZipCode" name="step5ZipCode"/>
					<div class="list-group">
					
							<input id="pac-input" class="controls" type="text"
								placeholder="Enter a location" style="margin-left: 20px;margin-top:10px;">
                            
                                <style>
						/* Set the size of the div element that contains the map */
						#map1 {
							height: 400px;  /* The height is 400 pixels */
							width: 100%;  /* The width is the width of the web page */
						}
                        </style>
                        
							<div id="map1"></div>

							<script>
							// This example requires the Places library. Include the libraries=places
							// parameter when you first load the API. For example:
							// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

							function initMap1() {
								var map = new google.maps.Map(document.getElementById('map1'), {
								center: {lat: 27.332617, lng: -81.255690},
								zoom: 7
								});
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
							</script>
							
						<script async defer
							src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHuYRyZsgIxxVSt3Ec84jbBcSDk8OdloA&libraries=visualization&libraries=places&callback=initialization">
						</script>

						<button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                		<button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
					</div>
			</div>
		</div>

		<div class="panel panel-primary setup-contentOrder" id="step-4">
            <div class="panel-heading">
                 <h3 class="panel-title"><font size="10"><strong>Select a time for service ....</strong></font></h3>
            </div>
            <div class="panel-body">
				<div class="form-group">			
				<span ><b>Please select the date and time of service. </b></span><input type="text" id="step6date" name="step6date" class="datepicker">Schedule repair service are schedule a week in advance
				</div>
					
				<div class="form-group">
					<div class="container:'body'">
						<div class="btn-group" role="group" arial-label="Basic example">
							<button type="button" class="btn btn-success" name="step6time" >9:00 AM</button>
							<button type="button" class="btn btn-success" name="step6time">10:00 AM</button>
							<button type="button" class="btn btn-success" name="step6time">11:00 AM</button>
							<button type="button" class="btn btn-success" name="step6time">12:00 PM</button>
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

		<div class="panel panel-primary setup-contentOrder" id="step-5">
            <div class="panel-heading">
                 <h3 class="panel-title"><font size="10"><strong>Select the professional</strong></font></h3>
            </div>
            <div class="panel-body">
				<div class="form-group">
				
								<label class="control-label" for="exampleRadios5">
								These Service Professionals are best suited for your scheduled repair and are all rated 4+ by previous customers. 
								</label>
								<label class="control-label" for="exampleRadios5">
								You can select one or the first available will respond to your work order?
								</label>
							
							
				</div>



				<div class="list-group" id="step7ListCompany">
					
				</div>



				

                
                <button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
            </div>
        </div>

		<div class="panel panel-primary setup-contentOrder" id="step-6">
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
							<span class="glyphicon glyphicon-map-marker"></span> Address of service <span class="badge">1</span>
							<div class="d-flex w-100 justify-content-between">
								<span ><b>Address: </b></span><span id="step8Address"></span><br>
								<span ><b>ZipCode: </b></span><span id="step8ZipCode"></span><br>
								<span ><b>Latitude: </b></span><span id="step8Latitude"></span><br>
								<span ><b>Longitude: </b></span><span id="step8Longitude"></span><br>
								
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
                <button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
            </div>
        </div>

		<div class="panel panel-primary setup-contentOrder" id="step-8">
            <div class="panel-heading">
                 <h3 class="panel-title">Payin the service</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label text-center h1"><big>To finish the order please, clic on <b>Pay your service</b> button to make the charge to your card </big></label>
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
					<label class="control-label text-center h1" id="answerZipCode"><big></big></label>
                </div>
				
				<button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
				
               
                
                
            </div>
		</div>
		
		<div class="panel panel-primary setup-contentOrder" id="step-7">
			<input type="hidden" id="userLoguedIn" value="false" />
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
										<input type="text" placeholder="" required="true" id="userClientOrder" name="userClientOrder" />
									</div>
									<div class="form-group">
										<label>Password<span class="required">*</span></label>
										<input type="password" placeholder="" required="true" id="passwordClientOrder" name="passwordClientOrder"/>
									</div>
									<button class=" btn-primary nextBtnOrder pull-left" type="button" id="buttonLoginCustomer">Login</button><br><br>
									<label id="answerValidateUserOrder" name="answerValidateUserOrder">Answer</label>
									<a href="#">Forgot password?</a>
									
								</div>
							</div>
						</div>
						<button class="btn btn-primary prevBtnOrder pull-left" type="button">Preview</button>
						<button class="btn btn-primary nextBtnOrder pull-right" type="button">Next</button>
					</div>
					<div class="col-sm-6">
						<div class="list-group">
							<div class="list-group-item ">
								<span class="glyphicon glyphicon-info-sign"></span> Info 
								<div class="d-flex w-100 justify-content-between">
									<span ><b>Are you new in RoofAdvisorZ?, fill the fields below</b></span><br><br>
									
								</div>
							</div>
							
							<div class="list-group-item " id="step6RegisterCustomerOrder">
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
									<label class="control-label ">Password</label>
									<input maxlength="100"  type="password" required="required"  data-minlength="6" placeholder="Password" id="inputPassword" name="inputPassword" onblur="validInputPassword()"  />
									<div class="help-block">Minimum of 6 characters</div>
									<label class="control-label" id="answerPasswordValidateStep6" name="answerPasswordValidateStep6"></label>
								</div>
								<div class="form-group">
									<label class="control-label ">Confirm Password</label>
									<input maxlength="100"  type="password" required="required"  data-minlength="6" placeholder="Confirm Password" id="inputPasswordConfirm" name="inputPasswordConfirm" onblur="validInputRePassword()" />
									<label class="control-label" id="answerRePasswordValidateStep6" name="answerRePasswordValidateStep6"></label>
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
								<button class=" btn-primary nextBtnOrder pull-left" type="button" id="buttonLoginCustomer" onclick="saveCustomerData('Order')">Register</button><br><br>
							</div>
							
						</div>
						<button class="btn btn-primary nextBtnCustomer pull-right" type="button" id="lastFinishButtonOrder" name="lastFinishButtonOrder">Finish Order</button>
					</div>
					
						
					</div>
				</div>
			</div>

		</div>

		
		
    </form>
</div>
